<?php




require('config.inc.php');
require('functions.php');

$page = $_GET['page'] ?? 1;
$page = (int) $page;

if ($page < 1)
	$page = 1;

?>

<!DOCTYPE html>
<html>

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

	<script>
		(function (b, r, a, i, n, y) {
			b.ux = b.ux || function () { (b.ux.q = b.ux.q || []).push(arguments) };
			n = r.getElementsByTagName('head')[0]; y = r.createElement('script'); y.async = 1; y.src = a + i;
			n.appendChild(y);
		})(window, document, 'https://api.brainybear.ai/cdn/js/bear', '.js?id=1428');
	</script>

	<!-- Modernizr JS -->
	<script src="js/modernizr-2.6.2.min.js"></script>

	<style>
		.post-form {
			border-radius: 12px;
			transition: all 0.3s ease;
		}

		.post-textarea {
			border: 1px solid #e0e0e0;
			border-radius: 8px;
			resize: none;
			transition: all 0.3s ease;
		}

		.post-textarea:focus {
			border-color: #80bdff;
			box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
		}

		.post-card {
			border-radius: 10px;
			overflow: hidden;
			box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
			transition: transform 0.3s ease, box-shadow 0.3s ease;
		}

		.post-card:hover {
			transform: translateY(-3px);
			box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
		}

		.login-prompt:hover {
			color: #007bff;
			text-decoration: underline;
		}

		.pagination-controls {
			margin-top: 20px;
			padding: 10px 0;
		}

		@keyframes fadeIn {
			0% {
				opacity: 0;
				transform: translateY(10px);
			}

			100% {
				opacity: 1;
				transform: translateY(0);
			}
		}

		.hide {
			display: none !important;
		}

		.image-preview-container {
			margin-top: 10px;
			transition: all 0.3s ease;
		}

		.js-post-image {
			object-fit: contain;
			max-width: 100%;
			border-radius: 8px;
		}

		.js-like-button.active {

			color: white;
			border-color: #dc3545;
		}

		.js-image-button {
			transition: all 0.2s ease;
		}

		.js-image-button:hover {
			background-color: #f8f9fa;
		}

		.js-image-input {
			position: absolute;
			opacity: 0;
			width: 0;
			height: 0;
			z-index: -1;
		}

		/* Add these styles to your existing CSS */
		.like-container {
			position: relative;
		}

		.btn-like {
			display: flex;
			align-items: center;
			background: transparent;
			border: none;
			padding: 0.5rem 1rem;
			border-radius: 50px;
			cursor: pointer;
			transition: all 0.3s ease;
			gap: 8px;
		}

		.btn-like:hover {
			background-color: rgba(220, 53, 69, 0.1);
		}

		.heart-icon {
			color: #adb5bd;
			font-size: 1.25rem;
			transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
		}

		.like-count {
			font-weight: 600;
			font-size: 0.9rem;
			color: #6c757d;
			transition: color 0.3s ease;
		}

		.js-like-button.active .heart-icon {
			color: #dc3545;
			transform: scale(1.2);
		}

		.js-like-button.active .like-count {
			color: #dc3545;
		}

		.js-like-button.active:hover {
			background-color: rgba(220, 53, 69, 0.15);
		}

		/* Like button animation */
		@keyframes heartBeat {
			0% {
				transform: scale(1);
			}

			15% {
				transform: scale(1.3);
			}

			30% {
				transform: scale(1);
			}

			45% {
				transform: scale(1.15);
			}

			60% {
				transform: scale(1);
			}
		}

		.js-like-button.clicked .heart-icon {
			animation: heartBeat 0.8s;
		}

		/* Image styling improvements */
		.js-post-image {
			object-fit: cover;

			width: 100%;
			border-radius: 8px;
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
			/* Changed from margin-bottom */
			z-index: 1;
		}

		/* Variations for different sections */
		.ocean-waves.blue-theme .wave3 {
			background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 1200 120' preserveAspectRatio='none'%3E%3Cpath d='M0,0V46.29c47.79,22.2,103.59,32.17,158,28,70.36-5.37,136.33-33.31,206.8-37.5C438.64,32.43,512.34,53.67,583,72.05c69.27,18,138.3,24.88,209.4,13.08,36.15-6,69.85-17.84,104.45-29.34C989.49,25,1113-14.29,1200,52.47V0Z' fill='%234a76a8'%3E%3C/path%3E%3C/svg%3E");
		}
	</style>

</head>

