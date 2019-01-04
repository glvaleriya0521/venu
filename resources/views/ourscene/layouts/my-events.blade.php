@extends('ourscene.layouts.main')

@section('head')
	@yield('my-events-head')
@stop

@section('content')

	@include('navs.main-navigation-3',
			['items' => array(
				array('text' => "My Events", 'image' => asset('images/icons/event-500-blue.png'), 'image-active' => asset('images/icons/event-500-white.png'), 'url' => action('EventController@getMyEventsEvents')),
				array('text' => "Calendar", 'image' => asset('images/icons/calendar-500-blue.png'), 'image-active' => asset('images/icons/calendar-500-white.png	'), 'url' => action('EventController@getMyEventsCalendar')),
				array('text' => "Requests", 'image' => asset('images/icons/requestss-500-blue.png'), 'image-active' => asset('images/icons/requests-500-white.png'), 'url' => action('EventController@getRequests')),
				)
			]

		)

	@yield('my-events-content')

@stop

@section('scripts')

	@yield('my-events-scripts')

@stop
