<div class="row col s12 m12 l12" style="margin-left: 0;">
	<div class="col-md-8 m8 profile-panel">	
		<div id="" class="" >

			<div class="profile-header card-title">
				<div class="info valign-wrapper">
					<div style="display:block; background-image: url('{{getProfilePicture($user->id)}}'); width:90px; height: 90px; background-size: cover; background-position: 50%;" class="circular-img-container valign">

					</div>
					<span class="" style="width: 5%;"></span>
					<span class="valign profile-title">{{ $user->name }}</span>
				</div>
			</div>
			<!-- Tab for profile details -->

			<div id="details" class="">
				<div class="row">
					<p class="col s12 m10 l8 profile-description">{{$user->description}}</p>
				</div>
			</div>

			<div class="container" style="width: 100%; margin-left: -2%;">
			    <div class="row">
			      <div>
			        <ul class="social-network social-circle">
			          <li><a href="#" class="icoRss" title="{{ $user->phone_number }}"><i class="fa fa-phone"></i></a></li>
			          <li><a href="#" class="icoGoogle" title="{{ $user->email }}"><i class="fa fa-envelope-o"></i></a></li>
			          <li><a href="{{ $user->social_media['fb'] }}" class="icoLinkedin" title="{{ $user->social_media['fb'] }}"><i class="fa fa-facebook"></i></a></li>
			          <li><a href="{{ $user->social_media['twitter'] }}" class="icoTwitter" title="{{ $user->social_media['twitter'] }}"><i class="fa fa-twitter"></i></a></li>
			        </ul>
			      </div>
			    </div>
			</div>
		</div>
	</div>

	<div class="col s3 m3 profile-panel" style="margin-top: 20px; margin-left: 3%; width: 30%;">	
	
		<div id="" class="">

			
			<!-- Tab for profile details -->

				<div id="details" class="">
					<div class="row property-section">
						<div class="label col s12 m12 l12 profile-title">Venue Serves</div>
						<div class="col s12 m12 l12 profile-description">
							<ul>
							@if ($user->full_bar == true)
								<li>Full Bar </li>
							@endif
							@if ($user->beer_wine == true)
								<li>Beer Wine </li>
							@endif
							@if ($user->none_alcohol == true)
								<li>None Alcohol </li>
							@endif
							@if ($user->full_menu == true)
								<li>Full Menu </li>
							@endif
							@if ($user->snacks == true)
								<li>Snacks </li>
							@endif
							@if ($user->none_food == true)
								<li>None Food </li>
							@endif
							</ul>
						</div>
					</div>

					<div class="row property-section">
						<div class="label col s12 m12 l12 profile-title">Venue Type</div>
						<div class="col s12 m12 l12 profile-description">
							<ul>
							@foreach ($user->venue_type as $type)
								@if(array_key_exists($type,$venue_types))
								<span>{{$venue_types[$type]}}, </span>
								@else
								<span> {{$type}}, 
								@endif
							@endforeach
							</ul>
						</div>
					</div>

					<div class="row property-section">
						<div class="label col s12 m12 l12 profile-title">Equipment</div>
						<div class="col s12 m12 l12 profile-description">
							<ul>
							@foreach ($equipments as $equip)
							 	<li>{{$equip->name}} </li>
							@endforeach
							</ul>
						</div>
					</div>
				</div>
			</div>
	</div>
	
</div>

<div class="row col s12 m12 l12" style="margin: 0px; padding: 0; margin-left: -1%">
	<div class="col-md-8 m8" style="margin: 0px; padding: 0; margin-left: 1%;">	
		<div class="row" style="width: 99%; margin: 0px; padding: 0;">
			<div id="" class="col-md-6 profile-panel">

				<div class="row">
					<div class="label col s12 m12 l12 profile-title">Location</div>
					<p class="col s12 m12 l12 profile-description">
						{{$user->address['unit_street']}}, {{$user->address['city']}}, {{$user->address['state']}}, {{$user->address['country']}}, {{$user->address['zipcode']}}
					</p>
				</div>
			</div>
			<div id="" class="col-md-5 profile-panel" style="margin-top: 20px; margin-left: 5%; width: 45%">

				<div class="row">
					<div class="label col s12 m12 l12 profile-title" style="text-align: left;">Operating Hours</div>
					<p class="col s12 m12 l12 profile-description"> {{$user->operating_hrs_open}} - {{$user->operating_hrs_close}} </p>
				</div>

				<div class="row">
					<div class="label col s12 m12 l12 profile-title" style="text-align: left;">Capacity</div>
					<p class="col s12 m12 l12 profile-description">{{ $user->seating_capacity }}</p>
				</div>

				<div class="row">
					<!-- <div class="label col s12 m12 l12 profile-title" style="text-align: left;">Capacity</div>
					<p class="col s12 m12 l12 profile-description">{{ $user->seating_capacity }}</p> -->
					<a href= "{{ $nearbyLink }}" class="class="label col s12 m12 l12 profile-title map-point">Nearby store:</a>
				</div>

			</div>
		</div>
	</div>

	<div class="col s4 m4 second-panel" style="margin-top: 20px; margin-left: 3%">	

	</div>
	
</div>

</br></br>
@if($user->user_type === 'venue')
<!-- Tab for Media (Artist Profile Only) -->
<div id="media" class="col s12 m12 l12 profile-tab" style="margin-left: -0.3%;">
	<div class="row">
		<div class="col s12 m12 l12">
			<div id="images-container row">
				<div class="label col s12 m12 l12 profile-title" style="margin-bottom:10px; margin-left: -0.1%;"> Photos </div>
			@if(count($images))
				@foreach ($images as $image)
				<div class="col s6 m2 l2">
			    	<a class="media_images" href="{{$image->url}}" style="">
			    		<div alt="" style="background-image: url('{{$image->url}}'); background-size:cover; background-position: 50%; width: 100%; height: 100%; margin:0 auto; align: baseline; top:0; left:0; border-radius: 20px;"/></div>
					</a>
				</div>
			  	@endforeach
			@else
				<div class="col s6 m2 l2">
					No photos.
				</div>
			@endif
			</div>
		</div>
	</div>
</div>
@endif