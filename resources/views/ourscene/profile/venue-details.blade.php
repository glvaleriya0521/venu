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
							@if ($user->serves_alcohol == true)
								<li>Serves Alcohol </li>
							@endif
							@if ($user->serves_food == true)
								<li>Serves Food </li>
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
								<li> {{$venue_types[$type]}} </li>
								@else
								<li> {{$type}}
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
	<div class="col-md-8 m8" style="margin: 0px; padding: 0;">	
		<div class="row" style="width: 100%; margin: 0px; padding: 0;">
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
			</div>
		</div>
	</div>

	<div class="col s4 m4 second-panel" style="margin-top: 20px; margin-left: 3%">	

	</div>
	
</div>

