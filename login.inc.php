<?php defined('APP') or die('direct script access denied!'); ?>

<div class="js-login-modal class_55 hide">
	<!-- Existing modal content -->
	<div class="modal-content">
		<div class="class_39" style="float:right; margin: 10px;padding:5px;padding-left:10px;padding-right:10px;"
			onclick="login.hide()">X</div>

		<h1 class="class_27">Login</h1>

		<form onsubmit="login.submit(event)" method="post" id="form">
			<div>
				<label for="email-input"><span>@</span></label>
				<input type="email" name="email" id="email-input" placeholder="Email" autocomplete="email" required>
			</div>
			<div>
				<label for="password-input">
					<svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 -960 960 960" width="24">
						<path
							d="M240-80q-33 0-56.5-23.5T160-160v-400q0-33 23.5-56.5T240-640h40v-80q0-83 58.5-141.5T480-920q83 0 141.5 58.5T680-720v80h40q33 0 56.5 23.5T800-560v400q0 33-23.5 56.5T720-80H240Zm240-200q33 0 56.5-23.5T560-360q0-33-23.5-56.5T480-440q-33 0-56.5 23.5T400-360q0 33 23.5 56.5T480-280ZM360-640h240v-80q0-50-35-85t-85-35q-50 0-85 35t-35 85v80Z" />
					</svg>
				</label>
				<input type="password" name="password" id="password-input" placeholder="Password"
					autocomplete="current-password" required>
			</div>
			<button type="submit">Login</button>
		</form>

		<p>Don't have an account? <a href="#" id="switchToSignup" onclick="signup.show()">Create Account</a></p>
		<p><a href="#" id="forgotPassword" onclick="forgotPassword.show()">Forgot Password?</a></p>
	</div>
</div>

<!-- Forgot Password Modal -->
<div class="js-forgot-password-modal class_55 hide">
	<div class="modal-content">
		<div class="class_39" style="float:right; margin: 10px;padding:5px;padding-left:10px;padding-right:10px;"
			onclick="forgotPassword.hide()">X</div>

		<h1 class="class_27">Forgot Password</h1>

		<form onsubmit="forgotPassword.submit(event)" method="post">
			<div>
				<label for="forgot-email-input"><span>@</span></label>
				<input type="email" name="email" id="forgot-email-input" placeholder="Enter your email" required>
			</div>
			<button type="submit">Reset Password</button>
		</form>

		<p><a href="#" onclick="login.show(); forgotPassword.hide()">Back to Login</a></p>
	</div>
</div>

<!-- Reset Code Modal -->
<div class="js-reset-code-modal class_55 hide">
	<div class="modal-content">
		<div class="class_39" style="float:right; margin: 10px;padding:5px;padding-left:10px;padding-right:10px;"
			onclick="resetCode.hide()">X</div>

		<h1 class="class_27">Enter Reset Code</h1>
		<p>Please enter the code sent to your email</p>

		<form onsubmit="resetCode.submit(event)" method="post">
			<input type="hidden" id="reset-email" name="email">
			<div>
				<label for="reset-code-input">
					<svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 -960 960 960" width="24">
						<path
							d="M240-80q-33 0-56.5-23.5T160-160v-400q0-33 23.5-56.5T240-640h40v-80q0-83 58.5-141.5T480-920q83 0 141.5 58.5T680-720v80h40q33 0 56.5 23.5T800-560v400q0 33-23.5 56.5T720-80H240Z" />
					</svg>
				</label>
				<input type="text" name="code" id="reset-code-input" placeholder="Enter code" required>
			</div>
			<button type="submit">Verify Code</button>
		</form>

		<p><a href="#" onclick="forgotPassword.show(); resetCode.hide()">Resend Code</a></p>
	</div>
</div>

