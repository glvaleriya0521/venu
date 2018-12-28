<div class="row col s12 m12 l12" style="margin-left: 0;">
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
					'id' => 'save-profile-form'
				)
			)!!}
			<div class="row">
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

				<div class="col s6 m4 l4" style="padding-left: 43%;">
					<input type="submit" class="btn btn-large ourscene-btn-1" value="SAVE" required/>
				</div>
			</div>


			<br/><br/>
			<div class="row" style="width: 100%;">
				<div class="col-md-4">
					<div class="row">
						<div class="col-md-6 input-field">
								{!! Form::label('name', 'Artist name', ["class"=>"required-label"]) !!}
								{!! Form::text('name', null, ['required',"class"=>"required"]) !!}
						</div>
						<div class="col-md-6 input-field">
								{!! Form::label('email', 'Email address', ["class"=>"required-label"]) !!}
								{!! Form::email('email', null, ['required',"class"=>"required", "placeholder"=>"your@email.com"]) !!}
						</div>
					</div>
					<div class="row input-field settings-about" style="margin: auto; margin-left: 0%;">
							{!! Form::label('description', 'About', ["class"=>"required-label"]) !!}
							<textarea name="description" id="description" class="materialize-textarea required" 
							cols="1" rows="30" placeholder="About the artist">{{ isset($user->description) ? $user->description: ''}}</textarea>
					</div>
					</br>
					<div class="row input-field" style="width: 95%; margin: auto; margin-left: 0%;">
							{!! Form::label('phone_number', 'Contact Number') !!}
							{!! Form::text('phone_number', null, ["placeholder"=>"Contact Number", "pattern"=>"[0-9-+\s\(\)]*"]) !!}
					</div>

					<div class="row">
						<div class="col-md-6 input-field">
							{!! Form::label('city', 'City', ["class"=>"required-label"]) !!}
							<input type="text" name="city" value="{{ $user->address['city'] }}" placeholder="" required/>
						</div>
						<div class="col-md-6 input-field">
							<label for="zip-code">Zip Code <font style="color: #f00;">*</font></label>
							<input type="text" name="zipcode" value="{{ $user->address['zipcode'] }}" placeholder="5110309" required/>
						</div>
					</div>
				</div>

				<div class="col-md-4 social-section-profile-setting">
						<div class="input-field">
							<label for="facebook_account">Facebook</label>
							<input type="text" id="facebook_account" name="facebook_account" class="registration-txtbx-1" placeholder="" value="{{ $user->social_media['fb'] }}"/>
						</div>
						<div class="input-field">
							<label for="twitter_account">Twitter</label>
							<input type="text" id="twitter_account" name="twitter_account" class="registration-txtbx-1" placeholder="" value="{!! $user->social_media['twitter'] !!}"/>
						</div>

						<div class="input-field">
							<label for="soundcloud_account">Soundcloud</label>
							<input type="text" id="soundcloud_account" name="soundcloud_account" class="registration-txtbx-1" placeholder="" @if(isset($user->social_media['bandcamp'])) value="{!!$user->social_media['soundcloud']  !!}" @endif/>
						</div>
						<div class="input-field">
							<label for="bandcamp_account">Bandcamp</label>
							<input type="text" id="bandcamp_account" name="bandcamp_account" class="registration-txtbx-1" placeholder="" @if(isset($user->social_media['bandcamp'])) value="{!!$user->social_media['bandcamp']  !!}" @endif/>
						</div>
						<div class="row input-field age-setting-artist-profile">
							<div class="col s12 m0 l0">
								<label for="" class="active required-label">Ages</label>
							</div>
							<div class="col s6 m2 l2">
								<input type="radio" id="age-none" name="ages" class="with-gap" value="none" @if($user->ages == 'none') checked @endif/>
								<label for="age-none">None</label>
							</div>
							<div class="col s6 m2 l2">
								<input type="radio" id="age-18" name="ages" class="with-gap" value="18+" @if($user->ages == '18+') checked @endif/>
								<label for="age-18">18+</label>
							</div>
							<div class="col s6 m2 l2">
								<input type="radio" id="age-21" name="ages" class="with-gap" value="21+" @if($user->ages == '21+') checked @endif/>
								<label for="age-21">21+</label>
							</div>
						</div>
				</div>

				<div class="col-md-4" style="padding-left: 3%; margin-top: -5px;">
					<div style="font-size: 14px; margin-top: 0;">Genres</div>
					@foreach ($user->artist_genre as $key=>$genre)
						<span style="font-size: 13px;">{{ $genre}}, </span>
					@endforeach
					<div class="row input-field">
						<div class=" col s12 m4 l4">
							<a href="#artist-genre-modal" class="btn ourscene-btn-2 modal-trigger">ADD GENRE</a>
						</div>
					</div>
					<div class="row" id="equipment-list">


						<table id="equipment-list-table" class="col s12 m10 l10 eqpmnt-table striped highlight centered">
						    <thead>
						      <tr>
						        <th data-field="name">Name</th>
						        <th data-field="inclusions">Contents</th>
								<th>Option</th>
						      </tr>
						    </thead>
						    <tbody>
								<div class='preloader col s12 m10 l10' style="display:none;">
									<div class="progress">
											<div class="indeterminate"></div>
									</div>
								</div>
								<!-- <tr class=""></tr> -->
								@if(count($equipments) > 0)
									@foreach($equipments as $equipment)
									<tr>
										<td class="hide"><input type="hidden" class="equipment_id" value="{{$equipment['_id']}}"></td>
										<td class="hide"><input type="hidden" class="equipment_type" value="{{$equipment['type']}}"></td>
										<td class="equip_name">{!! $equipment->name !!}</td>
									   	<td>
								      		<ul>
								      		@if(isset($equipment->inclusion))
									      		@foreach($equipment->inclusion as $inclusion)
									      			<li>{!! $inclusion !!}</li>
									      		@endforeach
									      	@endif
								      		</ul>
								      	</td>
										<td>
											<a href="javascript:void(0);" class="btn-flat edit-equipment-trigger"><i class="material-icons">mode_edit</i></href>
											<a href="javascript:void(0);" class="btn-flat delete-equipment-trigger"><i class="material-icons">delete</i></href>
										</td>
									 </tr>
									@endforeach
								@else
									<tr><td colspan="3">No Equipment Yet.<td><tr>
								@endif
							</tbody>
					    </table>
					</div>
					<div class="row">
						<div class=" col s12 m4 l4">
							<button data-target="add-update-equipment-modal" class="btn btn-link add-more-media-btn modal-trigger">+ ADD EQUIPMENT</button>
						</div>
					</div>
				</div>
			</div>


			{!! Form::close() !!}
		</div>

	</div>
