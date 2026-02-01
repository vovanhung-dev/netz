$(document).ready(function() {
   $("#header .js-toggle-menu").click(function() {
		$("#header").toggleClass("sticky open");
	});
	$("#main-menu li").click(function() {
		$("#main-menu li").removeClass("active");
		$(this).addClass("active");
		$(this).parent().parent().addClass("active");
	});
	
	$("#main-menu li").hover(
		function() {
			$(this).addClass("menu-active");
		},
		function() {
			$(this).removeClass("menu-active");
		}
	);
	
	$(".listd-download .download-cp").hover(
		function() {
			$(this).parent().addClass("active-item");
		},
		function() {
			$(this).parent().removeClass("active-item");
		}
	);

	// $(window).on('load', function(event) {
	// 		$('.loading').delay(1500).fadeOut('fast');
	// 	});

	/*COUNT*/

	setTimeout(function() {
		$('.loading').fadeOut('fast');
	}, 1500);
	
	$('.count').each(function(){$(this).prop('Counter',0).animate({Counter:$(this).text()},{duration:4000,easing:'swing',step:function(now){$(this).text(Math.ceil(now));}});				});	
	
	
	/*Scroll to div add class*/
	if( $(".header-breadcrumb") && $(".header-breadcrumb").offset() ) {
		var stickynavi = $('.p-section-about');
		var hieghtThreshold = $(".header-breadcrumb").offset().top;
		$(window).scroll(function() {
			var scroll = $(window).scrollTop();	
			if (scroll >= hieghtThreshold) {
				stickynavi.addClass('scroll-navi');
			} else {
				stickynavi.removeClass('scroll-navi');
			}
		});
	}
	
	
});

/*Scroll tab active*/
$(document).ready(function() {
	$('.navigation a').bind('click', function(e) { 
		e.preventDefault();
		var target = $(this).attr("href");
		var s = $('*[data-anchor="' + target.substring(1) + '"]').offset().top - $("#header").height() - $(".header-breadcrumb").height() - 15;
		
		$('html, body').stop().animate({
				scrollTop: Math.ceil(s)
		},600, function() {
				location.hash = target;
		});
		return false;
	});

	if(window.location.hash) {
		var target = window.location.hash;
		var s = $('*[data-anchor="' + target.substring(1) + '"]').offset().top - $("#header").height() - $(".header-breadcrumb").height() - 15;
		
		$('html, body').stop().animate({
				scrollTop: Math.ceil(s)
		},600, function() {
				location.hash = target;
		});
	}
});

$(window).scroll(function() {
	var scrollDistance = $(window).scrollTop();
	$('.page-section,.section-lv').each(function(i) {
		if ($(this).position().top <= scrollDistance) {
			$('.navigation a.active').removeClass('active');
			$('.navigation a').eq(i).addClass('active');
		}
	});
}).scroll();
/*End Scroll tab active*/

/*Slide Linh vuc*/
	$('.slide-lv').owlCarousel({
		loop:false,
		center: false,
		margin:0,
		stagePadding:0,
		nav:true,
		dots: false,
    	items:1,
	});
