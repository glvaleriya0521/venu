<?php
use OurScene\Models\User;
?>
<div class="row col s12 m12 l12" id="venu-profile-setting-panel" style="margin-left: 0;">
	<div class="col-md-12 m12 profile-panel">	
		<div class="settings-tab-container" id="" style="width: 100%;">
			<!-- <div class="row" id="venue-profile"> -->
			<!-- Start of Form -->
			{!! Form::model(
				$user,
				array(
					'url'		=> action('UserController@postUpdateProfile'),
					'method'	=> 'POST',
					'files'		=> 'true',
				)
			)!!}

			<div class="row profile-picture">
				<div class="col s6 m6 14 input-field">
					<!-- <div id="profile-picture-preview" style="background-color:#333;"></div> -->
					<div id="profile-picture-preview" style="float:left;display:block; background-image: url('{{getProfilePicture($user->id)}}'); width:120px; height: 120px; background-size: cover; background-position: 50%;" class="profile-picture-preview circle"></div>
					<!-- <img id="profile-picture-preview" class="profile-picture-preview circle" src="{!! url($user->image) !!}" onerror="makeDefaultProfilePic(this)" style="float:left;" alt="{!! $user->image !!}" /> -->
					<div class="file-field input-field" style="display:inline-block;margin-top:4.1em;margin-left:.6em;">
				    <div class="btn ourscene-btn-1">
				      <span>Change</span>
				      <input id="input-profile-picture" type="file"  class="form-control" name="input-profile-picture" onchange="loadProfilePicture(event)"/>
				    </div>
				    <div class="file-path-wrapper">
				      <input style="display:none;" class="file-path validate" type="text">
				    </div>
				  </div>
				</div>

			</div>


			<br/><br/>
			<div class="row" style="width: 100%;">
				<div class="col-md-4">
					<div class="input-field">
							{!! Form::label('name', 'Venue Name', ["class"=>"required-label"]) !!}
							{!! Form::text('name', null, ['required',"class"=>"required"]) !!}
					</div>
					<div class="input-field">
							{!! Form::label('email', 'Email address', ["class"=>"required-label"]) !!}
							{!! Form::email('email', null, ['required',"class"=>"required", "placeholder"=>"your@email.com"]) !!}
					</div>
					<div class="input-field settings-about-venue" style="width: 90%; margin: auto; margin-left: 0%;">
							{!! Form::label('description', 'About', ["class"=>"required-label"]) !!}
							<textarea name="description" id="description" class="materialize-textarea required" 
							cols="1" rows="30" placeholder="About the venue">{{ isset($user->description) ? $user->description: ''}}</textarea>
					</div>
					<div class="input-field">
							{!! Form::label('phone_number', 'Contact Number', ["class"=>"required-label"]) !!}
							{!! Form::text('phone_number', null, array('required', "class"=>"required", "placeholder"=>"Phone number","pattern"=>"[0-9-+\s\(\)]*")) !!}
					</div>
					<div class="input-field">
						<label for="seating_capacity">Seating Capacity <font style="color: #f00;">*</font></label>
						<input type="number" name="seating_capacity" min="1" step="1" value="{{ $user->seating_capacity }}" />
					</div>
				</div>

				<div class="col-md-4">
					<div class="input-field">
						<label for="unit_street">Street <font style="color: #f00;">*</font></label>
						<input type="text" name="unit_street" @if(isset($user["address"]["unit_street"])) value="{{ $user["address"]["unit_street"] }}" @else value="{!! old('unit_street') !!}" @endif required/>
					</div>
					<div class="input-field">
						<label for="zip-code">Zip Code <font style="color: #f00;">*</font></label>
						<input type="text" name="zipcode" @if(isset($user["address"]["zipcode"])) value="{{ $user["address"]["zipcode"] }}" @else value="{!! old('zipcode') !!}" @endif required/>
					</div>
					<div class="input-field">
						{!! Form::label('city', 'City', ["class"=>"required-label"]) !!}
						<input type="text" name="city" @if(isset($user["address"]["city"])) value="{{ $user["address"]["city"] }}" @else value="{!! old('city') !!}" @endif required/>
					</div>
					<div class="input-field">
						<label for="state">State/Province <font style="color: #f00;">*</font></label>
						<input type="text" name="state" @if(isset($user["address"]["state"])) value="{{ $user["address"]["state"] }}" @else  value="{!! old('state') !!}" @endif required/>
					</div>

					<div class="input-field">
						<label for="country">Country <font style="color: #f00;">*</font></label>
						<input type="text" name="country" @if(isset($user["address"]["country"])) value="{{ $user["address"]["country"] }}" @else  value="{!! old('country') !!}" @endif required/>
					</div>
					<div class="input-field">
						<label for="operating_hrs_open" style="top:-1.8rem">Open </label>
						<input type="text" class="" name="operating_hrs_open" id="operating_hrs_open" placeholder="" required value="{{$user['operating_hrs_open']}}">
					</div>
					</br>
					<div class="input-field">
						<label for="operating_hrs_close" style="top:-1.8rem">Close </label>
						<input type="text" class="" name="operating_hrs_close" id="operating_hrs_close" placeholder="" required value="{{$user['operating_hrs_close']}}">
					</div>

				</div>

				<div class="col-md-4">
					<div class="input-field">
						<label for="facebook_account">Facebook</label>
						<input type="text" id="facebook_account" name="facebook_account" class="registration-txtbx-1" placeholder="" value="{{ $user->social_media['fb'] }}"/>
					</div>
					<div class="input-field">
						<label for="twitter_account">Twitter</label>
						<input type="text" id="twitter_account" name="twitter_account" class="registration-txtbx-1" placeholder="" value="{!! $user->social_media['twitter'] !!}"/>
					</div>
					</br>
					<div class="input-field">
						<div class="input-field">
							<label for="" class="active">Venue Type</label>
						</div>
						@foreach($venue_types as $key => $value)
							<div class="col s6 m4 l4">
								 <input type="checkbox" id="{!! $key !!}" name="{!! $key !!}" class="filled-in" @if(User::where('_id',Session::get('id'))->first()['venue_type'] && in_array($key, User::where('_id',Session::get('id'))->first()['venue_type'])) checked/ @endif>
								 <label for="{!! $key !!}">{!!$value!!}</label>			
							</div>
						@endforeach

						<?php
							//get other venue type
							//assumption: other venue type is the last value in the user venue type array
							$other_venue_type = "";

							$user_venue_type = User::where('_id', Session::get('id'))->first()['venue_type'];

							if($user_venue_type && count($user_venue_type)){
								
								$last_type = end($user_venue_type);
								if(!in_array($last_type, array_keys($venue_types)))
									$other_venue_type = $last_type;
							}

						?>
						</br></br></br>
						<div class="input-field">
							<div for="" class="active">Other</div>
							<input type="text" class="registration-txtbx-1 col s4 m4 l4" name="other_venue_type" placeholder="Venue type" value="{{ $other_venue_type }}"/>
						</div>
					</div>
					</br></br></br>
					<div class="input-field">
						<label for="" class="active">Venue Serves</label>
					</div>
					<div class="input-field" style="margin-top: 7%;">
						<div class="col-md-6">
				          <div class="input-field col s12 m8 l4">
				            <input type="radio" class="serve-alcohol" name="serve_alcohol" id="full_bar" value="full_bar"/>
				            <label for="full_bar" class="active">FullBar</label>
				          </div>
				          <div class="input-field col s12 m8 l4">
				            <input type="radio" class="serve-alcohol" name="serve_alcohol" id="beer_wine" value="beer_wine"/>
				            <label for="beer_wine" class="active">Beer_Wine</label>
				          </div>
				          <div class="input-field col s12 m8 l4">
				            <input type="radio" class="serve-alcohol" name="serve_alcohol" id="none_alcohol" value="none_alcohol"/>
				            <label for="none_alcohol" class="active">None</label>
				          </div>
				      	</div>
				      	<div class="col-md-6">
				          <div class="input-field col s12 m8 l4">
				            <input type="radio" name="serve_food" class="serve_food" id="full_menu" value="full_menu"/>
				            <label for="full_menu" class="active">FullFood</label>
				          </div>
				          <div class="input-field col s12 m8 l4">
				            <input type="radio" name="serve_food" class="serve_food" id="snacks" value="snacks"/>
				            <label for="snacks" class="active">Snacks</label>
				          </div>
				          <div class="input-field col s12 m8 l4">
				            <input type="radio" name="serve_food" class="serve_food" id="none_food" value="none_food"/>
				            <label for="none_food" class="active">NoneFood</label>
				          </div>
				        </div>
					</div>
					<div class="col s6 m4 l4" style="padding-left: 68%; padding-top: 12px;">
						<input type="submit" class="btn btn-large ourscene-btn-1" value="SAVE" required/>
					</div>
				</div>
			</div>


			{!! Form::close() !!}
		</div>

	</div>
