
 $(document).ready(function () {
 $(function() {
	  $('a[href*=#]:not([href=#])').click(function() {
	    if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'') && location.hostname == this.hostname) {

	      var target = $(this.hash);
	      target = target.length ? target : $('[name=' + this.hash.slice(1) +']');
	      if (target.length) {
	        $('html,body').animate({
	          scrollTop: target.offset().top
	        }, 1000);
	        return false;
	      }
	    }
	  });
	});
	
  jQuery(document).ready(function() {
    var offset = 500;
    var duration = 300;
    var offsetnav = 700;
        //Script for back to Top button fadein and fadeout
        jQuery(window).scroll(function() {
            if (jQuery(this).scrollTop() > offset) {
                jQuery('.back-to-top').fadeIn(duration);
            } 
            else {
                jQuery('.back-to-top').fadeOut(duration);
            }
        });
        //Script for back to Top button with class="back-to-top" back to top
        jQuery('.back-to-top').click(function(event) {
            event.preventDefault();
            jQuery('html, body').animate({scrollTop: 0}, duration);
            return false;
        });
        //Script for back to Top button with id="back-to-top" back to top
        jQuery('#back-to-top').click(function(event) {
            event.preventDefault();
            jQuery('html, body').animate({scrollTop: 0}, duration);
            return false;
        });
        //Script for navigation to change background to white if window vertical size is > 700
        jQuery(window).scroll(function() {
            if (jQuery(this).scrollTop() > offsetnav) {
                jQuery('.navbar').addClass('navbar-white');
            } 
            else {
                jQuery('.navbar').removeClass('navbar-white');
            }
        });
    });
    //hover effect
    $('.round').hover(function(){
        $(this).children('img').stop(true, true).animate({
            'top'   : '+=8',
            'left'  : '+=8',
            'width' : 270,
            'height': 270,
            'opacity': 0.5
        }, 300);
    }, function(){
        $(this).children('img').stop(true, true).animate({
            'top'   : '-=8',
            'left'  : '-=8',
            'width' : 280,
            'height': 280,
            'opacity': 1  
        }, 200);
    });
    
    $('.arrow').click(function(){
        $(this).children('#content').toggle(300);
        // $(this).children('#content').toggleClass('r');
        // $('.r').parents('.content-box').toggleClass('remain');
    });
    // If window size is greater than 768
    if($(window).width() > 768){
        $('li.dropdown').hover(function(){
        $(this).children('.dropdown-menu').show(100);
        }, function(){
            $('.dropdown-menu').hide(100);
        });
    }

    $(window).scroll(function() {
            if ($(this).scrollTop() > 500) {
                $('#left').addClass('faid-in-left');
                $('#right').addClass('faid-in-right');
            } 
            else {
                $('#left').removeClass('faid-in-left');
                $('#right').removeClass('faid-in-right');
            }
        });

    $(window).scroll(function(){
        if($(this).scrollTop() > 555){
            $('#subscribe').addClass('fixed-subcribe-form');
            // alert($(window).scrollTop() + $(window).height());
        }
        else{
            $('#subscribe').removeClass('fixed-subcribe-form');
        }
    });

     $(window).scroll(function(){
        if($(this).scrollTop() > 2200) {
           $('#subscribe').hide();
           $('#subscribe2').show();

        }
        else{
            $('#subscribe').show();
            $('#subscribe2').hide();
        }
     });

     //Button
     $('a:contains("Signup")').addClass('btn btn-primary btn-nav ');
     $('a:contains("Login")').addClass('btn btn-success btn-nav ');
     

     // $('.btn-nav.sign').parents('li').addClass('pull-right sign');
     // $('.btn-nav.log').parents('li').addClass('pull-right log');

     //Auto Type Banner
     $(function(){
        $(".auto_type").typed({
          strings: ["Financial Planner", "Wealth Manager", "Retirement Planner"],
          typeSpeed: 3
        });
    });
});
//--Scroll Top Mesurement --//
// $(document).scroll(function() {
//     console.log($(document).scrollTop());
// });