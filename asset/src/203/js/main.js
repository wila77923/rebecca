jQuery(document).ready(function( $ ) {


  // Initiate the wowjs animation library
  new WOW().init();

  // Initiate superfish on nav menu
  $('.nav-menu').superfish({
    animation: {
      opacity: 'show'
    },
    speed: 400
  });

  // Mobile Navigation
  if ($('#nav-menu-container').length) {
    var $mobile_nav = $('#nav-menu-container').clone().prop({
      id: 'mobile-nav'
    });
    $mobile_nav.find('> ul').attr({
      'class': '',
      'id': ''
    });
    $('body').append($mobile_nav);
    $('body').prepend('<button type="button" id="mobile-nav-toggle"><i class="fa fa-bars"></i></button>');
    $('body').append('<div id="mobile-body-overly"></div>');
    $('#mobile-nav').find('.menu-has-children').prepend('<i class="fa fa-chevron-down"></i>');

    $(document).on('click', '.menu-has-children p', function(e) {
      $(this).next().toggleClass('menu-item-active');
      $(this).nextAll('ul').eq(0).slideToggle();
      $(this).parent().find('i').toggleClass("fa-chevron-up fa-chevron-down");
	  $(this).parent().siblings().find('i').removeClass("fa-chevron-down").parent().siblings().find('i').addClass("fa-chevron-up");
	  $(this).parent().siblings().find('ul').hide();
    });
	
	$(document).on('click', '.menu-has-children i', function(e) {
	  $(this).next().toggleClass('menu-item-active');
	  $(this).nextAll('ul').eq(0).slideToggle();
	  $(this).toggleClass("fa-chevron-up fa-chevron-down");
	});

    $(document).on('click', '#mobile-nav-toggle', function(e) {
      $('body').toggleClass('mobile-nav-active');
      $('#mobile-nav-toggle i').toggleClass('fa-times fa-bars');
      $('#mobile-body-overly').toggle();
    });

    $(document).click(function(e) {
      var container = $("#mobile-nav, #mobile-nav-toggle");
      if (!container.is(e.target) && container.has(e.target).length === 0) {
        if ($('body').hasClass('mobile-nav-active')) {
          $('body').removeClass('mobile-nav-active');
          $('#mobile-nav-toggle i').toggleClass('fa-times fa-bars');
          $('#mobile-body-overly').fadeOut();
        }
      }
    });
  } else if ($("#mobile-nav, #mobile-nav-toggle").length) {
    $("#mobile-nav, #mobile-nav-toggle").hide();
  }

  
  // Header scroll class
  $(window).scroll(function() {
    if ($(this).scrollTop() > 100) {
      $('#header').addClass('header-scrolled');
    } else {
      $('#header').removeClass('header-scrolled');
    }
  });

  // Banner carousel
  var bannerCarousel = $(".carousel");
  var bannerCarouselIndicators = $(".carousel-indicators");
  bannerCarousel.find(".carousel-inner").children(".carousel-item").each(function(index) {
    (index === 0) ?
    bannerCarouselIndicators.append("<li data-target='#bannerCarousel' data-slide-to='" + index + "' class='active'></li>") :
    bannerCarouselIndicators.append("<li data-target='#bannerCarousel' data-slide-to='" + index + "'></li>");
  });

  $(".carousel").swipe({
    swipe: function(event, direction, distance, duration, fingerCount, fingerData) {
      if (direction == 'left') $(this).carousel('next');
      if (direction == 'right') $(this).carousel('prev');
    },
    allowPageScroll:"vertical"
  });


  // Clients carousel (uses the Owl Carousel library)
  $(".clients-carousel").owlCarousel({
    autoplay: true,
    dots: true,
    loop: true,
    responsive: { 0: { items: 2 }, 768: { items: 4 }, 900: { items: 6 }
    }
  });


  $(".carousel__element").owlCarousel({
    loop:false,
	dots:false,
	nav:true,
	margin:30,
	responsive:{0:{items:1},768:{items:2},992:{items:3}}
  });
 
 
 
 
});