<!-- Reset Password Modal -->
<div class="js-reset-password-modal class_55 hide">
	<div class="modal-content">
		<div class="class_39" style="float:right; margin: 10px;padding:5px;padding-left:10px;padding-right:10px;"
			onclick="resetPassword.hide()">X</div>

		<h1 class="class_27">Reset Password</h1>
		<p>Enter your new password</p>

		<form onsubmit="resetPassword.submit(event)" method="post">
			<input type="hidden" id="reset-token" name="token">
			<input type="hidden" id="reset-password-email" name="email">
			<div>
				<label for="new-password-input">
					<svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 -960 960 960" width="24">
						<path
							d="M240-80q-33 0-56.5-23.5T160-160v-400q0-33 23.5-56.5T240-640h40v-80q0-83 58.5-141.5T480-920q83 0 141.5 58.5T680-720v80h40q33 0 56.5 23.5T800-560v400q0 33-23.5 56.5T720-80H240Z" />
					</svg>
				</label>
				<input type="password" name="password" id="new-password-input" placeholder="New Password" required>
			</div>
			<div>
				<label for="confirm-password-input">
					<svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 -960 960 960" width="24">
						<path
							d="M240-80q-33 0-56.5-23.5T160-160v-400q0-33 23.5-56.5T240-640h40v-80q0-83 58.5-141.5T480-920q83 0 141.5 58.5T680-720v80h40q33 0 56.5 23.5T800-560v400q0 33-23.5 56.5T720-80H240Z" />
					</svg>
				</label>
				<input type="password" name="confirm_password" id="confirm-password-input"
					placeholder="Confirm Password" required>
			</div>
			<button type="submit">Change Password</button>
		</form>
	</div>
</div>

<!-- Ban Details Modal -->
<div class="js-ban-details-modal class_55 hide">
	<div class="modal-content">
		<div class="class_39" style="float:right; margin: 10px;padding:5px;padding-left:10px;padding-right:10px;"
			onclick="banDetails.hide()">X</div>

		<h1 class="class_27">Account Suspended</h1>

		<div style="padding: 20px; text-align: center;">
			<svg xmlns="http://www.w3.org/2000/svg" width="84" height="84" viewBox="0 0 24 24" fill="none" stroke="red"
				stroke-width="2">
				<path d="M12 8v5M12 16h.01M5 19h14l-7-14z" />
			</svg>

			<p style="margin-top: 15px; font-weight: bold; color: #e53e3e;">Your account has been suspended</p>

			<div style="margin-top: 20px; text-align: left;">
				<p><strong>Reason:</strong> <span id="ban-reason-text">Violation of community standards</span></p>
				<p><strong>Ban expires:</strong> <span id="ban-expires-text">Never</span></p>
			</div>

			<p style="margin-top: 20px; font-size: 14px; color: #666;">
				If you believe this is a mistake, please contact support.
			</p>

			<button onclick="banDetails.hide()"
				style="margin-top: 15px; background-color: #4a5568; color: white; padding: 8px 15px; border-radius: 5px; border: none; cursor: pointer;">
				Close
			</button>
		</div>
	</div>
</div>

