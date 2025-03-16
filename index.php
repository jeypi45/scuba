<?php

require('config.inc.php');
require('functions.php');

$page = $_GET['page'] ?? 1;
$page = (int) $page;

if ($page < 1)
	$page = 1;

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
	<link rel="stylesheet" href="css/iziToast.min.css">
	<link rel="stylesheet" href="css/style.css">
	<link rel="stylesheet" href="css/style2.css">
	<link rel="stylesheet" href="css/style3.css">

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

	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />


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
		body {
			background-image: url(images/background.jpg);
			background-attachment: fixed;
			background-size: cover;
			background-position: center;
		}

		/* Modern Service Cards */
		.service-item {
			transition: all 0.3s ease;
			border: 1px solid rgba(0, 0, 0, 0.05);
			overflow: hidden;
			background-color: white;
		}

		.shadow-hover {
			transition: all 0.3s ease;
		}

		.shadow-hover:hover {
			transform: translateY(-10px);
			box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1) !important;
		}

		.service-item .p-4 {
			display: flex;
			flex-direction: column;
			height: 100%;
		}

		.service-item h5 {
			font-size: 18px;
			font-weight: 600;
			color: #333;
			margin-bottom: 15px;
		}

		.service-item p {
			color: #666;
			line-height: 1.6;
			flex-grow: 1;
		}

		.service-item i {
			background-color: white;
			width: 70px;
			height: 70px;
			display: flex;
			align-items: center;
			justify-content: center;
			border-radius: 50%;
			margin: 0 auto 20px;
			transition: all 0.3s ease;
		}

		.service-item:hover i {
			background-color: #4a76a8;
			color: white !important;
			transform: rotateY(180deg);
		}

		.service-item:hover h5 {
			color: #4a76a8;
		}

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
			z-index: 1;
		}

		/* Section Title Styles */
		.section-title {
			position: relative;
			font-weight: 600;
			display: inline-block;
			background-color: rgba(255, 255, 255, 0.9);
			border-radius: 30px;
			padding: 8px 20px !important;
			box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
			border: 1px solid rgba(74, 118, 168, 0.2);
			margin-bottom: 10px;
		}



		.section-title.text-start::before {
			left: 20px;
			transform: none;
		}

		.bluetxt.section-title {
			color: #3b5998;
			letter-spacing: 0.5px;
			font-size: 14px;
			text-transform: uppercase;
		}

		.icon-box-card {
			background-color: white;
			border-radius: 10px;
			box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
			padding: 30px 20px;
			height: 100%;
			transition: all 0.3s ease;
		}

		.icon-box-card:hover {
			transform: translateY(-10px);
			box-shadow: 0 15px 30px rgba(0, 0, 0, 0.12);
		}

		.icon_box_icon {
			margin-bottom: 20px;
		}

		.icon_box_icon img {
			width: 70px;
			height: auto;
			transition: all 0.3s ease;
		}

		.icon-box-card:hover .icon_box_icon img {
			transform: scale(1.1);
		}

		/* Section Container */
		.section-container {
			background-color: rgba(255, 255, 255, 0.9);
			border-radius: 12px;
			padding: 15px 30px;
			box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
			display: inline-block;
			margin-bottom: 20px;
			position: relative;
			border: 1px solid rgba(74, 118, 168, 0.15);
			transition: all 0.3s ease;
		}

		.section-container:hover {
			box-shadow: 0 8px 25px rgba(0, 0, 0, 0.12);
			transform: translateY(-2px);
		}

		.section-container h1.mb-5 {
			margin-bottom: 0.5rem !important;
			padding-bottom: 0;
		}

		/* Card container */
		.card-container {
			background-color: rgba(255, 255, 255, 0.95);
			border-radius: 12px;
			box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
			padding: 30px;
			margin-bottom: 40px;
			backdrop-filter: blur(5px);
			border: 1px solid rgba(255, 255, 255, 0.2);
			overflow: hidden;
		}

		.card-container1 {
			background-color: rgba(255, 255, 255, 0.95);
			border-radius: 12px;
			box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
			padding: 30px;
			margin-bottom: 40px;
			backdrop-filter: blur(5px);
			border: 1px solid rgba(255, 255, 255, 0.2);
		}

		.frm {
			display: flex;
			justify-content: center;

		}

		/* Star Rating System */
		.your-rating .rating {
			direction: rtl;
			align-items: center;
			margin: 10px 0;
		}

		.your-rating .star {
			font-size: 24px;
			cursor: pointer;
			display: inline-block;
			padding: 0 3px;
		}

		.your-rating .star:hover,
		.your-rating .star:hover~.star {
			color: #ffc107;
		}

		.your-rating .star.active {
			color: #ffc107;
		}

		#rating-message {
			font-size: 14px;
			margin-top: 5px;
			color: #4a76a8;
			font-style: italic;
		}

		/* Swiper styles */
		.feedback-carousel .swiper-button-prev:after,
		.feedback-carousel .swiper-button-next:after {
			color: white;
			font-weight: bold;
			text-shadow: 0px 0px 3px rgba(0, 0, 0, 0.5);
		}

		.feedback-carousel .swiper-pagination {
			margin-top: 20px;
		}

		.feedback-carousel .swiper-pagination-bullet {
			background: white;
			opacity: 0.7;
		}

		.feedback-carousel .swiper-pagination-bullet-active {
			background: white;
			opacity: 1;
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
					<h2>SCUBACONNECT</h2>
					<span><a class="btn btn-primary btn-lg" href="reservation.php">Book Now</a></span>
				</div>
			</div>

		</div>

		<!-- Animated Wave Section -->
		<div class="ocean-waves">
			<div class="wave wave1"></div>
			<div class="wave wave2"></div>
			<div class="wave wave3"></div>
		</div>

		<?php include('success.alert.inc.php') ?>
		<?php include('fail.alert.inc.php') ?>



		<br><br>
		<?php include('signup.inc.php') ?>
		<?php include('login.inc.php') ?>
		<?php include('post.edit.inc.php') ?>
	</section>



	<div class="fh5co-listing">
		<div class="container">
			<div class="row">
				<div class="col-md-4 col-sm-4 fh5co-item-wrap">
					<a href="d6.php" class="fh5co-listing-item">
						<img src="images/d1.png" alt="F" class="img-responsive">
						<div class="fh5co-listing-copy">
							<h2>Sabang Wreck</h2>
							<span class="icon">
								<i class="icon-chevron-right"></i>
							</span>
						</div>
					</a>
				</div>
				<div class="col-md-4 col-sm-4 fh5co-item-wrap">
					<a href="d7.php" class="fh5co-listing-item">
						<img src="images/d2.png" alt="F" class="img-responsive">
						<div class="fh5co-listing-copy">
							<h2>Sabang Point</h2>
							<span class="icon">
								<i class="icon-chevron-right"></i>
							</span>
						</div>
					</a>
				</div>
				<div class="col-md-4 col-sm-4 fh5co-item-wrap">
					<a href="d14.php" class="fh5co-listing-item">
						<img src="images/d3.png" alt="F" class="img-responsive">
						<div class="fh5co-listing-copy">
							<h2>Canyons</h2>
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



	<!-- About Start -->
	<div class="container-xxl py-5">
		<h6><span class="bluetxt section-title text-start pe-3">About Us</span></h6>
		<div class="container">
			<div class="row g-5">
				<div class="card-container about-card">
					<div class="row g-5">
						<div class="col-lg-6 wow fadeInUp" data-aos="fade-up" data-aos-duration="1000"
							style="min-height: 400px;">
							<div class="position-relative h-100">
								<img class="img-fluid w-100 h-100" src="images/coverbg3.jpg" alt=""
									style="object-fit: cover; border-radius: 8px;">
							</div>
						</div>
						<div class="col-lg-6 wow fadeInUp" data-aos="fade-up" data-aos-duration="1000">

							<h1 class="mb-4">Welcome to <br> <span class="bluetxt">Sabang Beach Club</span>
							</h1>
							<p class="mb-4">Nestled on the pristine shores of Sabang Beach, Sabang Beach Club offers an
								unparalleled blend of luxury accommodation and world-class diving experiences. Since
								2015, we've welcomed diving enthusiasts and leisure travelers from around the globe to
								explore the underwater wonders of Puerto Galera.</p>
							<p class="mb-4">Our resort features 24 meticulously maintained diving sites, PADI-certified
								instructors, and luxurious beachfront villas designed for ultimate comfort. We pride
								ourselves on personalized service, sustainable tourism practices, and creating
								unforgettable memories for our guests, whether they're experienced divers or first-time
								visitors to the Philippines.</p>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- About End -->


	<!-- Features -->

	<div class="features">
		<div class="container">
			<div class="text-center wow fadeInUp" data-aos="fade-up" data-aos-duration="0.1s">
				<h6><span class="section-title text-center bluetxt px-3">Services</span></h6>
				<div class="section-container">
					<h1 class="mb-5 ">What to Expect</h1>
				</div>
			</div>
			<div class="row">

				<div class="col-lg-4 icon_box_col wow fadeInUp" data-aos="fade-up" data-aos-duration="1000">
					<div class="icon-box-card">
						<div class="icon_box d-flex flex-column align-items-center justify-content-start text-center">
							<div class="icon_box_icon"><img src="images/icon_1.svg" class="svg"></div>
							<div class="icon_box_title">
								<h2
									style="font-family: 'Nunito', sans-serif; font-weight: 700; letter-spacing: 0.5px; font-size: 1.8rem; margin-top: 15px;">
									Fabulous Resort</h2>
							</div>
							<div class="icon_box_text">
								<p
									style="font-family: 'Poppins', sans-serif; font-weight: 400; font-size: 0.95rem; line-height: 1.7; color: #555;">
									Experience our exclusive beachfront location with stunning ocean views
									from every angle.
									Our accommodations feature private balconies, premium bedding, and
									modern
									amenities. The resort's intimate setting ensures personalized service in
									a tranquil
									paradise perfect for both relaxation and adventure.</p>
							</div>
						</div>
					</div>
				</div>

				<!-- Icon Box -->
				<div class="col-lg-4 icon_box_col wow fadeInUp" data-aos="fade-up" data-aos-duration="1000">
					<div class="icon-box-card">
						<div class="icon_box d-flex flex-column align-items-center justify-content-start text-center">
							<div class="icon_box_icon"><img src="images/icon_4.svg" class="svg"></div>
							<div class="icon_box_title">
								<h2
									style="font-family: 'Nunito', sans-serif; font-weight: 700; letter-spacing: 0.5px; font-size: 1.8rem; margin-top: 15px;">
									Culinary Experience</h2>
							</div>
							<div class="icon_box_text">
								<p
									style="font-family: 'Poppins', sans-serif; font-weight: 400; font-size: 0.95rem; line-height: 1.7; color: #555;">
									Savor exceptional dining at our oceanfront restaurant featuring fresh,
									locally-sourced
									ingredients. Our talented chefs blend international techniques with
									Filipino flavors to
									create memorable culinary experiences. From breakfast to dinner, enjoy
									gourmet meals
									with breathtaking views of Sabang Beach and personalized service.</p>
							</div>
						</div>
					</div>
				</div>

				<!-- Icon Box -->
				<div class="col-lg-4 icon_box_col wow fadeInUp" data-aos="fade-up" data-aos-duration="1000">
					<div class="icon-box-card">
						<div class="icon_box d-flex flex-column align-items-center justify-content-start text-center">
							<div class="icon_box_icon"><img src="images/icon_5.svg" class="svg"></div>
							<div class="icon_box_title">
								<h2
									style="font-family: 'Nunito', sans-serif; font-weight: 700; letter-spacing: 0.5px; font-size: 1.8rem; margin-top: 15px;">
									Scuba Diving</h2>
							</div>
							<div class="icon_box_text">
								<p
									style="font-family: 'Poppins', sans-serif; font-weight: 400; font-size: 0.95rem; line-height: 1.7; color: #555;">
									Explore 24 world-class dive sites with our PADI-certified instructors.
									From the famous
									Sabang Wreck to the vibrant Canyons, discover pristine coral reefs and
									diverse marine
									life. We provide top-quality equipment, personalized guidance for
									beginners
									to enhance your underwater adventures.</p>
							</div>
						</div>
					</div>
				</div>

			</div>
		</div>
	</div>

	<!-- Service -->
	<div class="container-xxl py-5">
		<div class="container">

			<div class="text-center wow fadeInUp" data-aos="fade-up" data-aos-duration="0.1s">
				<h6><span class="section-title text-center bluetxt px-3">Services</span></h6>
				<div class="section-container">
					<h1 class="mb-5 ">Our Premium Services</h1>
				</div>
			</div>
			<div class="row g-4">
				<div class="col-lg-3 col-sm-6" data-aos="fade-up" data-aos-delay="0.1s">
					<div class="service-item rounded pt-3 h-100 shadow-hover">
						<div class="p-4">
							<i class="fa fa-3x fa-hotel bluetxt mb-4"></i>
							<h5>Luxury Beachfront Accommodation</h5>
							<p>Experience the ultimate in comfort with our beachfront villas offering
								stunning ocean
								views, premium bedding and private balconies.</p>
						</div>
					</div>
				</div>
				<div class="col-lg-3 col-sm-6" data-aos="fade-up" data-aos-delay="0.3s">
					<div class="service-item rounded pt-3 h-100 shadow-hover">
						<div class="p-4">
							<i class="fa fa-3x fa-utensils bluetxt mb-4"></i>
							<h5>Ocean-View Dining</h5>
							<p>Savor exquisite cuisine with breathtaking views, featuring fresh local
								seafood and
								international dishes with Filipino influences.</p>
						</div>
					</div>
				</div>
				<div class="col-lg-3 col-sm-6" data-aos="fade-up" data-aos-delay="0.5s">
					<div class="service-item rounded pt-3 h-100 shadow-hover">
						<div class="p-4">
							<i class="fa fa-3x fa-water bluetxt mb-4"></i>
							<h5>Professional Scuba Diving</h5>
							<p>Discover stunning underwater worlds with our PADI-certified instructors
								guiding tours to
								24 world-class dive sites for all skill levels.</p>
						</div>
					</div>
				</div>
				<div class="col-lg-3 col-sm-6" data-aos="fade-up" data-aos-delay="0.7s">
					<div class="service-item rounded pt-3 h-100 shadow-hover">
						<div class="p-4">
							<i class="fa fa-3x fa-tshirt bluetxt mb-4"></i>
							<h5>Complimentary Laundry</h5>
							<p>Travel light with our daily laundry service included with your stay,
								featuring
								eco-friendly methods and special care for dive gear.</p>
						</div>
					</div>
				</div>

			</div>
		</div>
	</div>
	<!-- Service End -->


	<!-- Room Start -->
	<div class="container-xxl py-5">
		<div class="container">
			<h6><span class="bluetxt section-title text-start pe-3">Rooms</span></h6>
			<div class="text-center wow fadeInUp" data-wow-delay="0.1s">
				<div class="section-container">
					<h1 class="mb-5">Explore Our <span class="bluetxt text-uppercase">Rooms</span></h1>
				</div>
			</div>
		</div>
		<div class="row g-4 justify-content-center">
			<?php
			$query = $con->query("SELECT * FROM room ORDER BY price ASC");
			while ($fetch = $query->fetch_array()) {
				$isRegular = (strtolower($fetch['room_type']) === 'regular room');
				?>
				<div class="col-lg-6 col-md-6 d-flex justify-content-center wow fadeInUp" data-aos="fade-up"
					data-aos-duration="1000">
					<div class="room-item shadow rounded overflow-hidden bg-white">
						<div class="position-relative">
							<img class="img-fluid" src="<?php echo htmlspecialchars($fetch['photo']); ?>" alt="">
							<small
								class="position-absolute start-0 top-100 translate-middle-y bg-primary text-white rounded py-1 px-3 ms-4">
								₩<?php echo $fetch['price']; ?>/Night
							</small>
						</div>
						<div class="p-4 mt-2">
							<div class="d-flex justify-content-between mb-3">
								<h5 class="mb-0"><?php echo $fetch['room_type']; ?></h5>
								<div class="ps-2">
									<?php for ($i = 0; $i < 5; $i++) {
										echo '<small class="fa fa-star text-primary"></small>';
									} ?>
								</div>
							</div>
							<div class="d-flex mb-3">
								<small class="border-end me-3 pe-3"><i class="fa fa-bed text-primary me-2"></i>
									<?php echo ($isRegular) ? '1 Regular Size Bed' : '1 Queen Size Bed'; ?>
								</small>
								<small class="border-end me-3 pe-3"><i class="fa fa-bath text-primary me-2"></i>1
									Bath</small>
								<small><i class="fa fa-wifi text-primary me-2"></i>Wifi</small>
							</div>
							<p class="text-body mb-3">
								<?php if ($isRegular): ?>
									Cozy beachfront room (25m²) good for 2 people with ocean-view balcony, air conditioning, and
									modern amenities.
									Features a comfortable regular bed, private bathroom with rain shower, and complimentary
									WiFi.
								<?php else: ?>
									Spacious family accommodation (40m²) with panoramic ocean views, private balcony, premium
									queen bed, and expanded living area. Includes air conditioning, luxurious bathroom, and all
									resort amenities.
								<?php endif; ?>
							</p>
						</div>
					</div>
				</div>
			<?php } ?>
		</div>
	</div>
	<!-- Room End -->




	<!-- Team Start -->
	<div class="container-xxl py-5">
		<div class="container">
			<div class="text-center wow fadeInUp" data-aos="fade-up" data-aos-duration="1000">
				<h6><span class="section-title  text-center  bluetxt px-3">Scuba Divers</span></h6>
				<div class="section-container">
					<h1 class="mb-5">Meet Our Divers</h1>
				</div>
			</div>
			<div class="row g-4 justify-content-center">

				<div class="col-lg-3 col-md-6 wow fadeInUp" data-aos="fade-up" data-aos-duration="1000">
					<div class="team-item"
						style="background-color: white; border-radius: 10px; box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);">
						<div class="overflow-hidden">
							<img class="img-fluid" src="images/team2.png" alt="">
						</div>

						<div class="text-center p-4">
							<h5 class="mb-0">Diver 1</h5>
							<small>Diver Instructor</small>
						</div>
					</div>
				</div>
				<div class="col-lg-3 col-md-6 wow fadeInUp" data-aos="fade-up" data-aos-duration="1000">
					<div class="team-item" style="background-color: white;  border-radius: 10px;">
						<div class="overflow-hidden">
							<img class="img-fluid" src="images/team2.png" alt="">
						</div>

						<div class="text-center p-4">
							<h5 class="mb-0">Diver 2</h5>
							<small>Master Diver</small>
						</div>
					</div>
				</div>

			</div>
		</div>
	</div>
	<!-- Team End -->


	<!-- Feedback Section -->
	<div class="container-xxl py-5">
		<div class="container">
			<div class="text-center wow fadeInUp" data-aos="fade-up" data-aos-duration="1000">
				<h6><span class="section-title text-center bluetxt px-3">Guest Feedback</span></h6>
				<div class="section-container">
					<h1 class="mb-5">What Our Guests Say</h1>
				</div>
			</div>
			<div class="row g-4 justify-content-center">
				<div class="col-lg-8">
					<div class="swiper-container feedback-carousel">
						<div class="swiper-wrapper">
							<?php
							// Code to fetch and display feedback
							$query = "SELECT f.*, u.username, u.image FROM feedback f
                          JOIN users u ON f.user_id = u.id
                          ORDER BY f.created_at DESC";

							$result = mysqli_query($con, $query);

							if ($result && mysqli_num_rows($result) > 0) {
								while ($row = mysqli_fetch_assoc($result)) {
									?>
									<div class="swiper-slide">
										<div class="team-item mb-4 mt-4"
											style="background-color: white; border-radius: 10px; box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08); height: 420px; max-width: 350px; margin: 0 auto;">
											<div class="text-center p-4 pb-2">
												<div style="margin: -60px auto 20px; width: 120px; height: 120px;">
													<img src="<?= get_image($row['image']) ?>" alt="User"
														style="width: 120px; height: 120px; object-fit: cover; border-radius: 50%; border: 5px solid white; box-shadow: 0 3px 10px rgba(0,0,0,0.1);">
												</div>
												<h5 class="mb-1"><?= htmlspecialchars($row['username']) ?></h5>
												<div class="rating-stars mb-3">
													<?php
													for ($i = 1; $i <= 5; $i++) {
														if ($i <= $row['rating']) {
															echo '<i class="fa fa-star text-warning"></i>'; // Filled star
														} else {
															echo '<i class="far fa-star text-warning"></i>'; // Empty star
														}
													}
													?>
												</div>
												<div style="height: 150px; overflow-y: auto; margin-bottom: 10px;">
													<p class="feedback-text mb-2"><?= htmlspecialchars($row['feedback_text']) ?>
													</p>
												</div>
												<small
													class="text-muted"><?= date('F j, Y', strtotime($row['created_at'])) ?></small>
											</div>
										</div>
									</div>
									<?php
								}
							} else {
								echo '<p class="no-feedback">No feedback yet. Be the first to leave your thoughts!</p>';
							}
							?>
						</div>

						<!-- Navigation Buttons -->
						<div class="swiper-button-prev"></div>
						<div class="swiper-button-next"></div>

						<!-- Pagination -->
						<div class="swiper-pagination"></div>
					</div>
				</div>
			</div>


		</div>
	</div>


	<div class="row g-4 justify-content-center text-center"> <!-- Add text-center -->
		<div class="col-lg-6 d-flex justify-content-center">
			<div class="card-container1 w-100" data-aos="fade-up"> <!-- Ensure full width inside column -->
				<!-- Feedback Form -->
				<div class="feedback-form-container mt-4">
					<?php if (logged_in()): ?>
						<div class="feedback-form" data-aos="fade-up">
							<h3 class="text-center">Share Your Experience</h3> <!-- Center title -->
							<div class="frm">
								<?php if (isset($_SESSION['feedback_message'])): ?>
									<div class="alert alert-success text-center">
										<?= $_SESSION['feedback_message'] ?>
										<?php unset($_SESSION['feedback_message']); ?>
									</div>
								<?php endif; ?>

								<?php if (isset($_SESSION['feedback_error'])): ?>
									<div class="alert alert-danger text-center">
										<?= $_SESSION['feedback_error'] ?>
										<?php unset($_SESSION['feedback_error']); ?>
									</div>
								<?php endif; ?>

								<form method="post" action="submit_feedback.php">
									<div class="row justify-content-center">
										<div class="col-md-14">
											<div class="form-group mt-3" id="labelrating"
												style="max-width: 1000px; margin: 0 auto;">
												<label class="text-center d-block">Write your experience</label>
												<textarea class="form-control w-150" name="feedback_text" rows="6"
													placeholder="Write your feedback here..." required
													style="min-width: 100%; width: 100%; box-sizing: border-box; font-size: 16px;"></textarea>
											</div>
										</div>

										<div class="col-md-12">
											<div class="form-group mt-3" id="labelrating">
												<label class="text-center d-block">Rate your experience</label>
												<div class="your-rating d-flex justify-content-center">
													<div class="rating">
														<span class="star" data-value="5"><i class="fa fa-star"></i></span>
														<span class="star" data-value="4"><i class="fa fa-star"></i></span>
														<span class="star" data-value="3"><i class="fa fa-star"></i></span>
														<span class="star" data-value="2"><i class="fa fa-star"></i></span>
														<span class="star" data-value="1"><i class="fa fa-star"></i></span>
														<input type="hidden" name="rating" id="selected-rating" value="5">
													</div>
												</div>
												<p id="rating-message" class="text-center">Please select a rating</p>
												<div class="d-flex justify-content-center">
													<button type="submit" class="btn btn-primary mt-3"
														name="submit_feedback">
														Submit Feedback
													</button>
												</div>
											</div>
										</div>
									</div>
								</form>
							</div>
						</div>
					<?php else: ?>
						<div class="login-message text-center p-4 bg-white rounded shadow-sm" id="forum" data-aos="fade-up">
							<h4>Want to share your experience?</h4>
							<p>Please <a href="#" onclick="login.show()">login</a> to leave your feedback.</p>
						</div>
					<?php endif; ?>
				</div>
			</div>
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
						<p>Copyright Sabang Beach Club <a href="#">ScuBaConnect</a>. All Rights Reserved.
							<br>Made with <i class="icon-heart3"></i> by Group 7
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


	<!-- Include Swiper JS -->
	<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

	<!-- Initialize Swiper -->
	<script>
		var swiper = new Swiper('.feedback-carousel', {
			loop: true,
			slidesPerView: 1,
			spaceBetween: 20,
			autoplay: {
				delay: 3000,
				disableOnInteraction: false,
			},
			navigation: {
				nextEl: '.swiper-button-next',
				prevEl: '.swiper-button-prev',
			},
			pagination: {
				el: '.swiper-pagination',
				clickable: true,
			},
		});
	</script>

	<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
	<script>
		AOS.init();
	</script>

	<script>
		// Star rating system
		document.addEventListener('DOMContentLoaded', function () {
			const stars = document.querySelectorAll('.rating-star');
			const ratingInput = document.getElementById('selected-rating');

			// Set initial rating (5 stars)
			highlightStars(5);

			stars.forEach(star => {
				// When clicking on a star
				star.addEventListener('click', function () {
					const rating = this.getAttribute('data-rating');
					ratingInput.value = rating;
					highlightStars(rating);
				});
			});

			// Function to highlight stars based on rating
			function highlightStars(rating) {
				stars.forEach(star => {
					if (star.getAttribute('data-rating') <= rating) {
						star.classList.add('active');
					} else {
						star.classList.remove('active');
					}
				});
			}
		});
	</script>

	<script>
		document.addEventListener("DOMContentLoaded", function () {
			// Star rating system for feedback
			const stars = document.querySelectorAll(".your-rating .star");
			const ratingInput = document.getElementById("selected-rating");
			const ratingMessage = document.getElementById("rating-message");

			let currentRating = 0; // Start with no stars highlighted
			let defaultRating = 5; // But keep 5 as the default submission value

			// Initialize with no stars highlighted
			highlightStars(currentRating);

			function highlightStars(value) {
				stars.forEach(star => {
					star.classList.toggle("active", star.dataset.value <= value && value > 0);
				});
			}

			// Add event listeners to stars
			stars.forEach(star => {
				// Highlight on hover
				star.addEventListener("mouseover", function () {
					highlightStars(this.dataset.value);
				});

				// Restore previous selection on mouseout
				star.addEventListener("mouseout", function () {
					highlightStars(currentRating);
				});

				// Update rating on click
				star.addEventListener("click", function () {
					currentRating = this.dataset.value;
					ratingInput.value = currentRating; // Update the hidden input value
					highlightStars(currentRating);
					ratingMessage.textContent = `You selected ${currentRating} star${currentRating > 1 ? 's' : ''}`;
				});
			});
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

	<script src="js/jquery.steps.js"></script>
	<!-- Superfish -->
	<script src="js/hoverIntent.js"></script>
	<script src="js/superfish.js"></script>

	<!-- Main JS -->
	<script src="js/main.js"></script>
	<script src="js/iziToast.min.js"></script>

</body>

</html>