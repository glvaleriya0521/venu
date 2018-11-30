<?php namespace OurScene\Models;

use Session;

use Jenssegers\Mongodb\Model as Eloquent;
use Notification;
use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use GuzzleHttp\Client;

class User extends Eloquent implements AuthenticatableContract, CanResetPasswordContract {

	use Authenticatable, CanResetPassword;

	protected $connection = 'mongodb';

	protected $collection = 'user';

	protected $fillable = ['name', 'email', 'password'];

	public $timestamps = false;

	protected $dates = array('date_updated');


	public function scopeArtists($query){

		return $query->where('user_type', '=', 'artist');

	}

	public function scopeVenues($query){

		return $query->where('user_type', '=', 'venue');

	}

	public function scopeIsActive($query){

		return $query->where('status', '=', 'active');

	}

	public function scopeUserId($query, $id){

		return $query->where('_id', '=', $id);

	}

	public function scopeNotUserId($query, $id){

		return $query->where('_id', '!=', $id);

	}

	public function scopeUsername($query, $username){

		return $query->where('username', '=', $username);

	}

	public function scopeEmail($query, $email){

		return $query->where('email', '=', $email);

	}

	// Get users with paypal account
	// Assumption: User has Paypal account if his Paypal email is provided

	public function scopeUsersWithPaypalAccount($query){

		return $query->where('paypal_info.email', '!=', '');
	}

	// Search artists by name or genre or locality

	public static function searchArtists($name, $genre, $locality){

		$query = User::artists();

		$query->where(function ($query) use ($name, $genre, $locality) {

			if($name)
				$query->orWhere('name', 'LIKE', '%'.$name.'%');

			if($genre)
				$query->orWhereRaw([
					'artist_genre' => array(
						'$elemMatch' => array(
							'$regex' => $genre,
							'$options' => 'i'
						)
					)
				]);

			if($locality)
				$query->orWhere('address.city', 'LIKE', '%'.$locality.'%');
		});

		return $query;
	}

	// // Search venues by name or genre or locality
	// public static function searchVenues($name, $genre, $locality){

	// 	$query = User::venues();

	// 	$query->where(function ($query) use ($name, $genre, $locality) {
	// 		if($name)
	// 			$query->orWhere('name', 'LIKE', '%'.$name.'%');

	// 		if($genre)
	// 			$query->orWhereRaw([
	// 				'venue_type' => array(
	// 					'$elemMatch' => array(
	// 						'$regex' => $genre,
	// 						'$options' => 'i'
	// 					)
	// 				)
	// 			]);

	// 		if($locality){
	// 			$query->orWhere('address.unit', 'LIKE', '%'.$locality.'%');
	// 			$query->orWhere('address.street', 'LIKE', '%'.$locality.'%');
	// 			$query->orWhere('address.city', 'LIKE', '%'.$locality.'%');
	// 			$query->orWhere('address.zipcode', 'LIKE', '%'.$locality.'%');
	// 			$query->orWhere('address.state', 'LIKE', '%'.$locality.'%');
	// 			$query->orWhere('address.country', 'LIKE', '%'.$locality.'%');
	// 		}
	// 	});

	// 	// $query->select('address.city');
	// 	// $query->orderBy('distance', 'desc');
	// 	return $query;
	// }

	public static function distanceByZipcde($zipcodeFrom, $zipcodeTo) {
		$client = new Client();
		$apiKey = "s431dFLAqyr4u93tjRGP58F5JoglJ9dAaWM1FOa255l0Mk3XxnVjxiRWSv1uTCp6";
		// $res = $client->get('http://www.zipcodeapi.com/rest/Po9k2i9YAbWEjU5Kp0ey6J4ImKSKKAnrWVpXhRyPkt0CesMGE2Sw5TfATIwJ5OzF/distance.json/' . $zipcodeFrom .'/' . $zipcodeTo . '/km');
		// 		$res = $client->get('http://www.zipcodeapi.com/rest/s431dFLAqyr4u93tjRGP58F5JoglJ9dAaWM1FOa255l0Mk3XxnVjxiRWSv1uTCp6/distance.json/90277/90278/km');
		// $distance = $res->getBody();
		// return $distance;
		return abs($zipcodeFrom - $zipcodeTo);
	}
		// Search venues by name or genre or locality
	public static function searchVenues($name, $genre, $locality, $zipcode){

		$query = User::venues();

		if($zipcode)
		{
			$venues = $query->get();
			foreach ($venues as $venue)
			{
				 $zipcodeTo = $venue->address['zipcode'];
				 $distance = User::distanceByZipcde($zipcode, $zipcodeTo);
				 $venue->distance = $distance;
			}
		}

		$query->where(function ($query) use ($name, $genre, $locality) {
			if($name)
				$query->orWhere('name', 'LIKE', '%'.$name.'%');

			if($genre)
				$query->orWhereRaw([
					'venue_type' => array(
						'$elemMatch' => array(
							'$regex' => $genre,
							'$options' => 'i'
						)
					)
				]);

			if($locality){
				$query->orWhere('address.unit', 'LIKE', '%'.$locality.'%');
				$query->orWhere('address.street', 'LIKE', '%'.$locality.'%');
				$query->orWhere('address.city', 'LIKE', '%'.$locality.'%');
				$query->orWhere('address.zipcode', 'LIKE', '%'.$locality.'%');
				$query->orWhere('address.state', 'LIKE', '%'.$locality.'%');
				$query->orWhere('address.country', 'LIKE', '%'.$locality.'%');
			}
		});

		// $query->select('address.city');
		$query->orderBy('distance', 'asc');
		return $query;
	}

