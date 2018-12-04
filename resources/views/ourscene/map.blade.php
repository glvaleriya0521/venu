<?php
	use OurScene\Models\Event;
?>

@extends('ourscene.layouts.map')

@section('my-events-content')


    <div id="map-canvas"/>
  <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyATt8YZNu3NjbG6dvkfF5M2KN73B9UxS6Q&libraries=places&**callback=initMap**" async defer></script>
@stop

@section('my-events-scripts')

<script>
	/*
 * 5 ways to customize the Google Maps infowindow
 * 2015 - en.marnoto.com
 * http://en.marnoto.com/2014/09/5-formas-de-personalizar-infowindow.html
*/

// map center

// function initMap() {
//   var directionsService = new google.maps.DirectionsService;
//   var directionsDisplay = new google.maps.DirectionsRenderer;
//   var map = new google.maps.Map(document.getElementById('map'), {
//     zoom: 7,
//     center: {lat: 41.85, lng: -87.65}
//   });
//   directionsDisplay.setMap(map);

//     calculateAndDisplayRoute(directionsService, directionsDisplay);
// }

function calculateAndDisplayRoute(origin, destination) {

  var directionsService = new google.maps.DirectionsService;
  var directionsDisplay = new google.maps.DirectionsRenderer;
  directionsDisplay.setMap(map);
  directionsService.route({
    origin: origin,
    destination: destination,
    travelMode: 'DRIVING'
  }, function(response, status) {
    if (status === 'OK') {
      directionsDisplay.setDirections(response);
    } else {
      window.alert('Directions request failed due to ' + status);
    }
  });
}

$(document).on('click', '.map-point1', function(){

	calculateAndDisplayRoute($(this).attr('data-city'), $(this).attr('data-city'));
});

var geocoder; //To use later
var map; //Your map
function codeAddress(factory, origin, id, zipCode, name, description, phone, email, seating_capacity, image, unit_street, city, state) {
    // geocoder.geocode( { 'address': zipCode}, function(results, status) {
      // if (status == google.maps.GeocoderStatus.OK) {
        //Got result, center the map and put it out there
        var marker = new google.maps.Marker({
            map: map,
            // position: results[0].geometry.location,
            position: factory,
            title: name
        });
		  // InfoWindow content
		  var content = '<div id="iw-container">' +
		                    '<div class="iw-title">' + name + '</div>' +
		                    '<div class="iw-content">' +
		                      '<div class="iw-subTitle">History</div>' +
		                      '<img src="http://maps.marnoto.com/en/5wayscustomizeinfowindow/images/vistalegre.jpg" alt=" '+ name + '" height="115" width="83">' +
		                      '<p>' + description + '</p>' +
		                      '<div class="iw-subTitle">Contacts</div>' +
		                      '<p>' + unit_street +', ' + city + ', ' + '<br>' + state + '<br>'+
		                      '<br>Phone. ' + phone + '<br>Seating capacity. ' + seating_capacity + '<br>e-mail: ' + email + '<br>www: www.myvistaalegre.com</p>' + '<br><a href="/profile/'+ id +'">Calendar:</a>' +
		                      '<br><a href="/message/conversation/'+ id +'">Message:</a>' +
		                      '<br><a href="/view-map/directionTo/' + city + '" class="map-point" data-origin="' + origin + '" data-city="' + city + '">Direction to this venue:</a>' +
		                    '</div>' +
		                    '<div class="iw-bottom-gradient"></div>' +
		                  '</div>';

		  // A new Info Window is created and set content
		  var infowindow = new google.maps.InfoWindow({
		    content: content,

		    // Assign a maximum value for the width of the infowindow allows
		    // greater control over the various content elements
		    maxWidth: 350
		  });
		   
		  // This event expects a click on a marker
		  // When this event is fired the Info Window is opened.
		  google.maps.event.addListener(marker, 'click', function() {
		    infowindow.open(map,marker);
		  });

		  google.maps.event.addListener(marker, 'dblclick', function() {
		    window.location.replace("http://184.73.131.149/profile/" + id);
		  });
		  // Event that closes the Info Window with a click on the map
		  google.maps.event.addListener(map, 'click', function() {
		    infowindow.close();
		  });

		  // *
		  // START INFOWINDOW CUSTOMIZE.
		  // The google.maps.event.addListener() event expects
		  // the creation of the infowindow HTML structure 'domready'
		  // and before the opening of the infowindow, defined styles are applied.
		  // *
		  google.maps.event.addListener(infowindow, 'domready', function() {

		    // Reference to the DIV that wraps the bottom of infowindow
		    var iwOuter = $('.gm-style-iw');

		    /* Since this div is in a position prior to .gm-div style-iw.
		     * We use jQuery and create a iwBackground variable,
		     * and took advantage of the existing reference .gm-style-iw for the previous div with .prev().
		    */
		    var iwBackground = iwOuter.prev();

		    // Removes background shadow DIV
		    iwBackground.children(':nth-child(2)').css({'display' : 'none'});

		    // Removes white background DIV
		    iwBackground.children(':nth-child(4)').css({'display' : 'none'});

		    // Moves the infowindow 115px to the right.
		    iwOuter.parent().parent().css({left: '115px'});

		    // Moves the shadow of the arrow 76px to the left margin.
		    iwBackground.children(':nth-child(1)').attr('style', function(i,s){ return s + 'left: 76px !important;'});

		    // Moves the arrow 76px to the left margin.
		    iwBackground.children(':nth-child(3)').attr('style', function(i,s){ return s + 'left: 76px !important;'});

		    // Changes the desired tail shadow color.
		    iwBackground.children(':nth-child(3)').find('div').children().css({'box-shadow': 'rgba(72, 181, 233, 0.6) 0px 1px 6px', 'z-index' : '1'});

		    // Reference to the div that groups the close button elements.
		    var iwCloseBtn = iwOuter.next();

		    // Apply the desired effect to the close button
		    iwCloseBtn.css({opacity: '1', right: '38px', top: '3px', border: '7px solid #48b5e9', 'border-radius': '13px', 'box-shadow': '0 0 5px #3990B9'});

		    // If the content of infowindow not exceed the set maximum height, then the gradient is removed.
		    if($('.iw-content').height() < 140){
		      $('.iw-bottom-gradient').css({display: 'none'});
		    }

		    // The API automatically applies 0.7 opacity to the button after the mouseout event. This function reverses this event to the desired value.
		    iwCloseBtn.mouseout(function(){
		      $(this).css({opacity: '1'});
		    });
		  });

    //   } else {
    //     alert("Geocode was not successful for the following reason: " + status);
    //   }
    // });
}



