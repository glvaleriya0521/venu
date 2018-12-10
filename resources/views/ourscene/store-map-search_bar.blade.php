<!DOCTYPE html>
<html>
  <head>
    <title>Place Searches</title>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
    <meta charset="utf-8">
    <style>
      /* Always set the map height explicitly to define the size of the div
       * element that contains the map. */
      #map {
        height: 100%;
      }
      /* Optional: Makes the sample page fill the window. */
      html, body {
        height: 100%;
        margin: 0;
        padding: 0;
      }
    </style>
    <script>
      // This example requires the Places library. Include the libraries=places
      // parameter when you first load the API. For example:
      // <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&libraries=places">

      var map;
      var infowindow;
      var directionsDisplay;
      
      

      function initMap() {

        directionsDisplay = new google.maps.DirectionsRenderer();
         
         

        var pyrmont = {lat: 34.05223, lng:  -118.24368};

        map = new google.maps.Map(document.getElementById('map'), {
          center: pyrmont,
          mapTypeId: google.maps.MapTypeId.ROADMAP,
          zoom: 17
        });

        directionsDisplay.setMap(map);

        infowindow = new google.maps.InfoWindow();
        var service = new google.maps.places.PlacesService(map);
        service.nearbySearch({
          location: pyrmont,
          radius: 1500,
          type: ['restaurant']
        }, callback);
        calcRoute();
      }

      function calcRoute() {
        var haight = new google.maps.LatLng(34.05223,-118.24368);
        var oceanBeach = new google.maps.LatLng(34.04564,-118.24164);
        var request = {
        origin: haight,
        destination: oceanBeach,
        travelMode: google.maps.TravelMode.DRIVING
        };
        var directionsService = new google.maps.DirectionsService();
        directionsService.route(request, function(response, status) {
         if (status == google.maps.DirectionsStatus.OK) {
             directionsDisplay.setDirections(response);
            }
       });
      }

      function callback(results, status) {
        if (status === google.maps.places.PlacesServiceStatus.OK) {
          for (var i = 0; i < results.length; i++) {
            createMarker(results[i]);
          }
        }
      }

      function createMarker(place) {
        var placeLoc = place.geometry.location;
        var photos = place.photos;
        if (!photos) {
          return;
        }
        var center = new google.maps.LatLng('34.05223', '-118.24368');
        var marker_center = new google.maps.Marker({
              map: map,
              position: center
            });
        google.maps.event.addListener(marker_center, 'click', function() {
              infowindow.setContent('<div><strong>' + 'place.name' + '</strong><br>' +
                  place.formatted_address + '</div>');
              infowindow.open(map, this);
            });

        var service = new google.maps.places.PlacesService(map);
        service.getDetails({
          placeId: place.place_id
        }, function(place, status) {
          if (status === google.maps.places.PlacesServiceStatus.OK) {
            var marker = new google.maps.Marker({
              map: map,
              position: place.geometry.location
            });
            google.maps.event.addListener(marker, 'click', function() {
              infowindow.setContent('<div><strong>' + place.name + '</strong><br>' +
                  place.formatted_address + '</div>');
              infowindow.open(map, this);
            });
          }
        });
      }

      google.maps.event.addDomListener(window, 'load', initialize);
    </script>
  </head>
  <body>
    <div id="map"></div>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBc2Iddfy8NwxvC7sdbdvUa-pfqMnRXIBI&libraries=places&callback=initMap" async defer></script>
  </body>
</html>