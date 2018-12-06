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

use OurScene\Helpers\PaypalHelper;

use GuzzleHttp\Client;

class DashboardController extends Controller {	

public function __construct()
	{
		$this->middleware('auth.login');
	}

public function zipcodeByRadius($center_zipcode) {
	$client = new Client();
	$apiKey = "s431dFLAqyr4u93tjRGP58F5JoglJ9dAaWM1FOa255l0Mk3XxnVjxiRWSv1uTCp6";

	$res = $client->get('http://api.zip-codes.com/ZipCodesAPI.svc/1.0/FindZipCodesInRadius?zipcode=90210&minimumradius=0&maximumradius=10&key=DEMOAPIKEY')->json();
	dd($res);
	dd(json_encode($zip_array));
	return $zip_array['Code'];
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
		// $zipcodeByRadius = $this->zipcodeByRadius($zipCode);
		// dd($zipcodeByRadius);

		// Index view for search
		Input::merge(array_map('trim', Input::all()));
		$input = filter_var_array(Input::all(), FILTER_SANITIZE_STRIPPED);

		if ($user_type == "artist") {

			$users = User::where('user_type', 'artist')->where('address.city', $locality)->get();
			if (isset($input['params'])) {
				$type = $input['type'];
				$params = $input['params'];
				if ($type == "age") {
					$users = User::where('user_type', 'artist')
						->where('address.city', $locality)
						->where('ages', 'LIKE', '%'.$params.'%')->get();
				}
			}
	    	$books = array(); 
	    	foreach ($users as $user)
	    	{
	    		$user_id = $user->id;
	    		$name = $user->name;
				$artist_id = $user->id;

				$confirmed_events = Service::confirmed()
					->where(function ($query) use ($user_id, $artist_id){
		                $query->servicesBySenderId($user_id)
		                	->orWhere(function ($query) use ($artist_id){
		                		$query->servicesByArtistId($artist_id);
		                	});
		            })
					->count();

				$pending_events = Service::servicesBySenderId($user_id)->pending()->count();
				$rejected_events = Service::servicesBySenderId($user_id)->rejected()->count();
				$book = array("id" => $user_id, "name" => $name, "confirmed" => $confirmed_events, 
					"pending" => $pending_events, "rejected" => $rejected_events);
				array_push($books, $book);
	    	}
	    	$books = collect($books);
			return View::make('ourscene.art-dashboard', compact('books'));
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
				}
			}
			$books = array(); 
	    	foreach ($users as $user)
	    	{
	    		$name = $user->name;
	    		$user_id = $user->id;
				$venue_id = $user->id;

				$confirmed_events = Service::servicesByReceiverId($user_id)
					->confirmed()
					->count();

				$pending_events = Service::servicesByReceiverId($user_id)->pending()->count();
				$rejected_events = Service::servicesByReceiverId($user_id)->rejected()->count();
				$seating_capacity = $user->seating_capacity;
				$book = array("id" => $user_id, "name" => $name, "confirmed" => $confirmed_events, 
					"pending" => $pending_events, "rejected" => $rejected_events, "seating_capacity" => $seating_capacity);
				array_push($books, $book);
	    	}
	    	$books = collect($books);
			return View::make('ourscene.venue-dashboard', compact('books'));

		}

    	
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
