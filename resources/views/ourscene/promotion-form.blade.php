<?php

if($form_action == "add"){
	$form_url = action('PromotionController@postCreatePromotion');
	$submit_btn_label = 'Create';
}
else{
	$form_url = action('PromotionController@postEditPromotion', array('id' => $promotion['_id']));
	$submit_btn_label = 'Update';
}

?>

{!! Form::open(array(
	'id'			=> 'promotion-form',
	'url'			=> $form_url,
	'action'		=> 'POST'
)) !!}

<div id="error-in-promotion-form" class="error-field" style="display: none;">
	Please check and review the form again.
</div>

<div class="section-header">Promotion details</div>

<br/><br/>
Required items are indicated with <span class="required-color">*</span>.
<br/><br/>

<!-- Event details -->

<div id="promotion-details" class="section">

	<input type="hidden" id="venue-id" name="venue_id" value="{{ Session::get('id') }}"/>

	<div class="row">
		<div class="input-field col s12 m8 l4">
			<input type="text" name="title" id="promotion-title" placeholder="" value="{{ isset($promotion) ? $promotion['title'] : '' }}" required/>
			<label for="promotion-title" class="active"><span class="required-color">*</span> Promotion name</label>
		</div>
	</div>

	<div id="error-start-date-more-than-end-date" class="error-field" style="display: none;">
		Start datetime should be earlier than your end datetime.
	</div>

	<div class="row input-row">
		<div class="input-field col s12 m8 l4">
			<input type="text" name="start_date" id="start_date_promotion" placeholder=""
				class="date-input"  readonly="readonly"  value="<?= $start_date; ?>" required>
			<label for="start_date_promotion" class="active time-label"><span class="required-color">*</span> Start date</label>
		</div>
		<div class="input-field col s12 m8 l4">
			<input type="text" class="" name="start_time" id="start_time_invited_promotion" placeholder="" value="<?= $start_time; ?>" required>
			<label for="start_time_invited_promotion" class="active"><span class="required-color">*</span> Start time</label>
		</div>
	</div>
	<div class="row input-row">
		<div class="input-field col s12 m8 l4">
			<input type="text" name="end_date" id="end_date_invited_promotion" placeholder=""
				class="date-input" readonly="readonly" value="<?= $end_date; ?>" required>
			<label for="end_date_invited_promotion" class="active  time-label"><span class="required-color">*</span> End date</label>
		</div>
		<div class="input-field col s12 m8 l4">
			<input type="text" class="" name="end_time" id="end_time_invited_promotion" placeholder="" value="<?= $end_time; ?>" required>
			<label for="end-time_invited" class="active"><span class="required-color">*</span> End time</label>
		</div>
	</div>
	<div class="row">
		<div class="input-field col s12 m8 l4">
			<textarea name="description" id="promotion-description" class="materialize-textarea" placeholder="">{{ isset($promotion) ? $promotion['description'] : '' }}</textarea>
			<label for="promotion-description" class="active">Description</label>
		</div>
	</div>
	<div class="row">
		<div class="col s12 m12 l8">
			<div>
				<label class="ourscene-label-1"><span class="required-color">*</span> Promotion type</label>
			</div>
			<div class="input-field row">
				
				<div class="col s12 m6 l4">
					<input name="type" type="radio" id="promotion-type-drink-special" class="with-gap" value="Drink Special" checked="true" required/>
					<label for="promotion-type-drink-special">Drink Special</label>
				</div>

				<div class="col s12 m6 l4">
					<input name="type" type="radio" id="promotion-type-food-special" class="with-gap" value="Food Special" required/>
					<label for="promotion-type-food-special">Food Special</label>
				</div>

				<div class="col s12 m6 l4">
					<input name="type" type="radio" id="promotion-type-merchandise-special" class="with-gap" value="Merchandise Special" required/>
					<label for="promotion-type-merchandise-special">Merchandise Special</label>
				</div>
				
				<div class="col s12 m6 l4">
					<input name="type" type="radio" id="promotion-type-other" class="with-gap" value="other"/>
					<label for="promotion-type-other">Other</label>
				
					<div>
						<input name="other_type" type="text" id="promotion-other-type" value="" disabled="disabled" required/>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col s12 m12 l8">
			<div>
				<label class="ourscene-label-1"><span class="required-color">*</span> Age requirements</label>
			</div>
			<div class="input-field">
				<p>
					<input name="age_requirements" type="radio" id="promotion-age-req-none" class="with-gap" value="none" checked="checked"/>
					<label for="promotion-age-req-none">None</label>
				</p>
				<p>
					<input name="age_requirements" type="radio" id="promotion-age-req-18-plus" class="with-gap" value="18+"/>
					<label for="promotion-age-req-18-plus">18+</label>
				</p>
				<p>
					<input name="age_requirements" type="radio" id="promotion-age-req-21-plus" class="with-gap" value="21+"/>
					<label for="promotion-age-req-21-plus">21+</label>
				</p>
			</div>
		</div>
	</div>

</div>

<br/><br/>

<input type="submit" id="submit-btn" class="btn btn-large ourscene-btn-1" value="{{ $submit_btn_label }}"/>
<script>
$(document).ready(function() {

	$("#start_time_invited_promotion").kendoTimePicker({
	    min: new Date(2000, 0, 1, 8, 0, 0) //date part is ignored
	});
	$("#end_time_invited_promotion").kendoTimePicker({
	    min: new Date(2000, 0, 1, 8, 0, 0) //date part is ignored
	});

	$('#start_date_promotion').datepicker().on('changeDate', function(ev){
        $(this).datepicker('hide');
    });

    $('#end_date_invited_promotion').datepicker().on('changeDate', function(ev){
        $(this).datepicker('hide');
    });
});
</script>
{!! Form::close() !!}