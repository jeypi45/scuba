<?php
session_start();

// Check if user is logged in and is an admin
if (!isset($_SESSION['USER']) || $_SESSION['USER']['role'] !== 'admin') {
    header("Location: index.php");
    exit();
}

require('functions.adm.php');
require('config.inc.php'); // Ensure database connection is included

// Fetch data from the database
$q_users = $con->query("SELECT COUNT(*) as total FROM users");
$f_users = $q_users->fetch_assoc();

$q_pending = $con->query("SELECT COUNT(*) as total FROM transaction WHERE status = 'Pending'");
$f_pending = $q_pending->fetch_assoc();

$q_checkin = $con->query("SELECT COUNT(*) as total FROM transaction WHERE status = 'Check In'");
$f_checkin = $q_checkin->fetch_assoc();

// Get the unread message count
$unreadQuery = "SELECT COUNT(*) AS unread_count FROM message WHERE status = 'unread'";
$unreadResult = $con->query($unreadQuery);

if ($unreadResult) {
    $unreadRow = $unreadResult->fetch_assoc();
    $unreadCount = $unreadRow['unread_count'];
} else {
    $unreadCount = 0; // Default to 0 if the query fails
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $id = intval($_POST['id']);
    $response = update_message_status($id);
    echo json_encode($response);
    exit();
}

// Function to get user growth data by month
function getUserGrowthByMonth($conn)
{
    $months = [];
    $userData = [];

    $query = "SELECT MONTH(date) as month, COUNT(*) as user_count 
              FROM users 
              WHERE YEAR(date) = YEAR(CURRENT_DATE())
              GROUP BY MONTH(date) 
              ORDER BY month";

    $result = $conn->query($query);

    // Initialize all months with 0
    for ($i = 1; $i <= 12; $i++) {
        $months[] = date("M", mktime(0, 0, 0, $i, 1));
        $userData[$i] = 0;
    }

    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $userData[$row['month']] = $row['user_count'];
        }
    }

    return [
        'labels' => $months,
        'data' => array_values($userData)
    ];
}

// Function to get revenue data by month
function getRevenueByMonth($conn)
{
    $months = [];
    $revenueData = [];

    $query = "SELECT MONTH(checkin) as month, SUM(bill) as total_revenue 
              FROM transaction 
              WHERE YEAR(checkin) = YEAR(CURRENT_DATE()) AND bill != ''
              GROUP BY MONTH(checkin) 
              ORDER BY month";

    $result = $conn->query($query);

    // Initialize all months with 0
    for ($i = 1; $i <= 12; $i++) {
        $months[] = date("M", mktime(0, 0, 0, $i, 1));
        $revenueData[$i] = 0;
    }

    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $revenueData[$row['month']] = intval($row['total_revenue']);
        }
    }

    return [
        'labels' => $months,
        'data' => array_values($revenueData)
    ];
}

// Function to get check-ins by room type
function getCheckinsByRoomType($conn)
{
    $roomTypes = [];
    $checkinData = [];

    $query = "SELECT r.room_type, COUNT(t.transaction_id) as checkin_count 
              FROM transaction t
              JOIN room r ON t.room_id = r.room_id
              GROUP BY r.room_type";

    $result = $conn->query($query);

    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $roomTypes[] = $row['room_type'];
            $checkinData[] = $row['checkin_count'];
        }
    }

    return [
        'labels' => $roomTypes,
        'data' => $checkinData
    ];
}

// Get data for charts
$userGrowthData = getUserGrowthByMonth($con);
$revenueData = getRevenueByMonth($con);
$checkinData = getCheckinsByRoomType($con);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1">
    <title>ScubaConnect</title>
    <link rel="stylesheet" href="css/bootstrap.css">
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet"
        href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
                    },
                    animation: {
                        'pulse-slow': 'pulse 3s cubic-bezier(0.4, 0, 0.6, 1) infinite',
                    }
                },
                fontFamily: {
                    'merriweather': ['"Merriweather Sans"', 'sans-serif']
                }
            }
        }
    </script>
</head>