</div>
@if($user->user_type === 'venue')

{!! Form::open(array(
		'url'		=> action('UserController@updateArtistMaterials'),
		'method'	=> 'POST',
		'files'		=> 'true',
		'id' => 'update-media-form'
	)) !!}
<!-- Tab for Media (Artist Profile Only) -->
<div class="row">
	<button type="submit" id="media-update-form-submit-btn" class="col s3 m2 l2 btn ourscene-btn-1" style="margin-left: 83%;" required/><i class="fa fa-upload" ></i></button>
</div>
<div id="media" class="col s12 m12 l12 profile-tab" style="margin-left: -0.3%;">
	<div class="row">
		<div class="col s12 m12 l12">
			<div class="row" id="register-materials-images">
				<div class="label col s12 m12 l12 profile-title" style="margin-bottom:10px; margin-left: 14px;"> Photos </div>

				<div class="row" style="position: relative; height: 155px;">
					<?php $image_counter = count($images); ?>
					<div class="col-md-1" style="height: 100%;">
						<a href="javascript:void(0);" id="add-more-images" class="icoSoundCloud addMeterials  @if($image_counter>=5) disabled @endif" title="Rss" style="position: absolute; top: 50%; left: 50%; transform: translate(-39%, -50%);"><i class="fa fa-camera" ></i></a>
					</div>
					<div class="col-md-11" id="material-images-list" style="position: relative; height: 100%;">
						@if(count($images))
							@for($i=1; $i<=count($images) ; $i++)
							<div class="col s6 m2 l2" style="position: relative; height: 100%;">
								<input type="hidden" value="{{$images[$i-1]->id}}">
						    	<a class="media_images" href="{{$images[$i-1]->url}}" style="">
						    		<div alt="" style="background-image: url('{{$images[$i-1]->url}}'); background-size:cover; background-position: 50%; width: 100%; height: 100%; margin:0 auto; align: baseline; border-radius: 20px;
						    			position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);"/></div>
								</a>
								<a href="#!" class="remove-material-images" id='remove-material-href' title="Remove" style="text-align: right;"><i class="fa fa-trash" ></i><img src="{{asset('images/icons/media_loader.svg')}}" style="margin-top: 5px; display:none;" alt="" width="13px" /></a>
							</div>
						  	@endfor
						@else
							<div class="col s6 m2 l2">
								No photos.
							</div>
						@endif
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
{!! Form::close() !!}
@endif
<script>
	var image = <?php echo $image_counter; ?>;
	var media_uploader = "{{asset('images/icons/media_loader.svg')}}"
	var delete_icon = "{{asset('images/icons/delete.svg')}}"
	var delete_material_action = "{{action('UserController@postAjaxDeleteMaterial')}}"
