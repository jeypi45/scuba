<?php

require('config.inc.php');
require('functions.php');

$info['data_type'] = "";
$info['success'] = false;
$info['toast_type'] = "error"; // Default toast type

if ($_SERVER['REQUEST_METHOD'] == "POST" && !empty($_POST['data_type'])) {
	$info['data_type'] = $_POST['data_type'];

	if ($_POST['data_type'] == 'signup') {
		$username = addslashes($_POST['username']);
		$email = addslashes($_POST['email']);
		$password = $_POST['password'];
		$password_retype = $_POST['retype_password'];
		$role = $_POST['role'] ?? 'user';
		$date = date("Y-m-d H:i:s");

		$query = "SELECT * FROM users WHERE email = '$email' LIMIT 1";
		$row = query($query);

		if ($row) {
			$info['message'] = "That email already exists";
			$info['toast_type'] = "warning";
		} elseif ($password !== $password_retype) {
			$info['message'] = "Passwords don't match";
			$info['toast_type'] = "warning";
		} else {
			$password = password_hash($password, PASSWORD_DEFAULT);
			$query = "INSERT INTO users (username, email, password, date, role) VALUES ('$username', '$email', '$password', '$date', '$role')";
			query($query);

			$query = "SELECT * FROM users WHERE email = '$email' LIMIT 1";
			$row = query($query);

			if ($row) {
				$row = $row[0];
				$info['success'] = true;
				$info['toast_type'] = "success";
				$info['message'] = "Your profile was created successfully";
				authenticate($row);
			}
		}


	} else
		if ($_POST['data_type'] == 'add_post') {

			$post = addslashes($_POST['post']);
			$user_id = $_SESSION['USER']['id'];
			$date = date("Y-m-d H:i:s");
			$image_path = "";

			// Handle image upload if present
			if (!empty($_FILES['post_image']['name'])) {
				$folder = "uploads/forum/";

				// Create folder if it doesn't exist
				if (!file_exists($folder)) {
					mkdir($folder, 0777, true);
				}

				$allowed = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
				if (in_array($_FILES['post_image']['type'], $allowed)) {
					$image_name = time() . '_' . $_FILES['post_image']['name'];
					$destination = $folder . $image_name;

					if (move_uploaded_file($_FILES['post_image']['tmp_name'], $destination)) {
						$image_path = $destination;
					}
				}
			}

			$query = "INSERT INTO posts (post, user_id, date, image) VALUES ('$post', '$user_id', '$date', '$image_path')";
			query($query);

			$query = "SELECT * FROM posts WHERE user_id = '$user_id' ORDER BY id DESC LIMIT 1";
			$row = query($query);

			if ($row) {
				$row = $row[0];
				$info['success'] = true;
				$info['toast_type'] = "success";
				$info['message'] = "Your post was created successfully";
				$info['row'] = $row;
			}

		} else
			if ($_POST['data_type'] == 'add_comment') {

				$post_id = (int) $_POST['post_id'];
				$post = addslashes($_POST['post']);
				$user_id = $_SESSION['USER']['id'];
				$date = date("Y-m-d H:i:s");

				$query = "insert into posts (post,user_id,date,parent_id) values ('$post','$user_id','$date','$post_id')";
				query($query);

				$query = "select * from posts where user_id = '$user_id' && parent_id = '$post_id' order by id desc limit 1";
				$row = query($query);

				if ($row) {

					$row = $row[0];
					$info['success'] = true;
					$info['toast_type'] = "success";
					$info['message'] = "Your comment was created successfully";
					$info['row'] = $row;

				}

				//count how many comments on this post
				$query = "select count(*) as num from posts where parent_id = '$post_id'";
				$res = query($query);
				if ($res) {
					$num = $res[0]['num'];
					$query = "update posts set comments = '$num' where id = '$post_id' limit 1";
					query($query);
				}


			} else
				if ($_POST['data_type'] == 'edit_post') {

					$post = addslashes($_POST['post']);
					$id = (int) ($_POST['id']);
					$user_id = $_SESSION['USER']['id'];

					$query = "update posts set post = '$post' where user_id = '$user_id' && id = '$id' limit 1";
					query($query);

					$info['success'] = true;
					$info['toast_type'] = "success";
					$info['message'] = "Your post was edited successfully";


				} else
					if ($_POST['data_type'] == 'delete_post') {

						$id = (int) ($_POST['id']);
						$user_id = $_SESSION['USER']['id'];

						$query = "delete from posts where id = '$id' && user_id = '$user_id' limit 1";
						query($query);

						$info['success'] = true;
						$info['toast_type'] = "success";
						$info['message'] = "Your post was deleted successfully";

					} else
						if ($_POST['data_type'] == 'load_posts') {

							$user_id = $_SESSION['USER']['id'] ?? 0;
							$page_number = (int) $_POST['page_number'];
							$limit = 10;
							$offset = ($page_number - 1) * $limit;

							$query = "select * from posts where parent_id = 0 order by id desc limit $limit offset $offset";
							$rows = query($query);

							if ($rows) {

								foreach ($rows as $key => $row) {
									$rows[$key]['date'] = date("jS M, Y H:i:s a", strtotime($row['date']));
									$rows[$key]['post'] = nl2br(htmlspecialchars($row['post']));

									// Include image path explicitly in the response
									$rows[$key]['image'] = !empty($row['image']) ? $row['image'] : '';

									// Add like count
									$post_id = $row['id'];
									$likes_query = "SELECT COUNT(*) as count FROM post_likes WHERE post_id = '$post_id'";
									$likes_result = query($likes_query);
									$rows[$key]['likes'] = $likes_result[0]['count'] ?? 0;

									// Check if user has liked this post
									$rows[$key]['user_liked'] = false;
									if ($user_id > 0) {
										$like_query = "SELECT * FROM post_likes WHERE user_id = '$user_id' AND post_id = '$post_id' LIMIT 1";
										$like_result = query($like_query);
										if ($like_result) {
											$rows[$key]['user_liked'] = true;
										}
									}

									$rows[$key]['user_owns'] = false;
									if ($user_id == $row['user_id'])
										$rows[$key]['user_owns'] = true;

									$id = $row['user_id'];
									$query = "select * from users where id = '$id' limit 1";
									$user_row = query($query);

									if ($user_row) {
										$rows[$key]['user'] = $user_row[0];
										$rows[$key]['user']['image'] = get_image($user_row[0]['image']);
									}
								}

								$info['rows'] = $rows;
							}

							$info['success'] = true;

						} else
							if ($_POST['data_type'] == 'load_comments') {

								$user_id = $_SESSION['USER']['id'] ?? 0;
								$post_id = (int) $_POST['post_id'];
								$page_number = (int) $_POST['page_number'];
								$limit = 10;
								$offset = ($page_number - 1) * $limit;

								$query = "select * from posts where parent_id = '$post_id' order by id desc limit $limit offset $offset";
								$rows = query($query);

								if ($rows) {

									foreach ($rows as $key => $row) {
										$rows[$key]['date'] = date("jS M, Y H:i:s a", strtotime($row['date']));
										$rows[$key]['post'] = nl2br(htmlspecialchars($row['post']));

										$rows[$key]['user_owns'] = false;
										if ($user_id == $row['user_id'])
											$rows[$key]['user_owns'] = true;

										$id = $row['user_id'];
										$query = "select * from users where id = '$id' limit 1";
										$user_row = query($query);

										if ($user_row) {
											$rows[$key]['user'] = $user_row[0];
											$rows[$key]['user']['image'] = get_image($user_row[0]['image']);
										}
									}

									$info['rows'] = $rows;
								}

								$info['success'] = true;

							} else
								if ($_POST['data_type'] == 'login') {
									$email = addslashes($_POST['email']);
									$query = "SELECT * FROM users WHERE email = '$email' LIMIT 1";
									$row = query($query);

									if (!$row) {
										$info['message'] = "Wrong email or password";
										$info['toast_type'] = "warning";
									} else {
										$row = $row[0];

										// Add this to your login processing section where you check if a user is banned

										// After you've validated the user credentials and before allowing login:
										// Check if user is banned
										$ban_status = $row["ban_status"] ?? 0;
										if ($ban_status == 'banned') {
											// Check if ban has expired
											$ban_expired = false;
											if (!empty($row['ban_expires'])) {
												$now = new DateTime();
												$ban_expiry = new DateTime($row['ban_expires']);

												if ($now > $ban_expiry) {
													// Ban has expired, update user status
													$query = "UPDATE users SET ban_status='active', ban_reason=NULL, ban_expires=NULL WHERE id = " . $row['id'];
													query($query);
													$ban_expired = true;
												}
											}

											if (!$ban_expired) {
												// User is still banned
												$ban_expires = isset($row['ban_expires']) && $row['ban_expires'] ? date('F j, Y, g:i a', strtotime($row['ban_expires'])) : 'Permanent';
												$info['success'] = false;
												$info['message'] = "Your account has been suspended";
												$info['is_banned'] = true;
												$info['ban_reason'] = $row['ban_reason'] ?? 'Violation of terms';
												$info['ban_expires'] = $ban_expires;
												echo json_encode($info);
												exit;
											}
										}

										if (password_verify($_POST['password'], $row['password'])) {
											$info['success'] = true;
											$info['toast_type'] = "success";
											authenticate($row);
											$_SESSION['USER']['role'] = $row['role'];

											// Redirect admin, reload user page
											$info['redirect'] = ($row['role'] === 'admin') ? "dashboard.php" : "reload";

											$info['message'] = "Successful login";
										} else {
											$info['message'] = "Wrong email or password";
											$info['toast_type'] = "warning";
										}
									}
								} else
									if ($_POST['data_type'] == 'logout') {
										logout();
										$info['success'] = true;
										$info['toast_type'] = "success";
										$info['message'] = "You were successfully logged out";
									} elseif ($_POST['data_type'] == 'toggle_like') {
										// Check if user is logged in
										if (!isset($_SESSION['USER']) || !isset($_SESSION['USER']['id'])) {
											$info['message'] = "Please log in to like posts";
											$info['success'] = false;
											$info['toast_type'] = "warning";
										} else {
											$post_id = (int) $_POST['post_id'];
											$user_id = $_SESSION['USER']['id'];

											// Check if this user already liked this post
											$query = "SELECT * FROM post_likes WHERE user_id = '$user_id' AND post_id = '$post_id' LIMIT 1";
											$exists = query($query);

											if ($exists) {
												// User already liked the post, so remove the like
												$query = "DELETE FROM post_likes WHERE user_id = '$user_id' AND post_id = '$post_id'";
												query($query);
												$info['liked'] = false;
											} else {
												// User hasn't liked the post yet, so add a like
												$date = date("Y-m-d H:i:s");
												$query = "INSERT INTO post_likes (user_id, post_id, date) VALUES ('$user_id', '$post_id', '$date')";
												query($query);
												$info['liked'] = true;
											}

											// Get updated like count
											$query = "SELECT COUNT(*) as count FROM post_likes WHERE post_id = '$post_id'";
											$result = query($query);
											$info['like_count'] = $result[0]['count'] ?? 0;

											$info['success'] = true;
											$info['toast_type'] = "success";
										}
									} else if ($_POST['data_type'] == 'forgot_password') {
										$email = addslashes($_POST['email']);

										// Check if email exists
										$query = "SELECT * FROM users WHERE email = '$email' LIMIT 1";
										$row = query($query);

										if (!$row) {
											$info['message'] = "Email not found in our records";
											$info['toast_type'] = "error";
										} else {
											$row = $row[0];
											$user_id = $row['id'];

											// Generate random 6-digit code
											$reset_code = rand(100000, 999999);

											// Store code in user record
											$query = "UPDATE users SET code = '$reset_code' WHERE id = '$user_id' LIMIT 1";
											query($query);

											// Create password reset token
											$token = bin2hex(random_bytes(32));
											$expires = date('Y-m-d H:i:s', time() + 3600); // 1 hour expiration

											// Store token in password_resets table
											$query = "INSERT INTO password_resets (user_id, token, expires_at, used) 
												  VALUES ('$user_id', '$token', '$expires', 0)";
											query($query);

											// Send email with code
											require 'vendor/autoload.php';

											$mail = new PHPMailer\PHPMailer\PHPMailer(true);

											try {
												// Server settings
												$mail->isSMTP();
												$mail->Host = 'smtp.gmail.com';  // Replace with your SMTP server
												$mail->SMTPAuth = true;
												$mail->Username = 'scubaconnect30@gmail.com';  // Replace with your email
												$mail->Password = 'bqqi pbfk qfnn lpwg';  // Replace with your password
												$mail->SMTPSecure = 'tls';
												$mail->Port = 587;

												// Recipients
												$mail->setFrom('noreply@scubaconnect.com', 'ScuBa Connect');
												$mail->addAddress($email, $row['username']);

												// Content
												$mail->isHTML(true);
												$mail->Subject = 'Password Reset Code';
												$mail->Body = '
												<div style="font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #ddd; border-radius: 5px;">
													<h2 style="color: #0066cc;">ScuBa Connect Password Reset</h2>
													<p>Hello ' . $row['username'] . ',</p>
													<p>You have requested to reset your password. Use the following code to complete the process:</p>
													<div style="background-color: #f5f5f5; padding: 15px; font-size: 24px; text-align: center; letter-spacing: 5px; font-weight: bold; margin: 20px 0; border-radius: 4px;">
														' . $reset_code . '
													</div>
													<p>This code will expire in 60 minutes. If you did not request a password reset, please ignore this email.</p>
													<p>Thank you,<br>The ScuBa Connect Team</p>
												</div>
											';

												$mail->send();

												$info['success'] = true;
												$info['message'] = "Reset code sent to your email";
												$info['toast_type'] = "success";

											} catch (Exception $e) {
												$info['message'] = "Email could not be sent. Error: {$mail->ErrorInfo}";
												$info['toast_type'] = "error";
											}
										}
									} else if ($_POST['data_type'] == 'verify_reset_code') {
										$email = addslashes($_POST['email']);
										$code = addslashes($_POST['code']);

										// Check if email and code match
										$query = "SELECT * FROM users WHERE email = '$email' AND code = '$code' LIMIT 1";
										$row = query($query);

										if (!$row) {
											$info['message'] = "Invalid or expired code";
											$info['toast_type'] = "error";
										} else {
											$row = $row[0];
											$user_id = $row['id'];

											// Get latest token for this user - with more lenient query
											$query = "SELECT * FROM password_resets 
												 WHERE user_id = '$user_id' AND used = 0 
												 ORDER BY created_at DESC LIMIT 1";
											$reset = query($query);

											if (!$reset) {
												$info['message'] = "Reset request not found. Please try again.";
												$info['toast_type'] = "error";
											} else {
												$reset = $reset[0];

												// Check if token is expired manually
												$expires_at = strtotime($reset['expires_at']);
												$now = time();

												if ($expires_at < $now) {
													$info['message'] = "Reset code has expired. Please request a new one.";
													$info['toast_type'] = "error";
												} else {
													$info['success'] = true;
													$info['message'] = "Code verified successfully";
													$info['toast_type'] = "success";
													$info['token'] = $reset['token'];
												}
											}
										}
									} else if ($_POST['data_type'] == 'reset_password') {
										$email = addslashes($_POST['email']);
										$token = addslashes($_POST['token']);
										$password = $_POST['password'];

										if (strlen($password) < 8) {
											$info['message'] = "Password must be at least 8 characters long";
											$info['toast_type'] = "error";
										} else {
											// Find user by email
											$query = "SELECT * FROM users WHERE email = '$email' LIMIT 1";
											$row = query($query);

											if (!$row) {
												$info['message'] = "Invalid request";
												$info['toast_type'] = "error";
											} else {
												$row = $row[0];
												$user_id = $row['id'];

												// Check token validity with more lenient query
												$query = "SELECT * FROM password_resets 
													 WHERE user_id = '$user_id' AND token = '$token' AND used = 0 
													 LIMIT 1";
												$reset = query($query);

												if (!$reset) {
													$info['message'] = "Invalid token";
													$info['toast_type'] = "error";
												} else {
													$reset = $reset[0];

													// Check expiration manually
													$expires_at = strtotime($reset['expires_at']);
													$now = time();

													if ($expires_at < $now) {
														$info['message'] = "Reset token has expired. Please request a new one.";
														$info['toast_type'] = "error";
													} else {
														// Hash new password
														$hashed_password = password_hash($password, PASSWORD_DEFAULT);

														// Update user password
														$query = "UPDATE users SET password = '$hashed_password', code = 0 WHERE id = '$user_id' LIMIT 1";
														query($query);

														// Mark token as used
														$query = "UPDATE password_resets SET used = 1 WHERE token = '$token' LIMIT 1";
														query($query);

														$info['success'] = true;
														$info['message'] = "Password reset successful! You can now login with your new password.";
														$info['toast_type'] = "success";
													}
												}
											}
										}
									}
}

// Ensure toast_type is set based on success if not explicitly set
if (!isset($info['toast_type'])) {
	$info['toast_type'] = $info['success'] ? "success" : "error";
}

echo json_encode($info);
