<?php
require('config.inc.php');
require('functions.php');

$page = $_GET['page'] ?? 1;
$page = (int) $page;
if ($page < 1)
	$page = 1;

$item_id = $_GET['item_id'] ?? 4;
$existing_rating = 0;

if (logged_in()) {
	$user_id = $_SESSION['USER']['id']; // Fix: Access user ID correctly

	$query = "SELECT rating FROM ratings WHERE user_id = ? AND item_id = ?";
	$stmt = mysqli_prepare($con, $query);
	mysqli_stmt_bind_param($stmt, "ii", $user_id, $item_id);
	mysqli_stmt_execute($stmt);
	$result = mysqli_stmt_get_result($stmt);

	if ($row = mysqli_fetch_assoc($result)) {
		$existing_rating = $row['rating']; // Get saved rating
	}

	mysqli_stmt_close($stmt);
}

?>


<!DOCTYPE html>
<html class="no-js">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>ScuBaConnect</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">


	<meta property="og:title" content="" />
	<meta property="og:image" content="" />
	<meta property="og:url" content="" />
	<meta property="og:site_name" content="" />
	<meta property="og:description" content="" />
	<meta name="twitter:title" content="" />
	<meta name="twitter:image" content="" />
	<meta name="twitter:url" content="" />
	<meta name="twitter:card" content="" />

	<link rel="shortcut icon" href="favicon.ico">

	<!-- Animate.css -->
	<link rel="stylesheet" href="css/animate.css">
	<!-- Icomoon Icon Fonts-->
	<link rel="stylesheet" href="css/icomoon.css">
	<!-- Bootstrap  -->
	<link rel="stylesheet" href="css/bootstrap.css">
	<!-- Superfish -->
	<link rel="stylesheet" href="css/superfish.css">
	<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
	<link rel="stylesheet" href="css/style.css">
	<link rel="stylesheet" href="css/style2.css">
	<link rel="stylesheet" href="css/style3.css">
	<link rel="stylesheet" href="css/style5.css">
	<link href='https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css' rel='stylesheet'>
	<link rel="icon" href="/favicon.ico" type="image/x-icon">

	<script src="js/validation.js" defer></script>

	<!-- Modernizr JS -->
	<script src="js/modernizr-2.6.2.min.js"></script>


</head>

