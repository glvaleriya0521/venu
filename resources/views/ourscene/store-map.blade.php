<?php
  use OurScene\Models\Event;
?>

@extends('ourscene.layouts.store-map')

@section('my-store-head')
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
      .controls {
        margin-top: 10px;
        border: 1px solid transparent;
        border-radius: 2px 0 0 2px;
        box-sizing: border-box;
        -moz-box-sizing: border-box;
        height: 32px;
        outline: none;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3);
      }

      #origin-input,
      #destination-input {
        background-color: #fff;
        font-family: Roboto;
        font-size: 15px;
        font-weight: 300;
        margin-left: 12px;
        padding: 0 11px 0 13px;
        text-overflow: ellipsis;
        width: 400px;
        margin-top: 20px;
        margin-right: 80px;
      }

      #origin-input:focus,
      #destination-input:focus {
        border-color: #4d90fe;
      }

      #mode-selector {
        color: #fff;
        background-color: #000;
        margin-left: 12px;
        padding: 5px 11px 0px 11px;
        margin-top: 20px;
        border-radius: 10px;
        size: 20px;
        height: 38px;
        opacity: 0.8;
      }

      #type-selector {
        color: #fff;
        background-color: #000;
        /* margin-left: 0; */
        padding: 5px 11px 0px 11px;
        margin-top: 3px;
        border-radius: 10px;
        size: 20px;
        height: 38px;
        opacity: 0.9;
      }

      #type-selector label {
        margin-right: 2%;
      }

      #mode-selector label {
        font-family: Roboto;
        font-size: 13px;
        font-weight: 300;
      }

     .direct-container {
        margin-bottom: 0px;
     }
    </style>
@stop

@section('my-events-content')
    <div id="type-selector">
      <input type="radio" name="store" class="store-type" id="restaurant" value="restaurant">
      <label for="restaurant">Restaurant</label>
      <input type="radio" class="store-type" name="store" id="bar" value="bar">
      <label for="bar">Bar</label>
      <input type="radio" name="store" class="store-type" id="atm" value="atm">
      <label for="atm">Atm</label>
      <input type="radio" class="store-type" name="store" id="bank" value="bank">
      <label for="bank">Bank</label>
      <input type="radio" name="store" class="store-type" id="cafe" value="cafe">
      <label for="cafe">Cafe</label>
      <input type="radio" class="store-type" name="store" id="gas_station" value="gas_station">
      <label for="gas_station">Gas_station</label>
      <input type="radio" name="store" class="store-type" id="meal_delivery" value="meal_delivery">
      <label for="meal_delivery">Meal_delivery</label>
      <input type="radio" class="store-type" name="store" id="meal_takeaway" value="meal_takeaway">
      <label for="meal_takeaway">Meal_takeaway</label>
      <input type="radio" class="store-type" name="store" id="liquor_store" value="liquor_store">
      <label for="liquor_store">Liquor_store</label>
    </div>
    <div class="row direct-container">
      <div class="col-md-4">
          <input id="origin-input" class="controls store-direct" type="text"
              placeholder="Enter an origin location" style="color: black;">
      </div>
      <div class="col-md-4">
         <input id="destination-input" class="controls store-direct" type="text"
          placeholder="Enter a destination location" style="color: black;">
      </div>
      <div class="col-md-4">
          <div id="mode-selector" class="controls store-direct">
            <input type="radio" name="type" id="changemode-walking" checked="checked">
            <label for="changemode-walking">Walking</label>

            <input type="radio" name="type" id="changemode-transit">
            <label for="changemode-transit">Transit</label>

            <input type="radio" name="type" id="changemode-driving">
            <label for="changemode-driving">Driving</label>
          </div>
      </div>
    </div>
    <div id="map" style="height: 70%;"></div>
@stop

