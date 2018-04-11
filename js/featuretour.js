(function($) {
  $(document).ready(function() {
    var tooSmall = false;
    var maxWidth = 768;
    var bubbleWidth = 380;
    var xOffsetRight = 380;

    if ($(window).width() < maxWidth) {
      tooSmall = true;
      bubbleWidth = $(window).width() - 100;
      xOffsetRight = 0;
    }

    /**
     * Feature hotspots
     */
    // Get content for featuresTour
    var featuresContent = new Array();
    $('.feature-content').each(function() {
      featuresContent.push(this.innerHTML);
    });

    // Define the tour!
    var featuresTour = {
      id: 'features-list',
      smoothScroll: true,
      showPrevButton: true,
      bubbleWidth: bubbleWidth,
      bubblePadding: '20',
      showNumber: true,
      i18n: {
        nextBtn: 'Next',
        prevBtn: 'Prev',
        closeToolTip: "Close Tour",
        stepNums: ["1", "2", "3", "4", "5", "6", "7", "8", "9"]
      },
      steps: [{
        content: $('#feature-ac .feature-content').html(),
        target: 'feature-ac',
        placement: 'bottom',
        xOffset: -220,
        yOffset: -6,
        arrowOffset: 100,
      }, {
        content: $('#feature-water-sensor .feature-content').html(),
        target: 'feature-water-sensor',
        placement: 'bottom',
        xOffset: -150,
        yOffset: -20,
        arrowOffset: 120,
      }, {
        content: $('#feature-temp .feature-content').html(),
        target: 'feature-temp',
        placement: 'bottom',
        xOffset: -100,
        yOffset: -6,
        arrowOffset: 100,
      }, {
        content: $('#feature-door .feature-content').html(),
        target: 'feature-door',
        placement: 'top',
        xOffset: -200,
        yOffset: -6,
        arrowOffset: 200,
      }, {
        content: $('#feature-smoke-detector .feature-content').html(),
        target: 'feature-smoke-detector',
        placement: 'bottom',
        xOffset: -100,
        yOffset: -24,
        arrowOffset: 100,
      }, {
        content: $('#feature-garage-door .feature-content').html(),
        target: 'feature-garage-door',
        placement: 'top',
        xOffset: -250,
        yOffset: -6,
        arrowOffset: 100,
      }, {
        content: $('#feature-gas-shutoff .feature-content').html(),
        target: 'feature-gas-shutoff',
        placement: 'top',
        xOffset: -250,
        yOffset: -6,
        arrowOffset: 100,
      }, {
        content: $('#feature-door-locks .feature-content').html(),
        target: 'feature-door-locks',
        placement: 'top',
        xOffset: -100,
        yOffset: 6,
        arrowOffset: 100,
      }, {
        content: $('#feature-zwave-controller .feature-content').html(),
        target: 'feature-zwave-controller',
        placement: 'top',
        xOffset: -40,
        yOffset: 6,
        arrowOffset: 40,
      }]
    };

    // Start the tour!
    //hopscotch.startTour(featuresTour);

    // Trigger features tour from each feature
    $('.feature-link').click(function(event) {
      event.preventDefault();
      var target = $(this).parent().index();
      hopscotch.startTour(featuresTour, target);
    });


  }); // document ready
})(jQuery);
