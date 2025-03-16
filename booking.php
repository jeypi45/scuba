<?php
session_start();

// Check if user is logged in and is an admin
if (!isset($_SESSION['USER']) || $_SESSION['USER']['role'] !== 'admin') {
    header("Location: index.php");
    exit();
}

require('functions.adm.php');
require('config.inc.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1">
    <title>ScubaConnect - Pending Reservations</title>

    <!-- Original CSS -->

    <link rel="stylesheet" href="css/bootstrap.css">

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Icons -->
    <link rel="stylesheet"
        href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">

    <!-- Charts -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- Add DataTables CSS -->
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

    <script>
        function confirmationDelete() {
            return confirm("Are you sure you want to discard this reservation?");
        }
    </script>
</head>

<!-- Rest of your page content remains the same -->

<body class="bg-gray-50">

    <?php include('header.adm.php'); ?>

    <main class="pt-16">
        <div class="max-w-screen-2xl mx-auto px-2 sm:px-4 lg:px-6 py-8">
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <div class="p-4"> <!-- Keep reduced padding -->
                    <h1 class="text-2xl font-bold text-gray-800 mb-6 text-center">Pending Reservations</h1>

                    <?php
                    // Count pending and check-in transactions
                    $q_p = $con->query("SELECT COUNT(*) as total FROM `transaction` WHERE `status` = 'Pending'");
                    $f_p = $q_p->fetch_array();
                    $q_ci = $con->query("SELECT COUNT(*) as total FROM `transaction` WHERE `status` = 'Check In'");
                    $f_ci = $q_ci->fetch_array();
                    ?>

                    <div class="flex flex-wrap gap-2 mb-6">
                        <a
                            class="inline-flex items-center px-4 py-2 rounded-md bg-green-600 text-white font-medium cursor-default">
                            <span
                                class="bg-white text-green-600 rounded-full h-6 w-6 flex items-center justify-center mr-2">
                                <?php echo htmlspecialchars($f_p['total']); ?>
                            </span>
                            Pending
                        </a>
                        <a href="checkin.php"
                            class="inline-flex items-center px-4 py-2 rounded-md bg-blue-500 text-white font-medium hover:bg-blue-600 transition">
                            <span
                                class="bg-white text-blue-500 rounded-full h-6 w-6 flex items-center justify-center mr-2">
                                <?php echo htmlspecialchars($f_ci['total']); ?>
                            </span>
                            Check In
                        </a>
                        <a href="checkout.php"
                            class="inline-flex items-center px-4 py-2 rounded-md bg-amber-500 text-white font-medium hover:bg-amber-600 transition">
                            <i class="las la-eye mr-2"></i> Check Out
                        </a>
                    </div>

                    <div class="overflow-x-auto max-w-full">
                        <!-- Use 100% width instead of 98% -->
                        <div class="mx-auto" style="width: 100%;">
                            <table id="reservation-table" class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-accent text-white">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-sm font-medium uppercase tracking-wider">
                                            Name
                                        </th>
                                        <th class="px-6 py-3 text-left text-sm font-medium uppercase tracking-wider">
                                            Contact
                                            No</th>
                                        <th class="px-6 py-3 text-left text-sm font-medium uppercase tracking-wider">
                                            Room
                                            Type</th>
                                        <th class="px-6 py-3 text-left text-sm font-medium uppercase tracking-wider">
                                            Room No
                                        </th>
                                        <th class="px-6 py-3 text-left text-sm font-medium uppercase tracking-wider">
                                            Check-in Date</th>
                                        <th class="px-6 py-3 text-left text-sm font-medium uppercase tracking-wider">
                                            Check-out Date</th>
                                        <th class="px-6 py-3 text-left text-sm font-medium uppercase tracking-wider">
                                            Status
                                        </th>
                                        <th class="px-6 py-3 text-left text-sm font-medium uppercase tracking-wider">
                                            Action
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    <?php
                                    $query = $con->query("
                                SELECT guest.firstname, guest.lastname, guest.contactno, 
                                       room.room_type, transaction.room_no, 
                                       transaction.checkin, transaction.checkout, transaction.status, transaction.transaction_id 
                                FROM transaction 
                                INNER JOIN guest ON transaction.guest_id = guest.guest_id 
                                INNER JOIN room ON transaction.room_id = room.room_id 
                                WHERE transaction.status = 'Pending'
                                ") or die(mysqli_error($con));

                                    while ($fetch = $query->fetch_array()) {
                                        ?>
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800">
                                                <?php echo htmlspecialchars($fetch['firstname'] . " " . $fetch['lastname']); ?>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                                <?php echo htmlspecialchars($fetch['contactno']); ?>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                                <?php echo htmlspecialchars($fetch['room_type']); ?>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                                <?php echo htmlspecialchars($fetch['room_no']); ?>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <?php
                                                $checkin_date = strtotime($fetch['checkin']);
                                                $color = ($checkin_date <= strtotime("+8 HOURS")) ? "text-red-600" : "text-green-600";
                                                echo "<span class='font-medium $color'>" . date("M d, Y", $checkin_date) . "</span>";
                                                ?>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <?php
                                                $checkout_date = strtotime($fetch['checkout']);
                                                echo "<span class='font-medium text-red-600'>" . date("M d, Y", $checkout_date) . "</span>";
                                                ?>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span
                                                    class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                                    <?php echo htmlspecialchars($fetch['status']); ?>
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                                                <a href="confirm_reserve.php?transaction_id=<?php echo $fetch['transaction_id']; ?>"
                                                    class="inline-flex items-center px-3 py-1.5 bg-green-600 text-white rounded-md hover:bg-green-700 transition">
                                                    <i class="las la-check mr-1"></i> Check In
                                                </a>
                                                <a href="delete_pending.php?transaction_id=<?php echo $fetch['transaction_id']; ?>"
                                                    onclick="return confirmationDelete();"
                                                    class="inline-flex items-center px-3 py-1.5 bg-red-600 text-white rounded-md hover:bg-red-700 transition">
                                                    <i class="las la-trash-alt mr-1"></i> Discard
                                                </a>
                                            </td>
                                        </tr>
                                        <?php
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Empty state when no data -->
                    <?php if ($query->num_rows == 0): ?>
                        <div class="text-center py-10">
                            <p class="text-gray-500 text-lg">No pending reservations found</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </main>

    <script src="js/jquery.js"></script>
    <script src="js/jquery.dataTables.js"></script>
    <script src="js/dataTables.bootstrap.js"></script>
    <script>
        $(document).ready(function () {
            $('#reservation-table').DataTable({
                "dom": '<"top"lf>rt<"bottom"ip><"clear">',
                "responsive": true,
                "pageLength": 10,
                "lengthChange": true,
                "autoWidth": true, // Let DataTables calculate column widths
                "language": {
                    "search": "Search reservations:",
                    "emptyTable": "No pending reservations found"
                },
                "columnDefs": [
                    { "orderable": false, "targets": 7 } // Disable sorting on action column
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