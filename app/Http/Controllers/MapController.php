<?php

namespace OurScene\Http\Controllers;
use Mapper;

use Log;
use Session;
use View;
use Input;
use Redirect;
use App;
use Response;
use MongoDate;
use DB;

use OurScene\Models\User;
use OurScene\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Database\Support\Collection;
use OurScene\Models\Service;

use OurScene\Helpers\PaypalHelper;

use GuzzleHttp\Client;

class MapController extends Controller {	

public function __construct()
	{
		$this->middleware('auth.login');
	}

public function index()
    {

		// get Current user info
		$user_id = Session::get('id');
		$user 	 = User::find($user_id);
		$locality = $user->address['city'];
		// $locality = null;
		$zipCode = $user->address['zipcode'];

		// $all = User::where('user_type', 'venue')->get();
		$all = User::where('user_type', 'venue')->get();

		$direction = "false";
		$toCity = "";

		return View::make('ourscene.map', compact('all','locality','zipCode',  'toCity','direction'));
    }

public function distanceAsMile(
	  $latitudeFrom, $longitudeFrom, $latitudeTo, $longitudeTo, $earthRadius = 3959)
	{
		  // convert from degrees to radians
		  $latFrom = deg2rad($latitudeFrom);
		  $lonFrom = deg2rad($longitudeFrom);
		  $latTo = deg2rad($latitudeTo);
		  $lonTo = deg2rad($longitudeTo);

		  $latDelta = $latTo - $latFrom;
		  $lonDelta = $lonTo - $lonFrom;

		  $angle = 2 * asin(sqrt(pow(sin($latDelta / 2), 2) +
		    cos($latFrom) * cos($latTo) * pow(sin($lonDelta / 2), 2)));
		  return $angle * $earthRadius;
	}

public function others()
    {

		// get Current user info
		$user_id = Session::get('id');
		$user 	 = User::find($user_id);
		$locality = $user->address['city'];
		$zipCode = $user->address['zipcode'];
		$centerLat = $user->latlon['lat'];
		$centerLon = $user->latlon['lng'];

		$current_datetime = new MongoDate();
		$services = Service::where('status', 'confirmed')
			->where('start_datetime', '<', $current_datetime)
			->where('end_datetime', '>', $current_datetime)->get();

		$venue_ids = array();
		foreach ($services as $service) {

			$sender_id = $service['sender_id'];
			$receiver_id = $service['receiver_id'];
			array_push($venue_ids, $sender_id);
			array_push($venue_ids, $receiver_id);
		}

		$venues = User::where('user_type', 'venue')->whereIn('_id', $venue_ids)->get();

		Input::merge(array_map('trim', Input::all()));
		$input = filter_var_array(Input::all(), FILTER_SANITIZE_STRIPPED);

		$distance_filter = null;

		if (isset($input['params'])) {
			$type = $input['type'];
			$params = $input['params'];
			if ($type == "distance") {

					foreach ($venues as $venue) {
						$lat = $venue->latlon['lat'];
						$lon = $venue->latlon['lng'];
						$distance = $this->distanceAsMile((double)$centerLat, (double)$centerLon, (double)$lat, (double)$lon);
						$venue ->distance = $distance;
						$venue->save();
					}
					$venues = User::where('user_type', 'venue')->whereIn('_id', $venue_ids)
						->where('distance', '<', (double)$params)->get();
					$distance_filter = $params;
			}
		}
		
		$all = $venues;

		$direction = "false";
		$toCity = "";
		return View::make('ourscene.current_map', compact('all','locality','zipCode',  'toCity','direction', 'distance_filter'));
    }

public function store($id)
    {

    	// get Current user info
		$user_id = Session::get('id');
		$id = $id;
		$user = User::find($id);
		$latlon = $user->latlon;
		$name = $user->name;
		$unit_street = $user->address['unit_street'];
		$city = $user->address['city'];
		$state = $user->address['state'];
		$country = $user->address['country'];
		$lat = $latlon['lat'];
		$lon = $latlon['lng'];
		$type = "restaurant";
		Input::merge(array_map('trim', Input::all()));
		$input = filter_var_array(Input::all(), FILTER_SANITIZE_STRIPPED);
		if (isset($input['params'])) {
			$type = $input['params'];
		}
		return View::make('ourscene.store-map', compact('lat', 'lon', "type", "id", "name", "unit_street", "city", "state", "country"));
		// return View::make('ourscene.store.store-html');

    }

public function directionTo($city)
    {

		// get Current user info
		$user_id = Session::get('id');
		$user 	 = User::find($user_id);
		$locality = $user->address['city'];
		// $locality = null;
		$zipCode = $user->address['zipcode'];

		// $all = User::where('user_type', 'venue')->get();
		$all = User::where('user_type', 'venue')->get();

		$toCity = $city;
		$direction = "true";
		return View::make('ourscene.map', compact('all','locality','zipCode', 'toCity', 'direction'));
    }

public function generateLatLon()
    {

    	$id = "5803b8e2ee37721638d43956";
		$vanue = User::find($id);
		$address = array(
			'unit_street' 	=> $vanue->address['unit_street'],
			'city' 			=> $vanue->address['city'],
			'zipcode' 		=> $vanue->address['zipcode'],
			'state' 		=> $vanue->address['state'],
			'country' 		=> $vanue->address['country'],
			'lat' 		    => '48.763790',
			'lon' 		    => '18.571920'
		);
		$venue->address = $address;
		dd($venue);
		$venue->save();
		dd($vanue);

		return View::make('ourscene.map', compact('all','locality','zipCode'));
    }
}
