<?php
session_start();

// Check if user is logged in and is an admin
if (!isset($_SESSION['USER']) || !isset($_SESSION['USER']['role']) || $_SESSION['USER']['role'] !== 'admin') {
    header("Location: index.php");
    exit();
}

require('functions.adm.php');
require('config.inc.php');

// Handle adding new equipment
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_equipment'])) {
    $equipment_name = $_POST['equipment_name'];
    $damage = $_POST['damage'];
    $date = $_POST['date'];

    $stmt = $con->prepare("INSERT INTO equipment_maintenance (equipment_name, damage, progress, date) VALUES (?, ?, 'Pending', ?)");
    $stmt->bind_param("sss", $equipment_name, $damage, $date);
    $stmt->execute();
    $stmt->close();

    // Redirect to prevent form resubmission
    header("Location: equipment.php");
    exit();
}

// Handle updating progress
if (isset($_GET['done'])) {
    $id = $_GET['done'];
    $con->query("UPDATE equipment_maintenance SET progress='Done' WHERE id=$id");
    header("Location: equipment.php");
    exit();
}

if (isset($_GET['discard'])) {
    $id = $_GET['discard'];
    $con->query("DELETE FROM equipment_maintenance WHERE id=$id");
    header("Location: equipment.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1">
    <title>ScubaConnect - Equipment Maintenance</title>

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
        function confirmDelete() {
            return confirm("Are you sure you want to delete this equipment record?");
        }
    </script>
</head>

<body class="bg-gray-50">
    <?php include('header.adm.php'); ?>

    <main class="pt-16">
        <div class="max-w-screen-2xl mx-auto px-2 sm:px-4 lg:px-6 py-8">
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <div class="p-4">
                    <h1 class="text-2xl font-bold text-gray-800 mb-6 text-center">Equipment Maintenance</h1>

                    <!-- Add Equipment Button -->
                    <div class="mb-6">
                        <button id="openModalBtn"
                            class="inline-flex items-center px-4 py-2 rounded-md bg-blue-600 text-white font-medium hover:bg-blue-700 transition">
                            <i class="las la-plus mr-1"></i> Add Equipment
                        </button>
                    </div>

                    <div class="overflow-x-auto max-w-full">
                        <div class="mx-auto" style="width: 100%;">
                            <table id="equipmentTable" class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-accent text-white">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-sm font-medium uppercase tracking-wider">
                                            Equipment Name</th>
                                        <th class="px-6 py-3 text-left text-sm font-medium uppercase tracking-wider">
                                            Damage</th>
                                        <th class="px-6 py-3 text-left text-sm font-medium uppercase tracking-wider">
                                            Progress</th>
                                        <th class="px-6 py-3 text-left text-sm font-medium uppercase tracking-wider">
                                            Date</th>
                                        <th class="px-6 py-3 text-left text-sm font-medium uppercase tracking-wider">
                                            Action</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    <?php
                                    $result = $con->query("SELECT * FROM equipment_maintenance ORDER BY date DESC");
                                    while ($row = $result->fetch_assoc()) {
                                        echo '<tr class="hover:bg-gray-50">';
                                        echo '<td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800">' .
                                            htmlspecialchars($row['equipment_name']) . '</td>';
                                        echo '<td class="px-6 py-4 text-sm text-gray-600">' .
                                            htmlspecialchars($row['damage']) . '</td>';

                                        // Status badge styling based on progress
                                        $statusClass = '';
                                        if ($row['progress'] === 'Pending') {
                                            $statusClass = 'bg-yellow-100 text-yellow-800';
                                        } else if ($row['progress'] === 'In Progress') {
                                            $statusClass = 'bg-blue-100 text-blue-800';
                                        } else {
                                            $statusClass = 'bg-green-100 text-green-800';
                                        }

                                        echo '<td class="px-6 py-4 whitespace-nowrap">
                                                <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full ' . $statusClass . '">
                                                    ' . htmlspecialchars($row['progress']) . '
                                                </span>
                                            </td>';

                                        echo '<td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">' .
                                            htmlspecialchars($row['date']) . '</td>';

                                        echo '<td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">';

                                        // Display different buttons based on progress
                                        if ($row['progress'] !== 'Done') {
                                            echo '<a href="equipment.php?done=' . $row['id'] . '" 
                                                    class="inline-flex items-center px-3 py-1.5 bg-green-600 text-white rounded-md hover:bg-green-700 transition">
                                                    <i class="las la-check mr-1"></i> Mark Done
                                                </a>';
                                        }

                                        echo '<a href="equipment.php?discard=' . $row['id'] . '" 
                                                onclick="return confirmDelete();" 
                                                class="inline-flex items-center px-3 py-1.5 bg-red-600 text-white rounded-md hover:bg-red-700 transition">
                                                <i class="las la-trash-alt mr-1"></i> Delete
                                            </a>';
                                        echo '</td>';
                                        echo '</tr>';
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Empty state when no data -->
                    <?php if ($result->num_rows == 0): ?>
                        <div class="text-center py-10">
                            <p class="text-gray-500 text-lg">No equipment maintenance records found</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </main>

    <!-- Modal Background Overlay -->
    <div id="modal-overlay" class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center z-50">
        <!-- Modal -->
        <div class="bg-white rounded-lg shadow-xl w-full max-w-md mx-4">
            <!-- Modal Header -->
            <div class="flex justify-between items-center border-b p-4">
                <h3 class="text-xl font-semibold text-gray-800">Add Equipment</h3>
                <button id="closeModalBtn" class="text-gray-400 hover:text-gray-600">
                    <i class="las la-times text-2xl"></i>
                </button>
            </div>

            <!-- Modal Body -->
            <div class="p-6">
                <form method="POST" action="equipment.php">
                    <div class="mb-4">
                        <label for="equipment_name" class="block text-sm font-medium text-gray-700 mb-1">Equipment
                            Name:</label>
                        <input type="text" id="equipment_name" name="equipment_name" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>

                    <div class="mb-4">
                        <label for="damage" class="block text-sm font-medium text-gray-700 mb-1">Damage:</label>
                        <textarea id="damage" name="damage" rows="3" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
                    </div>

                    <div class="mb-6">
                        <label for="date" class="block text-sm font-medium text-gray-700 mb-1">Date:</label>
                        <input type="date" id="date" name="date" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>

                    <div class="flex justify-end">
                        <button type="button" id="cancelModalBtn"
                            class="px-4 py-2 mr-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-100">
                            Cancel
                        </button>
                        <button type="submit" name="add_equipment"
                            class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition">
                            Add Equipment
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="js/jquery.js"></script>
    <script src="js/jquery.dataTables.js"></script>
    <script src="js/dataTables.bootstrap.js"></script>
    <script>
        $(document).ready(function () {
            // Initialize DataTable
            $('#equipmentTable').DataTable({
                "dom": '<"top"lf>rt<"bottom"ip><"clear">',
                "responsive": true,
                "pageLength": 10,
                "lengthChange": true,
                "autoWidth": true,
                "language": {
                    "search": "Search equipment:",
                    "emptyTable": "No equipment maintenance records found"
                },
                "columnDefs": [
                    { "orderable": false, "targets": 4 } // Disable sorting on action column
                ]
            });

            // Style the DataTables elements to match Tailwind design
            $('.dataTables_wrapper .dataTables_filter input').addClass('border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500');
            $('.dataTables_length select').addClass('border border-gray-300 rounded-md px-3 py-2 mr-2 focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500');

            // Move search and length controls to be side by side for more space
            $('.dataTables_length').addClass('inline-block mr-4');
            $('.dataTables_filter').addClass('inline-block');

            // Modal functionality
            $('#openModalBtn').click(function () {
                $('#modal-overlay').removeClass('hidden');
            });

            $('#closeModalBtn, #cancelModalBtn').click(function () {
                $('#modal-overlay').addClass('hidden');
            });

            // Close modal on outside click
            $('#modal-overlay').click(function (e) {
                if (e.target === this) {
                    $(this).addClass('hidden');
                }
            });

            // Set today's date as default
            const today = new Date().toISOString().split('T')[0];
            $('#date').val(today);
        });
    </script>
</body>

</html>