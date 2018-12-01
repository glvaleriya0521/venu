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

use OurScene\Helpers\PaypalHelper;

use GuzzleHttp\Client;

class MapController extends Controller {

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

public function store()
    {

		return View::make('ourscene.store-map');
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
