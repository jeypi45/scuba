<!-- filepath: c:\xampps\htdocs\ScuBaConnect\header.adm.php -->
<?php
// Get current page for highlighting active link
$current_page = basename($_SERVER['PHP_SELF']);
?>

<input type="checkbox" id="menu-toggle" class="hidden">

<!-- Modern Sidebar -->
<div class="fixed h-full w-[260px] left-0 bottom-0 top-0 z-40 bg-white/95 dark:bg-gray-800 backdrop-blur-sm transition-all duration-300 shadow-lg transform border-r border-gray-100 dark:border-gray-700"
    id="sidebar">

    <!-- Sidebar Header -->
    <div class="flex justify-between items-center h-[70px] px-6 border-b border-gray-100 dark:border-gray-700">
        <h3 class="text-gray-800 dark:text-white text-xl font-bold">
            <span class="text-blue-600">ScuBa</span><span class="text-blue-400">Connect</span>
        </h3>
        <label for="menu-toggle"
            class="cursor-pointer p-2 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-md transition-colors lg:hidden">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500 dark:text-gray-400" fill="none"
                viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </label>
    </div>

    <!-- Sidebar Content -->
    <div
        class="h-[calc(100vh-70px)] overflow-auto scrollbar-thin scrollbar-thumb-gray-300 dark:scrollbar-thumb-gray-600 scrollbar-track-transparent">
        <!-- User Profile -->
        <div class="flex items-center px-6 py-5 border-b border-gray-100 dark:border-gray-700">
            <div
                class="w-12 h-12 rounded-full overflow-hidden ring-2 ring-blue-500 ring-offset-2 ring-offset-white dark:ring-offset-gray-800 mr-4">
                <?php if (logged_in()): ?>
                    <a href="profile.adm.php">
                        <img src="<?= get_image($_SESSION['USER']['image']) ?>" alt="Profile"
                            class="w-full h-full object-cover">
                    </a>
                <?php else: ?>
                    <div class="w-full h-full bg-blue-500/20 flex items-center justify-center">
                        <i class="las la-user text-2xl text-blue-500"></i>
                    </div>
                <?php endif; ?>
            </div>
            <div>
                <h4 class="text-gray-800 dark:text-white font-medium">Sabang Beach Club</h4>
                <div
                    class="mt-1 px-2 py-0.5 bg-blue-100 dark:bg-blue-900/40 rounded-full text-xs text-blue-700 dark:text-blue-300 font-medium inline-block">
                    Admin</div>
            </div>
        </div>

        <!-- Navigation -->
        <div class="mt-4 px-4">
            <h5 class="px-2 text-xs text-gray-500 dark:text-gray-400 font-medium uppercase tracking-wider mb-3">Main
                Navigation</h5>
            <ul class="space-y-1">
                <!-- Dashboard -->
                <li>
                    <a href="dashboard.php" class="flex items-center px-4 py-2.5 rounded-lg transition-all duration-200 
                             <?= $current_page == 'dashboard.php'
                                 ? 'bg-blue-50 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300 font-medium'
                                 : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700/40' ?>">
                        <span
                            class="flex items-center justify-center w-8 h-8 rounded-md <?= $current_page == 'dashboard.php' ? 'bg-blue-100 dark:bg-blue-800/50 text-blue-600' : 'bg-gray-100 dark:bg-gray-700/50 text-gray-500 dark:text-gray-400' ?>">
                            <i class="las la-home text-xl"></i>
                        </span>
                        <span class="ml-3">Dashboard</span>
                        <?php if ($current_page == 'dashboard.php'): ?>
                            <span class="ml-auto w-1.5 h-1.5 rounded-full bg-blue-500"></span>
                        <?php endif; ?>
                    </a>
                </li>

                <!-- Bookings -->
                <li>
                    <a href="booking.php" class="flex items-center px-4 py-2.5 rounded-lg transition-all duration-200 
                             <?= $current_page == 'booking.php'
                                 ? 'bg-blue-50 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300 font-medium'
                                 : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700/40' ?>">
                        <span
                            class="flex items-center justify-center w-8 h-8 rounded-md <?= $current_page == 'booking.php' ? 'bg-blue-100 dark:bg-blue-800/50 text-blue-600' : 'bg-gray-100 dark:bg-gray-700/50 text-gray-500 dark:text-gray-400' ?>">
                            <i class="las la-calendar-check text-xl"></i>
                        </span>
                        <span class="ml-3">Bookings</span>
                        <?php if ($current_page == 'booking.php'): ?>
                            <span class="ml-auto w-1.5 h-1.5 rounded-full bg-blue-500"></span>
                        <?php endif; ?>
                    </a>
                </li>

                <!-- Messages -->
                <li>
                    <a href="message.php" class="flex items-center px-4 py-2.5 rounded-lg transition-all duration-200 
                             <?= $current_page == 'message.php'
                                 ? 'bg-blue-50 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300 font-medium'
                                 : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700/40' ?>">
                        <span
                            class="flex items-center justify-center w-8 h-8 rounded-md <?= $current_page == 'message.php' ? 'bg-blue-100 dark:bg-blue-800/50 text-blue-600' : 'bg-gray-100 dark:bg-gray-700/50 text-gray-500 dark:text-gray-400' ?>">
                            <i class="las la-envelope text-xl"></i>
                        </span>
                        <span class="ml-3">Messages</span>

                        <?php
                        // Get unread message count
                        $unreadQuery = $con->query("SELECT COUNT(*) as unread FROM message WHERE status = 'unread'");
                        $unreadCount = ($unreadQuery && $unreadRow = $unreadQuery->fetch_assoc()) ? $unreadRow['unread'] : 0;

                        if ($unreadCount > 0): ?>
                            <span
                                class="ml-auto bg-blue-500 text-xs text-white px-1.5 py-0.5 rounded-full"><?= $unreadCount ?></span>
                        <?php elseif ($current_page == 'message.php'): ?>
                            <span class="ml-auto w-1.5 h-1.5 rounded-full bg-blue-500"></span>
                        <?php endif; ?>
                    </a>
                </li>
                <!-- Scanner -->
                <li>
                    <a href="scanner.php" class="flex items-center px-4 py-2.5 rounded-lg transition-all duration-200 
                             <?= $current_page == 'scanner.php'
                                 ? 'bg-blue-50 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300 font-medium'
                                 : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700/40' ?>">
                        <span
                            class="flex items-center justify-center w-8 h-8 rounded-md <?= $current_page == 'scanner.php' ? 'bg-blue-100 dark:bg-blue-800/50 text-blue-600' : 'bg-gray-100 dark:bg-gray-700/50 text-gray-500 dark:text-gray-400' ?>">
                            <i class="las la-qrcode text-xl"></i>
                        </span>
                        <span class="ml-3">Scanner</span>
                        <?php if ($current_page == 'scanner.php'): ?>
                            <span class="ml-auto w-1.5 h-1.5 rounded-full bg-blue-500"></span>
                        <?php endif; ?>
                    </a>
                </li>

            </ul>

            <h5 class="px-2 text-xs text-gray-500 dark:text-gray-400 font-medium uppercase tracking-wider mt-6 mb-3">
                Management</h5>
            <ul class="space-y-1">
                <!-- Equipment -->
                <li>
                    <a href="equipment.php" class="flex items-center px-4 py-2.5 rounded-lg transition-all duration-200 
                             <?= $current_page == 'equipment.php'
                                 ? 'bg-blue-50 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300 font-medium'
                                 : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700/40' ?>">
                        <span
                            class="flex items-center justify-center w-8 h-8 rounded-md <?= $current_page == 'equipment.php' ? 'bg-blue-100 dark:bg-blue-800/50 text-blue-600' : 'bg-gray-100 dark:bg-gray-700/50 text-gray-500 dark:text-gray-400' ?>">
                            <i class="las la-toolbox text-xl"></i>
                        </span>
                        <span class="ml-3">Equipment</span>
                        <?php if ($current_page == 'equipment.php'): ?>
                            <span class="ml-auto w-1.5 h-1.5 rounded-full bg-blue-500"></span>
                        <?php endif; ?>
                    </a>
                </li>

                <!-- Rooms -->
                <li>
                    <a href="room.php" class="flex items-center px-4 py-2.5 rounded-lg transition-all duration-200 
                             <?= $current_page == 'room.php'
                                 ? 'bg-blue-50 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300 font-medium'
                                 : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700/40' ?>">
                        <span
                            class="flex items-center justify-center w-8 h-8 rounded-md <?= $current_page == 'room.php' ? 'bg-blue-100 dark:bg-blue-800/50 text-blue-600' : 'bg-gray-100 dark:bg-gray-700/50 text-gray-500 dark:text-gray-400' ?>">
                            <i class="las la-bed text-xl"></i>
                        </span>
                        <span class="ml-3">Rooms</span>
                        <?php if ($current_page == 'room.php'): ?>
                            <span class="ml-auto w-1.5 h-1.5 rounded-full bg-blue-500"></span>
                        <?php endif; ?>
                    </a>
                </li>


                <!-- Users (Add this new navigation item) -->
                <li>
                    <a href="user.php" class="flex items-center px-4 py-2.5 rounded-lg transition-all duration-200 
                             <?= $current_page == 'user.php'
                                 ? 'bg-blue-50 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300 font-medium'
                                 : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700/40' ?>">
                        <span
                            class="flex items-center justify-center w-8 h-8 rounded-md <?= $current_page == 'user.php' ? 'bg-blue-100 dark:bg-blue-800/50 text-blue-600' : 'bg-gray-100 dark:bg-gray-700/50 text-gray-500 dark:text-gray-400' ?>">
                            <i class="las la-users text-xl"></i>
                        </span>
                        <span class="ml-3">Users</span>
                        <?php if ($current_page == 'user.php'): ?>
                            <span class="ml-auto w-1.5 h-1.5 rounded-full bg-blue-500"></span>
                        <?php endif; ?>
                    </a>
                </li>
                <li>
                    <a href="feedback.php" class="flex items-center px-4 py-2.5 rounded-lg transition-all duration-200 
             <?= $current_page == 'feedback.php'
                 ? 'bg-blue-50 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300 font-medium'
                 : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700/40' ?>">
                        <span
                            class="flex items-center justify-center w-8 h-8 rounded-md <?= $current_page == 'feedback.php' ? 'bg-blue-100 dark:bg-blue-800/50 text-blue-600' : 'bg-gray-100 dark:bg-gray-700/50 text-gray-500 dark:text-gray-400' ?>">
                            <i class="las la-star text-xl"></i>
                        </span>
                        <span class="ml-3">Feedback</span>
                        <?php if ($current_page == 'feedback.php'): ?>
                            <span class="ml-auto w-1.5 h-1.5 rounded-full bg-blue-500"></span>
                        <?php endif; ?>
                    </a>
                </li>
            </ul>

            <div class="px-2 mt-8 pt-6 border-t border-gray-100 dark:border-gray-700">
                <button onclick="user.logout()"
                    class="w-full flex items-center py-2.5 px-4 text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 hover:text-red-700 dark:hover:text-red-300 rounded-lg transition-colors">
                    <span
                        class="flex items-center justify-center w-8 h-8 rounded-md bg-red-100 dark:bg-red-900/30 text-red-500">
                        <i class="las la-sign-out-alt text-xl"></i>
                    </span>
                    <span class="ml-3">Logout</span>
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Main Content -->
<div class="ml-0 md:ml-[260px] transition-all duration-300" id="mainContent">
    <header
        class="fixed right-0 top-0 left-0 md:left-[260px] z-30 h-[70px] shadow-sm bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700 transition-all duration-300">
        <div class="flex justify-between items-center px-4 md:px-6 h-full">
            <div class="flex items-center">
                <!-- Menu toggle - Now only visible on mobile -->
                <label for="menu-toggle"
                    class="block md:hidden cursor-pointer p-2 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-md transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-600 dark:text-gray-300" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </label>

                <div class="hidden md:flex ml-6 relative">
                    <input type="text" placeholder="Search..."
                        class="pl-10 pr-4 py-2 rounded-lg bg-gray-50 border border-gray-200 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white dark:focus:bg-gray-800 w-64 transition-all">
                    <span class="las la-search absolute left-3 top-2.5 text-gray-500 dark:text-gray-400"></span>
                </div>
            </div>

            <!-- Rest of your header content remains the same -->
            <div class="flex items-center space-x-4">
                <div class="relative hidden sm:block">
                    <button
                        class="p-2 text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200 focus:outline-none">
                        <span class="las la-bell text-xl"></span>
                        <span class="absolute top-1 right-1 w-2 h-2 bg-red-500 rounded-full"></span>
                    </button>
                </div>

                <div class="md:hidden">
                    <a href="profile.adm.php" class="flex items-center cursor-pointer">
                        <div class="w-8 h-8 rounded-full overflow-hidden">
                            <?php if (logged_in()): ?>
                                <img src="<?= get_image($_SESSION['USER']['image']) ?>" alt="Profile"
                                    class="w-full h-full object-cover">
                            <?php else: ?>
                                <div class="w-full h-full bg-blue-100 flex items-center justify-center">
                                    <i class="las la-user text-lg text-blue-500"></i>
                                </div>
                            <?php endif; ?>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </header>

    <script>
        // Make the sidebar collapsible
        document.getElementById('menu-toggle').addEventListener('change', function () {
            const sidebar = document.getElementById('sidebar');
            const mainContent = document.getElementById('mainContent');
            const header = document.querySelector('header');

            if (window.innerWidth < 768) {
                // Mobile view - show/hide sidebar
                if (this.checked) {
                    sidebar.classList.add('-translate-x-full');
                } else {
                    sidebar.classList.remove('-translate-x-full');
                }
            } else {
                // Desktop view - collapse/expand sidebar
                if (this.checked) {
                    sidebar.classList.remove('w-[260px]');
                    sidebar.classList.add('w-[80px]');

                    mainContent.classList.remove('md:ml-[260px]');
                    mainContent.classList.add('md:ml-[80px]');

                    header.classList.remove('md:left-[260px]');
                    header.classList.add('md:left-[80px]');

                    // Hide text elements when collapsed
                    document.querySelectorAll('#sidebar span:not(.las), #sidebar h4, #sidebar h5').forEach(el => {
                        el.classList.add('hidden');
                    });

                    // Center the icons
                    document.querySelectorAll('#sidebar a').forEach(el => {
                        el.classList.remove('justify-between', 'items-center');
                        el.classList.add('justify-center');
                    });
                } else {
                    sidebar.classList.add('w-[260px]');
                    sidebar.classList.remove('w-[80px]');

                    mainContent.classList.add('md:ml-[260px]');
                    mainContent.classList.remove('md:ml-[80px]');

                    header.classList.add('md:left-[260px]');
                    header.classList.remove('md:left-[80px]');

                    // Show text elements when expanded
                    document.querySelectorAll('#sidebar span:not(.las), #sidebar h4, #sidebar h5').forEach(el => {
                        el.classList.remove('hidden');
                    });

                    // Restore icon alignment
                    document.querySelectorAll('#sidebar a').forEach(el => {
                        el.classList.add('justify-between', 'items-center');
                        el.classList.remove('justify-center');
                    });
                }
            }
        });

        // Define handleMobileView function
        function handleMobileView() {
            const sidebar = document.getElementById('sidebar');
            const menuToggle = document.getElementById('menu-toggle');

            // On mobile, hide sidebar by default
            if (window.innerWidth < 768) {
                sidebar.classList.add('-translate-x-full');
                menuToggle.checked = false;
            } else {
                sidebar.classList.remove('-translate-x-full');
            }
        }

        // Initial call and event listeners
        handleMobileView();
        window.addEventListener('resize', handleMobileView);
        document.addEventListener('DOMContentLoaded', handleMobileView);
    </script>

    <script>
        var user = {
            logout: function () {
                fetch('ajax.inc.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                    body: 'data_type=logout'
                })
                    .then(response => response.json())
                    .then(data => {
                        console.log("Logout response:", data);
                        if (data.success) {
                            window.location.href = "index.php";
                        } else {
                            alert("Logout failed: " + (data.error || "Unknown error"));
                        }
                    })
                    .catch(error => console.error('Fetch error:', error));
            }
        };
    </script>