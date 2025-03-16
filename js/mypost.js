var mypost = {

	page_number: (typeof page_number == 'undefined') ? 1 : page_number,

	submit: function(e){

		e.preventDefault();
		let text = document.querySelector(".js-post-input").value.trim();
		if(text == ""){
            iziToast.warning({
                title: 'Warning',
                message: 'Please type something to post',
                position: 'topRight',
                timeout: 5000
            });
            return;
        }
		let form = new FormData();

		// Add image file if it exists
		const imageInput = document.querySelector(".js-image-input");
		if(imageInput && imageInput.files && imageInput.files[0]) {
			form.append('post_image', imageInput.files[0]);
		}
	

		form.append('post', text);
		form.append('data_type', 'add_post');
		var ajax = new XMLHttpRequest();

		ajax.addEventListener('readystatechange',function(){

            if(ajax.readyState == 4)
            {
                if(ajax.status == 200){

                    //console.log(ajax.responseText);
                    let obj = JSON.parse(ajax.responseText);
                    
                    if(obj.success){
                        iziToast.success({
                            title: 'Success',
                            message: obj.message,
                            position: 'topRight',
                            timeout: 5000
                        });
                        
                        document.querySelector(".js-post-input").value = "";
                        // Clear image preview after successful post
                        if(imageInput) {
                            imageInput.value = '';
                            document.querySelector(".image-preview-container").classList.add('hide');
                        }
                        mypost.load_posts();
                    } else {
                        iziToast.error({
                            title: 'Error',
                            message: obj.message,
                            position: 'topRight',
                            timeout: 5000
                        });
                    }
                }else{
                    iziToast.error({
                        title: 'Connection Error',
                        message: 'Please check your internet connection',
                        position: 'topRight',
                        timeout: 5000
                    });
                }
            }
        });
    
        ajax.open('post','ajax.inc.php', true);
        ajax.send(form);
    },

	load_posts: function(e){

		let form = new FormData();

		form.append('page_number', mypost.page_number);
		form.append('data_type', 'load_posts');
		var ajax = new XMLHttpRequest();

		ajax.addEventListener('readystatechange',function(){

			if(ajax.readyState == 4)
			{
				if(ajax.status == 200){

					//console.log(ajax.responseText);
					let obj = JSON.parse(ajax.responseText);

					if(obj.success){
						let post_holder = document.querySelector(".js-posts");

						post_holder.innerHTML = "";
						let template = document.querySelector(".js-post-card");
						
						if(typeof obj.rows == 'object')
						{

							for (var i = 0; i < obj.rows.length; i++) {
 
 								template.querySelector(".js-post").innerHTML = obj.rows[i].post;
								template.querySelector(".js-date").innerHTML = obj.rows[i].date;
								template.querySelector(".js-comment-link").setAttribute('onclick',`mypost.view_comments(${obj.rows[i].id})`);
								
								if(obj.rows[i].comments > 0){
									template.querySelector(".js-comment-link").innerHTML = `Comments (${obj.rows[i].comments})`;
								}else{
									template.querySelector(".js-comment-link").innerHTML = `Comments`;
								}
								
								template.querySelector(".js-username").innerHTML = (typeof obj.rows[i].user == 'object') ? obj.rows[i].user.username : 'User';
								template.querySelector(".js-profile-link").href = (typeof obj.rows[i].user == 'object') ? 'profile.php?id='+obj.rows[i].user.id : '#';
								
								if(typeof obj.rows[i].user == 'object')
									template.querySelector(".js-image").src = obj.rows[i].user.image;
								
								// Handle post image if exists
								const imageContainer = template.querySelector(".js-post-image-container");
								const postImage = template.querySelector(".js-post-image");
								
								if(obj.rows[i].image && obj.rows[i].image !== '') {
									postImage.src = obj.rows[i].image;
									imageContainer.classList.remove('hide');
								} else {
									imageContainer.classList.add('hide');
								}
								
								// Set up like button functionality
								const likeButton = template.querySelector(".js-like-button");
								const likeCount = template.querySelector(".js-like-count");
								
								// Set initial like count
								likeCount.textContent = obj.rows[i].likes || 0;
								
								// Check if user has liked this post
								if(obj.rows[i].user_liked) {
									likeButton.classList.add('active');
								} else {
									likeButton.classList.remove('active');
								}
								
								let clone = template.cloneNode(true);
								clone.setAttribute('id','post_'+obj.rows[i].id);
								
								// Store the post ID as a data attribute for use with the event listener
								clone.setAttribute('data-post-id', obj.rows[i].id);
								
								let row_data = JSON.stringify(obj.rows[i]);
								row_data = row_data.replaceAll('"','\\"');
								clone.setAttribute('row',row_data);
								clone.classList.remove('hide');
								
								post_holder.appendChild(clone);
							}
							
							// After adding all posts, now add event listeners to the actual DOM elements
							document.querySelectorAll('.js-like-button').forEach(button => {
								button.addEventListener('click', function() {
									// Get the post id from the containing post card
									const postCard = this.closest('.js-post-card');
									const postId = postCard.getAttribute('data-post-id');
									if(postId) {
										mypost.toggle_like(postId);
									}
								});
							});
						}else{
							post_holder.innerHTML = "<div style='text-align:center;padding:10px'>No posts found</div>";
						}

					}

					document.querySelector(".js-page-number").innerHTML = "Page " + mypost.page_number;
				}
			}
		});

		ajax.open('post','ajax.inc.php', true);
		ajax.send(form);
	},

	view_comments: function(id){

		window.location.href = "post.php?id="+id;
	},

	next_page: function(){
		mypost.page_number = mypost.page_number + 1;
		mypost.load_posts();
		//window.location.href = 'forum.php?page=' + mypost.page_number;
	},

	prev_page: function(){
		mypost.page_number = mypost.page_number - 1;
		if(mypost.page_number < 1)
			mypost.page_number = 1;

		mypost.load_posts();
		//window.location.href = 'forum.php?page=' + mypost.page_number;
	},

	delete: function(id)
    {
        // Replace the standard confirm dialog with iziToast question dialog
        iziToast.question({
            timeout: 20000,
            close: false,
            overlay: true,
            displayMode: 'once',
            id: 'question',
            zindex: 999,
            title: 'Confirm Deletion',
            message: 'Are you sure you want to delete this post?',
            position: 'center',
            buttons: [
                ['<button><b>YES</b></button>', function (instance, toast) {
                    instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
                    
                    // The actual deletion code that runs after confirmation
                    let form = new FormData();
                    form.append('id', id);
                    form.append('data_type', 'delete_post');
                    var ajax = new XMLHttpRequest();

					ajax.addEventListener('readystatechange', function() {
						if(ajax.readyState == 4) {
							if(ajax.status == 200) {
								let obj = JSON.parse(ajax.responseText);
								

								toast.handleResponse(obj);
								

								if(obj.success) {
									
								}
							} else {
								toast.error('Connection error. Please check your internet connection.');
							}
						}
					});

                    ajax.open('post','ajax.inc.php', true);
                    ajax.send(form);
                }, true],
                ['<button>NO</button>', function (instance, toast) {
                    instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
                }],
            ],
            onClosing: function(instance, toast, closedBy) {
                console.info('Closing | closedBy: ' + closedBy);
            },
            onClosed: function(instance, toast, closedBy) {
                console.info('Closed | closedBy: ' + closedBy);
            }
        });
    },

	toggle_like: function(post_id) {
    let form = new FormData();
    form.append('post_id', post_id);
    form.append('data_type', 'toggle_like');
    var ajax = new XMLHttpRequest();

    ajax.addEventListener('readystatechange', function() {
        if(ajax.readyState == 4) {
            if(ajax.status == 200) {
                try {
                    let obj = JSON.parse(ajax.responseText);
                    
                    if(obj.success) {
                        // Update UI based on like status
                        const postElement = document.getElementById('post_' + post_id);
                        if(postElement) {
                            const likeButton = postElement.querySelector(".js-like-button");
                            const likeCount = postElement.querySelector(".js-like-count");
                            
                            // Toggle active class with smooth transition
                            if(obj.liked) {
                                likeButton.classList.add('active');
                            } else {
                                likeButton.classList.remove('active');
                            }
                            
                            // Update like count with number formatting
                            likeCount.textContent = obj.like_count;
                        }
                    } else if(obj.message === "Please log in to like posts") {
                        // If user is not logged in, show login dialog
                        if(typeof login !== 'undefined' && login.show) {
                            login.show();
                        } else {
                            alert("Please log in to like posts");
                        }
                    }
                } catch(e) {
                    console.error('Error parsing response:', e);
                }
            }
        }
    });

    ajax.open('post', 'ajax.inc.php', true);
    ajax.send(form);
}

};

// Add helper functions for easier toast usage
window.toast = {
    success: function(message, title = 'Success') {
        iziToast.success({
            title: title,
            message: message,
            position: 'topRight',
            timeout: 5000
        });
    },
    error: function(message, title = 'Error') {
        iziToast.error({
            title: title,
            message: message,
            position: 'topRight',
            timeout: 5000
        });
    },
    warning: function(message, title = 'Warning') {
        iziToast.warning({
            title: title,
            message: message,
            position: 'topRight',
            timeout: 5000
        });
    },
    info: function(message, title = 'Info') {
        iziToast.info({
            title: title,
            message: message,
            position: 'topRight',
            timeout: 5000
        });
    }
};



if(typeof home_page != 'undefined')
	mypost.load_posts();