/*End slide Linh vuc*/
/*Slide du an noi bat*/
	$(document).ready(function() {
	  var bigimage = $(".bigslide");
	  var thumbs = $(".thumbs");
	  //var totalslides = 10;
	  var syncedSecondary = true;
	
	  bigimage
		.owlCarousel({
		items: 1,
		slideSpeed: 2000,
		nav: false,
		margin:5,
		autoplay: true,
		dots: false,
		loop: false,
		responsiveRefreshRate: 200,
		navText: [
		  '<i class="fa fa-arrow-left" aria-hidden="true"></i>',
		  '<i class="fa fa-arrow-right" aria-hidden="true"></i>'
		]
	  })
		.on("changed.owl.carousel", syncPosition);
	
	  thumbs
		.on("initialized.owl.carousel", function() {
		thumbs
		  .find(".owl-item")
		  .eq(0)
		  .addClass("current");
	  })
		.owlCarousel({
		items: 3,
		dots: false,
		margin:30,
		nav: false,
		navText: [
		  '<i class="fa fa-arrow-left" aria-hidden="true"></i>',
		  '<i class="fa fa-arrow-right" aria-hidden="true"></i>'
		],
		smartSpeed: 200,
		slideSpeed: 500,
		slideBy: 3,
		responsiveRefreshRate: 100,
		responsiveClass:true,
		responsive:{
			0:{
				items:2,margin:30,
			},
			600:{
				items:2,margin:30,stagePadding:30,center: false,
			},
			1200:{
				items:3,margin:30,stagePadding:30,center: false,
			},
		}
	  })
		.on("changed.owl.carousel", syncPosition2);
	
	  function syncPosition(el) {
		//if loop is set to false, then you have to uncomment the next line
		//var current = el.item.index;
	
		//to disable loop, comment this block
		var count = el.item.count - 1;
		var current = Math.round(el.item.index - el.item.count / 2 - 0.5);
	
		if (current < 0) {
		  current = count;
		}
		if (current > count) {
		  current = 0;
		}
		//to this
		thumbs
		.find(".owl-item")
		.removeClass("current")
		.eq(current)
		.addClass("current");
		var onscreen = thumbs.find(".owl-item.active").length - 1;
		var start = thumbs
		.find(".owl-item.active")
		.first()
		.index();
		var end = thumbs
		.find(".owl-item.active")
		.last()
		.index();
	
		if (current > end) {
		  thumbs.data("owl.carousel").to(current, 100, true);
		}
		if (current < start) {
		  thumbs.data("owl.carousel").to(current - onscreen, 100, true);
		}
	  }
	
	  function syncPosition2(el) {
		if (syncedSecondary) {
		  var number = el.item.index;
		  bigimage.data("owl.carousel").to(number, 100, true);
		}
	  }
	
	  thumbs.on("click", ".owl-item", function(e) {
		e.preventDefault();
		var number = $(this).index();
		bigimage.data("owl.carousel").to(number, 300, true);
	  });
	  
	  
	  
	  $(".bt-field .pre-bt").click(function(e) {
		  e.preventDefault();
		  var total = $('.tab-field .nav .nav-item').length;
		  var currindex = $(".nav-link.active").data("item");
		  var next = currindex - 1;
		  if(currindex == 1) {
			  next = total;
		  }
		  
		  $('.nav-item-' + next + ' .nav-link').trigger("click");
	  });
	  $(".bt-field .next-bt").click(function(e) {
		  e.preventDefault();
		  var total = $('.tab-field .nav .nav-item').length;
		  var currindex = $(".nav-link.active").data("item");
		  var next = currindex + 1;
		  if(currindex == total) {
			  next = 1;
		  }
		  
		  $('.nav-item-' + next + ' .nav-link').trigger("click");
	  });
	  
	  var gallerytienich = $('.slide-project-detail-tienich');
	  gallerytienich.owlCarousel({
			loop:false,
			center: false,
			margin:0,
			stagePadding:0,
			nav:true,
			dots: false,
			items:1,
		});
		
	 
	 $(".tienich-item-cl ul li").click(function() {
		 var no = $(this).data("no");
		 gallerytienich.trigger('to.owl.carousel', no);
		 $(".tienich-item-cl ul li").removeClass("act-tog");
		 $(this).addClass("act-tog");
	 });

	});
/*End slide du an noi bat*/

/*Slide du an noi bat khac*/
	$('.slide-project-ort').owlCarousel({
		loop:false,
		center: false,
		margin:50,
		stagePadding:30,
		nav:true,
		dots: false,
		responsiveClass:true,
		responsive:{
			0:{
				items:1,margin:30,center: false,
			},
			600:{
				items:2,margin:30,stagePadding:30,center: false,
			},
			800:{
				items:3,
				margin:30,
				stagePadding:30,
			},
			1200:{
				items:3
			}
		}
	});
/*End slide du an noi bat khac*/

/*Slide du an chi tiet*/
$('.slide-project-detail,.slide-giaithuong').owlCarousel({
	loop:false,
	center: false,
	margin:0,
	stagePadding:0,
	nav:true,
	dots: false,
	items:1,
});

/*Slide product*/
$('.slide-prod').owlCarousel({
	loop:false,
	center: false,
	margin:50,
	stagePadding: 0,
	nav:false,
	dots: true,
	responsiveClass:true,
	responsive:{
		0:{
			items:1,margin:20,center: false,
		},
		600:{
			items:2,center: false,margin:30,
		},
		1000:{
			items:3
		}
	}
});
$('.slide-thuvienduan,.video-thuvienduan').owlCarousel({
	loop:false,
	margin:20,
	stagePadding: 0,
	nav:false,
	dots: true,
	responsiveClass:true,
	responsive:{
		0:{
			items:1,margin:20,
		},
		600:{
			items:2,
		},
		1000:{
			items:3
		},
		1200:{
			items:4
		}
	}
});
/*SLIDE BAN LANH DAO*/
$('.s-leadership').owlCarousel({
	loop:false,
	margin:30,
	stagePadding: 20,
	nav:false,
	dots: true,
	rows: 2,
	responsiveClass:true,
	responsive:{
		0:{
			items:1,margin:20,
		},
		600:{
			items:2,
		},
		1000:{
			items:3
		},
		1200:{
			items:4,rows: 2
		}
	}
});
/*TIN TUC DU AN*/
$('.slide-new-proj').owlCarousel({
	loop:false,
	margin:50,
	stagePadding:0,
	nav:false,
	dots: true,
	responsiveClass:true,
	responsive:{
		0:{
			items:1,margin:20,
		},
		600:{
			items:2,margin:20,
		},
		1000:{
			items:3,
			margin:20,
		},
		1200:{
			items:3
		}
	}
});
/*SLIDE TIN TUC*/
$('.slide-news').owlCarousel({
	loop:false,
	margin:10,
	stagePadding: 0,
	nav:true,
	dots: false,
	responsiveClass:true,
	responsive:{
		0:{
			items:1,margin:20,
		},
		600:{
			items:2
		},
		1000:{
			items:3
		},
		1200:{
			items:4
		}
	}
});
