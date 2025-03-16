<?php
session_start();

// Check if user is logged in and is an admin
if (!isset($_SESSION['USER']) || !isset($_SESSION['USER']['role']) || $_SESSION['USER']['role'] !== 'admin') {
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
	<title>ScubaConnect- Reservation Confirmation</title>

	<!-- Original CSS -->
	<link rel="stylesheet" href="css/bootstrap.css">

	<!-- Tailwind CSS -->
	<script src="https://cdn.tailwindcss.com"></script>

	<!-- Icons -->
	<link rel="stylesheet"
		href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">

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

		function confirmationDelete() {
			return confirm("Are you sure you want to discard this reservation?");
		}
	</script>
</head>

<body class="bg-gray-50">
	<?php include('header.adm.php'); ?>

	<main class="pt-16">
		<div class="max-w-screen-xl mx-auto px-2 sm:px-4 lg:px-6 py-8">
			<div class="bg-white rounded-lg shadow-md overflow-hidden">
				<div class="p-6">
					<div class="flex justify-between items-center border-b pb-4 mb-6">
						<h1 class="text-2xl font-bold text-gray-800">Reservation Confirmation</h1>
						<span class="px-3 py-1 bg-blue-100 text-blue-800 text-sm font-medium rounded-full">
							<i class="las la-clipboard-check mr-1"></i>Pending Confirmation
						</span>
					</div>

					<?php
					// Secure query with proper parameter binding to prevent SQL injection
					$transaction_id = mysqli_real_escape_string($con, $_REQUEST['transaction_id']);
					$query = $con->prepare("SELECT * FROM `transaction` 
                                          NATURAL JOIN `guest` 
                                          NATURAL JOIN `room` 
                                          WHERE `transaction_id` = ?");
					$query->bind_param("s", $transaction_id);
					$query->execute();
					$result = $query->get_result();
					$fetch = $result->fetch_array();
					?>

					<form method="POST" enctype="multipart/form-data"
						action="save_form.php?transaction_id=<?php echo htmlspecialchars($fetch['transaction_id']); ?>"
						class="space-y-6">

						<!-- Guest Information Section -->
						<div class="bg-gray-50 rounded-lg p-5 border border-gray-100">
							<h2 class="text-lg font-semibold text-gray-700 border-b border-gray-200 pb-2 mb-4">
								<i class="las la-user-circle text-accent mr-2"></i>Guest Information
							</h2>

							<div class="grid grid-cols-1 md:grid-cols-3 gap-4">
								<div>
									<label class="block text-sm font-medium text-gray-700 mb-1">First Name</label>
									<input type="text" value="<?php echo htmlspecialchars($fetch['firstname']); ?>"
										class="w-full px-3 py-2 bg-white text-gray-800 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
										disabled />
								</div>

								<div>
									<label class="block text-sm font-medium text-gray-700 mb-1">Middle Name</label>
									<input type="text" value="<?php echo htmlspecialchars($fetch['middlename']); ?>"
										class="w-full px-3 py-2 bg-white text-gray-800 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
										disabled />
								</div>

								<div>
									<label class="block text-sm font-medium text-gray-700 mb-1">Last Name</label>
									<input type="text" value="<?php echo htmlspecialchars($fetch['lastname']); ?>"
										class="w-full px-3 py-2 bg-white text-gray-800 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
										disabled />
								</div>
							</div>

							<div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
								<div>
									<label class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
									<div class="flex items-center">
										<i class="las la-envelope text-gray-400 absolute ml-3"></i>
										<input type="text" value="<?php echo htmlspecialchars($fetch['email']); ?>"
											class="w-full px-3 pl-10 py-2 bg-white text-gray-800 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
											disabled />
									</div>
								</div>

								<div>
									<label class="block text-sm font-medium text-gray-700 mb-1">Contact Number</label>
									<div class="flex items-center">
										<i class="las la-phone text-gray-400 absolute ml-3"></i>
										<input type="text" value="<?php echo htmlspecialchars($fetch['contactno']); ?>"
											class="w-full px-3 pl-10 py-2 bg-white text-gray-800 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
											disabled />
									</div>
								</div>
							</div>
						</div>

						<!-- Booking Details Section -->
						<div class="bg-gray-50 rounded-lg p-5 border border-gray-100">
							<h2 class="text-lg font-semibold text-gray-700 border-b border-gray-200 pb-2 mb-4">
								<i class="las la-calendar-check text-accent mr-2"></i>Booking Details
							</h2>

							<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
								<div>
									<label class="block text-sm font-medium text-gray-700 mb-1">Room Type</label>
									<input type="text" value="<?php echo htmlspecialchars($fetch['room_type']); ?>"
										class="w-full px-3 py-2 bg-white text-gray-800 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
										disabled />
								</div>

								<div>
									<label class="block text-sm font-medium text-gray-700 mb-1">Room Number</label>
									<input type="text" value="<?php echo htmlspecialchars($fetch['room_no']); ?>"
										class="w-full px-3 py-2 bg-white text-gray-800 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
										disabled />
								</div>

								<div>
									<label class="block text-sm font-medium text-gray-700 mb-1">Duration (Days)</label>
									<input type="text" value="<?php echo htmlspecialchars($fetch['days']); ?>"
										class="w-full px-3 py-2 bg-white text-gray-800 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
										disabled />
								</div>

								<div>
									<label class="block text-sm font-medium text-gray-700 mb-1">Extra Dive</label>
									<input type="text" value="<?php echo htmlspecialchars($fetch['extra_dive']); ?>"
										class="w-full px-3 py-2 bg-white text-gray-800 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
										disabled />
								</div>
							</div>

							<div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-4">
								<div>
									<label class="block text-sm font-medium text-gray-700 mb-1">Check-in Date</label>
									<div class="flex items-center">
										<i class="las la-calendar text-gray-400 absolute ml-3"></i>
										<input type="text"
											value="<?php echo date('F j, Y', strtotime($fetch['checkin'])); ?>"
											class="w-full px-3 pl-10 py-2 bg-white text-gray-800 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
											disabled />
									</div>
								</div>

								<div>
									<label class="block text-sm font-medium text-gray-700 mb-1">Check-out Date</label>
									<div class="flex items-center">
										<i class="las la-calendar-check text-gray-400 absolute ml-3"></i>
										<input type="text"
											value="<?php echo date('F j, Y', strtotime($fetch['checkout'])); ?>"
											class="w-full px-3 pl-10 py-2 bg-white text-gray-800 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
											disabled />
									</div>
								</div>

								<div>
									<label class="block text-sm font-medium text-gray-700 mb-1">Number of Guests</label>
									<div class="flex items-center">
										<i class="las la-users text-gray-400 absolute ml-3"></i>
										<input type="text" value="<?php echo htmlspecialchars($fetch['num_guests']); ?>"
											class="w-full px-3 pl-10 py-2 bg-white text-gray-800 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
											disabled />
									</div>
								</div>
							</div>
						</div>

						<!-- Payment Information -->
						<div class="bg-gray-50 rounded-lg p-6 border border-gray-100 shadow-sm">
							<h2 class="text-lg font-semibold text-gray-700 flex items-center mb-5">
								<i class="las la-money-bill-wave text-accent mr-2 text-xl"></i>Payment Information
							</h2>

							<?php
							// Calculate total bill correctly
							$room_price = $fetch['price'];
							$num_guests = $fetch['num_guests'];
							$days = $fetch['days'];
							$extra_dive = $fetch['extra_dive'];

							// Price per night (room price × number of guests)
							$price_per_night = $room_price * $num_guests;

							// Calculate extra dive cost
							$extra_dive_cost = 0;
							if ($extra_dive == 'morning') {
								$extra_dive_cost = 12600;
							} elseif ($extra_dive == 'night') {
								$extra_dive_cost = 25200;
							}

							// Total bill calculation
							$room_total = $price_per_night * $days;
							$total_bill = $room_total + $extra_dive_cost;
							?>

							<div
								class="bg-gradient-to-r from-blue-50 to-indigo-50 rounded-xl overflow-hidden shadow-sm">
								<!-- Header -->
								<div class="bg-blue-600 px-5 py-3 text-white flex justify-between items-center">
									<h3 class="font-medium text-white">Booking Summary</h3>
									<span class="text-xs bg-white text-blue-700 px-2 py-1 rounded-full font-medium">
										<?php echo htmlspecialchars($fetch['reservation_id']); ?>
									</span>
								</div>

								<!-- Bill details -->
								<div class="p-5">
									<div class="space-y-3 divide-y divide-blue-100">
										<!-- Base Price -->
										<div class="flex justify-between items-center pb-2">
											<div>
												<p class="text-sm text-gray-600 font-medium">Base Room Price</p>
												<p class="text-xs text-gray-500">Standard rate</p>
											</div>
											<p class="text-sm font-semibold">₩<?php echo number_format($room_price); ?>
											</p>
										</div>

										<!-- Per Night Rate with Guests -->
										<div class="flex justify-between items-center py-3">
											<div>
												<p class="text-sm text-gray-600 font-medium">Rate Per Night</p>
												<p class="text-xs text-gray-500">
													<span class="inline-flex items-center">
														<i class="las la-users text-blue-500 mr-1"></i>
														<?php echo $num_guests; ?>
														guest<?php echo $num_guests > 1 ? 's' : ''; ?>
													</span>
												</p>
											</div>
											<p class="text-sm font-semibold">
												₩<?php echo number_format($price_per_night); ?></p>
										</div>

										<!-- Duration -->
										<div class="flex justify-between items-center py-3">
											<div>
												<p class="text-sm text-gray-600 font-medium">Stay Duration</p>
												<p class="text-xs text-gray-500">
													<span class="inline-flex items-center">
														<i class="las la-calendar-day text-blue-500 mr-1"></i>
														<?php echo $days; ?> night<?php echo $days > 1 ? 's' : ''; ?>
													</span>
												</p>
											</div>
											<div class="text-right">
												<p class="text-sm font-semibold">
													₩<?php echo number_format($room_total); ?></p>
												<p class="text-xs text-gray-500">
													<?php echo number_format($price_per_night); ?> ×
													<?php echo $days; ?>
												</p>
											</div>
										</div>

										<!-- Extra Dive if applicable -->
										<?php if ($extra_dive_cost > 0): ?>
											<div class="flex justify-between items-center py-3">
												<div>
													<p class="text-sm text-gray-600 font-medium">
														<?php echo ucfirst($extra_dive); ?> Dive Package
													</p>
													<p class="text-xs text-gray-500">
														<span class="inline-flex items-center">
															<i class="las la-swimming-pool text-blue-500 mr-1"></i>
															Additional activity
														</span>
													</p>
												</div>
												<p class="text-sm font-semibold">
													₩<?php echo number_format($extra_dive_cost); ?></p>
											</div>
										<?php endif; ?>

										<!-- Total -->
										<div class="pt-4 mt-2">
											<div class="bg-blue-100 -mx-5 -mb-5 p-5 rounded-b-xl">
												<div class="flex justify-between items-center">
													<div>
														<p class="font-bold text-blue-900">Total</p>
														<p class="text-xs text-blue-700">
															<span class="inline-flex items-center">
																<i class="las la-info-circle mr-1"></i>
																All taxes included
															</span>
														</p>
													</div>
													<div class="text-right">
														<p class="text-2xl font-bold text-blue-900">
															₩<?php echo number_format($total_bill); ?></p>
														<p class="text-xs text-blue-700"><?php echo $days; ?>
															night<?php echo $days > 1 ? 's' : ''; ?> ·
															<?php echo $num_guests; ?>
															guest<?php echo $num_guests > 1 ? 's' : ''; ?>
														</p>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>

							<!-- Payment Status -->
							<div class="mt-5 flex items-center justify-end">
								<div
									class="inline-flex items-center px-4 py-2 rounded-lg bg-blue-50 border border-blue-100">
									<div
										class="h-2 w-2 rounded-full bg-<?php echo isset($fetch['payment_status']) && $fetch['payment_status'] == 'Paid' ? 'green' : 'yellow'; ?>-500 mr-2">
									</div>
									<span class="text-sm font-medium text-gray-700">
										<?php echo isset($fetch['payment_status']) ? $fetch['payment_status'] : 'Pending Payment'; ?>
									</span>
								</div>
							</div>
						</div>

						<!-- Action Buttons -->
						<div
							class="flex flex-col sm:flex-row justify-between items-center pt-5 border-t border-gray-200">
							<a href="pending_reserve.php"
								class="w-full sm:w-auto inline-flex items-center justify-center px-4 py-2 mb-3 sm:mb-0 border border-gray-300 text-gray-700 rounded-md shadow-sm hover:bg-gray-100 transition">
								<i class="las la-arrow-left mr-2"></i> Back to Reservations
							</a>

							<div class="flex space-x-3 w-full sm:w-auto">
								<a href="cancel_pending.php?transaction_id=<?php echo $fetch['transaction_id']; ?>"
									onclick="return confirmationDelete()"
									class="flex-1 sm:flex-initial inline-flex items-center justify-center px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 transition">
									<i class="las la-times-circle mr-2"></i> Discard
								</a>
								<button name="add_form"
									class="flex-1 sm:flex-initial inline-flex items-center justify-center px-5 py-2 bg-accent text-white rounded-md hover:bg-blue-700 transition">
									<i class="las la-check-circle mr-2"></i> Confirm Reservation
								</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</main>

	<script src="js/jquery.js"></script>

	<!-- Add this script to define the missing function -->
	<script>
		function handleMobileView() {
			// Toggle mobile menu visibility
			const sidebar = document.querySelector('.sidebar');
			const menuBtn = document.querySelector('#menu-btn');

			if (sidebar && menuBtn) {
				sidebar.classList.toggle('active');
				menuBtn.classList.toggle('active');
			}
		}

		// Add event listener for the menu button if it exists
		document.addEventListener('DOMContentLoaded', function () {
			const menuBtn = document.querySelector('#menu-btn');
			if (menuBtn) {
				menuBtn.addEventListener('click', handleMobileView);
			}

			// Handle resize events for responsive design
			window.addEventListener('resize', function () {
				if (window.innerWidth > 768) {
					const sidebar = document.querySelector('.sidebar');
					if (sidebar && sidebar.classList.contains('active')) {
						sidebar.classList.remove('active');
					}
				}
			});
		});
	</script>
</body>

</html>