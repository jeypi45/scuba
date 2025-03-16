<?php
session_start();

// Check if user is logged in and is an admin
if (!isset($_SESSION['USER']) || !isset($_SESSION['USER']['role']) || $_SESSION['USER']['role'] !== 'admin') {
    header("Location: index.php");
    exit();
}

require('functions.adm.php');
require('config.inc.php');

// Handle feedback deletion
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $con->query("DELETE FROM feedback WHERE id=$id");
    header("Location: feedback.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1">
    <title>ScubaConnect - Feedback Management</title>

    <!-- Original CSS -->
    <link rel="stylesheet" href="css/bootstrap.css">

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
                        main: '#264e86',
                        mainLight: '#3a6db3',
                        mainDark: '#1e3f6b',
                        dark: '#34425a',
                        textGrey: '#b0b0b0',
                        primary: '#264e86',
                        secondary: '#34425a',
                        accent: '#007bff'
                    }
                }
            }
        }
    </script>

    <script>
        function confirmDelete() {
            return confirm("Are you sure you want to delete this feedback? This action cannot be undone.");
        }

        function viewFeedback(id, username, rating, feedback_text, created_at) {
            document.getElementById('feedback-username').textContent = username;
            document.getElementById('feedback-rating').textContent = rating + ' / 5';
            document.getElementById('feedback-message').textContent = feedback_text;
            document.getElementById('feedback-date').textContent = created_at;
            document.getElementById('feedback-modal-overlay').classList.remove('hidden');
        }

        function closeFeedbackModal() {
            document.getElementById('feedback-modal-overlay').classList.add('hidden');
        }

        // Close modal on outside click
        function handleModalClick(e) {
            if (e.target === document.getElementById('feedback-modal-overlay')) {
                closeFeedbackModal();
            }
        }
    </script>
</head>

