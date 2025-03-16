<?php
ob_start(); // Start output buffering
error_reporting(0); // Disable error reporting in production

session_start();

// Check if user is logged in and is an admin
if (!isset($_SESSION['USER']) || $_SESSION['USER']['role'] !== 'admin') {
    header("Location: index.php");
    exit();
}

require('config.inc.php'); // Database connection
require('functions.adm.php');

// Handle message deletion
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'delete' && isset($_POST['id'])) {
    $messageId = intval($_POST['id']);
    $response = deleteMessage($messageId, $con);
    echo json_encode($response);
    exit();
}

// Handle marking message as read
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'read' && isset($_POST['id'])) {
    // Clear any previous output that might corrupt the JSON
    ob_clean();
    header('Content-Type: application/json');

    $id = intval($_POST['id']);

    // Validate ID is positive integer
    if ($id <= 0) {
        echo json_encode([
            "status" => "error",
            "message" => "Invalid message ID"
        ]);
        exit();
    }

    $query = "UPDATE message SET status = 'read' WHERE id = ?";
    $stmt = $con->prepare($query);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        // Check if any rows were affected
        if ($stmt->affected_rows > 0) {
            echo json_encode([
                "status" => "success",
                "message" => "Message marked as read"
            ]);
        } else {
            echo json_encode([
                "status" => "error",
                "message" => "Message not found or already marked as read"
            ]);
        }
    } else {
        echo json_encode([
            "status" => "error",
            "message" => "Database error: " . $con->error
        ]);
    }
    // End script after JSON response
    exit();
}

// Get unread message count
$unreadQuery = "SELECT COUNT(*) AS unread_count FROM message WHERE status = 'unread'";
$unreadResult = $con->query($unreadQuery);
$unreadRow = $unreadResult->fetch_assoc();
$unreadCount = $unreadRow['unread_count'];

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1">
    <title>ScubaConnect - Messages</title>

    <!-- Original CSS -->
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/iziToast.min.css">

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Icons -->
    <link rel="stylesheet"
        href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">

    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css">

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        // Add these required color definitions for the sidebar
                        main: '#264e86',
                        mainLight: '#3a6db3',
                        mainDark: '#1e3f6b',
                        dark: '#34425a',
                        textGrey: '#b0b0b0',
                        // Keep existing colors too
                        primary: '#264e86',
                        secondary: '#34425a',
                        accent: '#007bff'
                    }
                }
            }
        }
    </script>

    <style>
        .unread {
            color: #f97316;
            font-weight: 500;
        }

        .read {
            color: #22c55e;
            font-weight: 500;
        }
    </style>
</head>