<script>
	var login = {
		show: function () {
			document.querySelector(".js-login-modal").classList.remove('hide');
			document.querySelector(".js-signup-modal").classList.add('hide');
		},

		hide: function () {
			document.querySelector(".js-login-modal").classList.add('hide');
		},

		submit: function (e) {
			e.preventDefault();
			let inputs = e.currentTarget.querySelectorAll("input");
			let form = new FormData();

			for (var i = 0; i < inputs.length; i++) {
				form.append(inputs[i].name, inputs[i].value);
			}

			form.append('data_type', 'login');
			var ajax = new XMLHttpRequest();

			ajax.addEventListener('readystatechange', function () {
				if (ajax.readyState == 4) {
					if (ajax.status == 200) {
						let obj = JSON.parse(ajax.responseText);

						// Replace alert with iziToast
						if (obj.success) {
							iziToast.success({
								title: 'Success',
								message: obj.message,
								position: 'topRight',
								timeout: 5000,
								onClosed: function () {
									// Redirect after the toast is closed
									if (obj.redirect === "reload") {
										location.reload(); // Reloads the current page for users
									} else {
										window.location.href = obj.redirect; // Redirects admins
									}
								}
							});
						} else if (obj.is_banned) {
							// Show ban details modal
							login.hide();
							document.getElementById('ban-reason-text').textContent = obj.ban_reason;
							document.getElementById('ban-expires-text').textContent = obj.ban_expires;
							document.querySelector('.js-ban-details-modal').classList.remove('hide');
						} else {
							iziToast.error({
								title: 'Error',
								message: obj.message,
								position: 'topRight',
								timeout: 5000
							});
						}
					} else {
						iziToast.error({
							title: 'Connection Error',
							message: 'Please check your internet connection',
							position: 'topRight',
							timeout: 5000
						});
					}
				}
			});

			ajax.open('post', 'ajax.inc.php', true);
			ajax.send(form);
		}
	};

	// Add ban details handling
	var banDetails = {
		hide: function () {
			document.querySelector(".js-ban-details-modal").classList.add('hide');
		}
	};

	var forgotPassword = {
		show: function () {
			login.hide();
			document.querySelector(".js-forgot-password-modal").classList.remove('hide');
		},

		hide: function () {
			document.querySelector(".js-forgot-password-modal").classList.add('hide');
		},

		submit: function (e) {
			e.preventDefault();
			let email = document.querySelector("#forgot-email-input").value;
			let form = new FormData();

			form.append('email', email);
			form.append('data_type', 'forgot_password');

			var ajax = new XMLHttpRequest();

			ajax.addEventListener('readystatechange', function () {
				if (ajax.readyState == 4) {
					if (ajax.status == 200) {
						let obj = JSON.parse(ajax.responseText);

						if (obj.success) {
							forgotPassword.hide();
							resetCode.show(email);

							iziToast.success({
								title: 'Success',
								message: obj.message,
								position: 'topRight',
								timeout: 5000
							});
						} else {
							iziToast.error({
								title: 'Error',
								message: obj.message,
								position: 'topRight',
								timeout: 5000
							});
						}
					} else {
						iziToast.error({
							title: 'Connection Error',
							message: 'Please check your internet connection',
							position: 'topRight',
							timeout: 5000
						});
					}
				}
			});

			ajax.open('post', 'ajax.inc.php', true);
			ajax.send(form);
		}
	};

	var resetCode = {
		show: function (email) {
			document.querySelector(".js-reset-code-modal").classList.remove('hide');
			document.querySelector("#reset-email").value = email || "";
		},

		hide: function () {
			document.querySelector(".js-reset-code-modal").classList.add('hide');
		},

		submit: function (e) {
			e.preventDefault();
			let code = document.querySelector("#reset-code-input").value;
			let email = document.querySelector("#reset-email").value;
			let form = new FormData();

			form.append('code', code);
			form.append('email', email);
			form.append('data_type', 'verify_reset_code');

			var ajax = new XMLHttpRequest();

			ajax.addEventListener('readystatechange', function () {
				if (ajax.readyState == 4) {
					if (ajax.status == 200) {
						let obj = JSON.parse(ajax.responseText);

						if (obj.success) {
							resetCode.hide();
							resetPassword.show(obj.token, email);

							iziToast.success({
								title: 'Success',
								message: obj.message,
								position: 'topRight',
								timeout: 5000
							});
						} else {
							iziToast.error({
								title: 'Error',
								message: obj.message,
								position: 'topRight',
								timeout: 5000
							});
						}
					} else {
						iziToast.error({
							title: 'Connection Error',
							message: 'Please check your internet connection',
							position: 'topRight',
							timeout: 5000
						});
					}
				}
			});

			ajax.open('post', 'ajax.inc.php', true);
			ajax.send(form);
		}
	};

	var resetPassword = {
		show: function (token, email) {
			document.querySelector(".js-reset-password-modal").classList.remove('hide');
			document.querySelector("#reset-token").value = token || "";
			document.querySelector("#reset-password-email").value = email || "";
		},

		hide: function () {
			document.querySelector(".js-reset-password-modal").classList.add('hide');
		},

		submit: function (e) {
			e.preventDefault();
			let password = document.querySelector("#new-password-input").value;
			let confirm_password = document.querySelector("#confirm-password-input").value;
			let token = document.querySelector("#reset-token").value;
			let email = document.querySelector("#reset-password-email").value;

			if (password !== confirm_password) {
				iziToast.error({
					title: 'Error',
					message: 'Passwords do not match',
					position: 'topRight',
					timeout: 5000
				});
				return;
			}

			let form = new FormData();

			form.append('password', password);
			form.append('token', token);
			form.append('email', email);
			form.append('data_type', 'reset_password');

			var ajax = new XMLHttpRequest();

			ajax.addEventListener('readystatechange', function () {
				if (ajax.readyState == 4) {
					if (ajax.status == 200) {
						let obj = JSON.parse(ajax.responseText);

						if (obj.success) {
							resetPassword.hide();
							login.show();

							iziToast.success({
								title: 'Success',
								message: obj.message,
								position: 'topRight',
								timeout: 5000
							});
						} else {
							iziToast.error({
								title: 'Error',
								message: obj.message,
								position: 'topRight',
								timeout: 5000
							});
						}
					} else {
						iziToast.error({
							title: 'Connection Error',
							message: 'Please check your internet connection',
							position: 'topRight',
							timeout: 5000
						});
					}
				}
			});

			ajax.open('post', 'ajax.inc.php', true);
			ajax.send(form);
		}
	};
</script>