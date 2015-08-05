(function($) {

  Drupal.behaviors.UndpMap = {
    ajaxSuccessHandler: function(ajaxEvent, xhr, ajaxOptions) {
      if (ajaxOptions.url != '/views/ajax') { return; }
      // the filters have been updated
    
      Drupal.behaviors.UndpMap.updateMap();
    },

    /*
      Convert coordinates from WKT format to L.LatLng
    */
    convertCoordinates: function(coords) {
      var wktRegex = /^POINT \((-?[0-9.]+) (-?[0-9.]+)\)$/;
      var results = wktRegex.exec(coords);
      if (!results) { return false; }
      return new L.LatLng(results[2], results[1]);
    },

    /*
      Setup the MarkerIcon class based on default icon settings
    */
    loadDefaultIconSettings: function() {
      Drupal.behaviors.UndpMap.MarkerIcon = L.Icon.extend(Drupal.settings.undpmap.icon['default']);
    },
    
    updateMap: function() {
      // remove markers
      var map = Drupal.settings.leaflet[0].lMap;
      for (item in map._layers) {
        if (item == 'earth') {continue;}
        var feature = map._layers[item];
      
        // points with "_opened" are pins, not markers
        if (typeof(map._layers[item]['_opened']) == 'undefined') {
          // remove this layer
          map.removeLayer(feature);
        }
      }
    
      // get the markers based on the table
      var $data = $('.view-explore table');
      var $rows = $('tbody tr');
      for (var i = 0; i < $rows.length; i++) {
        var $row = $($rows[i]);
        var $titleLink = $row.find('td.views-field.views-field-title a');
        var $dataDiv = $row.find('td.views-field.views-field-field-region div');
        var coordinates = Drupal.behaviors.UndpMap.convertCoordinates($dataDiv.data('coordinates'));
        if (!coordinates) {
          continue; 
        }
        
        var marker = new L.Marker(coordinates, {
          icon: new Drupal.behaviors.UndpMap.MarkerIcon($dataDiv.data('icon'))
        });
        marker.bindPopup('<a href="' + $titleLink.attr('href') + '">' + $titleLink.text() + '</a>');
        map.addLayer(marker);
      }
      
    }
  };
  
  $('body').bind('ajaxSuccess', Drupal.behaviors.UndpMap.ajaxSuccessHandler);
  $(document).ready(Drupal.behaviors.UndpMap.loadDefaultIconSettings);
})(jQuery);
