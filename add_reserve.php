<?php

require('config.inc.php');
require('functions.php');

// Check if room_id is provided
if (!isset($_REQUEST['room_id'])) {
	$_SESSION['error'] = "No room selected. Please choose a room first.";
	header("Location: reservation.php");
	exit;
}

// Validate other required parameters
if (!isset($_GET['checkin']) || !isset($_GET['checkout'])) {
	$_SESSION['error'] = "Missing check-in or check-out dates.";
	header("Location: reservation.php");
	exit;
}

?>

<!DOCTYPE html>
<html class="no-js">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>ScuBaConnect</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<link
		href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&family=Rajdhani:wght@700&family=Raleway:wght@400&display=swap"
		rel="stylesheet">
	<link rel="shortcut icon" href="favicon.ico">

	<!-- Animate.css -->
	<link rel="stylesheet" href="css/animate.css">
	<!-- Icomoon Icon Fonts-->
	<link rel="stylesheet" href="css/icomoon.css">
	<!-- Bootstrap  -->
	<link rel="stylesheet" href="css/bootstrap.css">
	<!-- Superfish -->
	<link rel="stylesheet" href="css/superfish.css">

	<link rel="stylesheet" href="css/style.css">
	<link rel="stylesheet" href="css/iziToast.min.css">
	<link rel="stylesheet" href="css/style3.css">
	<link rel="stylesheet" href="css/style4.css">

	<link rel="icon" href="/favicon.ico" type="image/x-icon">
	<link href="css/bootstrap.min.css" rel="stylesheet">

	<!-- Google Web Fonts -->
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link
		href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600&family=Nunito:wght@600;700;800&display=swap"
		rel="stylesheet">

	<!-- Icon Font Stylesheet -->
	<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

	<link rel="stylesheet" href="https://unpkg.com/aos@2.3.1/dist/aos.css">
	<link href='https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css' rel='stylesheet'>

	<script src="js/validation.js" defer></script>

	<!-- Modernizr JS -->
	<script src="js/modernizr-2.6.2.min.js"></script>


	<style>
		/* Main Form Container Styles */
		.reservation-container {
			background-color: #f8f9fa;
			border-radius: 15px;
			box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
			padding: 40px 30px;
			margin: 30px auto;
			max-width: 1200px;
		}

		.reservation-title {
			text-align: center;
			margin-bottom: 30px;
			color: #334155;
			font-size: 28px;
			font-weight: 700;
		}

		.reservation-title:after {
			content: "";
			display: block;
			width: 80px;
			height: 4px;
			background: linear-gradient(to right, #00bcd4, #3498db);
			margin: 15px auto 0;
			border-radius: 2px;
		}

		/* Form Field Styling */
		.form-group {
			margin-bottom: 22px;
		}

		.form-group label {
			font-weight: 600;
			font-size: 14px;
			color: #4a5568;
			margin-bottom: 8px;
			display: block;
		}

		.form-control {
			height: 50px;
			border-radius: 8px;
			border: 1px solid #e2e8f0;
			padding: 10px 15px;
			font-size: 15px;
			transition: all 0.3s ease;
			background-color: #fff;
		}

		.form-control:focus {
			border-color: #00bcd4;
			box-shadow: 0 0 0 3px rgba(0, 188, 212, 0.15);
		}

		/* Select Dropdown Styling */
		select.form-control {
			appearance: none;
			background-image: url("data:image/svg+xml;charset=utf-8,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' viewBox='0 0 24 24' fill='none' stroke='%234a5568' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpath d='M6 9l6 6 6-6'/%3E%3C/svg%3E");
			background-repeat: no-repeat;
			background-position: right 15px center;
			padding-right: 45px;
		}

		/* Button Styling */
		.btn-reservation {
			background: linear-gradient(135deg, #00bcd4, #007bff);
			border: none;
			color: white;
			height: 54px;
			border-radius: 8px;
			font-weight: 600;
			font-size: 16px;
			text-transform: uppercase;
			letter-spacing: 1px;
			transition: all 0.3s ease;
			box-shadow: 0 4px 15px rgba(0, 188, 212, 0.3);
			margin-top: 10px;
		}

		.btn-reservation:hover {
			transform: translateY(-2px);
			box-shadow: 0 7px 20px rgba(0, 188, 212, 0.4);
			background: linear-gradient(135deg, #00acc1, #0069d9);
		}

		.btn-reservation:active {
			transform: translateY(1px);
		}

		.btn-reservation i {
			margin-right: 10px;
		}

		/* Receipt Summary Styling */
		.receipt-container {
			background-color: #fff;
			border-radius: 12px;
			box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
			padding: 25px;
			height: 100%;
		}

		.receipt-container h4 {
			color: #334155;
			font-weight: 700;
			font-size: 20px;
			margin-bottom: 20px;
			padding-bottom: 15px;
			border-bottom: 2px solid #f1f5f9;
		}

		.receipt-item {
			display: flex;
			justify-content: space-between;
			margin-bottom: 12px;
			font-size: 15px;
		}

		.receipt-item strong {
			color: #4a5568;
		}

		.receipt-total {
			margin-top: 20px;
			padding-top: 15px;
			border-top: 2px solid #f1f5f9;
			font-size: 18px;
			font-weight: 700;
			color: #334155;
			display: flex;
			justify-content: space-between;
		}

		/* Room Info Section */
		.room-info {
			background-color: rgba(0, 188, 212, 0.1);
			border-radius: 12px;
			padding: 20px;
			margin-bottom: 30px;
			text-align: center;
		}

		.room-type {
			font-size: 24px;
			color: #334155;
			margin-bottom: 5px;
		}

		.room-price {
			font-size: 22px;
			color: #10b981;
			font-weight: 700;
		}

		.step.active .step-icon {
			background-color: #007bff !important;
			color: white !important;
			border: none !important;
		}

		.step.active p {
			font-weight: bold;
			color: #007bff;
		}

		.step:hover .step-icon {
			transform: scale(1.1);
			transition: transform 0.3s;
		}

		/* Responsive Adjustments */
		@media (max-width: 768px) {
			.reservation-container {
				padding: 30px 20px;
			}

			.form-container,
			.receipt-container {
				margin-bottom: 30px;
			}
		}
	</style>
</head>

<body>
	<section class="class">
		<?php include('header.inc.php') ?>

		<?php include('success.alert.inc.php') ?>
		<?php include('fail.alert.inc.php') ?>

		<br><br>
		<?php include('signup.inc.php') ?>
		<?php include('login.inc.php') ?>
		<?php include('post.edit.inc.php') ?>
	</section>

	<!-- Updated Form Structure -->
	<div class="reservation-container">
		<h3 class="reservation-title">MAKE A RESERVATION</h3>

		<div class="container mb-5" style="margin-top: 0 !important;">
			<div class="row justify-content-center">
				<div class="col-md-8">
					<div class="position-relative py-4">
						<div class="progress" style="height: 3px;">
							<div class="progress-bar bg-primary" role="progressbar" style="width: 50%;"
								aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
						</div>
						<div class="row position-absolute w-100" style="top: 0;">
							<div class="col-6 text-center">
								<div class="step ">
									<div class="step-icon rounded-circle bg-primary text-white d-inline-flex align-items-center justify-content-center"
										style="width: 50px; height: 50px;"><i class="fas fa-check"></i></div>
									<p class="mt-2 font-weight-bold">Choose Room</p>
								</div>
							</div>
							<div class="col-6 text-center">
								<div class="step active">
									<div class="step-icon rounded-circle bg-light border d-inline-flex align-items-center justify-content-center"
										style="width: 50px; height: 50px;">2</div>
									<p class="mt-2">Checkout</p>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<?php
		$query = $con->query("SELECT * FROM `room` WHERE `room_id` = '$_REQUEST[room_id]'");
		$fetch = $query->fetch_array();
		$room_price = $fetch['price']; // Room price per night
		?>

		<div class="room-info">
			<h3 class="room-type"><?php echo $fetch['room_type'] ?></h3>
			<div class="room-price"><?php echo "₩" . number_format($room_price) . ".00"; ?></div>
		</div>

		<div class="row">
			<div class="col-md-7">
				<div class="form-container">
					<form method="POST" action="stripecheckout.php" enctype="multipart/form-data" id="reservationForm">
						<input type="hidden" name="checkin" id="checkin" value="<?php echo $_GET['checkin']; ?>">
						<input type="hidden" name="checkout" id="checkout" value="<?php echo $_GET['checkout']; ?>">
						<input type="hidden" name="days" id="days">

						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label for="firstname">First Name</label>
									<input type="text" class="form-control" id="firstname" name="firstname"
										placeholder="Enter your first name" required />
								</div>
							</div>
							<input type="hidden" name="room_id" value="<?php echo $_REQUEST['room_id']; ?>">
							<div class="col-md-6">
								<div class="form-group">
									<label for="lastname">Last Name</label>
									<input type="text" class="form-control" id="lastname" name="lastname"
										placeholder="Enter your last name" required />
								</div>
							</div>
						</div>

						<div class="form-group">
							<label for="middlename">Middle Name</label>
							<input type="text" class="form-control" id="middlename" name="middlename"
								placeholder="Enter your middle name" required />
						</div>

						<div class="form-group">
							<label for="address">Address</label>
							<input type="text" class="form-control" id="address" name="address"
								placeholder="Enter your address" required />
						</div>

						<div class="form-group">
							<label for="contactno">Contact Number</label>
							<input type="text" class="form-control" id="contactno" name="contactno"
								placeholder="Enter your contact number" required />
						</div>

						<!-- Add this after the contact number field -->
						<div class="form-group">
							<label for="email">Email Address</label>
							<input type="email" class="form-control" id="email" name="email"
								placeholder="Enter your email address" required />
						</div>

						<div class="form-group">
							<label for="extra_dive">Extra Dive Option</label>
							<select name="extra_dive" id="extra_dive" class="form-control">
								<option value="none" data-price="0">No Extra Dive</option>
								<option value="morning" data-price="12600">Morning Dive (₩12,600)</option>
								<option value="night" data-price="25200">Night Dive (₩25,200)</option>
							</select>
						</div>

						<div class="form-group">
							<label for="num_guests">Number of Guests</label>
							<select name="num_guests" id="num_guests" class="form-control" required>
								<?php
								// Set max guests based on room type
								$max_guests = ($fetch['room_type'] == "Family Room") ? 5 : 2;

								// Generate options from 1 to max_guests
								for ($i = 1; $i <= $max_guests; $i++) {
									echo "<option value=\"$i\">$i</option>";
								}
								?>
							</select>
							<small class="form-text text-muted">
								<?php echo ($fetch['room_type'] == "Family Room") ?
									"Family Room can accommodate up to 5 guests" :
									"Regular Room can accommodate up to 2 guests"; ?>
							</small>
						</div>

						<!-- Add this to your form in add_reserve.php -->
						<input type="hidden" name="reservation_id" value="<?php echo uniqid('SCUBA-'); ?>">

						<div class="form-group">
							<button class="btn btn-reservation form-control" name="add_guest">
								<i class="fas fa-calendar-check"></i> Complete Reservation
							</button>
						</div>
					</form>
				</div>
			</div>

			<div class="col-md-5">
				<div class="receipt-container">
					<h4>Receipt Summary</h4>

					<div class="receipt-item">
						<strong>Room Type:</strong>
						<span><?php echo $fetch['room_type']; ?></span>
					</div>

					<div class="receipt-item">
						<strong>Base Price Per Night:</strong>
						<span>₩<?php echo number_format($room_price); ?></span>
					</div>

					<div class="receipt-item">
						<strong>Number of Guests:</strong>
						<span><span id="numGuests">1</span></span>
					</div>

					<div class="receipt-item">
						<strong>Price Per Night:</strong>
						<span>₩<span id="pricePerNight"><?php echo number_format($room_price); ?></span></span>
					</div>

					<div class="receipt-item">
						<strong>Stay Duration:</strong>
						<span><span id="stayDuration">0</span> Nights</span>
					</div>

					<div class="receipt-item">
						<strong>Room Total:</strong>
						<span>₩<span id="roomTotal">0</span></span>
					</div>

					<div class="receipt-item">
						<strong>Extra Dive:</strong>
						<span>₩<span id="extraDiveCost">0</span></span>
					</div>

					<div class="receipt-total">
						<strong>Total Bill:</strong>
						<span>₩<span id="totalBill">0</span></span>
					</div>

				</div>
			</div>
		</div>
	</div>




	<footer>
		<div id="footer">
			<div class="container">
				<div class="row">
					<div class="col-md-6 col-md-offset-3 text-center">
						<p class="fh5co-social-icons">
							<a href="#"><i class="icon-twitter2"></i></a>
							<a href="#"><i class="icon-facebook2"></i></a>
							<a href="#"><i class="icon-instagram"></i></a>
							<a href="#"><i class="icon-dribbble2"></i></a>
							<a href="#"><i class="icon-youtube"></i></a>
						</p>
						<p>Copyright Sabang Beach Club <a href="#">ScuBaConnect</a>. All Rights Reserved.
							<br>Made with <i class="icon-heart3"></i> by Group 7
						</p>
					</div>
				</div>
			</div>
		</div>
	</footer>

	<!-- jQuery -->
	<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
	<script>
		AOS.init();
	</script>

	<script>
		document.addEventListener("DOMContentLoaded", function () {
			function calculateTotal() {
				let checkin = new Date(document.getElementById("checkin").value);
				let checkout = new Date(document.getElementById("checkout").value);
				let roomPrice = <?php echo $room_price; ?>;
				let numGuests = parseInt(document.getElementById("num_guests").value);
				let extraDiveDropdown = document.getElementById("extra_dive");
				let extraDiveCost = parseInt(extraDiveDropdown.options[extraDiveDropdown.selectedIndex].getAttribute("data-price"));

				// Calculate number of nights
				let stayDuration = (checkout - checkin) / (1000 * 60 * 60 * 24);
				if (stayDuration < 1) stayDuration = 1; // Prevent 0-night stays

				// Update the hidden input field
				document.getElementById("days").value = stayDuration;

				// Calculate costs
				// First multiply room price by number of guests, then by stay duration
				let pricePerNight = roomPrice * numGuests;
				let roomTotal = pricePerNight * stayDuration;
				let totalBill = roomTotal + extraDiveCost;

				// Update receipt
				document.getElementById("stayDuration").innerText = stayDuration;
				document.getElementById("numGuests").innerText = numGuests;
				document.getElementById("pricePerNight").innerText = pricePerNight.toLocaleString();
				document.getElementById("roomTotal").innerText = roomTotal.toLocaleString();
				document.getElementById("extraDiveCost").innerText = extraDiveCost.toLocaleString();
				document.getElementById("totalBill").innerText = totalBill.toLocaleString();
			}

			// Initial calculation
			calculateTotal();

			// Recalculate when inputs change
			document.getElementById("extra_dive").addEventListener("change", calculateTotal);
			document.getElementById("num_guests").addEventListener("change", calculateTotal);
		});
	</script>


	<script src="js/jquery.min.js"></script>
	<!-- jQuery Easing -->
	<script src="js/jquery.easing.1.3.js"></script>
	<!-- Bootstrap -->
	<script src="js/bootstrap.min.js"></script>
	<!-- Waypoints -->
	<script src="js/jquery.waypoints.min.js"></script>
	<!-- Stellar -->
	<script src="js/jquery.stellar.min.js"></script>
	<!-- Superfish -->
	<script src="js/hoverIntent.js"></script>
	<script src="js/superfish.js"></script>

	<!-- Main JS -->
	<script src="js/main.js"></script>
	<script src="js/jquery.js"></script>
	<script src="js/bootstrap.js"></script>
	<script src="js/iziToast.min.js"></script>

</body>

</html>