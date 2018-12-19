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

			<div class="row property-section">
				<div class="label col s12 m12 l12 profile-title">Location</div>
				<p class="col s12 m12 l12 profile-description">{{ $user->address['city'] }}</p>
			</div>
			<div class="row property-section">
				<div class="label col s12 m12 l12 profile-title">Genres</div>
				<div class="col s12 m12 l12 profile-description">
					<ul>
					@foreach ($user->artist_genre as $key => $genre)
						<li> {{$genre}} </li>
					@endforeach
					</ul>
				</div>
			</div>
			<div class="row property-section">
				<div class="label col s12 m12 l12 profile-title">Equipment</div>
				<div class="col s12 m12 l12 profile-description">
					<ul>
					@foreach ($equipments as $equip)
					 	<li> {{$equip->name}} </li>
					@endforeach
					</ul>
				</div>
			</div>
		</div>
	</div>
	
</div>
</br></br>
@if($user->user_type === 'artist')
<!-- Tab for Media (Artist Profile Only) -->
<div id="media" class="col s12 m12 l12 profile-tab" style="margin-left: -0.3%;">
	<div class="row" id="" style="margin-left: 0;">
		<div class="profile-title">Music</div>
		<div class="col s12 m12 l12">
			<div class="row material-upload">
				@for($i=1; $i<=count($songs) ; $i++)
				<div class="col s5 m3 8  song-file-container" id="songs-container">
					<input type="hidden" value="{{$songs[$i-1]->id}}">
					<span class="song-title row"><b class="profile-description">{{$songs[$i-1]->title}}</b></span>
					<audio class="" id="music{{$i}}" controls>	<source src="{{$songs[$i-1]->url}}" type="audio/mp3">	</audio>
				</div>
				@endfor
			</div>
		</div>
		<?php $song_counter = count($songs); ?>
	</div>

	<div class="row">
		<div class="col s12 m12 l12">
			<div id="images-container row">
				<div class="label col s12 m12 l12 profile-title" style="margin-bottom:10px; margin-left: -0.1%;"> Photos </div>
			@if(count($images))
				@foreach ($images as $image)
				<div class="col s6 m2 l2">
			    	<a class="media_images" href="{{$image->url}}" style="width:auto">
			    		<div alt="" style="background-image: url('{{$image->url}}'); background-size:cover; background-position: 50%; width: 100%;height: auto; margin:0 auto; align: baseline; top:0; left:0; border-radius: 20px;"/></div>
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

		<br/><br/>
		<div class="col s12 m12 l12">
			<div id="videos-container row">
				<div class="label col s12 m12 l12" style="margin-bottom:10px;"> Videos </div>
				@if(count($videos))
					@foreach ($videos as $video)
						<div class="col s12 m4 l4">
							<video class="responsive-video" src="{{$video->url}}" controls>
							   <!-- <source src="{{$video->url}}" type="video/mp4"> -->
							</video>
						</div>
					@endforeach
				@else
					<div class="col s6 m2 l2">
					No videos.
					</div>
				@endif
			</div>
		</div>
	</div>
</div>
@endif



