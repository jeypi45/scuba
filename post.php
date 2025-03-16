<?php

require('config.inc.php');
require('functions.php');

$post_id = $_GET['id'] ?? 0;
$user_id = $_SESSION['USER']['id'] ?? 0;

$query = "select * from posts where id = '$post_id' limit 1";
$row = query($query);

if ($row) {
	$row = $row[0];
	$id = $row['user_id'];
	$query = "select * from users where id = '$id' limit 1";
	$user_row = query($query);

	if ($user_row) {
		$row['user'] = $user_row[0];
		$row['user']['image'] = get_image($user_row[0]['image']);
	}

	// Get like count for this post
	$likes_query = "SELECT COUNT(*) as count FROM post_likes WHERE post_id = '$post_id'";
	$likes_result = query($likes_query);
	$row['likes'] = $likes_result[0]['count'] ?? 0;

	// Check if current user has liked this post
	$row['user_liked'] = false;
	if ($user_id > 0) {
		$like_query = "SELECT * FROM post_likes WHERE user_id = '$user_id' AND post_id = '$post_id' LIMIT 1";
		$like_result = query($like_query);
		if ($like_result) {
			$row['user_liked'] = true;
		}
	}
}

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



	<!-- Modernizr JS -->
	<script src="js/modernizr-2.6.2.min.js"></script>
	<!-- FOR IE9 below -->
	<!--[if lt IE 9]>
	<script src="js/respond.min.js"></script>
	<![endif]-->

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

		/* Post Card Styling */
		.post-card {
			border-radius: 10px;
			overflow: hidden;
			box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
			transition: box-shadow 0.3s ease;
		}

		.post-card:hover {
			box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
		}

		.post-content {
			font-size: 1.1rem;
			line-height: 1.6;
		}

		.post-image-container img {
			max-height: 500px;
			object-fit: contain;
			width: 100%;
			border-radius: 8px;
		}

		/* Comment Styling */
		.js-comment-card {
			transition: background-color 0.3s ease;
		}

		.js-comment-card:hover {
			background-color: #f8f9fa;
		}

		.js-comment {
			font-size: 0.95rem;
			line-height: 1.5;
		}

		/* Like Button Styling */
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

		/* Animations */
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

		.login-prompt:hover {
			color: #007bff;
			text-decoration: underline;
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

		.hide {
			display: none !important;
		}
	</style>

	<section class="class_1">
		<?php include('header.inc.php') ?>
		<div class="class_11">
			<?php include('success.alert.inc.php') ?>
			<?php include('fail.alert.inc.php') ?>
			<h1 class="class_41">
				Single Post
			</h1>

			<?php if (!empty($row)): ?>
				<div class="container my-4">
					<div id="post_<?= $row['id'] ?>" row="<?= htmlspecialchars(json_encode($row)) ?>"
						class="card post-card mb-4">
						<div class="card-header bg-light d-flex align-items-center">
							<a href="profile.php?id=<?= $row['user']['id'] ?? 0 ?>"
								class="d-flex align-items-center text-decoration-none">
								<img src="<?= $row['user']['image'] ?>" class="rounded-circle me-2" width="45" height="45">
								<h5 class="mb-0"><?= $row['user']['username'] ?? 'Unknown' ?></h5>
							</a>
							<span class="ms-auto text-muted small">
								<?= date("jS M, Y H:i:s a", strtotime($row['date'])) ?>
							</span>
						</div>
						<div class="card-body">
							<div class="post-content mb-3">
								<?= nl2br(htmlspecialchars($row['post'])) ?>
							</div>

							<?php if (!empty($row['image'])): ?>
								<div class="post-image-container mb-3">
									<img src="<?= $row['image'] ?>" class="img-fluid rounded" alt="Post image">
								</div>
							<?php endif; ?>

							<div class="d-flex justify-content-between align-items-center">
								<?php if (i_own_post($row)): ?>
									<div class="action-buttons">
										<button onclick="postedit.show(<?= $row['id'] ?>)"
											class="btn btn-sm btn-outline-primary">
											<i class="bi bi-pencil me-1"></i> Edit
										</button>
										<button onclick="mypost.delete(<?= $row['id'] ?>)"
											class="btn btn-sm btn-outline-danger">
											<i class="bi bi-trash me-1"></i> Delete
										</button>
									</div>
								<?php endif; ?>

								<div class="like-container">
									<button class="btn-like js-like-button <?= ($row['user_liked'] ? 'active' : '') ?>"
										data-post-id="<?= $row['id'] ?>">
										<i class="bi bi-heart-fill heart-icon"></i>
										<span class="js-like-count like-count"><?= $row['likes'] ?? 0 ?></span>
									</button>
								</div>
							</div>
						</div>
					</div>
				</div>
			<?php else: ?>
				<div class="alert alert-warning d-flex align-items-center m-4">
					<i class="bi bi-exclamation-circle-fill me-2 fs-4"></i>
					<div>Post not found!</div>
				</div>
			<?php endif; ?>

			<div class="container mb-5">
				<div class="card shadow-sm">
					<div class="card-header bg-light">
						<h5 class="mb-0"><i class="bi bi-chat-left-text me-2"></i> Comments</h5>
					</div>

					<?php if (logged_in()): ?>
						<div class="card-body border-bottom">
							<form onsubmit="mycomment.submit(event)" method="post">
								<div class="form-group mb-3">
									<textarea placeholder="Add your comment..." name="post"
										class="js-comment-input form-control" rows="3"></textarea>
								</div>
								<div class="text-end">
									<button class="btn btn-primary">
										<i class="bi bi-send me-1"></i> Post Comment
									</button>
								</div>
							</form>
						</div>
					<?php else: ?>
						<div class="card-body border-bottom">
							<div class="alert alert-info d-flex align-items-center mb-0">
								<i class="bi bi-info-circle-fill me-2 fs-4"></i>
								<div onclick="login.show()" class="login-prompt" style="cursor:pointer;text-align: center;">
									You're not logged in <br>Click here to login and comment
								</div>
							</div>
						</div>
					<?php endif; ?>

					<div class="card-body p-0">
						<section class="js-comments p-3">
							<div class="text-center p-4">
								<div class="spinner-border text-primary" role="status">
									<span class="visually-hidden">Loading...</span>
								</div>
								<p class="mt-2">Loading comments...</p>
							</div>
						</section>
					</div>

					<div class="card-footer bg-light">
						<div class="d-flex justify-content-between align-items-center">
							<button onclick="mycomment.prev_page()" class="btn btn-outline-secondary">
								<i class="bi bi-chevron-left"></i> Previous
							</button>
							<div class="js-page-number badge bg-light text-dark p-2">Page <?= $page ?></div>
							<button onclick="mycomment.next_page()" class="btn btn-outline-secondary">
								Next <i class="bi bi-chevron-right"></i>
							</button>
						</div>
					</div>
				</div>
			</div>

		</div>
		<br><br>
		<?php include('login.inc.php') ?>
		<?php include('signup.inc.php') ?>
		<?php include('post.edit.inc.php') ?>
	</section>


	<!--comment card template-->
	<div class="js-comment-card hide border-bottom p-3" style="animation: fadeIn 0.5s ease;">
		<div class="d-flex">
			<div class="flex-shrink-0">
				<a href="#" class="js-profile-link">
					<img src="images/user.jpg" class="js-image rounded-circle" width="40" height="40">
				</a>
			</div>
			<div class="flex-grow-1 ms-3">
				<div class="d-flex align-items-center mb-1">
					<a href="#" class="js-profile-link text-decoration-none">
						<h6 class="js-username mb-0">Jane Name</h6>
					</a>
					<small class="js-date text-muted ms-2">3rd Jan 23 14:35 pm</small>
				</div>
				<div class="js-comment mb-2">
					is simply dummy text of the printing and typesetting industry...
				</div>
				<div class="js-action-buttons" style="display: none;">
					<button class="js-edit-button btn btn-sm btn-link text-primary p-0 me-2">
						<i class="bi bi-pencil"></i> Edit
					</button>
					<button class="js-delete-button btn btn-sm btn-link text-danger p-0">
						<i class="bi bi-trash"></i> Delete
					</button>
				</div>
			</div>
		</div>
	</div>
	<!--end comment card template-->


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
	<script src="js/iziToast.min.js"></script>
	<script src="js/main.js"></script>

</body>
<script>
	var page_number = <?= $page ?>;
	var post_id = <?= $post_id ?>;
</script>
<script src="js/mypost.js?v3"></script>
<script src="js/mycomment.js?v3"></script>
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

				// Get post ID from data attribute
				const postId = likeBtn.dataset.postId;
				if (postId) {
					// Toggle like in the database
					let form = new FormData();
					form.append('post_id', postId);
					form.append('data_type', 'toggle_like');

					var ajax = new XMLHttpRequest();
					ajax.addEventListener('readystatechange', function () {
						if (ajax.readyState == 4 && ajax.status == 200) {
							try {
								let obj = JSON.parse(ajax.responseText);
								if (obj.success) {
									// Update UI based on like status
									if (obj.liked) {
										likeBtn.classList.add('active');
									} else {
										likeBtn.classList.remove('active');
									}

									// Update like count
									const likeCount = likeBtn.querySelector('.js-like-count');
									likeCount.textContent = obj.like_count;
								} else if (obj.message === "Please log in to like posts") {
									// Show login dialog
									if (typeof login !== 'undefined' && login.show) {
										login.show();
									} else {
										alert("Please log in to like posts");
									}
								}
							} catch (e) {
								console.error('Error parsing response:', e);
							}
						}
					});

					ajax.open('post', 'ajax.inc.php', true);
					ajax.send(form);
				}
			}
		});

		// Your existing code for comment hover effects
		document.addEventListener('mouseover', function (e) {
			const commentCard = e.target.closest('.js-comment-card');
			if (commentCard) {
				const actionButtons = commentCard.querySelector('.js-action-buttons');
				if (actionButtons) {
					actionButtons.style.display = 'block';
				}
			}
		});

		document.addEventListener('mouseout', function (e) {
			const commentCard = e.target.closest('.js-comment-card');
			if (commentCard) {
				const actionButtons = commentCard.querySelector('.js-action-buttons');
				if (actionButtons) {
					actionButtons.style.display = 'none';
				}
			}
		});
	});
</script>

</html>