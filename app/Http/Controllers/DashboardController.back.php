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
use OurScene\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Database\Support\Collection;
use OurScene\Helpers\DatetimeUtils;

use OurScene\Helpers\PaypalHelper;

use GuzzleHttp\Client;

class DashboardController extends Controller {	

public function __construct()
	{
		$this->middleware('auth.login');
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

public function index()
    {
    		// get Current user info
		$user_id = Session::get('id');
		$user 	 = User::find($user_id);
		$locality = $user->address['city'];
		$genres = $user->artist_genre;
		$user_type = $user->user_type;
		$zipCode = $user->address['zipcode'];
		$centerLat = $user->latlon['lat'];
		$centerLon = $user->latlon['lng'];
		
		// Index view for search
		Input::merge(array_map('trim', Input::all()));
		$input = filter_var_array(Input::all(), FILTER_SANITIZE_STRIPPED);

		$type_filter = null;
		$age_filter = null;
		$distance_filter = null;

		if ($user_type == "artist") {

			$users = User::where('user_type', 'artist')->where('address.city', $locality)->get();
			if (isset($input['params'])) {
				$type = $input['type'];
				$params = $input['params'];
				if ($type == "age") {
					$users = User::where('user_type', 'artist')
						->where('address.city', $locality)
						->where('ages', 'LIKE', '%'.$params.'%')->get();
					$age_filter = $params;
				}
				if ($type == "distance") {

					$users = User::where('user_type', 'artist')->where('address.city', $locality)->get();
					foreach ($users as $user) {
						$lat = $user->latlon['lat'];
						$lon = $user->latlon['lng'];
						$distance = $this->distanceAsMile((double)$centerLat, (double)$centerLon, (double)$lat, (double)$lon);
						$user ->distance = $distance;
						$user->save();
					}
					$users = User::where('user_type', 'artist')->where('address.city', $locality)
						->where('distance', '<', (double)$params)->get();
					$distance_filter = $params;
				}
			}
	    	$books = array(); 
	    	foreach ($users as $user)
	    	{
	    		$user_id = $user->id;
	    		$name = $user->name;
				$artist_id = $user->id;

				$confirmed_events1 = Service::servicesByReceiverId($user_id)->confirmed()->count();

				$pending_events1 = Service::servicesByReceiverId($user_id)->pending()->count();
				$rejected_events1 = Service::servicesByReceiverId($user_id)->rejected()->count();

				$confirmed_events2 = Service::servicesBySenderId($user_id)->confirmed()->count();

				$pending_events2 = Service::servicesBySenderId($user_id)->pending()->count();
				$rejected_events2 = Service::servicesBySenderId($user_id)->rejected()->count();

				$confirmed_events = $confirmed_events1 + $confirmed_events2;
				$pending_events = $pending_events1 + $pending_events2;
				$rejected_events = $rejected_events1 + $rejected_events2;

				$book = array("id" => $user_id, "name" => $name, "confirmed" => $confirmed_events, 
					"pending" => $pending_events, "rejected" => $rejected_events);
				array_push($books, $book);
	    	}
	    	$books = collect($books);
			return View::make('ourscene.art-dashboard', compact('books', 'age_filter', 'distance_filter'));
		}
		else {

			$users = User::where('user_type', 'venue')
				->where('address.city', $locality)->get();
			// $users = User::where('user_type', 'venue')->get();
			if (isset($input['params'])) {
				$type = $input['type'];
				$params = $input['params'];
				if ($type == "type") {
					$users = User::where('user_type', 'venue')
						->where('address.city', $locality)
						->where('venue_type.0', $params)
						->orWhere('venue_type.0', $params)->get();
					$type_filter = $params;
				}
				if ($type == "distance") {

					$users = User::where('user_type', 'venue')->where('address.city', $locality)->get();
					foreach ($users as $user) {
						$lat = $user->latlon['lat'];
						$lon = $user->latlon['lng'];
						$distance = $this->distanceAsMile((double)$centerLat, (double)$centerLon, (double)$lat, (double)$lon);
						$user ->distance = $distance;
						$user->save();
					}
					$users = User::where('user_type', 'venue')->where('address.city', $locality)
						->where('distance', '<', (double)$params)->get();
					$distance_filter = $params;
				}
			}
			$books = array(); 
	    	foreach ($users as $user)
	    	{
	    		$name = $user->name;
	    		$user_id = $user->id;
				$venue_id = $user->id;

				$confirmed_events1 = Service::servicesByReceiverId($user_id)->confirmed()->count();

				$pending_events1 = Service::servicesByReceiverId($user_id)->pending()->count();
				$rejected_events1 = Service::servicesByReceiverId($user_id)->rejected()->count();

				$confirmed_events2 = Service::servicesBySenderId($user_id)->confirmed()->count();

				$pending_events2 = Service::servicesBySenderId($user_id)->pending()->count();
				$rejected_events2 = Service::servicesBySenderId($user_id)->rejected()->count();

				$confirmed_events = $confirmed_events1 + $confirmed_events2;
				$pending_events = $pending_events1 + $pending_events2;
				$rejected_events = $rejected_events1 + $rejected_events2;

				$seating_capacity = $user->seating_capacity;
				$book = array("id" => $user_id, "name" => $name, "confirmed" => $confirmed_events, 
					"pending" => $pending_events, "rejected" => $rejected_events, "seating_capacity" => $seating_capacity);
				array_push($books, $book);
	    	}
	    	$books = collect($books);
			return View::make('ourscene.venue-dashboard', compact('books', 'type_filter', 'distance_filter'));

		}

    	
    }

public function getMyState()
    {
    		// get Current user info
		$user_id = Session::get('id');
		$user 	 = User::find($user_id);
		$locality = $user->address['city'];

		Input::merge(array_map('trim', Input::all()));
		$input = filter_var_array(Input::all(), FILTER_SANITIZE_STRIPPED);

		if (isset($input['params'])) {
			$type = $input['type'];
			$params = $input['params'];
			if ($type == "age") {
				dd($params);
				$users = User::where('user_type', 'artist')
					->where('address.city', $locality)
					->where('ages', 'LIKE', '%'.$params.'%')->get();
				$age_filter = $params;
			}
			if ($type == "distance") {

				$users = User::where('user_type', 'artist')->where('address.city', $locality)->get();
				foreach ($users as $user) {
					$lat = $user->latlon['lat'];
					$lon = $user->latlon['lng'];
					$distance = $this->distanceAsMile((double)$centerLat, (double)$centerLon, (double)$lat, (double)$lon);
					$user ->distance = $distance;
					$user->save();
				}
				$users = User::where('user_type', 'artist')->where('address.city', $locality)
					->where('distance', '<', (double)$params)->get();
				$distance_filter = $params;
			}
		}

		$type_filter = null;
		$age_filter = null;
		$distance_filter = null;

		$books = array();
		$curYear = date('Y'); 
		for ($i = 1; $i < 13; $i++) {

			$start_datetime = $i.'/1/'.$curYear.'00:00';
			$end_datetime = $i.'/31/'.$curYear.'23:59';

			$start_datetime = new MongoDate(strtotime($start_datetime));
			$end_datetime = new MongoDate(strtotime($end_datetime));


			$confirmed_events1 = Service::servicesByReceiverId($user_id)
				->whereBetween('confirmation_date',[$start_datetime, $end_datetime])->confirmed()->count();

			$pending_events1 = Service::servicesByReceiverId($user_id)
				->whereBetween('request_date',[$start_datetime, $end_datetime])->pending()->count();
			$rejected_events1 = Service::servicesByReceiverId($user_id)
				->whereBetween('rejection_date',[$start_datetime, $end_datetime])->rejected()->count();

			$confirmed_events2 = Service::servicesBySenderId($user_id)
				->whereBetween('confirmation_date',[$start_datetime, $end_datetime])->confirmed()->count();

			$pending_events2 = Service::servicesBySenderId($user_id)
				->whereBetween('request_date',[$start_datetime, $end_datetime])->pending()->count();
			$rejected_events2 = Service::servicesBySenderId($user_id)
				->whereBetween('rejection_date',[$start_datetime, $end_datetime])->rejected()->count();

			$confirmed_events = $confirmed_events1 + $confirmed_events2;
			$pending_events = $pending_events1 + $pending_events2;
			$rejected_events = $rejected_events1 + $rejected_events2;
			$month = "";
			switch ($i) {
			    case 1:
			        $month = "January";
			        break;
			    case 2:
			        $month = "February";
			        break;
			    case 3:
			        $month = "March";
			        break;
			    case 4:
			        $month = "April";
			        break;
			    case 5:
			        $month = "May";
			        break;
			    case 6:
			        $month = "June";
			        break;
			    case 7:
			        $month = "July";
			        break;
			    case 8:
			        $month = "August";
			        break;
			    case 9:
			        $month = "September";
			        break;
			    case 10:
			        $month = "October";
			        break;
			    case 11:
			        $month = "November";
			        break;
			    case 12:
			        $month = "December";
			        break;
			}

			$book = array("id" => $user_id, "name" => $month, "confirmed" => $confirmed_events, 
				"pending" => $pending_events, "rejected" => $rejected_events);
			array_push($books, $book);
		}
	
	$books = collect($books);
	return View::make('ourscene.my-dashboard', compact('books', 'curYear', 'age_filter', 'distance_filter'));

    	
    }

public function store()
    {
    	// get Current user info
		$user_id = Session::get('id');
		$user 	 = User::find($user_id);
		$zipCode = $user->address['zipcode'];
		return View::make('ourscene.store-map', compact('zipCode'));
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
