@extends('ourscene.layouts.main')

@section('head')
	@yield('my-events-head')
@stop

@section('content')

	@include('navs.main-navigation-3',
		['items' => array(
			array('text' => "Search", 'image' => asset('images/icons/blue-search-24.png'), 'image-active' => asset('images/icons/white-search-24.png'), 'url' => action('SearchController@getSearch')),
			array('text' => "Map", 'image' => asset('images/icons/blue-map-marker-24.png'), 'image-active' => asset('images/icons/white-map-marker-24.png'), 'url' => action('MapController@index')),
			array('text' => "Other Shows", 'image' => asset('images/icons/blue-map-marker-24.png'), 'image-active' => asset('images/icons/white-map-marker-24.png'), 'url' => action('MapController@others')),
			)
		]
	)
	@yield('my-events-content')

@stop

@section('scripts')

	@yield('my-events-scripts')

@stop
