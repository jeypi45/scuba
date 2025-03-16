<?php
// At the top of diving.php
require 'config.inc.php';
require 'functions.php';

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
	<!-- FOR IE9 below -->
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

		.search-filter-container {
			background-color: #f8f9fa;
			padding: 30px 0;
			box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
		}

		.filter-form {
			margin: 20px 0;
		}

		.filter-form .form-group {
			margin-bottom: 15px;
		}

		/* Dive site item data attributes */
		.fh5co-item-wrap[data-filtered="hidden"] {
			display: none;
		}

		/* Result message */
		.no-results-message {
			text-align: center;
			padding: 30px;
			font-size: 18px;
			color: #777;
		}
	</style>

</head>

<body>
	<section class="class">
		<?php include 'header.inc.php' ?>

		<div class="fh5co-hero">
			<div class="fh5co-overlay"></div>
			<div class="fh5co-cover text-center" id="hero-cover" data-stellar-background-ratio="0.5"
				style="background-image: url(images/coverbg1.jpg);">
				<div class="desc animate-box">
					<h2>Dive Sites</h2>
					<span><a class="btn btn-primary btn-lg" href="reservation.php">Book Now</a></span>
				</div>
			</div>
		</div>

		<?php include 'success.alert.inc.php' ?>
		<?php include 'fail.alert.inc.php' ?>

		<!-- Animated Wave Section -->
		<div class="ocean-waves">
			<div class="wave wave1"></div>
			<div class="wave wave2"></div>
			<div class="wave wave3"></div>
		</div>
		<!-- Add Search and Filter Section -->
		<div class="search-filter-container">
			<div class="container">
				<div class="row">
					<div class="col-md-12">
						<h3 class="text-center">Find Your Perfect Dive Site</h3>
						<div class="filter-form">
							<div class="row">
								<div class="col-md-4">
									<div class="form-group">
										<input type="text" id="site-search" class="form-control"
											placeholder="Search dive sites...">
									</div>
								</div>
								<div class="col-md-3">
									<div class="form-group">
										<select id="fish-filter" class="form-control">
											<option value="">All Fish Types</option>
											<option value="anemonefish">Anemonefish</option>
											<option value="angelfish">Angelfish</option>
											<option value="batfish">Batfish</option>
											<option value="butterflyfish">Butterflyfish</option>
											<option value="clownfish">Clownfish</option>
											<option value="coral">Coral Fish</option>
											<option value="damselfish">Damselfish</option>
											<option value="grouper">Groupers</option>
											<option value="invertebrates">Invertebrates</option>
											<option value="lionfish">Lionfish</option>
											<option value="moray">Moray Eels</option>
											<option value="nudibranch">Nudibranchs</option>
											<option value="octopus">Octopus</option>
											<option value="parrotfish">Parrotfish</option>
											<option value="pufferfish">Pufferfish</option>
											<option value="ray">Rays</option>
											<option value="seahorse">Seahorses</option>
											<option value="shark">Sharks</option>
											<option value="snapper">Snappers</option>
											<option value="surgeonfish">Surgeonfish</option>
											<option value="sweetlips">Sweetlips</option>
											<option value="turtle">Sea Turtles</option>
										</select>
									</div>
								</div>
								<div class="col-md-3">
									<div class="form-group">
										<select id="level-filter" class="form-control">
											<option value="">All Dive Levels</option>
											<option value="beginner">Beginner</option>
											<option value="intermediate">Intermediate</option>
											<option value="advanced">Advanced</option>
										</select>
									</div>
								</div>
								<div class="col-md-2">
									<div class="form-group">
										<select id="type-filter" class="form-control">
											<option value="">All Dive Site Types</option>
											<option value="reef">Reef</option>
											<option value="wreck">Wreck</option>
											<option value="wall">Wall</option>
											<option value="slope">Slope</option>
											<option value="drift">Drift</option>
											<option value="cave">Cave</option>
											<option value="rock">Rock</option>
										</select>
									</div>
								</div>
								<div class="col-md-2">
									<button id="reset-filters" class="btn btn-primary btn-block">Reset</button>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>


		<div class="fh5co-listing">
			<div class="container">
				<div class="row">
					<!-- Dry Dock (d1) -->
					<div class="col-md-4 fh5co-item-wrap" data-name="dry dock"
						data-fish="sweetlips,batfish,surgeonfish,grouper,snapper,lionfish,pufferfish,octopus,seahorse,anemonefish"
						data-level="advanced" data-type="reef">
						<a href="d1.php" class="fh5co-listing-item">
							<img src="images/dv1.png" alt="F" class="img-responsive">
							<div class="fh5co-listing-copy">
								<h2>Dry Dock</h2>
								<span class="icon">
									<i class="icon-chevron-right"></i>
								</span>
							</div>
						</a>
					</div>

					<!-- Lalaguna Point (d2) -->
					<div class="col-md-4 fh5co-item-wrap" data-name="lalaguna point"
						data-fish="coral,angelfish,butterflyfish,parrotfish" data-level="intermediate" data-type="reef">
						<a href="d2.php" class="fh5co-listing-item">
							<img src="images/dv2.png" alt="F" class="img-responsive">
							<div class="fh5co-listing-copy">
								<h2>Lalaguna Point</h2>
								<span class="icon">
									<i class="icon-chevron-right"></i>
								</span>
							</div>
						</a>
					</div>

					<!-- Alma Jane Wreck (d3) -->
					<div class="col-md-4 fh5co-item-wrap" data-name="alma jane wreck"
						data-fish="snapper,grouper,batfish,lionfish" data-level="intermediate" data-type="wreck">
						<a href="d3.php" class="fh5co-listing-item">
							<img src="images/dv3.png" alt="F" class="img-responsive">
							<div class="fh5co-listing-copy">
								<h2>Alma Jane Wreck</h2>
								<span class="icon">
									<i class="icon-chevron-right"></i>
								</span>
							</div>
						</a>
					</div>

					<!-- St. Christopher Wreck (d4) -->
					<div class="col-md-4 fh5co-item-wrap" data-name="st. christopher wreck"
						data-fish="batfish,grouper,snapper,lionfish" data-level="intermediate" data-type="wreck">
						<a href="d4.php" class="fh5co-listing-item">
							<img src="images/dv4.png" alt="F" class="img-responsive">
							<div class="fh5co-listing-copy">
								<h2>St. Christopher Wreck</h2>
								<span class="icon">
									<i class="icon-chevron-right"></i>
								</span>
							</div>
						</a>
					</div>

					<!-- Sabang Reef (d5) -->
					<div class="col-md-4 fh5co-item-wrap" data-name="sabang reef"
						data-fish="coral,angelfish,butterflyfish,parrotfish,damselfish,clownfish" data-level="beginner"
						data-type="reef">
						<a href="d5.php" class="fh5co-listing-item">
							<img src="images/dv5.png" alt="F" class="img-responsive">
							<div class="fh5co-listing-copy">
								<h2>Sabang Reef</h2>
								<span class="icon">
									<i class="icon-chevron-right"></i>
								</span>
							</div>
						</a>
					</div>

					<!-- Sabang Wreck (d6) -->
					<div class="col-md-4 fh5co-item-wrap" data-name="sabang wreck"
						data-fish="grouper,snapper,lionfish,batfish" data-level="intermediate" data-type="wreck">
						<a href="d6.php" class="fh5co-listing-item">
							<img src="images/dv6.png" alt="F" class="img-responsive">
							<div class="fh5co-listing-copy">
								<h2>Sabang Wreck</h2>
								<span class="icon">
									<i class="icon-chevron-right"></i>
								</span>
							</div>
						</a>
					</div>

					<!-- Sabang Point (d7) -->
					<div class="col-md-4 fh5co-item-wrap" data-name="sabang point"
						data-fish="coral,angelfish,butterflyfish,parrotfish,damselfish" data-level="beginner"
						data-type="reef">
						<a href="d7.php" class="fh5co-listing-item">
							<img src="images/dv7.png" alt="F" class="img-responsive">
							<div class="fh5co-listing-copy">
								<h2>Sabang Point</h2>
								<span class="icon">
									<i class="icon-chevron-right"></i>
								</span>
							</div>
						</a>
					</div>

					<!-- Monkey Wreck (d8) -->
					<div class="col-md-4 fh5co-item-wrap" data-name="monkey wreck"
						data-fish="grouper,snapper,batfish,lionfish" data-level="intermediate" data-type="wreck">
						<a href="d8.php" class="fh5co-listing-item">
							<img src="images/dv8.png" alt="F" class="img-responsive">
							<div class="fh5co-listing-copy">
								<h2>Monkey Wreck</h2>
								<span class="icon">
									<i class="icon-chevron-right"></i>
								</span>
							</div>
						</a>
					</div>

					<!-- Monkey Beach (d9) -->
					<div class="col-md-4 fh5co-item-wrap" data-name="monkey beach"
						data-fish="coral,damselfish,angelfish,butterflyfish,ray" data-level="beginner,intermediate"
						data-type="slope">
						<a href="d9.php" class="fh5co-listing-item">
							<img src="images/dv9.png" alt="F" class="img-responsive">
							<div class="fh5co-listing-copy">
								<h2>Monkey Beach</h2>
								<span class="icon">
									<i class="icon-chevron-right"></i>
								</span>
							</div>
						</a>
					</div>

					<!-- Ernie's Point (d10) -->
					<div class="col-md-4 fh5co-item-wrap" data-name="ernies point"
						data-fish="coral,angelfish,butterflyfish,ray,turtle" data-level="intermediate"
						data-type="cave,reef">
						<a href="d10.php" class="fh5co-listing-item">
							<img src="images/dv1.png" alt="F" class="img-responsive">
							<div class="fh5co-listing-copy">
								<h2>Ernie's Point</h2>
								<span class="icon">
									<i class="icon-chevron-right"></i>
								</span>
							</div>
						</a>
					</div>

					<!-- Dungon Beach/Wall (d11) -->
					<div class="col-md-4 fh5co-item-wrap" data-name="dungon beach wall"
						data-fish="coral,angelfish,butterflyfish,ray,turtle" data-level="beginner,intermediate"
						data-type="wall,slope">
						<a href="d11.php" class="fh5co-listing-item">
							<img src="images/dv1.png" alt="F" class="img-responsive">
							<div class="fh5co-listing-copy">
								<h2>Dungon Beach/Wall</h2>
								<span class="icon">
									<i class="icon-chevron-right"></i>
								</span>
							</div>
						</a>
					</div>

					<!-- West Escarceo (d12) -->
					<div class="col-md-4 fh5co-item-wrap" data-name="west escarceo"
						data-fish="coral,butterflyfish,angelfish,shark,ray" data-level="beginner,intermediate,advanced"
						data-type="drift,reef">
						<a href="d12.php" class="fh5co-listing-item">
							<img src="images/dv1.png" alt="F" class="img-responsive">
							<div class="fh5co-listing-copy">
								<h2>West Escarceo</h2>
								<span class="icon">
									<i class="icon-chevron-right"></i>
								</span>
							</div>
						</a>
					</div>

					<!-- Fish Bowl (d13) -->
					<div class="col-md-4 fh5co-item-wrap" data-name="fish bowl"
						data-fish="coral,angelfish,butterflyfish,surgeonfish,damselfish,parrotfish,clownfish"
						data-level="advanced" data-type="reef">
						<a href="d13.php" class="fh5co-listing-item">
							<img src="images/dv1.png" alt="F" class="img-responsive">
							<div class="fh5co-listing-copy">
								<h2>Fish Bowl</h2>
								<span class="icon">
									<i class="icon-chevron-right"></i>
								</span>
							</div>
						</a>
					</div>

					<!-- Canyons (d14) -->
					<div class="col-md-4 fh5co-item-wrap" data-name="canyons"
						data-fish="coral,angelfish,butterflyfish,ray,shark" data-level="advanced" data-type="drift">
						<a href="d14.php" class="fh5co-listing-item">
							<img src="images/dv1.png" alt="F" class="img-responsive">
							<div class="fh5co-listing-copy">
								<h2>Canyons</h2>
								<span class="icon">
									<i class="icon-chevron-right"></i>
								</span>
							</div>
						</a>
					</div>

					<!-- Hole in the Wall (d15) -->
					<div class="col-md-4 fh5co-item-wrap" data-name="hole in the wall"
						data-fish="coral,angelfish,butterflyfish,grouper,snapper"
						data-level="beginner,intermediate,advanced" data-type="cave,wall">
						<a href="d15.php" class="fh5co-listing-item">
							<img src="images/dv1.png" alt="F" class="img-responsive">
							<div class="fh5co-listing-copy">
								<h2>Hole in the Wall</h2>
								<span class="icon">
									<i class="icon-chevron-right"></i>
								</span>
							</div>
						</a>
					</div>

					<!-- Pink Wall (d16) -->
					<div class="col-md-4 fh5co-item-wrap" data-name="pink wall"
						data-fish="coral,angelfish,butterflyfish,nudibranch,seahorse"
						data-level="beginner,intermediate,advanced" data-type="wall">
						<a href="d16.php" class="fh5co-listing-item">
							<img src="images/dv1.png" alt="F" class="img-responsive">
							<div class="fh5co-listing-copy">
								<h2>Pink Wall</h2>
								<span class="icon">
									<i class="icon-chevron-right"></i>
								</span>
							</div>
						</a>
					</div>

					<!-- Shark Cave (d17) -->
					<div class="col-md-4 fh5co-item-wrap" data-name="shark cave" data-fish="shark,ray,grouper,snapper"
						data-level="advanced" data-type="cave">
						<a href="d17.php" class="fh5co-listing-item">
							<img src="images/dv1.png" alt="F" class="img-responsive">
							<div class="fh5co-listing-copy">
								<h2>Shark Cave</h2>
								<span class="icon">
									<i class="icon-chevron-right"></i>
								</span>
							</div>
						</a>
					</div>

					<!-- Atoll (d18) -->
					<div class="col-md-4 fh5co-item-wrap" data-name="atoll"
						data-fish="coral,angelfish,butterflyfish,parrotfish,damselfish,clownfish" data-level="advanced"
						data-type="rock">
						<a href="d18.php" class="fh5co-listing-item">
							<img src="images/dv1.png" alt="F" class="img-responsive">
							<div class="fh5co-listing-copy">
								<h2>Atoll</h2>
								<span class="icon">
									<i class="icon-chevron-right"></i>
								</span>
							</div>
						</a>
					</div>

					<!-- Kilima Beach/Steps (d19) -->
					<div class="col-md-4 fh5co-item-wrap" data-name="kilima beach steps"
						data-fish="coral,damselfish,angelfish,butterflyfish" data-level="beginner,intermediate,advanced"
						data-type="reef">
						<a href="d19.php" class="fh5co-listing-item">
							<img src="images/dv1.png" alt="F" class="img-responsive">
							<div class="fh5co-listing-copy">
								<h2>Kilima Beach/Steps</h2>
								<span class="icon">
									<i class="icon-chevron-right"></i>
								</span>
							</div>
						</a>
					</div>

					<!-- Sinandigan Wall (d20) -->
					<div class="col-md-4 fh5co-item-wrap" data-name="sinandigan wall"
						data-fish="coral,angelfish,butterflyfish,ray,nudibranch"
						data-level="beginner,intermediate,advanced" data-type="wall,slope">
						<a href="d20.php" class="fh5co-listing-item">
							<img src="images/dv1.png" alt="F" class="img-responsive">
							<div class="fh5co-listing-copy">
								<h2>Sinandigan Wall</h2>
								<span class="icon">
									<i class="icon-chevron-right"></i>
								</span>
							</div>
						</a>
					</div>

					<!-- Turtle Rock (d21) -->
					<div class="col-md-4 fh5co-item-wrap" data-name="turtle rock"
						data-fish="turtle,coral,angelfish,butterflyfish" data-level="advanced" data-type="reef">
						<a href="d21.php" class="fh5co-listing-item">
							<img src="images/dv1.png" alt="F" class="img-responsive">
							<div class="fh5co-listing-copy">
								<h2>Turtle Rock</h2>
								<span class="icon">
									<i class="icon-chevron-right"></i>
								</span>
							</div>
						</a>
					</div>

					<!-- Coral Cove (d22) -->
					<div class="col-md-4 fh5co-item-wrap" data-name="coral cove"
						data-fish="coral,angelfish,butterflyfish,damselfish,clownfish"
						data-level="beginner,intermediate,advanced" data-type="slope,wall">
						<a href="d22.php" class="fh5co-listing-item">
							<img src="images/dv1.png" alt="F" class="img-responsive">
							<div class="fh5co-listing-copy">
								<h2>Coral Cove</h2>
								<span class="icon">
									<i class="icon-chevron-right"></i>
								</span>
							</div>
						</a>
					</div>

					<!-- Boulders (d23) -->
					<div class="col-md-4 fh5co-item-wrap" data-name="boulders"
						data-fish="coral,angelfish,butterflyfish,grouper,snapper" data-level="intermediate"
						data-type="cave">
						<a href="d23.php" class="fh5co-listing-item">
							<img src="images/dv1.png" alt="F" class="img-responsive">
							<div class="fh5co-listing-copy">
								<h2>Boulders</h2>
								<span class="icon">
									<i class="icon-chevron-right"></i>
								</span>
							</div>
						</a>
					</div>

					<!-- Japanese Wreck (d24) -->
					<div class="col-md-4 fh5co-item-wrap" data-name="japanese wreck"
						data-fish="moray,sweetlips,invertebrates" data-level="advanced" data-type="wreck">
						<a href="d24.php" class="fh5co-listing-item">
							<img src="images/dv1.png" alt="F" class="img-responsive">
							<div class="fh5co-listing-copy">
								<h2>Japanese Wreck</h2>
								<span class="icon">
									<i class="icon-chevron-right"></i>
								</span>
							</div>
						</a>
					</div>
					<!-- END 3 row -->

				</div>
			</div>
		</div>

		<br><br>
		<?php include 'signup.inc.php' ?>
		<?php include 'login.inc.php' ?>
		<?php include 'post.edit.inc.php' ?>

	</section>

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
	</footer>


	</div>
	<!-- END fh5co-page -->

	</div>
	<!-- END fh5co-wrapper -->

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
	<script src="js/validation.js" defer></script>
	<!-- Main JS -->
	<script src="js/main.js"></script>
	<script src="js/iziToast.min.js"></script>

	<script>

		document.addEventListener('DOMContentLoaded', function () {
			const searchInput = document.getElementById('site-search');
			const fishFilter = document.getElementById('fish-filter');
			const levelFilter = document.getElementById('level-filter');
			const typeFilter = document.getElementById('type-filter'); // Add this line
			const resetButton = document.getElementById('reset-filters');
			const diveSites = document.querySelectorAll('.fh5co-item-wrap');
			const listingContainer = document.querySelector('.fh5co-listing .container .row');

			// Function to filter dive sites
			function filterDiveSites() {
				const searchTerm = searchInput.value.toLowerCase();
				const selectedFish = fishFilter.value.toLowerCase();
				const selectedLevel = levelFilter.value.toLowerCase();
				const selectedType = typeFilter.value.toLowerCase(); // Add this line

				let visibleCount = 0;

				diveSites.forEach(site => {
					const name = site.getAttribute('data-name') || '';
					const fishTypes = site.getAttribute('data-fish') || '';
					const level = site.getAttribute('data-level') || '';
					const siteType = site.getAttribute('data-type') || ''; // Add this line

					const nameMatch = name.includes(searchTerm);
					const fishMatch = !selectedFish || fishTypes.includes(selectedFish);
					const levelMatch = !selectedLevel || level.split(',').map(l => l.trim()).includes(selectedLevel);
					const typeMatch = !selectedType || siteType.split(',').map(t => t.trim()).includes(selectedType); // Add this line

					if (nameMatch && fishMatch && levelMatch && typeMatch) { // Update condition
						site.setAttribute('data-filtered', 'visible');
						site.style.display = '';
						visibleCount++;
					} else {
						site.setAttribute('data-filtered', 'hidden');
						site.style.display = 'none';
					}
				});

				// Show message if no results
				const existingMessage = document.querySelector('.no-results-message');
				if (existingMessage) {
					existingMessage.remove();
				}

				if (visibleCount === 0) {
					const noResults = document.createElement('div');
					noResults.className = 'col-md-12 no-results-message';
					noResults.textContent = 'No dive sites match your search criteria. Please try different filters.';
					listingContainer.appendChild(noResults);
				}
			}

			// Event listeners
			searchInput.addEventListener('input', filterDiveSites);
			fishFilter.addEventListener('change', filterDiveSites);
			levelFilter.addEventListener('change', filterDiveSites);
			typeFilter.addEventListener('change', filterDiveSites); // Add this line

			// Reset filters
			resetButton.addEventListener('click', function () {
				searchInput.value = '';
				fishFilter.value = '';
				levelFilter.value = '';
				typeFilter.value = ''; // Add this line

				diveSites.forEach(site => {
					site.setAttribute('data-filtered', 'visible');
					site.style.display = '';
				});

				const existingMessage = document.querySelector('.no-results-message');
				if (existingMessage) {
					existingMessage.remove();
				}
			});
		});
	</script>

</body>

</html>