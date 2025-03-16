<!-- filepath: c:\xampps\htdocs\ScuBaConnect\profile.adm.php -->
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
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>ScuBaConnect - Admin Profile</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<!-- CSS Files -->
	<link rel="stylesheet" href="css/iziToast.min.css">

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
	</script>
</head>

<!-- filepath: c:\xampps\htdocs\ScuBaConnect\profile.adm.php -->

<body class="bg-gray-50">
	<?php include('header.adm.php'); ?>

	<main class="pt-[70px] ml-0 transition-all duration-300">
		<?php if (!empty($row)): ?>
			<!-- Profile Header - Full Width -->
			<div class="bg-gradient-to-r from-blue-600 to-blue-800 text-white py-12 px-6">
				<div class="max-w-7xl mx-auto">
					<div class="flex flex-col md:flex-row md:items-center gap-8">
						<!-- Profile Image -->
						<div class="flex-shrink-0">
							<div
								class="w-32 h-32 md:w-40 md:h-40 rounded-full overflow-hidden border-4 border-white shadow-xl mx-auto md:mx-0">
								<img src="<?= get_image($row['image']) ?>" alt="Profile Image"
									class="w-full h-full object-cover">
							</div>
						</div>

						<!-- Basic Info -->
						<div class="flex-grow text-center md:text-left">
							<h1 class="text-2xl md:text-4xl font-bold mb-2"><?= htmlspecialchars($row['username']) ?></h1>
							<p class="inline-block px-3 py-1 bg-blue-700/40 rounded-full text-sm mb-4">
								<?= $row['role'] ?? 'Administrator' ?>
							</p>

							<!-- Social Media Links -->
							<div class="flex justify-center md:justify-start space-x-4">
								<?php if (!empty($row['fb'])): ?>
									<a href="<?= $row['fb'] ?>" target="_blank"
										class="w-10 h-10 rounded-full bg-white/20 hover:bg-white/30 flex items-center justify-center text-white transition-colors">
										<i class="lab la-facebook-f text-xl"></i>
									</a>
								<?php endif; ?>

								<?php if (!empty($row['tw'])): ?>
									<a href="<?= $row['tw'] ?>" target="_blank"
										class="w-10 h-10 rounded-full bg-white/20 hover:bg-white/30 flex items-center justify-center text-white transition-colors">
										<i class="lab la-twitter text-xl"></i>
									</a>
								<?php endif; ?>

								<?php if (!empty($row['yt'])): ?>
									<a href="<?= $row['yt'] ?>" target="_blank"
										class="w-10 h-10 rounded-full bg-white/20 hover:bg-white/30 flex items-center justify-center text-white transition-colors">
										<i class="lab la-youtube text-xl"></i>
									</a>
								<?php endif; ?>
							</div>
						</div>

						<!-- Action Buttons -->
						<?php if (i_own_profile($row)): ?>
							<div class="mt-4 md:mt-0 flex flex-col sm:flex-row gap-3">
								<a href="profile-settings.adm.php"
									class="px-6 py-3 bg-white hover:bg-blue-50 text-blue-600 font-medium rounded-lg transition-colors flex items-center justify-center">
									<i class="las la-user-edit mr-2 text-xl"></i>
									Edit Profile
								</a>
								<button onclick="user.logout()"
									class="px-6 py-3 bg-blue-700 hover:bg-blue-800 text-white font-medium rounded-lg transition-colors flex items-center justify-center">
									<i class="las la-sign-out-alt mr-2 text-xl"></i>
									Logout
								</button>
							</div>
						<?php endif; ?>
					</div>
				</div>
			</div>

			<!-- Profile Content - Full Width Sections -->
			<div class="bg-white">
				<div class="max-w-7xl mx-auto px-6 py-12">
					<!-- Bio Section -->
					<div class="mb-12">
						<h2 class="text-xl font-bold mb-6 text-gray-800 pb-2 border-b border-gray-100">About</h2>
						<div class="text-gray-600">
							<?php if (!empty($row['bio'])): ?>
								<p><?= nl2br(htmlspecialchars($row['bio'])) ?></p>
							<?php else: ?>
								<p class="italic text-gray-400">No bio information available.</p>
							<?php endif; ?>
						</div>
					</div>

					<!-- Additional Information -->
					<div class="mb-6">
						<h2 class="text-xl font-bold mb-6 text-gray-800 pb-2 border-b border-gray-100">Contact Information
						</h2>
						<div class="grid grid-cols-1 md:grid-cols-2 gap-8">
							<!-- Contact Info -->
							<div class="space-y-6">
								<div class="flex items-start">
									<div
										class="w-12 h-12 rounded-lg bg-blue-50 flex items-center justify-center text-blue-600 mr-4">
										<i class="las la-envelope text-2xl"></i>
									</div>
									<div>
										<p class="font-medium text-gray-800">Email Address</p>
										<p class="text-gray-600 mt-1">
											<?= htmlspecialchars($row['email'] ?? 'Not available') ?>
										</p>
									</div>
								</div>

								<div class="flex items-start">
									<div
										class="w-12 h-12 rounded-lg bg-blue-50 flex items-center justify-center text-blue-600 mr-4">
										<i class="las la-phone text-2xl"></i>
									</div>
									<div>
										<p class="font-medium text-gray-800">Phone Number</p>
										<p class="text-gray-600 mt-1">
											<?= htmlspecialchars($row['phone'] ?? 'Not available') ?>
										</p>
									</div>
								</div>
							</div>

							<!-- Account Info -->
							<div class="space-y-6">
								<div class="flex items-start">
									<div
										class="w-12 h-12 rounded-lg bg-blue-50 flex items-center justify-center text-blue-600 mr-4">
										<i class="las la-calendar text-2xl"></i>
									</div>
									<div>
										<p class="font-medium text-gray-800">Joined Date</p>
										<p class="text-gray-600 mt-1">
											<?= isset($row['date']) ? date("F j, Y", strtotime($row['date'])) : 'Not available' ?>
										</p>
									</div>
								</div>

								<div class="flex items-start">
									<div
										class="w-12 h-12 rounded-lg bg-blue-50 flex items-center justify-center text-blue-600 mr-4">
										<i class="las la-shield-alt text-2xl"></i>
									</div>
									<div>
										<p class="font-medium text-gray-800">Access Level</p>
										<p class="text-gray-600 mt-1">
											<?= htmlspecialchars($row['role'] ?? 'Administrator') ?>
										</p>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>

		<?php else: ?>
			<!-- Error Message - Full Width -->
			<div class="px-6 py-12 bg-white">
				<div class="max-w-3xl mx-auto bg-red-50 border-l-4 border-red-500 p-6">
					<div class="flex items-center">
						<div class="text-red-500 mr-4">
							<i class="las la-exclamation-circle text-4xl"></i>
						</div>
						<div>
							<h3 class="font-bold text-lg text-red-800">Profile Not Found</h3>
							<p class="text-red-700">Sorry, the requested profile could not be found or has been removed.</p>
							<a href="dashboard.php"
								class="inline-block mt-3 text-sm font-medium text-red-600 hover:text-red-800">
								Return to Dashboard
							</a>
						</div>
					</div>
				</div>
			</div>
		<?php endif; ?>
	</main>

	<script src="js/jquery.min.js"></script>
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