<?php
require('config.inc.php');
require('functions.php');

if (!logged_in()) {
	header("Location: forum.php");
	die;
}

$user_id = $_GET['id'] ?? $_SESSION['USER']['id'];
$query = "select * from users where id = '$user_id' limit 1";
$row = query($query);

if ($row) {
	$row = $row[0];
}
?>

<!DOCTYPE html>
<html class="exclude">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>ScuBaConnect</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">



	<link
		href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&family=Rajdhani:wght@700&family=Raleway:wght@400&display=swap"
		rel="stylesheet">


	<!-- Animate.css -->
	<link rel="stylesheet" href="css/animate.css">
	<!-- Icomoon Icon Fonts-->

	<!-- Bootstrap  -->

	<!-- Superfish -->
	<link rel="stylesheet" href="css/superfish.css">
	<link rel="stylesheet" href="css/iziToast.min.css">
	<link rel="stylesheet" href="css/style.css">
	<link rel="stylesheet" href="css/style2.css">
	<link rel="stylesheet" href="css/style3.css">

	<link rel="icon" href="/favicon.ico" type="image/x-icon">



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



	<!-- Modernizr JS -->
	<script src="js/modernizr-2.6.2.min.js"></script>
	<style>
		.hide {
			display: none;
		}

		/* Profile Header Styles */
		.profile-header {
			background-image: linear-gradient(to right, #2563eb 0%, #1e40af 100%);
			color: white;
			padding: 3rem 0;
			margin-bottom: 2rem;
			margin-top: 70px;
			/* Add this line to create space below the header */
		}

		.profile-header-content {
			display: flex;
			flex-wrap: wrap;
			align-items: center;
			max-width: 1200px;
			margin: 0 auto;
			padding: 0 15px;
		}

		.profile-image-container {
			margin-right: 2rem;
			margin-bottom: 1rem;
		}

		.profile-image {
			width: 140px;
			height: 140px;
			border-radius: 50%;
			border: 4px solid white;
			box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
			object-fit: cover;
		}

		.profile-info {
			flex-grow: 1;
		}

		.profile-name {
			font-size: 2.5rem;
			font-weight: 700;
			margin-bottom: 0.5rem;
		}

		.profile-role {
			display: inline-block;
			background-color: rgba(255, 255, 255, 0.2);
			padding: 4px 15px;
			border-radius: 20px;
			font-size: 0.9rem;
			margin-bottom: 1rem;
		}

		.social-links {
			display: flex;
			gap: 1rem;
			margin-top: 1rem;
		}

		.social-icon {
			width: 40px;
			height: 40px;
			border-radius: 50%;
			background-color: rgba(255, 255, 255, 0.2);
			display: flex;
			align-items: center;
			justify-content: center;
			transition: background-color 0.3s;
		}

		.social-icon:hover {
			background-color: rgba(255, 255, 255, 0.3);
		}

		.profile-actions {
			margin-top: 1.5rem;
			display: flex;
			flex-wrap: wrap;
			gap: 10px;
		}

		.btn-profile {
			padding: 8px 20px;
			border-radius: 5px;
			font-weight: 600;
			display: inline-flex;
			align-items: center;
		}

		.btn-edit {
			background-color: white;
			color: #264e86;
		}

		.btn-edit:hover {
			background-color: #17325a;
		}

		.btn-logout {
			background-color: #1e3f6b;
			color: white;
		}

		.btn-logout:hover {
			background-color: #17325a;
		}

		.icon-mr {
			margin-right: 8px;
		}

		/* Profile Content Styles */
		.profile-content {

			padding: 2rem 0;
			max-width: 1200px;
			margin: 0 auto;
		}

		.content-section {
			margin-bottom: 2.5rem;
			padding: 0 15px;
		}

		.section-title {
			font-size: 1.25rem;
			font-weight: 700;
			color: #333;
			padding-bottom: 10px;
			border-bottom: 1px solid #eee;
			margin-bottom: 1.5rem;
		}

		.contact-grid {
			display: flex;
			flex-wrap: wrap;
			gap: 2rem;
		}

		.contact-item {
			flex: 1 1 300px;
			display: flex;
			margin-bottom: 1.5rem;
		}

		.contact-icon {
			width: 50px;
			height: 50px;
			background-color: #e6f0ff;
			border-radius: 8px;
			display: flex;
			align-items: center;
			justify-content: center;
			margin-right: 1rem;
			color: #264e86;
			font-size: 1.5rem;
		}

		.contact-text h4 {
			font-weight: 600;
			margin-bottom: 5px;
			color: #333;
		}

		.contact-text p {
			color: #666;
		}

		.text-gray {
			color: #666;
		}

		.text-light-gray {
			color: #999;
			font-style: italic;
		}

		/* Responsive styles */
		@media (max-width: 767px) {
			.profile-header-content {
				flex-direction: column;
				text-align: center;
			}

			.profile-image-container {
				margin-right: 0;
			}

			.social-links {
				justify-content: center;
			}

			.profile-actions {
				justify-content: center;
			}
		}
	</style>
</head>

<body>
	<section class="class_1">
		<?php include('header.inc.php') ?>

		<?php if (!empty($row)): ?>
			<!-- Profile Header - Similar to admin design -->
			<div class="profile-header">
				<div class="profile-header-content">
					<!-- Profile Image -->
					<div class="profile-image-container">
						<img src="<?= get_image($row['image']) ?>" class="profile-image" alt="Profile Image">
					</div>

					<!-- Basic Info -->
					<div class="profile-info">
						<h1 class="profile-name"><?= htmlspecialchars($row['username']) ?></h1>
						<div class="profile-role"><?= $row['role'] ?? 'User' ?></div>


					</div>

					<!-- Action Buttons -->
					<?php if (i_own_profile($row)): ?>
						<div class="profile-actions">
							<a href="profile-settings.php" class="btn-profile btn-edit">
								<i class="fas fa-user-edit icon-mr"></i> Edit Profile
							</a>
							<button onclick="user.logout()" class="btn-profile btn-logout">
								<i class="fas fa-sign-out-alt icon-mr"></i> Logout
							</button>
						</div>
					<?php endif; ?>
				</div>
			</div>

			<!-- Profile Content - Similar to admin design -->
			<div class="profile-content">
				<!-- Bio Section -->
				<div class="content-section">
					<h2 class="section-title">About</h2>
					<div class="text-gray">
						<?php if (!empty($row['bio'])): ?>
							<p><?= nl2br(htmlspecialchars($row['bio'])) ?></p>
						<?php else: ?>
							<p class="text-light-gray">No bio information available.</p>
						<?php endif; ?>
					</div>
				</div>

				<!-- Additional Information -->
				<div class="content-section">
					<h2 class="section-title">Contact Information</h2>
					<div class="contact-grid">
						<!-- Contact Info -->
						<div class="contact-item">
							<div class="contact-icon">
								<i class="fas fa-envelope"></i>
							</div>
							<div class="contact-text">
								<h4>Email Address</h4>
								<p><?= htmlspecialchars($row['email'] ?? 'Not available') ?></p>
							</div>
						</div>

						<div class="contact-item">
							<div class="contact-icon">
								<i class="fas fa-phone"></i>
							</div>
							<div class="contact-text">
								<h4>Phone Number</h4>
								<p><?= htmlspecialchars($row['phone'] ?? 'Not available') ?></p>
							</div>
						</div>

						<!-- Account Info -->
						<div class="contact-item">
							<div class="contact-icon">
								<i class="fas fa-calendar"></i>
							</div>
							<div class="contact-text">
								<h4>Joined Date</h4>
								<p><?= isset($row['date']) ? date("F j, Y", strtotime($row['date'])) : 'Not available' ?>
								</p>
							</div>
						</div>

						<div class="contact-item">
							<div class="contact-icon">
								<i class="fas fa-shield-alt"></i>
							</div>
							<div class="contact-text">
								<h4>Access Level</h4>
								<p><?= htmlspecialchars($row['role'] ?? 'User') ?></p>
							</div>
						</div>
					</div>
				</div>
			</div>

		<?php else: ?>
			<div class="class_16">
				<i class="bi bi-exclamation-circle-fill class_14"></i>
				<div class="class_15">
					Profile not found!
				</div>
			</div>
		<?php endif; ?>

		<?php include('signup.inc.php') ?>
	</section>

	<script src="js/jquery.min.js"></script>
	<script src="js/jquery.easing.1.3.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script src="js/jquery.waypoints.min.js"></script>
	<script src="js/jquery.stellar.min.js"></script>
	<script src="js/hoverIntent.js"></script>
	<script src="js/superfish.js"></script>
	<script src="js/iziToast.min.js"></script>

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
</body>

</html>