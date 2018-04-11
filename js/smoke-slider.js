(function($) {
  $(window).load(function() {
    $('.flexslider').flexslider({
      animation: "slide",
      pauseOnHover: true,
      start: function(slider) {
        $('body').removeClass('loading');
        slider.play();
      }
    });
  });
})(jQuery);