<body>
	<section class="class">
		<?php include('header.inc.php') ?>

		<div class="fh5co-hero">
			<div class="fh5co-overlay"></div>
			<div class="fh5co-cover text-center" id="hero-cover" data-stellar-background-ratio="0.5"
				style="background-image: url(images/coverbg1.jpg);">
				<div class="desc animate-box">
					<h2>St. Christopher Wreck</h2>
					<span><a class="btn btn-primary btn-lg" href="#">Book Now</a></span>
				</div>
			</div>
		</div>

		<div class="ocean-waves">
			<div class="wave wave1"></div>
			<div class="wave wave2"></div>
			<div class="wave wave3"></div>
		</div>

		<?php include('success.alert.inc.php') ?>
		<?php include('fail.alert.inc.php') ?>

		<?php include('signup.inc.php') ?>
		<?php include('login.inc.php') ?>
		<?php include('post.edit.inc.php') ?>

		<!-- Main Content Section -->
		<section class="dive-site-container">
			<div class="container">
				<!-- Back Navigation -->
				<div class="back-navigation">
					<a href="diving.php" class="btn btn-outline-primary">
						<i class="icon-arrow-left"></i> Back to Dive Sites
					</a>
				</div>

				<!-- Dive Site Header -->
				<div class="dive-site-header">
					<h1 class="dive-site-title">St. Christopher Wreck</h1>
					<div class="dive-site-quick-info">
						<div class="info-badge">
							<i class="icon-arrow-down"></i>
							<span>Depth: 20-24m</span>
						</div>
						<div class="info-badge">
							<i class="icon-gauge"></i>
							<span>Intermediate</span>
						</div>
						<div class="info-badge">
							<i class="icon-compass"></i>
							<span>Wreck Dive</span>
						</div>
						<div class="info-badge">
							<i class="icon-clock2"></i>
							<span>45min Dive</span>
						</div>
					</div>
				</div>

				<!-- Location Map -->
				<div class="dive-site-map">
					<div id="map" class="main-dive-map"></div>
					<div class="map-overlay">
					</div>
				</div>

				<div class="dive-site-content">
					<div class="row">
						<!-- Left Column: Description -->
						<div class="col-md-8">
							<div class="content-card">
								<div class="card-header">
									<h2><i class="icon-info"></i> About This Dive Site</h2>
								</div>
								<div class="card-body">
									<p>
										<strong>St. Christopher</strong> is a retired 20m live-a-board dive boat sunk
										off the end of the
										El Galleon Pier in 1995. It is also known as Anton's Wreck. This is good start
										to begin exploring
										the reef fronting Small Lalaguna Beach.
									</p>
									<p>
										The wreck is home to various marine life including:
									</p>
									<ul class="marine-life-list">
										<li><i class="icon-fish"></i> Large Snapper</li>
										<li><i class="icon-fish"></i> Giant Frogfish</li>
										<li><i class="icon-fish"></i> Sergeant Majors</li>
										<li><i class="icon-fish"></i> Butterflyfish</li>
										<li><i class="icon-fish"></i> Wrasses</li>
									</ul>
									<p>
										After some time enjoying the large Snapper that live on the wreck, the current
										will propel
										you up to another wreck, The Speedboat, in 12m/40′. This little wreck is a real
										favourite
										since giant Frogfish reside here, watching large numbers of Sergeant Majors
										defend their
										purple eggs from opportunistic Butterflyfish and Wrasses.
									</p>
									<div class="dive-note">
										<i class="icon-warning"></i>
										<div>
											<strong>Note:</strong> This dive is suitable for intermediate divers and
											offers excellent
											photography opportunities due to the varied marine life and the wrecks'
											structures.
										</div>
									</div>
								</div>
							</div>
						</div>

						<!-- Right Column: Rating and Booking -->
						<div class="col-md-4">
							<!-- Rating Card -->
							<div class="content-card rating-card">
								<div class="card-header">
									<h3><i class="icon-star"></i> Diver Ratings</h3>
								</div>
								<div class="card-body">
									<div id="rating-section" data-item-id="4">
										<div id="average-rating">
											<div class="avg-rating-display">
												<span id="avg-rating">Loading...</span>
												<span class="out-of">/5</span>
											</div>
											<div class="rating-stars-display">
												<div class="stars-container"></div>
												<div class="rating-count" id="rating-count"></div>
											</div>
										</div>

										<?php if (logged_in()): ?>
											<div class="your-rating">
												<p>Rate this dive site:</p>
												<div class="rating">
													<span class="star" data-value="5">&#9733;</span>
													<span class="star" data-value="4">&#9733;</span>
													<span class="star" data-value="3">&#9733;</span>
													<span class="star" data-value="2">&#9733;</span>
													<span class="star" data-value="1">&#9733;</span>
												</div>
												<p id="rating-message"></p>
											</div>
										<?php else: ?>
											<div class="login-to-rate">
												<button class="btn btn-primary" onclick="login.show()">
													<i class="icon-user"></i> Log in to rate
												</button>
											</div>
										<?php endif; ?>
									</div>
								</div>
							</div>

							<!-- Booking Card -->
							<div class="content-card booking-card">
								<div class="card-header">
									<h3><i class="icon-calendar"></i> Book This Dive</h3>
								</div>
								<div class="card-body">
									<p>Ready to explore St. Christopher Wreck? Join our next dive trip!</p>
									<a href="reservation.php?dive=st-christopher-wreck"
										class="btn btn-primary btn-block">
										<i class="icon-ticket"></i> Book Now
									</a>
									<div class="certification-required">
										<i class="icon-info"></i> Open Water certification required
									</div>
								</div>
							</div>

							<!-- Special Features Card -->
							<div class="content-card">
								<div class="card-header">
									<h3><i class="icon-compass"></i> Wreck Features</h3>
								</div>
								<div class="card-body">
									<ul class="feature-list">
										<li><i class="icon-check"></i> Retired 20m live-aboard dive boat</li>
										<li><i class="icon-check"></i> Sunken in 1995</li>
										<li><i class="icon-check"></i> Also known as Anton's Wreck</li>
										<li><i class="icon-check"></i> Close to The Speedboat wreck</li>
										<li><i class="icon-check"></i> Great for underwater photography</li>
									</ul>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>

		<div class="ocean-waves inverted">
			<div class="wave wave1"></div>
			<div class="wave wave2"></div>
			<div class="wave wave3"></div>
		</div>
	</section>

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
	<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

	<script>
		// Initialize the map
		var map = L.map('map').setView([13.524022, 120.973874], 15); // St. Christopher Wreck coordinates

		// Load ESRI Satellite tiles
		L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', {
			attribution: '&copy; Esri & contributors'
		}).addTo(map);

		// Add a marker
		L.marker([13.524022, 120.973874]).addTo(map)
			.bindPopup('<b>St. Christopher Wreck</b><br>Diving Spot')
			.openPopup();
	</script>

	<script>
		document.addEventListener("DOMContentLoaded", function () {
			// Star rating functionality
			const stars = document.querySelectorAll(".star");
			const ratingMessage = document.getElementById("rating-message");
			const avgRating = document.getElementById("avg-rating");
			const ratingCount = document.getElementById("rating-count");
			const starsContainer = document.querySelector(".stars-container");
			const itemId = document.getElementById("rating-section").dataset.itemId;

			let existingRating = <?php echo json_encode($existing_rating); ?>;

			function highlightStars(value) {
				stars.forEach(star => {
					star.classList.toggle("active", star.dataset.value <= value);
				});
			}

			// Set initial state based on existing rating
			highlightStars(existingRating);

			// Update average rating stars display
			function updateStarsDisplay(rating) {
				if (!starsContainer) return;

				// Clear existing stars
				starsContainer.innerHTML = '';

				// Calculate full and partial stars
				const fullStars = Math.floor(rating);
				const hasHalfStar = rating % 1 >= 0.5;

				// Add full stars
				for (let i = 0; i < fullStars; i++) {
					starsContainer.innerHTML += '★';
				}

				// Add half star if needed
				if (hasHalfStar) {
					starsContainer.innerHTML += '★';
				}

				// Add empty stars
				const emptyStars = 5 - fullStars - (hasHalfStar ? 1 : 0);
				for (let i = 0; i < emptyStars; i++) {
					starsContainer.innerHTML += '☆';
				}
			}

			stars.forEach(star => {
				star.addEventListener("mouseover", function () {
					highlightStars(this.dataset.value);
				});

				star.addEventListener("mouseout", function () {
					highlightStars(existingRating);
				});

				star.addEventListener("click", function () {
					const rating = this.dataset.value;

					// Show loading state
					ratingMessage.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Saving...';

					fetch("submit_rating.php", {
						method: "POST",
						headers: { "Content-Type": "application/x-www-form-urlencoded" },
						body: "rating=" + rating + "&item_id=" + itemId
					})
						.then(response => response.json())
						.then(data => {
							if (data.success) {
								ratingMessage.innerHTML = "Thanks for your rating!";
								existingRating = rating;
								highlightStars(existingRating);
								getAverageRating();
							} else {
								ratingMessage.innerHTML = "Error submitting rating.";
							}
						});
				});
			});

			function getAverageRating() {
				fetch("get_rating.php?item_id=" + itemId)
					.then(response => response.json())
					.then(data => {
						if (data.average) {
							const average = parseFloat(data.average);
							avgRating.innerHTML = average.toFixed(1);
							updateStarsDisplay(average);

							if (data.count) {
								ratingCount.innerHTML = data.count;
							}
						} else {
							avgRating.innerHTML = "0.0";
							updateStarsDisplay(0);
						}
					});
			}

			// Initialize average rating display
			getAverageRating();
		});
	</script>
</body>

</html>