		// Search all venues 
	public static function searchAllVenues(){

		$query = User::venues();
		// $locality = "Los Angeles";
		// $query->where('address.city', 'LIKE', '%'.$locality.'%');
		return $query;
	}

			// Search all venues 
	public static function searchVenue($id){

		$query = User::venues();
		$query->where('_id', '=', $id);
		// $locality = "Los Angeles";
		// $query->where('address.city', 'LIKE', '%'.$locality.'%');
		return $query;
	}

	// Search all by name or genre or locality

	public static function searchAll($name, $genre, $locality){

		$query = User::where(function ($query) use ($name, $genre, $locality) {

			if($name)
				$query->orWhere('name', 'LIKE', '%'.$name.'%');

			//artist query

			if($genre)
				$query->orWhereRaw([
					'artist_genre' => array(
						'$elemMatch' => array(
							'$regex' => $genre,
							'$options' => 'i'
						)
					)
				]);

			if($locality)
				$query->orWhere('address.city', 'LIKE', '%'.$locality.'%');

			//venue query

			if($genre)
				$query->orWhereRaw([
					'venue_type' => array(
						'$elemMatch' => array(
							'$regex' => $genre,
							'$options' => 'i'
						)
					)
				]);

			if($locality){
				$query->orWhere('address.unit', 'LIKE', '%'.$locality.'%');
				$query->orWhere('address.street', 'LIKE', '%'.$locality.'%');
				$query->orWhere('address.city', 'LIKE', '%'.$locality.'%');
				$query->orWhere('address.zipcode', 'LIKE', '%'.$locality.'%');
				$query->orWhere('address.state', 'LIKE', '%'.$locality.'%');
				$query->orWhere('address.country', 'LIKE', '%'.$locality.'%');
			}
			
		});

		return $query;
	}

	public function uploadProfilePicture($filePath,$file){
		$s3 = \Storage::disk('s3');
		$s3->put($filePath, file_get_contents($file), 'public');
	}

	public function updateProfilePicture($file){
		$extension = $file->getClientOriginalExtension();
		$filename = $this->id.'.'.$extension;
		$filePath = 'profile-pictures/'.$filename;

		$this->uploadProfilePicture($filePath,$file);
		$this->image = getenv('S3_ENDPOINT').$filePath;
	}

	public function getMaterialTitleFor($file){
		$filename = $file->getClientOriginalName();
		$title = clean($filename);
		return $title;
	}

	public function addArtistImage($file){
		$title = $this->getMaterialTitleFor($file);
		$filePath = 'materials/'.$this->id.'/images/'.$title;
		upload_material_toS3($file, $filePath, $title, $this->id,"image");
	}

	public function addArtistSong($file){
		$title = $this->getMaterialTitleFor($file);
		$filePath = 'materials/'.$this->id.'/songs/'.$title;
		upload_material_toS3($file, $filePath, $title, $this->id,"song");
	}

	public function addArtistVideo($file){
		$title = $this->getMaterialTitleFor($file);
		$filePath = 'materials/'.$this->id.'/videos/'.$title;
		upload_material_toS3($file, $filePath, $title, $this->id,"video");
	}

	public function updateSessionWithUserDetails(){
		Session::put('id', $this->id);
		Session::put('user_type', $this->user_type);
		Session::put('status', $this->status);
		Session::put('name', $this->name);
	}

	public function updateArtistGenreWithInput($input){
		$genres  = array();
		$options = json_decode(file_get_contents(base_path()."/resources/assets/genres.json"));

		$i=0;
		if(count($input) > 0){
			foreach ($options as $mainCategory => $sub) {
				if(in_array($i, $input)){
					$genres[$i]= $mainCategory;
				}
				$i++;
				foreach($sub as $genre){
					if(in_array($i, $input)){
						$genres[$i]= $genre;
					}
					$i++;
				}
			}
		}
		$this->artist_genre = $genres;
	}

}
