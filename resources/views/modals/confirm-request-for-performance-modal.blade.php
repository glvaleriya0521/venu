<div id="confirm-request-for-performance-modal" class="modal confirm-with-link-modal">	
	
	{!! Form::open(array(
		'id'			=> 'confirm-request-for-performance-modal-form',
		'url'			=> '',
		'action'		=> 'POST'
	)) !!}

	<div class="modal-content" style="color: white;">
		Are you sure you want to <span class='bold-weight confirm-color'>accept</span> this request for performance?

		<br/><br/><br/>

		<div class="row input-row">
			<div class="input-field col s12 m8 l4">
				<input type="text" name="start_date" id="start_date_confirm_request" placeholder=""
					class="date-input"  readonly="readonly"  value="" required>
				<label for="start_date_confirm_request" class="active time-label"><span class="required-color">*</span> Start date</label>
			</div>
			<div class="input-field col s12 m8 l4">
				<input type="text" class="" name="start_time" id="start_time_confirm_request" placeholder="" value="" required>
				<label for="start_time_confirm_request" class="active"><span class="required-color">*</span> Start time</label>
			</div>
		</div>
		<div class="row input-row">
			<div class="input-field col s12 m8 l4">
				<input type="text" name="end_date" id="end_date_confirm_request" placeholder=""
					class="date-input" readonly="readonly" value="" required>
				<label for="end_date_confirm_request" class="active  time-label"><span class="required-color">*</span> End date</label>
			</div>
			<div class="input-field col s12 m8 l4">
				<input type="text" class="" name="end_time" id="end_time_confirm_request" placeholder="" value="" required>
				<label for="end-time_confirm_request" class="active"><span class="required-color">*</span> End time</label>
			</div>
		</div>
		
		<div class="input-field col s12 m8 l4" style="display: none;">
			<input type="number" name="price" min="0.00" step="0.01" value="0.00" required></input>
			<label for="" class="active">
				Price
				<font style="color: #f00; font-style: normal; font-size: 13px;">*</font>
			</label>
		</div>

	</div>

	<div class="modal-footer">
		<input type="submit" class="modal-action btn ourscene-btn-plain-1" value="Book">	
		<a class="modal-action modal-close btn ourscene-btn-plain-1">Cancel</a>
	</div>
	<script>
		$(document).ready(function() {

			$("#start_time_confirm_request").kendoTimePicker({
			    min: new Date(2000, 0, 1, 8, 0, 0) //date part is ignored
			});
			$("#end_time_confirm_request").kendoTimePicker({
			    min: new Date(2000, 0, 1, 8, 0, 0) //date part is ignored
			});

			$('#start_date_confirm_request').datepicker().on('changeDate', function(ev){
		        $(this).datepicker('hide');
		    });

		    $('#end_date_confirm_request').datepicker().on('changeDate', function(ev){
		        $(this).datepicker('hide');
		    });
		});
	</script>
	{!! Form::close() !!}

</div>