<body class="bg-gray-50">
    <?php include('header.adm.php'); ?>

    <main class="pt-16">
        <div class="max-w-screen-2xl mx-auto px-2 sm:px-4 lg:px-6 py-8">
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <div class="p-4">
                    <h1 class="text-2xl font-bold text-gray-800 mb-6 text-center">Messages</h1>

                    <div class="overflow-x-auto max-w-full">
                        <div class="mx-auto" style="width: 100%;">
                            <table id="messageTable" class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-accent text-white">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-sm font-medium uppercase tracking-wider">ID
                                        </th>
                                        <th class="px-6 py-3 text-left text-sm font-medium uppercase tracking-wider">
                                            Name</th>
                                        <th class="px-6 py-3 text-left text-sm font-medium uppercase tracking-wider">
                                            Email</th>
                                        <th class="px-6 py-3 text-left text-sm font-medium uppercase tracking-wider">
                                            Message</th>
                                        <th class="px-6 py-3 text-left text-sm font-medium uppercase tracking-wider">
                                            Date</th>
                                        <th class="px-6 py-3 text-left text-sm font-medium uppercase tracking-wider">
                                            Status</th>
                                        <th class="px-6 py-3 text-left text-sm font-medium uppercase tracking-wider">
                                            Action</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    <?php
                                    $query = "SELECT id, name, email, message, created_at, status FROM message ORDER BY created_at DESC";
                                    $result = $con->query($query);

                                    if ($result->num_rows > 0) {
                                        while ($row = $result->fetch_assoc()) {
                                            $statusClass = ($row['status'] == 'unread') ? 'unread' : 'read';
                                            echo "<tr class=\"hover:bg-gray-50\" data-id='{$row['id']}'>";
                                            echo "<td class=\"px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800\">" . htmlspecialchars($row['id']) . "</td>";
                                            echo "<td class=\"px-6 py-4 whitespace-nowrap text-sm text-gray-600\">" . htmlspecialchars($row['name']) . "</td>";
                                            echo "<td class=\"px-6 py-4 whitespace-nowrap text-sm text-gray-600\">" . htmlspecialchars($row['email']) . "</td>";
                                            echo "<td class=\"px-6 py-4 text-sm text-gray-600\">" . htmlspecialchars($row['message']) . "</td>";
                                            echo "<td class=\"px-6 py-4 whitespace-nowrap text-sm text-gray-600\">" . date("M d, Y h:i a", strtotime($row['created_at'])) . "</td>";

                                            // Status badge similar to booking.php
                                            if ($row['status'] == 'unread') {
                                                echo "<td class=\"px-6 py-4 whitespace-nowrap\">
                                                    <span class=\"px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800 response-status $statusClass\">
                                                        Unread
                                                    </span>
                                                </td>";
                                            } else {
                                                echo "<td class=\"px-6 py-4 whitespace-nowrap\">
                                                    <span class=\"px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full bg-green-100 text-green-800 response-status $statusClass\">
                                                        Read
                                                    </span>
                                                </td>";
                                            }

                                            // Action buttons similar to booking.php
                                            echo "<td class=\"px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2\">
                                                <button class=\"inline-flex items-center px-3 py-1.5 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition respond-btn\" data-id='{$row['id']}'>
                                                    <i class=\"las la-envelope-open mr-1\"></i> Respond
                                                </button>
                                                <button class=\"inline-flex items-center px-3 py-1.5 bg-red-600 text-white rounded-md hover:bg-red-700 transition discard-btn\" data-id='{$row['id']}'>
                                                    <i class=\"las la-trash-alt mr-1\"></i> Discard
                                                </button>
                                            </td>";
                                            echo "</tr>";
                                        }
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Empty state when no data -->
                    <?php if ($result->num_rows == 0): ?>
                        <div class="text-center py-10">
                            <p class="text-gray-500 text-lg">No messages found</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </main>

    <script src="js/jquery.js"></script>
    <script src="js/jquery.dataTables.js"></script>
    <script src="js/dataTables.bootstrap.js"></script>
    <script src="js/iziToast.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#messageTable').DataTable({
                "dom": '<"top"lf>rt<"bottom"ip><"clear">',
                "responsive": true,
                "pageLength": 10,
                "lengthChange": true,
                "autoWidth": true,
                "language": {
                    "search": "Search messages:",
                    "emptyTable": "No messages found"
                },
                "columnDefs": [
                    { "orderable": false, "targets": 6 }, // Disable sorting on action column
                    { "width": "5%", "targets": 0 },     // ID column
                    { "width": "15%", "targets": 1 },    // Name column
                    { "width": "15%", "targets": 2 },    // Email column
                    { "width": "30%", "targets": 3 },    // Message column (wider)
                    { "width": "15%", "targets": 4 },    // Date column
                    { "width": "10%", "targets": 5 },    // Status column
                    { "width": "15%", "targets": 6 }     // Actions column
                ]
            });

            // Style the DataTables elements to match Tailwind design
            $('.dataTables_wrapper .dataTables_filter input').addClass('border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500');
            $('.dataTables_length select').addClass('border border-gray-300 rounded-md px-3 py-2 mr-2 focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500');

            // Move search and length controls to be side by side for more space
            $('.dataTables_length').addClass('inline-block mr-4');
            $('.dataTables_filter').addClass('inline-block');

            // Mark message as read
            $(".respond-btn").click(function () {
                let row = $(this).closest('tr');
                let messageId = row.data("id");

                // Add iziToast notification for better feedback
                iziToast.info({
                    title: 'Processing',
                    message: 'Updating message status...',
                    position: 'topRight',
                    timeout: 1500
                });

                // Send the AJAX request and update UI
                $.ajax({
                    url: "message.php",
                    type: "POST",
                    data: {
                        id: messageId,
                        action: "read"
                    },
                    dataType: "json",
                    success: function (data) {
                        if (data.status === "success") {
                            // Update the status cell badge
                            row.find(".response-status")
                                .removeClass("bg-yellow-100 text-yellow-800")
                                .addClass("bg-green-100 text-green-800")
                                .text("Read");

                            // Update counter in header if it exists
                            let unreadCounter = $("#unreadCount");
                            if (unreadCounter.length) {
                                let currentCount = parseInt(unreadCounter.text(), 10);
                                if (!isNaN(currentCount) && currentCount > 0) {
                                    unreadCounter.text(currentCount - 1);

                                    // If count becomes zero, hide the badge
                                    if (currentCount - 1 === 0) {
                                        unreadCounter.parent().addClass('hidden');
                                    }
                                }
                            }

                            // Show success notification
                            iziToast.success({
                                title: 'Success',
                                message: data.message || 'Message marked as read',
                                position: 'topRight',
                                timeout: 3000
                            });
                        } else {
                            // Show error notification
                            iziToast.error({
                                title: 'Error',
                                message: data.message || 'Failed to update message status',
                                position: 'topRight',
                                timeout: 3000
                            });
                        }
                    },
                    error: function (xhr, status, error) {
                        // Try to parse the response
                        try {
                            let data = JSON.parse(xhr.responseText);
                            iziToast.error({
                                title: 'Error',
                                message: data.message || 'Server error',
                                position: 'topRight',
                                timeout: 3000
                            });
                        } catch (e) {
                            console.error("AJAX Error:", status, error);
                            iziToast.error({
                                title: 'Error',
                                message: 'Failed to communicate with server',
                                position: 'topRight',
                                timeout: 3000
                            });
                        }
                    }
                });
            });

            // Delete message
            $(".discard-btn").click(function () {
                let row = $(this).closest('tr');
                let messageId = row.data("id");

                // Confirm before deleting
                iziToast.question({
                    timeout: 10000,
                    close: false,
                    overlay: true,
                    displayMode: 'once',
                    id: 'question',
                    zindex: 999,
                    title: 'Confirm',
                    message: 'Are you sure you want to delete this message?',
                    position: 'center',
                    buttons: [
                        ['<button><b>YES</b></button>', function (instance, toast) {
                            instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');

                            $.ajax({
                                url: "message.php",
                                type: "POST",
                                data: {
                                    id: messageId,
                                    action: "delete"
                                },
                                dataType: "json",
                                success: function (data) {
                                    if (data.status === "success") {
                                        row.fadeOut(300, function () {
                                            row.remove();

                                            // Refresh table to update counts and display
                                            $('#messageTable').DataTable().draw(false);
                                        });

                                        // Show success notification
                                        iziToast.success({
                                            title: 'Success',
                                            message: 'Message deleted successfully',
                                            position: 'topRight',
                                            timeout: 3000
                                        });
                                    } else {
                                        iziToast.error({
                                            title: 'Error',
                                            message: data.message || 'Failed to delete message',
                                            position: 'topRight',
                                            timeout: 3000
                                        });
                                    }
                                },
                                error: function (xhr, status, error) {
                                    console.error("AJAX Error:", status, error);
                                    iziToast.error({
                                        title: 'Error',
                                        message: 'Failed to communicate with server',
                                        position: 'topRight',
                                        timeout: 3000
                                    });
                                }
                            });
                        }, true],
                        ['<button>NO</button>', function (instance, toast) {
                            instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
                        }]
                    ]
                });
            });
        });
    </script>
</body>

</html>