<body>

	<style>
		@keyframes appear {
			0% {
				opacity: 0;
			}

			100% {
				opacity: 1;
			}
		}

		.hide {
			display: none;
		}
	</style>
	<section class="class">
		<?php include('header.inc.php') ?>

		<div class="fh5co-hero">
			<div class="fh5co-overlay"></div>
			<div class="fh5co-cover text-center" id="hero-cover" data-stellar-background-ratio="0.5"
				style="background-image: url(images/coverbg1.jpg);">
				<div class="desc animate-box">
					<h2>Forum</h2>
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

		<div class="class_11">
			<?php include('success.alert.inc.php') ?>
			<?php include('fail.alert.inc.php') ?>
			<h1 class="class_41">
				Posts
			</h1>

			<?php if (logged_in()): ?>
				<form onsubmit="mypost.submit(event)" method="post" enctype="multipart/form-data"
					class="post-form card shadow p-3 mb-4">
					<div class="form-group">
						<textarea placeholder="What's on your mind?" name="post"
							class="js-post-input form-control post-textarea" rows="3"></textarea>
					</div>
					<!-- Image preview area -->
					<div class="image-preview-container mt-2 mb-2 hide">
						<div class="position-relative d-inline-block">
							<img src="#" class="js-image-preview img-thumbnail" style="max-height: 200px;">
							<button type="button"
								class="btn btn-sm btn-danger position-absolute top-0 end-0 js-remove-image">
								<i class="bi bi-x"></i>
							</button>
						</div>
					</div>
					<div class="d-flex justify-content-between align-items-center mt-2">
						<div>
							<button type="button" class="btn btn-outline-secondary js-image-button">
								<i class="bi bi-image me-1"></i> Add Image
							</button>
							<input type="file" name="post_image" accept="image/*" class="js-image-input hide">
						</div>
						<button class="btn btn-primary px-4">
							<i class="bi bi-send me-2"></i> Post
						</button>
					</div>
				</form>
			<?php else: ?>
				<div class="alert alert-info d-flex align-items-center">
					<i class="bi bi-info-circle-fill me-2 fs-4"></i>
					<div onclick="login.show()" class="login-prompt" style="cursor:pointer;text-align: center;">
						You're not logged in <br>Click here to login and post
					</div>
				</div>
			<?php endif; ?>

			<section class="js-posts">
				<div class="text-center p-4">
					<div class="spinner-border text-primary" role="status">
						<span class="visually-hidden">Loading...</span>
					</div>
					<p class="mt-2">Loading posts...</p>
				</div>
			</section>

			<div class="pagination-controls d-flex justify-content-between align-items-center mt-4">
				<button onclick="mypost.prev_page()" class="btn btn-outline-primary">
					<i class="bi bi-chevron-left"></i> Previous
				</button>
				<div class="js-page-number badge bg-light text-dark p-2">Page <?= $page ?></div>
				<button onclick="mypost.next_page()" class="btn btn-outline-primary">
					Next <i class="bi bi-chevron-right"></i>
				</button>
			</div>

		</div>
		<br><br>
		<?php include('signup.inc.php') ?>
		<?php include('login.inc.php') ?>
		<?php include('post.edit.inc.php') ?>
	</section>

	<!--post card template-->
	<div class="js-post-card hide card mb-4 post-card" style="animation: fadeIn 0.5s ease;">
		<div class="card-header bg-light d-flex align-items-center">
			<a href="#" class="js-profile-link d-flex align-items-center text-decoration-none">
				<img src="images/user.jpg" class="js-image rounded-circle me-2" width="40" height="40">
				<h5 class="js-username mb-0">Jane Name</h5>
			</a>
			<span class="js-date ms-auto text-muted small">3rd Jan 23 14:35 pm</span>
		</div>
		<div class="card-body">
			<div class="js-post post-content mb-3">
				is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been...
			</div>
			<div class="js-post-image-container mb-3 hide">
				<img src="" class="js-post-image img-fluid rounded" alt="Post image">
			</div>
			<div class="d-flex align-items-center pt-2">
				<button class="btn btn-sm btn-outline-primary js-comment-link">
					<i class="bi bi-chat-left-dots me-1"></i> Comments
				</button>
				<div class="ms-auto like-container">
					<button class="btn-like js-like-button">
						<i class="bi bi-heart-fill heart-icon"></i>
						<span class="js-like-count like-count">0</span>
					</button>
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
						<p>Copyright Sabang Beach Club <a href="#">ScuBaConnect</a>. All Rights Reserved. <br>Made with
							<i class="icon-heart3"></i> by Group 7
						</p>
					</div>
				</div>
			</div>
		</div>
		</div>
	</footer>

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

	<script src="js/main.js"></script>
	<script src="js/iziToast.min.js"></script>
	<script src="js/toast-handler.js"></script>
	<script>
		document.addEventListener('DOMContentLoaded', function () {
			// Handle like button animations
			document.addEventListener('click', function (e) {
				const likeBtn = e.target.closest('.js-like-button');
				if (likeBtn) {
					// Add clicked class for animation
					likeBtn.classList.add('clicked');

					// Remove it after animation completes
					setTimeout(() => {
						likeBtn.classList.remove('clicked');
					}, 800);
				}
			});

			// Image upload preview functionality (your existing code here)
			const imageInput = document.querySelector('.js-image-input');
			const imageButton = document.querySelector('.js-image-button');
			const imagePreview = document.querySelector('.js-image-preview');
			const imageContainer = document.querySelector('.image-preview-container');
			const removeImageBtn = document.querySelector('.js-remove-image');

			if (imageButton && imageInput) {
				imageButton.addEventListener('click', function () {
					imageInput.click();
				});

				imageInput.addEventListener('change', function () {
					if (this.files && this.files[0]) {
						const reader = new FileReader();

						reader.onload = function (e) {
							imagePreview.src = e.target.result;
							imageContainer.classList.remove('hide');
						}

						reader.readAsDataURL(this.files[0]);
					}
				});

				if (removeImageBtn) {
					removeImageBtn.addEventListener('click', function () {
						imageInput.value = '';
						imageContainer.classList.add('hide');
					});
				}
			}
		});
	</script>

	<script>
		// Debug helper to check if like buttons are clickable
		document.addEventListener('click', function (e) {
			if (e.target.closest('.js-like-button')) {
				console.log('Like button clicked');
			}
		});
	</script>

</body>



<script>
	var page_number = <?= $page ?>;
	var home_page = true;

</script>
<script src="js/mypost.js?v3"></script>

</html>