</script>
<script>
$(document).ready(function() {
	var timezone_offset = new Date().getTimezoneOffset();
	$("#timezone_offset").val(timezone_offset);

	$("#operating_hrs_open").kendoTimePicker({
	    min: new Date(2000, 0, 1, 8, 0, 0) //date part is ignored
	});
	$("#operating_hrs_close").kendoTimePicker({
	    min: new Date(2000, 0, 1, 8, 0, 0) //date part is ignored
	});

	var full_bar = '{{ $user->full_bar }}';
	var beer_wine = '{{ $user->beer_wine }}';
	var none_alcohol = '{{ $user->none_alcohol }}';
	var full_menu = '{{ $user->full_menu }}';
	var snacks = '{{ $user->snacks }}';
	var none_food = '{{ $user->none_food }}';

	if (full_bar == true) {
	    $("#full_bar").prop('checked', true);
	}
	if (beer_wine == true) {
	    $("#beer_wine").prop('checked', true);
	}
	if (none_alcohol == true) {
	    $("#none_alcohol").prop('checked', true);
	}
	if (full_menu == true) {
	    $("#full_menu").prop('checked', true);
	}
	if (snacks == true) {
	    $("#snacks").prop('checked', true);
	}
	if (none_food == true) {
	    $("#none_food").prop('checked', true);
	}
	
});
</script>
