var mycomment = {

    page_number: (typeof page_number == 'undefined') ? 1 : page_number,
    post_id: (typeof post_id == 'undefined') ? 0 : post_id,

    submit: function(e){

        e.preventDefault();
        let text = document.querySelector(".js-comment-input").value.trim();
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

        form.append('post_id', mycomment.post_id);
        form.append('post', text);
        form.append('data_type', 'add_comment');
        var ajax = new XMLHttpRequest();

        ajax.addEventListener('readystatechange', function() {
            if(ajax.readyState == 4) {
                if(ajax.status == 200) {
                    let obj = JSON.parse(ajax.responseText);
                    
                    // Show appropriate toast notification
                    if(obj.success) {
                        toast.success(obj.message || 'Comment posted successfully');
                        
                        // Clear the comment input field
                        document.querySelector(".js-comment-input").value = "";
                        
                        // Refresh the comments list
                        mycomment.load_comments();
                    } else {
                        toast.error(obj.message || 'Failed to post comment');
                    }
                } else {
                    toast.error('Connection error. Please check your internet connection.');
                }
            }
        });

        ajax.open('post','ajax.inc.php', true);
        ajax.send(form);
    },

    load_comments: function(e){

        let form = new FormData();

        form.append('post_id', mycomment.post_id);
        form.append('page_number', mycomment.page_number);
        form.append('data_type', 'load_comments');
        var ajax = new XMLHttpRequest();

        ajax.addEventListener('readystatechange',function(){

            if(ajax.readyState == 4)
            {
                if(ajax.status == 200){

                    //console.log(ajax.responseText);
                    let obj = JSON.parse(ajax.responseText);

                    if(obj.success){
                        let post_holder = document.querySelector(".js-comments");

                        post_holder.innerHTML = "";
                        let template = document.querySelector(".js-comment-card");
                        
                        if(typeof obj.rows == 'object')
                        {

                            for (var i = obj.rows.length - 1; i >= 0; i--) {
 
                                template.querySelector(".js-comment").innerHTML = obj.rows[i].post;
                                template.querySelector(".js-date").innerHTML = obj.rows[i].date;
                                template.querySelector(".js-delete-button").setAttribute('onclick',`mycomment.delete(${obj.rows[i].id})`);
                                template.querySelector(".js-edit-button").setAttribute('onclick',`postedit.show(${obj.rows[i].id})`);
                                template.querySelector(".js-username").innerHTML = (typeof obj.rows[i].user == 'object') ? obj.rows[i].user.username : 'User';
                                template.querySelector(".js-profile-link").href = (typeof obj.rows[i].user == 'object') ? 'profile.php?id='+obj.rows[i].user.id : '#';
                                
                                if(typeof obj.rows[i].user == 'object')
                                    template.querySelector(".js-image").src = obj.rows[i].user.image;

                                let clone = template.cloneNode(true);
                                clone.setAttribute('id','post_'+obj.rows[i].id);
                                let row_data = JSON.stringify(obj.rows[i]);
                                row_data = row_data.replaceAll('"','\\"');

                                clone.setAttribute('row',row_data);

                                let action_buttons = clone.querySelector(".js-action-buttons");
                                if(!obj.rows[i].user_owns)
                                    action_buttons.remove();
                                
                                clone.classList.remove('hide');
                                
                                post_holder.appendChild(clone);
                            }
                        }else{
                            post_holder.innerHTML = "<div style='text-align:center;padding:10px'>No comments found</div>";
                        }

                    }

                    document.querySelector(".js-page-number").innerHTML = "Page " + mycomment.page_number;
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
        mycomment.page_number = mycomment.page_number + 1;
        mycomment.load_comments();
        //window.location.href = 'forum.php?page=' + mycomment.page_number;
    },

    prev_page: function(){
        mycomment.page_number = mycomment.page_number - 1;
        if(mycomment.page_number < 1)
            mycomment.page_number = 1;

        mycomment.load_comments();
        //window.location.href = 'forum.php?page=' + mycomment.page_number;
    },

    delete: function(id) {
        // Replace the confirm dialog with iziToast
        iziToast.question({
            timeout: 20000,
            close: false,
            overlay: true,
            displayMode: 'once',
            id: 'question',
            zindex: 999,
            title: 'Confirm',
            message: 'Are you sure you want to delete this comment?',
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
                                
                                if(obj.success) {
                                    iziToast.success({
                                        title: 'Success',
                                        message: obj.message,
                                        position: 'topRight',
                                        timeout: 5000
                                    });
                                    window.location.reload();
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

};

// You might also want to add a helper function like this
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
    },
    // Add this missing function
    handleResponse: function(response) {
        if (response.success) {
            this.success(response.message || 'Operation completed successfully');
        } else {
            this.error(response.message || 'Operation failed');
        }
        return response; // Allow chaining
    }
};

mycomment.load_comments();