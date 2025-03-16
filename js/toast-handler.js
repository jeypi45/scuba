/**
 * Global toast handler for consistent iziToast notifications
 */
const ToastHandler = {
    /**
     * Process AJAX response and show appropriate toast
     * @param {Object} response - JSON response from AJAX call
     */
    handleResponse: function(response) {
        const toastType = response.toast_type || (response.success ? 'success' : 'error');
        const message = response.message || 'Operation completed';
        
        switch(toastType) {
            case 'success':
                this.success(message);
                break;
            case 'error':
                this.error(message);
                break;
            case 'warning':
                this.warning(message);
                break;
            case 'info':
                this.info(message);
                break;
            default:
                this.info(message);
        }
        
        return response; // Allow chaining
    },
    
    success: function(message, title = 'Success') {
        return iziToast.success({
            title: title,
            message: message,
            position: 'topRight',
            timeout: 5000
        });
    },
    
    error: function(message, title = 'Error') {
        return iziToast.error({
            title: title,
            message: message,
            position: 'topRight',
            timeout: 5000
        });
    },
    
    warning: function(message, title = 'Warning') {
        return iziToast.warning({
            title: title,
            message: message,
            position: 'topRight',
            timeout: 5000
        });
    },
    
    info: function(message, title = 'Information') {
        return iziToast.info({
            title: title,
            message: message,
            position: 'topRight',
            timeout: 5000
        });
    },
    
    question: function(options) {
        return iziToast.question({
            timeout: 20000,
            close: false,
            overlay: true,
            displayMode: 'once',
            zindex: 999,
            title: options.title || 'Confirm',
            message: options.message || 'Are you sure?',
            position: 'center',
            buttons: [
                ['<button><b>YES</b></button>', function (instance, toast) {
                    instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
                    if (typeof options.onYes === 'function') {
                        options.onYes();
                    }
                }, true],
                ['<button>NO</button>', function (instance, toast) {
                    instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
                    if (typeof options.onNo === 'function') {
                        options.onNo();
                    }
                }]
            ]
        });
    }
};

// Make it globally available
window.toast = ToastHandler;