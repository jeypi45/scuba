<?php defined('APP') or die('direct script access denied!'); ?>

<div id="fh5co-wrapper">
	<div id="fh5co-page">
		<nav>
			<div class="nav-bar">
				<i class='bx bx-menu sidebarOpen'></i>
				<span class="logo navLogo"><a href="#">SBC</a></span>
				<div class="menu">
					<div class="logo-toggle">
						<span class="logo"><a href="#">SBC</a></span>
						<i class='bx bx-x siderbarClose'></i>
					</div>
					<ul class="nav-links">
						<li><a href="index.php">Home</a></li>
						<li><a href="diving.php">Dive Site</a></li>
						<li><a href="services.php">Services</a></li>
						<li><a href="forum.php">Forum</a></li>
						<li><a href="reservation.php">Reservation</a></li>
						<li><a href="contact.php">Contact</a></li>
					</ul>
				</div>
				<div class="darkLight-searchBox">



					<div class="language-toggle">
						<i class='bx bx-globe' id="google_translate_icon"
							style="cursor: pointer; font-size: 1.2rem; color:rgb(250, 250, 250); transition: transform 0.3s ease;"
							title="Translate Page" aria-label="Toggle translation options"
							onmouseover="this.style.transform='scale(1.1)'"
							onmouseout="this.style.transform='scale(1)'"></i>
						<div id="google_translate_element"></div>
					</div>

					<div class="searchBox">
						<div class="searchToggle">
							<?php if (logged_in()): ?>
								<a href="profile.php">
									<img src="<?= get_image($_SESSION['USER']['image']) ?>" class="class_10">
								</a>
								<a href="profile.php">
									<span><?= $_SESSION['USER']['username'] ?></span>
								</a>
							<?php else: ?>
								<i class="bx bx-user cursor:pointer;" onclick="login.show()"></i>
							<?php endif; ?>
						</div>
					</div>
				</div>
			</div>
		</nav>

	</div>
</div>

<script>
	document.addEventListener("DOMContentLoaded", function () {
		let icon = document.getElementById("google_translate_icon");
		let translator = document.getElementById("google_translate_element");

		icon.addEventListener("click", function () {
			translator.style.display = translator.style.display === "none" ? "block" : "none";
		});
	});

	function googleTranslateElementInit() {
		new google.translate.TranslateElement(
			{
				pageLanguage: 'en',
				includedLanguages: 'en,ko',
				layout: google.translate.TranslateElement.InlineLayout.SIMPLE
			},
			'google_translate_element'
		);
	}

</script>

<script type="text/javascript"
	src="https://translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>