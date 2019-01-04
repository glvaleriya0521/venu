<nav id="main-navigation-1">
	<div class="nav-wrapper">

		<a href="{{ action('DashboardController@index') }}" class="brand-logo left">
			<img src="{{ asset('images/icons/Venu.png') }}" class="brand-logo-icon"/>
			<b style="font-size: 8px;margin-left: -15px;">Beta Version</b>
		</a>

		<!-- Top navigation search bar -->
		<a href="#" class="brand-logo center hide-on-med-and-down">
			<!-- Search input -->
			<div class="input-field">
				<input id="main-navigation-search-input" type="search" placeholder="Search for venues or artists...">
				<!-- <label for="search"> <i class="material-icons"> search </i> </label> -->
				<i class="material-icons"> close </i>
			</div>
		</a>
		<!-- Testing one nav bar -->
		<div class="col s12 m12 offset-l4 l4">
			<div class="row hide-on-med-and-down" style="margin-left: 45%;"><!-- New class for one row -->
				<!-- Dashboard nav not needed if home = dashboard
				<div class="col s2 m2 5">
					<a href="{{ action('DashboardController@index') }}" @if(Request::is('dashboard')) class="active" @endif>DASHBOARD</a>
				</div>
				-->
				<div class="col s2 m2 5">
					@if(Session::get('user_type') == 'venue')
						<a href="{{ action('EventController@getMyEventsEvents') }}" @if(Request::is('my-events/*')) class="active" @endif>My Events</a>
					@endif
					@if(Session::get('user_type') == 'artist')
						<a href="{{ action('EventController@getMyEventsEvents') }}" @if(Request::is('my-events/*')) class="active" @endif>Calendar</a>
					@endif

				</div>
				<div class="col s3 m3 7" style="width: 17%">
					@if(Session::get('user_type') == 'venue')
						<a href="{{ action('MapController@index') }}" @if(Request::is('view-map/*')) class="active" @endif>Local Artists</a>
					@endif
					@if(Session::get('user_type') == 'artist')
						<a href="{{ action('MapController@index') }}" @if(Request::is('view-map/*')) class="active" @endif>Members</a>
					@endif
				</div>
				<div class="col s3 m3 7 side-btn-container right-align" style="width: 20%">
					@if(Session::get('user_type') == 'venue')
						<a href="{{ action('EventController@getCreateEvent') }}" class="btn ourscene-btn-2" style="padding-left: .5rem; padding-right: .5rem; text-transform: none; font-size: 13px;">Create Event/Promotion</a>
					@endif
					@if(Session::get('user_type') == 'artist')
						<a href="{{ action('EventController@getCreateEvent') }}" class="btn ourscene-btn-2" style="padding-left: .5rem; padding-right: .5rem; text-transform: none; font-size: 13px;">Book a Show</a>
					@endif
				</div>
				<div class="col s3 m3 7" style="width: 30%">
					<ul style="display:inline">
			        <li style="margin-left: 5%">
			        	<a href="{!! url('/messages') !!}">
			        		<img src="{{asset('images/icons/artists---popup-profile-message-icon@2x.png')}}" class="nav-icon">
			        		<span class="badge red messages-counter-icon" style="display:none"></span>
			        	</a>
			    	</li>
			    	<li style="margin-left: -5%">
			    		<a href="{!! url('/profile') !!}">
				    		@if(getProfilePicture(Session::get('id')) != "")
				    			<img src="{{getProfilePicture(Session::get('id'))}}" class="nav-icon circle"/>
				    		@else
				    			{!! Session::get('name') !!}
				    		@endif
			    		</a>
			    	</li>
					<li style="margin-left: -5%">
						<a class="dropdown-button" href="#!" data-activates="main-navigation-1-dropdown" data-constrainwidth="false" data-beloworigin="true" data-gutter="10">
							<img class="dropdown-icon" src="{{ asset('images/icons/white-expand-arrow-50.png') }}">
						</a>
					</li>
			    </ul>
				</div>
			</div>
		</div>


		<a href="#" data-activates="mobile-demo" class="button-collapse">
			<i class="material-icons hamburger-icon">menu</i>
		</a>

			<ul class="right hide-on-large-only">
		      	<li>
		      		@if(Session::get('user_type') == 'venue')
						<a href="{{ action('EventController@getCreateEvent') }}" class="btn ourscene-btn-2">Create Event</a>
					@endif
					@if(Session::get('user_type') == 'artist')
						<a href="{{ action('EventController@getCreateEvent') }}" class="btn ourscene-btn-2">Book a Show</a>
					@endif
				</li>
			</ul>

		<!--  Topright icons on large screen
	    <ul class="right hide-on-med-and-down">
	        <li>
	        	<a href="{!! url('/messages') !!}">
	        		<img src="{{asset('images/icons/artists---popup-profile-message-icon@2x.png')}}" class="nav-icon">
	        		<span class="badge red messages-counter-icon" style="display:none"></span>
	        	</a>
	    	</li>
	    	<li>
	    		<a href="{!! url('/profile') !!}">
		    		@if(getProfilePicture(Session::get('id')) != "")
		    			<img src="{{getProfilePicture(Session::get('id'))}}" class="nav-icon circle"/>
		    		@else
		    			{!! Session::get('name') !!}
		    		@endif
	    		</a>
	    	</li>
			<li>
				<a class="dropdown-button" href="#!" data-activates="main-navigation-1-dropdown" data-constrainwidth="false" data-beloworigin="true" data-gutter="10">
					<img class="dropdown-icon" src="{{ asset('images/icons/dropdown.svg') }}">
				</a>
			</li>
	    </ul>
