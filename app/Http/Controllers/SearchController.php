<?php namespace OurScene\Http\Controllers;

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

class SearchController extends Controller {

	/*
	|--------------------------------------------------------------------------
	| Search Controller
	|--------------------------------------------------------------------------
	|
	| This controller manages all search queries and results.
	|
	*/

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		$this->middleware('auth.login');
	}

	public function distanceByZipcde($zipcodeFrom, $zipcodeTo) {
		return $zipcodeFrom - $zipcodeTo;
	}
	/* Search */

	public function getSearch(){

		// get Current user info
		$user_id = Session::get('id');
		$user 	 = User::find($user_id);
		$locality = $user->address['city'];
		// $locality = null;
		$zipcode = $user->address['zipcode'];

		// Index view for search
		Input::merge(array_map('trim', Input::all()));
		$input = filter_var_array(Input::all(), FILTER_SANITIZE_STRIPPED);
		$name = null;
		$genre =null;
		$search_results = true;
		$isSingleParam = false;
		$singleParam = null;
		if (isset($input['params'])) {
			$singleParam = $input['params'];
			$name = $singleParam;
			$genre = $singleParam;
			$locality = $singleParam;
			$isSingleParam = true;
			if ($user->user_type == 'artist') {
				$all = User::searchVenues($name, $genre, $locality, $zipcode)->isActive()->paginate(6);
			} else {
				$all = User::searchArtists($name, $genre, $locality)->isActive()->paginate(6);
			}
			$all->setPath(env('PAGINATE_URI') . '/search');
		}else{
			if ($user->user_type == 'artist') {
				$all = User::searchVenues($name, $genre, $locality, $zipcode)->isActive()->paginate(6);
			} else {
				$all = User::searchArtists($name, $genre, $locality)->isActive()->paginate(6);
			}
			$all->setPath(env('PAGINATE_URI') . '/search');
		}

		return View::make('ourscene.search', compact('all','search_results','name','genre','locality','isSingleParam','singleParam'));
	}

	/* Search results */

	public function getSearchResults(Request $request){

		//trim and sanitize all inputs
		Input::merge(array_map('trim', Input::all()));
		$input = filter_var_array(Input::all(), FILTER_SANITIZE_STRIPPED);

		$user_id = Session::get('id');
		$user 	 = User::find($user_id);
		$locality = $user->address['city'];
		// $locality = null;
		$zipcode = $user->address['zipcode'];

		// parameters
		$name = $input['param'];
		$genre = $input['param'];
		// $locality = $input['param'];

		// pagination
		$artists = User::searchArtists($name, $genre, $locality)->isActive()->take(5)->get();
		$venues = User::searchVenues($name, $genre, $locality, $zipcode)->isActive()->take(5)->get();

		$search_results = true;
		return response()->json(compact('name', 'genre', 'locality', 'artists', 'venues', 'search_results'));
	}
}