<body class="bg-gray-50">
    <?php include('header.adm.php'); ?>

    <main class="pt-16">
        <div class="max-w-screen-2xl mx-auto px-2 sm:px-4 lg:px-6 py-8">
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <div class="p-4">
                    <h1 class="text-2xl font-bold text-gray-800 mb-6 text-center">Feedback Management</h1>

                    <div class="overflow-x-auto max-w-full">
                        <div class="mx-auto" style="width: 100%;">
                            <table id="feedbackTable" class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-accent text-white">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-sm font-medium uppercase tracking-wider">
                                            ID</th>
                                        <th class="px-6 py-3 text-left text-sm font-medium uppercase tracking-wider">
                                            User</th>
                                        <th class="px-6 py-3 text-left text-sm font-medium uppercase tracking-wider">
                                            Rating</th>
                                        <th class="px-6 py-3 text-left text-sm font-medium uppercase tracking-wider">
                                            Feedback Preview</th>
                                        <th class="px-6 py-3 text-left text-sm font-medium uppercase tracking-wider">
                                            Date</th>
                                        <th class="px-6 py-3 text-left text-sm font-medium uppercase tracking-wider">
                                            Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    <?php
                                    // Join with users table to get username
                                    $query = "SELECT f.*, u.username FROM feedback f 
                                             LEFT JOIN users u ON f.user_id = u.id 
                                             ORDER BY f.created_at DESC";
                                    $result = $con->query($query);

                                    if ($result && $result->num_rows > 0) {
                                        while ($row = $result->fetch_assoc()) {
                                            echo '<tr class="hover:bg-gray-50">';

                                            // ID
                                            echo '<td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">' .
                                                $row['id'] . '</td>';

                                            // Username
                                            echo '<td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800">' .
                                                htmlspecialchars($row['username'] ?? 'Unknown User') . '</td>';

                                            // Rating with stars
                                            $rating = (int) $row['rating'];
                                            echo '<td class="px-6 py-4 whitespace-nowrap">';
                                            echo '<div class="flex items-center">';
                                            for ($i = 1; $i <= 5; $i++) {
                                                if ($i <= $rating) {
                                                    echo '<i class="las la-star text-yellow-400"></i>';
                                                } else {
                                                    echo '<i class="las la-star text-gray-300"></i>';
                                                }
                                            }
                                            echo '</div></td>';

                                            // Feedback preview (truncated)
                                            $feedback = htmlspecialchars($row['feedback_text']);
                                            $preview = (strlen($feedback) > 50) ? substr($feedback, 0, 50) . '...' : $feedback;
                                            echo '<td class="px-6 py-4 text-sm text-gray-600">' . $preview . '</td>';

                                            // Date
                                            echo '<td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">' .
                                                date('Y-m-d H:i', strtotime($row['created_at'])) . '</td>';

                                            // Actions
                                            echo '<td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">';

                                            // View Button
                                            echo '<button onclick="viewFeedback(' .
                                                $row['id'] . ', \'' .
                                                htmlspecialchars(addslashes($row['username'] ?? 'Unknown User')) . '\', ' .
                                                $row['rating'] . ', \'' .
                                                htmlspecialchars(addslashes($row['feedback_text'])) . '\', \'' .
                                                date('F j, Y, g:i a', strtotime($row['created_at'])) . '\')" 
                                                class="inline-flex items-center px-3 py-1.5 bg-blue-600 hover:bg-blue-700 text-white rounded-md transition">
                                                <i class="las la-eye mr-1"></i> View
                                            </button>';

                                            // Delete Button
                                            echo '<a href="feedback.php?delete=' . $row['id'] . '" 
                                                    onclick="return confirmDelete();" 
                                                    class="inline-flex items-center px-3 py-1.5 bg-red-600 text-white rounded-md hover:bg-red-700 transition">
                                                    <i class="las la-trash-alt mr-1"></i> Delete
                                                </a>';

                                            echo '</td>';
                                            echo '</tr>';
                                        }
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Empty state when no data -->
                    <?php if (!$result || $result->num_rows == 0): ?>
                        <div class="text-center py-10">
                            <div class="inline-flex rounded-full bg-blue-100 p-4">
                                <div class="rounded-full bg-blue-200 stroke-blue-600 p-4">
                                    <i class="las la-inbox text-3xl text-blue-600"></i>
                                </div>
                            </div>
                            <h1 class="mt-5 text-xl font-bold text-gray-700">No feedback received yet</h1>
                            <p class="text-gray-500 mt-2">When users submit feedback, it will appear here.</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </main>

    <!-- Feedback Detail Modal -->
    <div id="feedback-modal-overlay"
        class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center z-50"
        onclick="handleModalClick(event)">
        <div class="bg-white rounded-lg shadow-xl w-full max-w-2xl mx-4">
            <!-- Modal Header -->
            <div class="flex justify-between items-center border-b p-4 bg-gray-50 rounded-t-lg">
                <h3 class="text-xl font-semibold text-gray-800">Feedback Details</h3>
                <button onclick="closeFeedbackModal()" class="text-gray-400 hover:text-gray-600">
                    <i class="las la-times text-2xl"></i>
                </button>
            </div>

            <!-- Modal Body -->
            <div class="p-6">
                <div class="mb-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                        <!-- Username -->
                        <div class="bg-gray-50 rounded-md p-3">
                            <h4 class="text-sm font-medium text-gray-500">From User</h4>
                            <p id="feedback-username" class="text-gray-800 font-medium"></p>
                        </div>

                        <!-- Rating -->
                        <div class="bg-gray-50 rounded-md p-3">
                            <h4 class="text-sm font-medium text-gray-500">Rating</h4>
                            <p id="feedback-rating" class="text-gray-800 flex items-center">
                                <span class="mr-2" id="rating-stars"></span>
                            </p>
                        </div>
                    </div>

                    <!-- Date -->
                    <div class="mb-4 text-sm text-gray-500">
                        Submitted on <span id="feedback-date"></span>
                    </div>

                    <!-- Feedback content -->
                    <div class="mt-6">
                        <h4 class="text-sm font-medium text-gray-500 mb-2">Feedback</h4>
                        <div class="bg-gray-50 p-4 rounded-md">
                            <p id="feedback-message" class="text-gray-800 whitespace-pre-wrap"></p>
                        </div>
                    </div>
                </div>

                <div class="flex justify-end space-x-3 pt-4 border-t">
                    <button onclick="closeFeedbackModal()"
                        class="px-4 py-2 bg-gray-300 text-gray-800 rounded-md hover:bg-gray-400 transition">
                        Close
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script src="js/jquery.js"></script>
    <script src="js/jquery.dataTables.js"></script>
    <script src="js/dataTables.bootstrap.js"></script>
    <script>
        $(document).ready(function () {
            // Initialize DataTable
            $('#feedbackTable').DataTable({
                "dom": '<"top"lf>rt<"bottom"ip><"clear">',
                "responsive": true,
                "pageLength": 10,
                "lengthChange": true,
                "autoWidth": false,
                "language": {
                    "search": "Search feedback:",
                    "emptyTable": "No feedback found"
                },
                "columnDefs": [
                    { "orderable": false, "targets": [5] },
                    { "width": "5%", "targets": 0 },   // ID column
                    { "width": "15%", "targets": 1 },  // User column
                    { "width": "10%", "targets": 2 },  // Rating column
                    { "width": "40%", "targets": 3 },  // Feedback preview column
                    { "width": "15%", "targets": 4 },  // Date column
                    { "width": "15%", "targets": 5 }   // Actions column
                ]
            });

            // Style the DataTables elements to match Tailwind design
            $('.dataTables_wrapper .dataTables_filter input').addClass('border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500');
            $('.dataTables_length select').addClass('border border-gray-300 rounded-md px-3 py-2 mr-2 focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500');

            // Move search and length controls to be side by side for more space
            $('.dataTables_length').addClass('inline-block mr-4');
            $('.dataTables_filter').addClass('inline-block');
        });
    </script>
</body>

</html>