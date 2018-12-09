<?php
	use OurScene\Models\Event;
?>

@extends('ourscene.layouts.store-map')

@section('my-store-head')
@stop

@section('my-events-content')
  <input type="hidden" name="" id="zipcode" value="{{$zipCode}}">
	<div id="panel"></div>
  <div id="map-canvas"></div>
@stop

@section('my-events-scripts')

	<script
	  src="https://maps.googleapis.com/maps/api/js?libraries=places"></script>

	<script src="{{ asset('store/store-locator.min.js') }}"></script>
	<script src="{{ asset('store/places.js') }}"></script>
<!-- 	<script>
      var _gaq = _gaq || [];
      _gaq.push(['_setAccount', 'UA-12846745-20']);
      _gaq.push(['_trackPageview']);

      (function() {
        var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
        ga.src = ('https:' === document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
        var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
      })();
    </script> -->

	 <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBc2Iddfy8NwxvC7sdbdvUa-pfqMnRXIBI&libraries=places&**callback=initMap**" async defer></script>
   

@stop
