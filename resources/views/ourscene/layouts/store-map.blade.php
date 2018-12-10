@extends('ourscene.layouts.store-main')

@section('head')
	@yield('my-store-head')
@stop

@section('content')
	@include('navs.main-navigation-3',
		['items' => array(
			array('text' => "SEARCH", 'image' => asset('images/icons/calendar-events-purple.svg'), 'image-active' => asset('images/icons/calendar-events-white.svg'), 'url' => action('SearchController@getSearch')),
			array('text' => "VIEW ON MAP", 'image' => asset('images/icons/calendar-purple.svg'), 'image-active' => asset('images/icons/calendar-white.svg'), 'url' => action('MapController@index')),
			)
		]
	)
	@yield('my-events-content')

@stop

@section('scripts')
	
	@yield('my-events-scripts')

@stop