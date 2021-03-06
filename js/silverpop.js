(function ($, Drupal, drupalSettings) {

  Drupal.behaviors.silverpop = {
    attach: function (context, settings) {
      // Add our silverpop event tracking js here.
      if (drupalSettings.silverpop.events) {

        // Go through each event and add code to send the data to silverpop on
        // the click event for that particular selector.
        $.each(drupalSettings.silverpop.events, function(index, silverpopEvent) {
          $(silverpopEvent.cssSelector).click(function () {
            // Add the basic event specific elements.
            var trackingArray = {
              name: silverpopEvent.name,
              type: silverpopEvent.type,
              link: this
            };

            // Now, send the tracking data.
            return ewt.trackLink({
              trackingArray
            });
          });

        });
      }
    }
  };

}(jQuery, Drupal, drupalSettings));
