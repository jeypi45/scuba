<?php defined('APP') or die('direct script access denied!'); ?>

<div class="js-post-edit-modal class_55 hide" style="min-width: 600px;min-height:auto">
	<div class="class_39" style="float:right; margin: 10px;padding:5px;padding-left:10px;padding-right:10px;"
		onclick="postedit.hide()">X</div>
	<h1 class="class_27">
		Edit Post
	</h1>
	<form onsubmit="postedit.submit(event)" method="post" class="post-edit-form">
		<div class="post-edit-content">
			<textarea placeholder="What's on your mind?" name="post"
				class="js-post-edit-input post-edit-textarea"></textarea>
		</div>
		<div class="post-edit-actions">
			<button type="button" class="post-edit-cancel-btn" onclick="postedit.hide()">Cancel</button>
			<button type="submit" class="post-edit-submit-btn">
				<span class="btn-text">Save</span>
				<span class="btn-loader hide"></span>
			</button>
		</div>
	</form>
</div>

<style>
	/* Post edit form styles */
	.class_27 {
		background-color: #fff;
	}

	.post-edit-form {
		padding: 15px;
		border-radius: 8px;
		background-color: #fff;
	}

	.post-edit-content {
		margin-bottom: 15px;
	}

	.post-edit-textarea {
		width: 100%;
		min-height: 120px;
		padding: 12px;
		border: 1px solid #ddd;
		border-radius: 8px;
		font-family: inherit;
		font-size: 1rem;
		resize: vertical;
		transition: border-color 0.2s ease;
	}

	.post-edit-textarea:focus {
		outline: none;
		border-color: #4a76a8;
		box-shadow: 0 0 0 2px rgba(74, 118, 168, 0.2);
	}

	.post-edit-actions {
		display: flex;
		justify-content: flex-end;
		gap: 10px;
	}

	.post-edit-cancel-btn {
		padding: 8px 16px;
		background-color: #f0f2f5;
		color: #65676b;
		border: none;
		border-radius: 6px;
		font-weight: 500;
		cursor: pointer;
		transition: background-color 0.2s ease;
	}

	.post-edit-cancel-btn:hover {
		background-color: #e4e6e9;
	}

	.post-edit-submit-btn {
		padding: 8px 20px;
		background-color: #4a76a8;
		color: white;
		border: none;
		border-radius: 6px;
		font-weight: 500;
		cursor: pointer;
		transition: background-color 0.2s ease;
		position: relative;
	}

	.post-edit-submit-btn:hover {
		background-color: #3b5998;
	}

	.btn-loader {
		display: inline-block;
		width: 16px;
		height: 16px;
		border: 2px solid rgba(255, 255, 255, 0.3);
		border-radius: 50%;
		border-top-color: #fff;
		animation: spin 0.8s linear infinite;
		position: absolute;
		right: 10px;
		top: 50%;
		transform: translateY(-50%);
	}

	@keyframes spin {
		to {
			transform: translateY(-50%) rotate(360deg);
		}
	}

	.hide {
		display: none;
	}
</style>

<script>

	var postedit = {

		edit_id: 0,

		show: function (id) {

			postedit.edit_id = id;

			let data = document.querySelector("#post_" + id).getAttribute("row");
			data = data.replaceAll('\\"', '"');
			data = JSON.parse(data);

			if (typeof data == 'object') {
				document.querySelector(".js-post-edit-input").value = data.post;
			} else {
				alert("Invalid post data");
			}

			document.querySelector(".js-post-edit-modal").classList.remove('hide');
			document.querySelector(".js-login-modal").classList.add('hide');
			document.querySelector(".js-signup-modal").classList.add('hide');
		},

		hide: function () {
			document.querySelector(".js-post-edit-modal").classList.add('hide');
		},

		submit: function (e) {

			e.preventDefault();

			// Show loading state
			const submitBtn = document.querySelector(".post-edit-submit-btn");
			const btnText = submitBtn.querySelector(".btn-text");
			const btnLoader = submitBtn.querySelector(".btn-loader");

			btnText.textContent = "Saving...";
			btnLoader.classList.remove('hide');
			submitBtn.disabled = true;

			let post = document.querySelector(".js-post-edit-input").value.trim();
			let form = new FormData();

			form.append('id', postedit.edit_id);
			form.append('post', post);
			form.append('data_type', 'edit_post');
			var ajax = new XMLHttpRequest();

			ajax.addEventListener('readystatechange', function () {

				if (ajax.readyState == 4) {

					// Reset button state
					btnText.textContent = "Save";
					btnLoader.classList.add('hide');
					submitBtn.disabled = false;

					if (ajax.status == 200) {

						console.log(ajax.responseText);
						let obj = JSON.parse(ajax.responseText);
						alert(obj.message);

						if (obj.success)
							window.location.reload();
					} else {
						alert("Please check your internet connection");
					}
				}
			});

			ajax.open('post', 'ajax.inc.php', true);
			ajax.send(form);
		},


	};

</script>