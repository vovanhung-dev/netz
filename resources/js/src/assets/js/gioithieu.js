(function ($) {
    $(function () {
      function safeTop(sel) {
        var $el = $(sel);
        var off = $el.length ? $el.offset() : null;
        return off && typeof off.top === 'number' ? off.top : 0;
      }
  
      $('.navigation__link').off('.safe').on('click.safe', function (e) {
        var href = $(this).attr('href');
        if (!href || href.charAt(0) !== '#') return;
        e.preventDefault();
        e.stopPropagation();
        var y = safeTop(href);
        $('html, body').stop(true).animate({ scrollTop: y }, 600);
      });
    });
  })(jQuery);
  

$(window).scroll(function () {
    if ($(window).scrollTop() != 0) {
        $("#header").addClass("sticky");		
        $('#top').fadeIn();
    } else {
        $("#header").removeClass("sticky");
        $('#top').fadeOut();
    }
});

$(document).ready(function() {
    /*Scroll to div add class*/
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

})