<body class="bg-gray-50 font-merriweather">
    <?php include('header.adm.php') ?>

    <main class="mt-16 max-w-screen-2xl mx-auto px-4 py-8">
        <!-- Page Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-800">Dashboard</h1>
            <p class="text-gray-600 mt-1">Welcome to ScuBaConnect admin panel</p>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
            <!-- Users Card -->
            <div
                class="bg-white rounded-xl shadow-md p-6 border-l-4 border-blue-500 transition-all duration-300 hover:shadow-xl hover:-translate-y-1">
                <div class="flex justify-between items-center">
                    <div>
                        <p class="text-gray-500 text-sm font-medium uppercase tracking-wider">Total Users</p>
                        <h2 class="text-4xl font-bold text-gray-800 mt-2"><?php echo $f_users['total']; ?></h2>
                    </div>
                    <div class="bg-blue-100 p-3 rounded-full">
                        <span class="las la-user-friends text-3xl text-blue-600"></span>
                    </div>
                </div>
            </div>

            <!-- Pending Card -->
            <div
                class="bg-white rounded-xl shadow-md p-6 border-l-4 border-amber-500 transition-all duration-300 hover:shadow-xl hover:-translate-y-1">
                <div class="flex justify-between items-center">
                    <div>
                        <p class="text-gray-500 text-sm font-medium uppercase tracking-wider">Pending</p>
                        <h2 class="text-4xl font-bold text-gray-800 mt-2"><?php echo $f_pending['total']; ?></h2>
                    </div>
                    <div class="bg-amber-100 p-3 rounded-full">
                        <span class="las la-clock text-3xl text-amber-600"></span>
                    </div>
                </div>
            </div>

            <!-- Check In Card -->
            <div
                class="bg-white rounded-xl shadow-md p-6 border-l-4 border-green-500 transition-all duration-300 hover:shadow-xl hover:-translate-y-1">
                <div class="flex justify-between items-center">
                    <div>
                        <p class="text-gray-500 text-sm font-medium uppercase tracking-wider">Check In</p>
                        <h2 class="text-4xl font-bold text-gray-800 mt-2"><?php echo $f_checkin['total']; ?></h2>
                    </div>
                    <div class="bg-green-100 p-3 rounded-full">
                        <span class="las la-check-circle text-3xl text-green-600"></span>
                    </div>
                </div>
            </div>

            <!-- Messages Card -->
            <div
                class="bg-white rounded-xl shadow-md p-6 border-l-4 border-purple-500 transition-all duration-300 hover:shadow-xl hover:-translate-y-1">
                <div class="flex justify-between items-center">
                    <div>
                        <p class="text-gray-500 text-sm font-medium uppercase tracking-wider">New Messages</p>
                        <h2 id="unreadMessages" class="text-4xl font-bold text-gray-800 mt-2">
                            <?php echo $unreadCount; ?></h2>
                    </div>
                    <div class="bg-purple-100 p-3 rounded-full">
                        <span class="las la-envelope text-3xl text-purple-600"></span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Charts Section -->
        <div class="grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-3 gap-6 mb-8">
            <!-- User Growth Chart -->
            <div
                class="bg-white rounded-xl shadow-md overflow-hidden transition-all duration-300 hover:shadow-lg border border-gray-100">
                <div class="bg-gradient-to-r from-blue-500 to-blue-700 p-4 text-white">
                    <h3 class="font-bold text-lg">Users Growth</h3>
                    <p class="text-blue-100 text-sm">Monthly new user registrations</p>
                </div>
                <div class="p-5 h-72">
                    <canvas id="userGrowthChart"></canvas>
                </div>
            </div>

            <!-- Revenue Chart -->
            <div
                class="bg-white rounded-xl shadow-md overflow-hidden transition-all duration-300 hover:shadow-lg border border-gray-100">
                <div class="bg-gradient-to-r from-green-500 to-green-700 p-4 text-white">
                    <h3 class="font-bold text-lg">Revenue (₩)</h3>
                    <p class="text-green-100 text-sm">Monthly financial performance</p>
                </div>
                <div class="p-5 h-72">
                    <canvas id="revenueChart"></canvas>
                </div>
            </div>

            <!-- Check-in Type Chart -->
            <div
                class="bg-white rounded-xl shadow-md overflow-hidden transition-all duration-300 hover:shadow-lg border border-gray-100">
                <div class="bg-gradient-to-r from-purple-500 to-purple-700 p-4 text-white">
                    <h3 class="font-bold text-lg">Check-in Type Distribution</h3>
                    <p class="text-purple-100 text-sm">Room type popularity</p>
                </div>
                <div class="p-5 h-72">
                    <canvas id="checkinChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Quick Links or Additional Information Section -->
        <div class="bg-white rounded-xl shadow-md p-6 border border-gray-100">
            <h3 class="text-xl font-bold text-gray-800 mb-4">Quick Actions</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <a href="booking.php"
                    class="flex items-center p-4 bg-blue-50 rounded-lg hover:bg-blue-100 transition-colors">
                    <span class="las la-calendar-check text-2xl text-blue-600 mr-3"></span>
                    <div>
                        <h4 class="font-medium text-gray-800">Manage Bookings</h4>
                        <p class="text-sm text-gray-600">View and process reservations</p>
                    </div>
                </a>
                <a href="message.php"
                    class="flex items-center p-4 bg-purple-50 rounded-lg hover:bg-purple-100 transition-colors">
                    <span class="las la-envelope text-2xl text-purple-600 mr-3"></span>
                    <div>
                        <h4 class="font-medium text-gray-800">Check Messages</h4>
                        <p class="text-sm text-gray-600">Respond to customer inquiries</p>
                    </div>
                </a>
                <a href="room.php"
                    class="flex items-center p-4 bg-green-50 rounded-lg hover:bg-green-100 transition-colors">
                    <span class="las la-bed text-2xl text-green-600 mr-3"></span>
                    <div>
                        <h4 class="font-medium text-gray-800">Room Management</h4>
                        <p class="text-sm text-gray-600">Update room availability</p>
                    </div>
                </a>
            </div>
        </div>
    </main>

    <script>
        // User Growth Chart
        const ctx1 = document.getElementById('userGrowthChart').getContext('2d');
        new Chart(ctx1, {
            type: 'line',
            data: {
                labels: <?php echo json_encode($userGrowthData['labels']); ?>,
                datasets: [{
                    label: 'Users Growth',
                    data: <?php echo json_encode($userGrowthData['data']); ?>,
                    borderColor: '#3b82f6',
                    backgroundColor: 'rgba(59, 130, 246, 0.1)',
                    borderWidth: 3,
                    fill: true,
                    tension: 0.3,
                    pointBackgroundColor: '#3b82f6',
                    pointBorderColor: '#fff',
                    pointBorderWidth: 2,
                    pointRadius: 4,
                    pointHoverRadius: 6
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        backgroundColor: 'rgba(0, 0, 0, 0.8)',
                        titleColor: '#fff',
                        bodyColor: '#fff',
                        bodyFont: {
                            size: 14
                        },
                        padding: 12,
                        cornerRadius: 8,
                        callbacks: {
                            label: function (context) {
                                return 'New Users: ' + context.raw;
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: 'rgba(0, 0, 0, 0.05)',
                            drawBorder: false
                        },
                        ticks: {
                            font: {
                                size: 12
                            }
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        },
                        ticks: {
                            font: {
                                size: 12
                            }
                        }
                    }
                }
            }
        });

        // Revenue Chart
        const ctx2 = document.getElementById('revenueChart').getContext('2d');
        new Chart(ctx2, {
            type: 'bar',
            data: {
                labels: <?php echo json_encode($revenueData['labels']); ?>,
                datasets: [{
                    label: 'Revenue (₩)',
                    data: <?php echo json_encode($revenueData['data']); ?>,
                    backgroundColor: [
                        'rgba(22, 163, 74, 0.7)',
                    ],
                    borderColor: 'rgba(22, 163, 74, 1)',
                    borderWidth: 1,
                    borderRadius: 4,
                    hoverBackgroundColor: 'rgba(22, 163, 74, 0.9)'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        backgroundColor: 'rgba(0, 0, 0, 0.8)',
                        titleColor: '#fff',
                        bodyColor: '#fff',
                        bodyFont: {
                            size: 14
                        },
                        padding: 12,
                        cornerRadius: 8,
                        callbacks: {
                            label: function (context) {
                                return 'Revenue: ₩' + context.raw.toLocaleString();
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: 'rgba(0, 0, 0, 0.05)',
                            drawBorder: false
                        },
                        ticks: {
                            font: {
                                size: 12
                            }
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        },
                        ticks: {
                            font: {
                                size: 12
                            }
                        }
                    }
                }
            }
        });

        // Check-in Type Chart (Pie Chart)
        const ctx3 = document.getElementById('checkinChart').getContext('2d');
        new Chart(ctx3, {
            type: 'doughnut',
            data: {
                labels: <?php echo json_encode($checkinData['labels']); ?>,
                datasets: [{
                    label: 'Check-ins by Room Type',
                    data: <?php echo json_encode($checkinData['data']); ?>,
                    backgroundColor: [
                        'rgba(59, 130, 246, 0.8)',
                        'rgba(16, 185, 129, 0.8)',
                        'rgba(236, 72, 153, 0.8)',
                        'rgba(249, 115, 22, 0.8)',
                        'rgba(139, 92, 246, 0.8)',
                        'rgba(20, 184, 166, 0.8)',
                        'rgba(245, 158, 11, 0.8)',
                        'rgba(239, 68, 68, 0.8)',
                    ],
                    borderWidth: 2,
                    borderColor: '#ffffff',
                    hoverOffset: 8
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '65%',
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            usePointStyle: true,
                            padding: 15,
                            font: {
                                size: 12
                            }
                        }
                    },
                    tooltip: {
                        backgroundColor: 'rgba(0, 0, 0, 0.8)',
                        titleColor: '#fff',
                        bodyColor: '#fff',
                        bodyFont: {
                            size: 14
                        },
                        padding: 12,
                        cornerRadius: 8,
                        callbacks: {
                            label: function (context) {
                                const label = context.label || '';
                                const value = context.raw || 0;
                                const total = context.dataset.data.reduce((acc, data) => acc + data, 0);
                                const percentage = ((value / total) * 100).toFixed(1);
                                return `${label}: ${value} check-ins (${percentage}%)`;
                            }
                        }
                    }
                }
            }
        });
    </script>
</body>

</html>