@section('my-events-scripts')

 <script>
      // This example requires the Places library. Include the libraries=places
      // parameter when you first load the API. For example:
      // <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&libraries=places">
      var map;
      var infowindow;
      var geocoder;
      var lat = '{{ $lat }}';
      var lon = '{{ $lon }}';
      var name = '{{ $name }}';
      var unit_street = '{{ $unit_street }}';
      var city = '{{ $city }}';
      var state = '{{ $state }}';
      var country = '{{ $country }}';
      var address = unit_street + ", " + city + ',' + state + ',' +country;
     
      function initMap() {
        
        lat = parseFloat(lat);
        lon = parseFloat(lon);
        var pyrmont = {lat: lat, lng:  lon};
        map = new google.maps.Map(document.getElementById('map'), {
          mapTypeControl: false,
          center: pyrmont,
          mapTypeId: google.maps.MapTypeId.ROADMAP,
          zoom: 15
        });


        infowindow = new google.maps.InfoWindow();
        var service = new google.maps.places.PlacesService(map);
        var store_type = '{{ $type }}';
        service.nearbySearch({
          location: pyrmont,
          radius: 1500,
          type: [store_type]
        }, callback);

        var center = new google.maps.LatLng(lat, lon);

        var geocoder = new google.maps.Geocoder();
         if (geocoder) {
          geocoder.geocode({
            'address': address
          }, function(results, status) {
            if (status == google.maps.GeocoderStatus.OK) {
              if (status != google.maps.GeocoderStatus.ZERO_RESULTS) {
                map.setCenter(results[0].geometry.location);

                var pinColor = "0000FF";
                var pinImage = new google.maps.MarkerImage("http://chart.apis.google.com/chart?chst=d_map_pin_letter&chld=%E2%80%A2|" + pinColor,
                  new google.maps.Size(51, 64),
                  new google.maps.Point(0,0),
                  new google.maps.Point(20, 34));

                var marker_center = new google.maps.Marker({
                  position: results[0].geometry.location,
                  map: map,
                  title: address,
                  icon: pinImage
                });
               
                
                google.maps.event.addListener(marker_center, 'click', function() {
                      infowindow.setContent('<div><strong>' + name + '</strong><br>' +
                          address + '</div>');
                      infowindow.open(map, this);
                    });


              } else {
                alert("No results found");
              }
            } else {
              alert("Geocode was not successful for the following reason: " + status);
            }
          });
        }

        new AutocompleteDirectionsHandler(map);

      }

       /**
        * @constructor
       */
      function AutocompleteDirectionsHandler(map) {
        this.map = map;
        this.originPlaceId = null;
        this.destinationPlaceId = null;
        this.travelMode = 'WALKING';
        var originInput = document.getElementById('origin-input');
        var destinationInput = document.getElementById('destination-input');
        var modeSelector = document.getElementById('mode-selector');
        this.directionsService = new google.maps.DirectionsService;
        this.directionsDisplay = new google.maps.DirectionsRenderer;
        this.directionsDisplay.setMap(map);

        var originAutocomplete = new google.maps.places.Autocomplete(
            originInput, {placeIdOnly: true});
        var destinationAutocomplete = new google.maps.places.Autocomplete(
            destinationInput, {placeIdOnly: true});

        this.setupClickListener('changemode-walking', 'WALKING');
        this.setupClickListener('changemode-transit', 'TRANSIT');
        this.setupClickListener('changemode-driving', 'DRIVING');

        this.setupPlaceChangedListener(originAutocomplete, 'ORIG');
        this.setupPlaceChangedListener(destinationAutocomplete, 'DEST');

        // this.map.controls[google.maps.ControlPosition.TOP_LEFT].push(originInput);
        // this.map.controls[google.maps.ControlPosition.TOP_LEFT].push(destinationInput);
        // this.map.controls[google.maps.ControlPosition.TOP_LEFT].push(modeSelector);
      }

      // Sets a listener on a radio button to change the filter type on Places
      // Autocomplete.
      AutocompleteDirectionsHandler.prototype.setupClickListener = function(id, mode) {
        var radioButton = document.getElementById(id);
        var me = this;
        radioButton.addEventListener('click', function() {
          me.travelMode = mode;
          me.route();
        });
      };

      AutocompleteDirectionsHandler.prototype.setupPlaceChangedListener = function(autocomplete, mode) {
        var me = this;
        autocomplete.bindTo('bounds', this.map);
        autocomplete.addListener('place_changed', function() {
          var place = autocomplete.getPlace();
          if (!place.place_id) {
            window.alert("Please select an option from the dropdown list.");
            return;
          }
          if (mode === 'ORIG') {
            me.originPlaceId = place.place_id;
          } else {
            me.destinationPlaceId = place.place_id;
          }
          me.route();
        });

      };

      AutocompleteDirectionsHandler.prototype.route = function() {
        if (!this.originPlaceId || !this.destinationPlaceId) {
          return;
        }
        var me = this;

        this.directionsService.route({
          origin: {'placeId': this.originPlaceId},
          destination: {'placeId': this.destinationPlaceId},
          travelMode: this.travelMode
        }, function(response, status) {
          if (status === 'OK') {
            me.directionsDisplay.setDirections(response);
          } else {
            window.alert('Directions request failed due to ' + status);
          }
        });
      };

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



        var service = new google.maps.places.PlacesService(map);
        service.getDetails({
          placeId: place.place_id
        }, function(place, status) {
          if (status === google.maps.places.PlacesServiceStatus.OK) {
            var marker = new google.maps.Marker({
              map: map,
              position: place.geometry.location
            });
            console.log(place.geometry.location);
            google.maps.event.addListener(marker, 'click', function() {
              infowindow.setContent('<div><strong>' + place.name + '</strong><br>' +
                  place.formatted_address + '</div>');
              infowindow.open(map, this);
              var placeFullInfo = place.name + ',' + place.formatted_address;
              $('#destination-input').val = placeFullInfo;
            });
          }
        });
      }

    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBc2Iddfy8NwxvC7sdbdvUa-pfqMnRXIBI&libraries=places&callback=initMap"
        async defer></script>
    <script type="text/javascript">

      $(document).on('click','.store-type', function(e){
        var radioValue = $("input[name='store']:checked").val();
        var id = '{{ $id }}';
        if(radioValue){
          window.location = '/view-map/store/nearby/' + id + '?params=' + radioValue;
        }
      })
      var store_type = '{{ $type }}';
      if (store_type != null) {
          $("#"+store_type).prop('checked', true);
      }
    </script>
   

@stop