-->
	    <!-- Drawer Menu -->
		<ul class="side-nav" id="mobile-demo" style="z-index:9999;">
			<li class="brand-logo left">
					<img src="{{asset('images/icons/Venu.png')}}" class="brand-logo-icon">
					<!--<b>VenU</b>-->
			</li>
			<li>
				<!-- Search input -->
				<div class="input-field">
					<input id="search-sidebar" type="search" placeholder="Search">
					<label for="search" id="search_label"><i class="material-icons valign">search</i></label>
					<i class="material-icons">close</i>

					<!-- Search dropdown -->
					<ul id="search-sidebar-dropdown" class="dropdown-content search-dropdown"></ul>
				</div>
			</li>
			<li class="profile-info">
				<div class="img">
					@if(getProfilePicture(Session::get('id')) != "")
						<img src="{{getProfilePicture(Session::get('id'))}}" class="nav-icon circle"/>
					@else
						{!! Session::get('name') !!}
					@endif
				</div>
				<span>{{Session::get('name')}}</span>
			</li>
			<li class="sidebar-nav"><a href="{{ url('/view-map/search')   }}">	Home 	 	</a></li>
			<li class="sidebar-nav">
				<a href="{{ url('/messages') }}">
					Messages
					<span class="badge red messages-counter-icon"></span>
				</a>
			</li>
			<li class="sidebar-nav"><a href="{{ url('/settings') }}">	Settings 	</a></li>
			<li class="sidebar-nav"><a href="{{ url('/dashboard')  }}">	Dashboard </a></li>
			<li class="sidebar-nav"><a href="{{ url('/about-us') }}">	About 	</a></li>
			<li class="sidebar-nav"><a href="{{ url('/faq') }}">	FAQs 	</a></li>
			<li class="sidebar-nav"><a href="{{ url('/help') }}">	Help 	</a></li>
			<li class="sign-out"><a href="{{ url('/logout') }}">	Sign Out	</a></li>
			<!-- End of drawer menu -->
  		</ul>
	</div>
</nav>


<!-- Search dropdown -->

<ul id="main-navigation-search-dropdown" class="dropdown-content search-dropdown"></ul>

<div>
	<ul id="main-navigation-1-dropdown" class="dropdown-content">
		<li><a href="{!! url('/settings') !!}">Settings</a></li>
		<li class="divider"></li>
		<li><a href="{!! url('/dashboard') !!}">Dashboard</a></li>
		<li class="divider"></li>
		<li><a href="{!! url('/about-us') !!}">About Us</a></li>
		<li class="divider"></li>
		<li><a href="{!! url('/faq') !!}">FAQs</a></li>
		<li class="divider"></li>
		<li><a href="{!! url('/help') !!}">Help</a></li>
		<li class="divider"></li>
		<li><a href="{!! url('/logout') !!}">Sign out</a></li>
	</ul>
</div>
<!-- Testing one nav bar
<div id="main-navigation-2">
	<div class="row">
		<div class="col s12 m12 offset-l4 l4">
			<div class="row">
				<!-- Dashboard nav not needed if home = dashboard
				<div class="col s2 m2 5">
					<a href="{{ action('DashboardController@index') }}" @if(Request::is('dashboard')) class="active" @endif>DASHBOARD</a>
				</div>
				-->
				<!--
				<div class="col s2 m2 5">
					<a href="{{ action('EventController@getMyEventsCalendar') }}" @if(Request::is('my-events/*')) class="active" @endif>MY EVENTS</a>
				</div>
				<div class="col s2 m2 5">
					<a href="{{ action('EventController@getRequests') }}"
					 @if(Request::is('requests') || Request::is('requests/*')) class="active" @endif>
					 	REQUESTS
					 	<?php
					 		$pending_requests = OurScene\Models\Service::servicesByReceiverId(Session::get('id'))->pending()->get();
                        	$pending_requests_counter = count($pending_requests);
					 	?>
					 	@if($pending_requests_counter > 0)
					 		<span class="badge red"> {{$pending_requests_counter}}</span>
					 	@endif
					 </a>
				</div>
				<div class="col s3 m3 7">
					<a href="{{ action('MapController@index') }}" @if(Request::is('view-map/*')) class="active" @endif>LOCAL VENUES</a>
				</div>
			</div>
		</div>

		<div class="col m12 l4 side-btn-container right-align">
			@if(Session::get('user_type') == 'venue')
				<a href="{{ action('EventController@getCreateEvent') }}" class="btn ourscene-btn-2">CREATE EVENT/PROMOTION</a>
			@endif
			@if(Session::get('user_type') == 'artist')
				<a href="{{ action('EventController@getCreateEvent') }}" class="btn ourscene-btn-2">REQUEST A SHOW</a>
			@endif
		</div>
	</div>
</div>
		-->
<div>
	<ul id="search-sidebar-dropdown" class="dropdown-content">
		<span class="search-divider">Artist</span>
		<li class="divider"></li>
		<li>
			<a href="{!! url('/profile') !!}">My Profile</a>
			<div class="">
				<span>Venue</span><i>•</i><!-- <span>New York City</span> -->
			</div>
		</li>
		<li class="divider"></li>
		<li>Settings</a></li>
		<li class="divider"></li>
		<li>
			<a href="{!! url('/logout') !!}">Sign out</a>
		</li>
	</ul>
</div>
