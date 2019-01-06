@extends('ourscene/layouts.main')

@section('head')

<!-- Autocomplete -->
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">

@endsection

@section('content')
{!! Form::open(array(
	'id'			=> 'help-form',
	'url'			=> action('UserController@postEmail'),
	'action'		=> 'POST'
)) !!}
</br></br>
<div id="help-form">

		<div id="help-title">Need Help?</div>
		<div id="help-subtitle">If you'd like to send us an email, please use this message box and we'll get back to you shortly. Thanks!</div>
		<div class="row input-field settings-about" style="margin: auto; margin-left: 0%; margin-top: 24px;">
				<div class="col-md-1"></div>
				<textarea name="description" id="description" class="materialize-textarea col-md-10 required"
				cols="1" rows="30" placeholder="Please write here..." style="min-height: 292px; font-size: 15px;"></textarea>
				<button type="submit" class="btn btn-large col-md-1" style="float: right;"><i class="fa fa-paper-plane"></i></button>
		</div>
	    </br></br>
</div>
{!! Form::close() !!}
@endsection

@section('scripts')

<!-- Event form JS -->

<script>
	var AJAX_AUTOCOMPLETE_ARTISTS = "{{ action('UserController@getAutocompleteArtists') }}";
	var AJAX_AUTOCOMPLETE_VENUES = "{{ action('UserController@getAutocompleteVenues') }}";
	var USER_TYPE = "{{ Session::get('user_type') }}";
</script>
<script src="{{ asset('js/event-form.js') }}"></script>

@endsection
