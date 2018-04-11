/**
 * This file is for any custom JavaScript.
 *
 * @author SunlitStudio
 * @link https://sunlitstud.io
 * @version 1.1.0
 * @license GPL-2.0+
 */

'use strict';

/* Create grayscale map */
var znetMap = (function() {
  return {
    init: function() {
      var stylez = [{
        featureType: "all",
        elementType: "all",
        stylers: [{
            saturation: -100
          } // <-- THIS
        ]
      }];
      var mapCanvas = document.getElementById('map_canvas'),
        contentString = '<div id="content">' +
        '<div id="siteNotice">' +
        '</div>' +
        '<h1 id="firstHeading" class="firstHeading">Xenon Headquarters</h1>' +
        '<div id="bodyContent"' +
        '<p>Irvine, CA</p>' +
        '</div>' +
        '</div>',
        myLatlng = new google.maps.LatLng(33.695030, -117.835692),
        mapCenter = new google.maps.LatLng(33.695030, -117.835692),
        mapOptions = {
          center: mapCenter,
          zoom: 13,
          scrollwheel: false,
          draggable: true,
          disableDefaultUI: true,
          mapTypeControlOptions: {
            mapTypeIds: [google.maps.MapTypeId.ROADMAP, "tehgrayz"]
          }
        },
        map = new google.maps.Map(mapCanvas, mapOptions),
        infowindow = new google.maps.InfoWindow({
          content: contentString,
          maxWidth: 300
        }),
        marker = new google.maps.Marker({
          position: myLatlng,
          map: map,
          title: 'Xenon (California)'
        }),
        mapType = new google.maps.StyledMapType(stylez, {
          name: "Grayscale"
        });
      map.mapTypes.set("tehgrayz", mapType);
      map.setMapTypeId("tehgrayz");
      google.maps.event.addListener(marker, 'click', function() {
        infowindow.open(map, marker);
      });
    }
  };
}());



jQuery(document).ready(function($) {
  znetMap.init();
});
