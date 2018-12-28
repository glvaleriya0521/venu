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
			           <li><a href="{{ $user->social_media['bandcamp'] }}" class="icoLinkedin" title="{{ $user->social_media['bandcamp'] }}"><i class="fa fa-book"></i></a></li>
			          <li><a href="{{ $user->social_media['soundcloud'] }}" class="icoFacebook" title="{{ $user->social_media['soundcloud'] }}"><i class="fa fa-soundcloud"></i></a></li>
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

			<div class="row property-section">
				<div class="label col s12 m12 l12 profile-title">Location</div>
				<p class="col s12 m12 l12 profile-description">{{ $user->address['city'] }}</p>
			</div>
			<div class="row property-section">
				<div class="label col s12 m12 l12 profile-title">Genres</div>
				<div class="col s12 m12 l12 profile-description">
					@foreach ($user->artist_genre as $key => $genre)
						<span>{{$genre}}, </span>
					@endforeach
				</div>
			</div>
			<div class="row property-section">
				<div class="label col s12 m12 l12 profile-title">Equipment</div>
				<div class="col s12 m12 l12 profile-description">
					@foreach ($equipments as $equip)
					 	<span> {{$equip->name}}, </span>
					@endforeach
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

		<div class="col s12 m12 l12" style="margin-top: 27px;">
			<div id="videos-container row">
				<div class="label col s12 m12 l12 profile-title" style="margin-bottom:10px;"> Videos </div>
				@if(count($videos))
					@foreach ($videos as $video)
						<div class="col s2 m2 l4">
							<video class="responsive-video" src="{{$video->url}}" controls style="max-width: 69%; border-radius: 20px;">
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



