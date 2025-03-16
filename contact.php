<?php

require('config.inc.php');
require('functions.php');

$page = $_GET['page'] ?? 1;
$page = (int) $page;

if ($page < 1)
	$page = 1;

?>

<!DOCTYPE html>
<html class="exclude">

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
	<link rel="stylesheet" href="css/iziToast.min.css">
	<link rel="stylesheet" href="css/style.css">
	<link rel="stylesheet" href="css/style2.css">
	<link rel="stylesheet" href="css/style3.css">
	<link href='https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css' rel='stylesheet'>
	<link rel="icon" href="/favicon.ico" type="image/x-icon">
	<link href="css/bootstrap.min.css" rel="stylesheet">

	<script src="js/validation.js" defer></script>

	<!-- Modernizr JS -->
	<script src="js/modernizr-2.6.2.min.js"></script>

	<script>
		(function (b, r, a, i, n, y) {
			b.ux = b.ux || function () { (b.ux.q = b.ux.q || []).push(arguments) };
			n = r.getElementsByTagName('head')[0]; y = r.createElement('script'); y.async = 1; y.src = a + i;
			n.appendChild(y);
		})(window, document, 'https://api.brainybear.ai/cdn/js/bear', '.js?id=1428');
	</script>

	<style>
		/* Ocean Waves Animation */
		.ocean-waves {
			position: relative;
			width: 100%;
			height: 120px;
			overflow: hidden;
			margin: 0;
			padding: 0;
		}

		.wave {
			position: absolute;
			width: 200%;
			height: 120px;
			background-repeat: repeat-x;
			background-position: 0 bottom;
			transform-origin: center bottom;
		}

		.wave1 {
			background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 1200 120' preserveAspectRatio='none'%3E%3Cpath d='M0,0V46.29c47.79,22.2,103.59,32.17,158,28,70.36-5.37,136.33-33.31,206.8-37.5C438.64,32.43,512.34,53.67,583,72.05c69.27,18,138.3,24.88,209.4,13.08,36.15-6,69.85-17.84,104.45-29.34C989.49,25,1113-14.29,1200,52.47V0Z' fill='%235988c0' opacity='.25'%3E%3C/path%3E%3C/svg%3E");
			z-index: 3;
			animation: wave-animation 10s linear infinite;
		}

		.wave2 {
			background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 1200 120' preserveAspectRatio='none'%3E%3Cpath d='M0,0V46.29c47.79,22.2,103.59,32.17,158,28,70.36-5.37,136.33-33.31,206.8-37.5C438.64,32.43,512.34,53.67,583,72.05c69.27,18,138.3,24.88,209.4,13.08,36.15-6,69.85-17.84,104.45-29.34C989.49,25,1113-14.29,1200,52.47V0Z' fill='%234a76a8' opacity='.5'%3E%3C/path%3E%3C/svg%3E");
			z-index: 2;
			animation: wave-animation 8s linear infinite;
		}

		.wave3 {
			background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 1200 120' preserveAspectRatio='none'%3E%3Cpath d='M0,0V46.29c47.79,22.2,103.59,32.17,158,28,70.36-5.37,136.33-33.31,206.8-37.5C438.64,32.43,512.34,53.67,583,72.05c69.27,18,138.3,24.88,209.4,13.08,36.15-6,69.85-17.84,104.45-29.34C989.49,25,1113-14.29,1200,52.47V0Z' fill='%233b5998'%3E%3C/path%3E%3C/svg%3E");
			z-index: 1;
			animation: wave-animation 6s linear infinite;
		}

		@keyframes wave-animation {
			0% {
				transform: translateX(0) translateZ(0);
			}

			50% {
				transform: translateX(-25%) translateZ(0);
			}

			100% {
				transform: translateX(-50%) translateZ(0);
			}
		}

		/* Inverted waves (for top of sections) */
		.ocean-waves.inverted {
			transform: rotate(180deg);
			margin-top: -2px;
			/* Changed from margin-bottom */
			z-index: 1;
		}

		/* Variations for different sections */
		.ocean-waves.blue-theme .wave3 {
			background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 1200 120' preserveAspectRatio='none'%3E%3Cpath d='M0,0V46.29c47.79,22.2,103.59,32.17,158,28,70.36-5.37,136.33-33.31,206.8-37.5C438.64,32.43,512.34,53.67,583,72.05c69.27,18,138.3,24.88,209.4,13.08,36.15-6,69.85-17.84,104.45-29.34C989.49,25,1113-14.29,1200,52.47V0Z' fill='%234a76a8'%3E%3C/path%3E%3C/svg%3E");
		}


		.container {
			max-width: 95%;
		}

		h2 {
			font-size: 2rem;
			margin-bottom: 20px;
		}

		table {
			width: 100%;
			font-size: 1.1rem;
			text-align: center;
		}

		th,
		td {
			padding: 15px;
			vertical-align: middle;
		}

		thead {
			background-color: #007bff;
			color: white;
		}

		tbody tr:nth-child(even) {
			background-color: #f2f2f2;
		}

		.btn-small {
			padding: 5px 10px;
			font-size: 0.9rem;
		}

		.read {
			color: green;
			font-weight: bold;
		}

		.unread {
			color: red;
			font-weight: bold;
		}

		@media (max-width: 768px) {
			table {
				font-size: 0.9rem;
			}

			th,
			td {
				padding: 10px;
			}
		}
	</style>

