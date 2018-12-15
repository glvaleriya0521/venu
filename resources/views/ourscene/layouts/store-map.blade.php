@extends('ourscene.layouts.store-main')

@section('head')
	@yield('my-store-head')
@stop

@section('content')
	@include('navs.main-navigation-3',
		['items' => array(
			array('text' => "SEARCH", 'image' => asset('images/icons/blue-search-24.png'), 'image-active' => asset('images/icons/white-search-24.png'), 'url' => action('SearchController@getSearch')),
			array('text' => "VIEW ON MAP", 'image' => asset('images/icons/blue-map-marker-24.png'), 'image-active' => asset('images/icons/white-map-marker-24.png'), 'url' => action('MapController@index')),
			array('text' => "OTHER SHOWS", 'image' => asset('images/icons/blue-map-marker-24.png'), 'image-active' => asset('images/icons/white-map-marker-24.png'), 'url' => action('MapController@others')),
			)
		]
	)
	@yield('my-events-content')

@stop

@section('scripts')

	@yield('my-events-scripts')

@stop