</div>
</br></br>
@if($user->user_type === 'artist')

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
	<div class="row" id="register-materials-songs" style="margin-left: 0;">
		<div class="profile-title">Music</div>
		<div class="row" style="position: relative; height: 100px;">
			<div class="col-md-1" style="height: 100%;">
				<a href="javascript:void(0);" id="add-more-songs" class="icoSoundCloud addMeterials" title="Rss" style="position: absolute; top: 50%; left: 50%; transform: translate(-89%, -33%);"><i class="fa fa-plus-circle" ></i></a>
			</div>
			<div class="col-md-11" style="position: relative; height: 100%;">
				<div class="row material-upload" style="height: 100%;">
					@for($i=1; $i<=count($songs) ; $i++)
					<div class="col s5 m3 8  song-file-container" id="songs-container" style="position: relative; height: 100%;">
						<input type="hidden" value="{{$songs[$i-1]->id}}">
						<span class="song-title row"><b class="profile-description">{{$songs[$i-1]->title}}</b></span>
						<audio class="" id="music{{$i}}" controls>	<source src="{{$songs[$i-1]->url}}" type="audio/mp3" 
							style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);">	</audio>
						<a href="#!" class="remove-material-songs" title="Remove" style="text-align: right;"><i class="fa fa-trash" ></i><img src="{{asset('images/icons/media_loader.svg')}}" style="margin-top: 5px; display:none;" alt="" width="13px" /></a>
					</div>
					@endfor
				</div>
			</div>
			<?php $song_counter = count($songs); ?>
		</div>
	</div>

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

		<div class="col s12 m12 l12" style="margin-top: 27px; margin-left: 1%;">
			<div class="row" id="register-materials-videos">
				<div class="label col s12 m12 l12 profile-title" style="margin-bottom:10px;"> Videos </div>
				<?php $video_counter = count($videos); ?>
				<div class="row" style="position: relative; height: 100px; margin-bottom: 138px;">
					<div class="col-md-1" style="height: 100%;">
						<a href="javascript:void(0);" class="icoSoundCloud addMeterials @if($video_counter>=5) disabled @endif" id="add-more-videos" title="Rss" style="position: absolute; top: 50%; left: 50%; transform: translate(-62%, -50%);"><i class="fa fa-video-camera" ></i></a>
					</div>
					<div class="col-md-11" style="position: relative; height: 100%;">
						<div class="row" style="margin-left: -2%;">
							@if(count($videos))
								@for($i=1; $i<=count($videos) ; $i++)
									<div class="" style="display: inline; margin-left: 2%;">
										<input type="hidden" value="{{$videos[$i-1]->id}}">
										<video class="responsive-video" src="{{ $videos[$i-1]->url }}" controls 
											style="max-width: 22%; border-radius: 15px;">
										</video>
										<a href="#!" class="remove-material-videos" id='remove-material-href' title="Remove" style="text-align: right;"><i class="fa fa-trash" style="margin-left: 0;"></i><img src="{{asset('images/icons/media_loader.svg')}}" style="margin-top: 5px; display:none;" alt="" width="13px" /></a>
									</div>
								@endfor
							@else
								<div class="col s6 m2 l2">
								No videos.
								</div>
							@endif
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
{!! Form::close() !!}
@endif
<script>
	var song = <?php echo $song_counter; ?>;
	var image = <?php echo $image_counter; ?>;
	var video = <?php echo $video_counter; ?>;
	var media_uploader = "{{asset('images/icons/media_loader.svg')}}"
	var delete_icon = "{{asset('images/icons/delete.svg')}}"
	var delete_material_action = "{{action('UserController@postAjaxDeleteMaterial')}}"
</script>