</head>

<body>
	<section class="class">
		<?php include('header.inc.php') ?>

		<div class="fh5co-hero">
			<div class="fh5co-overlay"></div>
			<div class="fh5co-cover text-center" id="hero-cover" data-stellar-background-ratio="0.5"
				style="background-image: url(images/coverbg1.jpg);">
				<div class="desc animate-box">
					<h2>Contacs Us</h2>
					<span><a class="btn btn-primary btn-lg" href="reservation.php">Book Now</a></span>
				</div>
			</div>
		</div>

		<?php include('success.alert.inc.php') ?>
		<?php include('fail.alert.inc.php') ?>
		<!-- Animated Wave Section (Mountain-like) -->
		<div class="ocean-waves">
			<div class="wave wave1"></div>
			<div class="wave wave2"></div>
			<div class="wave wave3"></div>
		</div>
		<br><br>
		<?php include('signup.inc.php') ?>
		<?php include('login.inc.php') ?>
		<?php include('post.edit.inc.php') ?>

	</section>

	<div id="fh5co-contact" class="fh5co-section animate-box">
		<div class="container">
			<form id="contactForm" action="contact_process.php" method="POST">
				<div class="row">
					<div class="col-md-6">
						<h3 class="section-title">Our Address</h3>
						<p>Far far away, beside the wide sea.</p>
						<ul class="contact-info">
							<li><i class="icon-location-pin"></i>
								<h1>Sabang Puerto Galera Oriental Mindoro</h1>
							</li>
							<li><i class="icon-phone2"></i>
								<h1>+ 1235 2355 98</h1>
							</li>
							<li><i class="icon-mail"></i>
								<h1>scubaconnet30b@gmail.com</h1>
							</li>
							<li><i class="icon-globe2"></i>
								<h1>www.ScubaConnect.com</h1>
							</li>
						</ul>
					</div>
					<div class="col-md-6">
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<input type="text" name="name" class="form-control" placeholder="Name" required>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<input type="email" name="email" class="form-control" placeholder="Email" required>
								</div>
							</div>
							<div class="col-md-12">
								<div class="form-group">
									<textarea name="message" class="form-control" cols="30" rows="7"
										placeholder="Message" required></textarea>
								</div>
							</div>
							<div class="col-md-12">
								<div class="form-group">
									<input type="submit" name="submit" value="Send Message"
										class="btn btn-primary btn-lg">
								</div>
							</div>
						</div>
					</div>
				</div>
			</form>
		</div>
	</div>
	<!-- Animated Wave Section (Mountain-like) -->
	<div class="ocean-waves inverted">
		<div class="wave wave1"></div>
		<div class="wave wave2"></div>
		<div class="wave wave3"></div>
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
						<p>Copyright Sabang Beach Club <a href="#">ScuBaConnect</a>. All Rights Reserved. <br>Made with
							<i class="icon-heart3"></i> by Group 7
						</p>
					</div>
				</div>
			</div>
		</div>
		</div>
	</footer>


	</div>
	<!-- END fh5co-page -->

	</div>
	<!-- END fh5co-wrapper -->

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

	<!-- Google Map -->
	<script
		src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCefOgb1ZWqYtj7raVSmN4PL2WkTrc-KyA&sensor=false"></script>
	<script src="js/google_map.js"></script>

	<!-- Main JS -->
	<script src="js/main.js"></script>
	<script src="js/iziToast.min.js"></script>
	<script>
		document.addEventListener('DOMContentLoaded', function () {
			const contactForm = document.getElementById('contactForm');

			if (contactForm) {
				contactForm.addEventListener('submit', function (e) {
					e.preventDefault();

					// Show loading toast
					iziToast.info({
						title: 'Sending',
						message: 'Sending your message...',
						position: 'topRight',
						timeout: 2000
					});

					// Create form data object
					const formData = new FormData(contactForm);

					// Send AJAX request
					fetch('contact_process.php', {
						method: 'POST',
						body: formData
					})
						.then(response => response.json())
						.then(data => {
							if (data.success) {
								iziToast.success({
									title: 'Success',
									message: data.message,
									position: 'topRight',
									timeout: 5000
								});
								document.getElementById('contactForm').reset();
							} else {
								iziToast.error({
									title: 'Error',
									message: data.message,
									position: 'topRight',
									timeout: 5000
								});
							}
						})
						.catch(error => {
							iziToast.error({
								title: 'Error',
								message: 'Something went wrong. Please try again.',
								position: 'topRight',
								timeout: 5000
							});
						});
				});
			}
		});
	</script>

</body>

</html>