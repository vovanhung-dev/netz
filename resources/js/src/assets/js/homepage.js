jQuery( document ).ready(function($) { 
	$('.partner-slide').owlCarousel({
		loop:false,
		center: false,
		margin:50,
		stagePadding: 0,
		nav:true,
		dots: false,
    	responsiveClass:true,
		responsive:{
			0:{
				items:2,margin:10,stagePadding:0,center: false,autoplay:true,nav:false,autoplayTimeout:2000
			},
			600:{
				items:3, margin:10,
			},
			1000:{
				items:5
			}
		}
	});
}); 