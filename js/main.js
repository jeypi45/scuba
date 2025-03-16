;(function () {
	
	'use strict';



	// iPad and iPod detection	
	var isiPad = function(){
		return (navigator.platform.indexOf("iPad") != -1);
	};

	var isiPhone = function(){
	    return (
			(navigator.platform.indexOf("iPhone") != -1) || 
			(navigator.platform.indexOf("iPod") != -1)
	    );
	};

	// Main Menu Superfish
	var mainMenu = function() {

		$('#fh5co-primary-menu').superfish({
			delay: 0,
			animation: {
				opacity: 'show'
			},
			speed: 'fast',
			cssArrows: true,
			disableHI: true
		});

	};

	// Parallax
	var parallax = function() {
		$(window).stellar();
	};


	// Offcanvas and cloning of the main menu
	var offcanvas = function() {

		var $clone = $('#fh5co-menu-wrap').clone();
		$clone.attr({
			'id' : 'offcanvas-menu'
		});
		$clone.find('> ul').attr({
			'class' : '',
			'id' : ''
		});

		$('#fh5co-page').prepend($clone);

		// click the burger
		$('.js-fh5co-nav-toggle').on('click', function(){

			if ( $('body').hasClass('fh5co-offcanvas') ) {
				$('body').removeClass('fh5co-offcanvas');
			} else {
				$('body').addClass('fh5co-offcanvas');
			}
			// $('body').toggleClass('fh5co-offcanvas');

		});

		$('#offcanvas-menu').css('height', $(window).height());

		$(window).resize(function(){
			var w = $(window);


			$('#offcanvas-menu').css('height', w.height());

			if ( w.width() > 769 ) {
				if ( $('body').hasClass('fh5co-offcanvas') ) {
					$('body').removeClass('fh5co-offcanvas');
				}
			}

		});	

	}

	

	// Click outside of the Mobile Menu
	var mobileMenuOutsideClick = function() {
		$(document).click(function (e) {
	    var container = $("#offcanvas-menu, .js-fh5co-nav-toggle");
	    if (!container.is(e.target) && container.has(e.target).length === 0) {
	      if ( $('body').hasClass('fh5co-offcanvas') ) {
				$('body').removeClass('fh5co-offcanvas');
			}
	    }
		});
	};


	// Animations

	var contentWayPoint = function() {
		var i = 0;
		$('.animate-box').waypoint( function( direction ) {

			if( direction === 'down' && !$(this.element).hasClass('animated') ) {
				
				i++;

				$(this.element).addClass('item-animate');
				setTimeout(function(){

					$('body .animate-box.item-animate').each(function(k){
						var el = $(this);
						setTimeout( function () {
							el.addClass('fadeInUp animated');
							el.removeClass('item-animate');
						},  k * 200, 'easeInOutExpo' );
					});
					
				}, 100);
				
			}

		} , { offset: '85%' } );
	};
	

	// Document on load.
	$(function(){
		mainMenu();
		parallax();
		offcanvas();
		mobileMenuOutsideClick();
		contentWayPoint();
		

	});

	


}());

// DOM elements selection with null checks
const body = document.querySelector("body");
const nav = document.querySelector("nav");
const modeToggle = document.querySelector(".dark-light");
const searchToggle = document.querySelector(".searchToggle");
const sidebarOpen = document.querySelector(".sidebarOpen");
const siderbarClose = document.querySelector(".siderbarClose");

// Dark mode persistence
let getMode = localStorage.getItem("mode");
if(getMode && getMode === "dark-mode" && body){
  body.classList.add("dark");
}

// Event listeners with null checks
if(modeToggle) {
  modeToggle.addEventListener("click", () => {
    modeToggle.classList.toggle("active");
    body.classList.toggle("dark");
    // Store user's preferred mode
    if(!body.classList.contains("dark")){
      localStorage.setItem("mode", "light-mode");
    } else {
      localStorage.setItem("mode", "dark-mode");
    }
  });
}

// Search toggle with null check
if(searchToggle) {
  searchToggle.addEventListener("click", () => {
    searchToggle.classList.toggle("active");
  });
}

// Sidebar toggle with null checks
if(sidebarOpen && nav) {
  sidebarOpen.addEventListener("click", () => {
    nav.classList.add("active");
  });
}

if(body && nav) {
  body.addEventListener("click", e => {
    let clickedElm = e.target;
    if(!clickedElm.classList.contains("sidebarOpen") && !clickedElm.classList.contains("menu")){
      nav.classList.remove("active");
    }
  });
}

// Replace the problem section with this conditional code
$(function () {
    // Only run steps if the plugin exists and the element exists
    if($.fn.steps && $("#form-total").length > 0) {
        $("#form-total").steps({
            headerTag: "h2",
            bodyTag: "section",
            transitionEffect: "fade",
            enableAllSteps: true,
            stepsOrientation: "vertical",
            autoFocus: true,
            transitionEffectSpeed: 500,
            titleTemplate: '<div class="title">#title#</div>',
            labels: {
                previous: 'Back Step',
                next: 'Next',
                finish: 'Submit',
                current: ''
            },
        });
    }
});

// Image Carousel for Hero Section - Improved Animation
$(document).ready(function() {
    // Array of background images for carousel
    const heroImages = [
        "images/coverbg1.jpg",
        "images/coverbg2.jpg", 
        "images/coverbg3.jpg",
        "images/coverbg4.jpg"
    ];
    
    let currentIndex = 0;
    const heroElement = $('#hero-cover');
    
    // Create a second background element for smooth crossfade
    if ($('#hero-cover-next').length === 0) {
        heroElement.append('<div id="hero-cover-next"></div>');
    }
    const nextElement = $('#hero-cover-next');
    

    
    // Set initial background
    heroElement.css('background-image', `url(${heroImages[0]})`);
    
    // Function to create smooth crossfade between images
    function smoothTransition() {
        // Calculate next image index
        const nextIndex = (currentIndex + 1) % heroImages.length;
        
        // Set next background image
        nextElement.css({
            'background-image': `url(${heroImages[nextIndex]})`,
            'opacity': 0,
            'transition': 'none'
        });
        
        // Trigger reflow to ensure transition starts fresh
        nextElement[0].offsetHeight;
        
        // Start smooth transition
        nextElement.css({
            'opacity': 1,
            'transition': 'opacity 1.8s cubic-bezier(0.22, 0.61, 0.36, 1)'
        });
        
        // After transition completes
        setTimeout(function() {
            // Set main background to the new image
            heroElement.css('background-image', `url(${heroImages[nextIndex]})`);
            
            // Reset overlay for next transition
            nextElement.css('opacity', 0);
            
            // Update current index
            currentIndex = nextIndex;
        }, 1800);
    }
    
    // Start carousel with smooth transitions
    setInterval(smoothTransition, 6000);
});
