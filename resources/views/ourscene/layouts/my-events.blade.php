@extends('ourscene.layouts.main')

@section('head')
	@yield('my-events-head')
@stop

@section('content')

	@if(Session::get('user_type') == 'venue')

		@include('navs.main-navigation-3',
			['items' => array(
				array('text' => "MY EVENTS", 'image' => asset('images/icons/calendar-events-purple.svg'), 'image-active' => asset('images/icons/calendar-events-white.svg'), 'url' => action('EventController@getMyEventsEvents')),
				array('text' => "CALENDAR", 'image' => asset('images/icons/calendar-purple.svg'), 'image-active' => asset('images/icons/calendar-white.svg'), 'url' => action('EventController@getMyEventsCalendar')),
				array('text' => "REQUESTS", 'image' => asset('images/icons/calendar-purple.svg'), 'image-active' => asset('images/icons/calendar-white.svg'), 'url' => action('EventController@getRequests')),
				)
			]

		)

	@elseif(Session::get('user_type') == 'artist')

		@include('navs.main-navigation-3',
			['items' => array(
				array('text' => "MY EVENTS", 'image' => asset('images/icons/calendar-events-purple.svg'), 'image-active' => asset('images/icons/calendar-events-white.svg'), 'url' => action('EventController@getMyEventsEvents')),
				array('text' => "CALENDAR", 'image' => asset('images/icons/calendar-purple.svg'), 'image-active' => asset('images/icons/calendar-white.svg'), 'url' => action('EventController@getMyEventsCalendar')),
				array('text' => "REQUESTS", 'image' => asset('images/icons/calendar-purple.svg'), 'image-active' => asset('images/icons/calendar-white.svg'), 'url' => action('EventController@getRequests')),
				)
			]
		)

	@endif

	@yield('my-events-content')

@stop

@section('scripts')
	
	@yield('my-events-scripts')

@stop