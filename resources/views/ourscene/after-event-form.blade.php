<?php
use OurScene\Models\User;
use OurScene\Helpers\DatetimeUtils;

if($form_action == "add"){
	$form_url = action('EventController@postCreateEvent');
	$submit_btn_label = 'Create';
}
else{
	$form_url = action('EventController@postEditEventAfter', array('id' => $event['_id']));
	$submit_btn_label = 'Update';
}

?>
<style media="screen">
	.dropdown-content.autocomplete{
		width: 94%;
	}
</style>

{!! Form::open(array(
	'id'			=> 'after-event-form',
	'url'			=> $form_url,
	'action'		=> 'POST'
)) !!}

<div id="error-in-regular-event-form" class="error-field" style="display: none;">
	Please check and review the form again.
</div>

<div class="section-header">Event details</div>
<br/><br/>
Required items are indicated with <span class="required-color">*</span>.
<br/><br/>

<!-- Event details -->

<div id="event-details" class="section">
	<div class="row">
		<div class="input-field col s12 m8 l4">
			<input type="text" name="merchandise" id="title" placeholder="Merchandise" value="{{ isset($event) ? $event['merchandise'] : '' }}" required/>
			<label for="title" class="active"><span class="required-color">*</span> Merchandise</label>
		</div>
	</div>

	<div class="row">
		<div class="input-field col s12 m8 l4">
			<input type="text" name="attendance" id="title" placeholder="Attendance" value="{{ isset($event) ? $event['attendance'] : '' }}" required/>
			<label for="title" class="active"><span class="required-color">*</span> Attendance</label>
		</div>
	</div>
	
</div>

<br/><br/>

<input type="submit" id="submit-btn" class="btn btn-large ourscene-btn-1" value="{{ $submit_btn_label }}"/>

{!! Form::close() !!}