function initialize() {

	var geocoder = new google.maps.Geocoder();
	var zipCode = '{{ $zipCode }}';
	var direction = '{{ $direction }}';
	var origin = '{{ $locality }}';
	var destination = '{{ $toCity }}';

	geocoder.geocode( { 'address': zipCode}, function(results, status) {
	  if (status == google.maps.GeocoderStatus.OK) {
		  	var position = JSON.stringify(results[0].geometry.location);
		  	var pos = JSON.parse(position);
		  	var center = new google.maps.LatLng(pos['lat'], pos['lng']);
		  	 var mapOptions = {
			    center: center,
			    zoom: 6,
			    mapTypeId: google.maps.MapTypeId.ROADMAP
			  };

			  map = new google.maps.Map(document.getElementById("map-canvas"),mapOptions);
			  var directionsService = new google.maps.DirectionsService;
			  var directionsDisplay = new google.maps.DirectionsRenderer;
			  directionsDisplay.setMap(map);

			  var venues = [];
			  @foreach($all as $venue)
				venues['{{ $venue->_id }}'] = {
					"id" : '{{ $venue->_id }}',
					"name": '{{ $venue->name }}',
					"description": '{{ $venue->description }}',
					"phone": '{{ $venue->phone_number }}',
					"email": '{{ $venue->email }}',
					"seating_capacity": '{{ $venue->seating_capacity }}',
					"image": '{{ $venue->image }}',
					"address": {
						"unit_street": "{{ $venue['address']['unit_street'] }}",
						"city": "{{ $venue['address']['city'] }}",
						"zipcode": "{{ $venue['address']['zipcode'] }}",
						"state": "{{ $venue['address']['state'] }}",
						"country": "{{ $venue['address']['country'] }}",
						"lat": "{{ $venue['address']['lat'] }}",
						"lon": "{{ $venue['address']['lon'] }}",
					}
				}
			 @endforeach

			  for (var i in venues) {
				 var zipcode = venues[i].address.zipcode;
				 var name = venues[i].name;
				 var description = venues[i].description;
				 var phone = venues[i].phone;
				 var email = venues[i].email;
				 var seating_capacity = venues[i].seating_capacity;
				 var image = venues[i].image;
				 var unit_street = venues[i].address.unit_street;
				 var city = venues[i].address.city;
				 var state = venues[i].address.state;
				 var lat = venues[i].address.lat;
				 var lon = venues[i].address.lon;
				 var id = venues[i].id;
				 var factory = new google.maps.LatLng(lat, lon);
				 codeAddress(factory, origin, id, zipcode, name, description, phone, email, seating_capacity, image, unit_street, city, state);
				}

				if (direction == 'true') {
				  	calculateAndDisplayRoute(origin, destination);
				 }
			  } 
	  else {
	    alert("Geocode was not successful for the following reason: " + status);
	  }
	});
		 

 
}
google.maps.event.addDomListener(window, 'load', initialize);
</script>

@stop
