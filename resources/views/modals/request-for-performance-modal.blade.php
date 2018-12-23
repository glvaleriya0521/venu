<?php
	use OurScene\Helpers\DatetimeUtils;
?>

<div id="request-for-performance-modal" class="modal">
	<div class="modal-content">

		<div class="ourscene-modal-title-1">Request for performance</div>

		{!! Form::open(array(
			'id'			=> 'request-for-performance-form',
			'url'			=> action('ServiceController@postRequestForPerformance', array('id' => $event['_id'])),
			'method'		=> 'POST'
		)) !!}

		<div id="error-start-date-more-than-end-date" class="error-field" style="display: none;">
			Start datetime should be earlier than your end datetime.
		</div>
		<div id="error-performance-outside-event" class="error-field" style="display: none;">
			Your performance can be held on the event duration only.
		</div>

		<br/>

		<?php
			$start_date = DatetimeUtils::formatDateFromBackendToFrontEnd(DatetimeUtils::convertMongoUTCDatetimeToMongoClientDatetime($event->start_datetime)->sec);
			$start_time = DatetimeUtils::formatTimeFromBackendToFrontEnd(DatetimeUtils::convertMongoUTCDatetimeToMongoClientDatetime($event->start_datetime)->sec);

			$end_date = DatetimeUtils::formatDateFromBackendToFrontEnd(DatetimeUtils::convertMongoUTCDatetimeToMongoClientDatetime($event->end_datetime)->sec);
			$end_time = DatetimeUtils::formatTimeFromBackendToFrontEnd(DatetimeUtils::convertMongoUTCDatetimeToMongoClientDatetime($event->end_datetime)->sec);
		?>

		<div class="row input-row">
			<div class="input-field col s12 m8 l4">
				<input type="text" name="start_date" id="start_date_request" placeholder=""
					class="date-input"  readonly="readonly"  value="<?= $start_date; ?>" required>
				<label for="start_date_request" class="active time-label"><span class="required-color">*</span> Start date</label>
			</div>
			<div class="input-field col s12 m8 l4">
				<input type="text" class="" name="start_time" id="start_time_request" placeholder="" value="<?= $start_time; ?>" required>
				<label for="start_time_request" class="active"><span class="required-color">*</span> Start time</label>
			</div>
		</div>
		<div class="row input-row">
			<div class="input-field col s12 m8 l4">
				<input type="text" name="end_date" id="end_date_request" placeholder=""
					class="date-input" readonly="readonly" value="<?= $end_date; ?>" required>
				<label for="end_date_request" class="active  time-label"><span class="required-color">*</span> End date</label>
			</div>
			<div class="input-field col s12 m8 l4">
				<input type="text" class="" name="end_time" id="end_time_request" placeholder="" value="<?= $end_time; ?>" required>
				<label for="end-time_request" class="active"><span class="required-color">*</span> End time</label>
			</div>
		</div>

		<!-- Equipments -->

		<div class="section-title">Equipment</div>

		<div id="equipments" class="section">

		<div class="row">
			<div class="col s12 m8 l6">
				<table id="add-equipments-table">
				@foreach($default_equipments as $equipment)
					<tr class="equipment-row">
						<td>
							<b>{{ $equipment->name }}</b>
						@if(count($equipment->inclusion))
							<br/><br/>
							@foreach($equipment->inclusion as $inclusion)
								<p>{{ $inclusion }}</p>
							@endforeach
						@endif
						</td>
						<td class="right-align">
							<a onclick="RFPM_removeHouseEquipment(this)">
								<img class="remove-icon" src="{{ asset('images/icons/delete.svg') }}"/>
							</a>
							<input type="hidden" name="equipments[]" value="{{ $equipment->_id }}">
						</td>
					</tr>
				@endforeach
				</table>
			</div>
		</div>

			<!-- Add equipment -->

		@if(count($all_equipments) > 0)

			<br/><br/>

			<div class="row">
				<div class="col s10 m8 l6">
					<select type="dropdown" id="add-house-equipment-select">
					@foreach($all_equipments as $equipment)
						<option value="{{ $equipment->_id }}">{{$equipment->name}}</option>
					@endforeach
					</select>
				</div>
				<div class="col s2 m4 l6">
					<a onClick="RFPM_addHouseEquipment()"><img src="{{ asset('images/icons/approved.svg') }}" class="add-icon"/></a>
				</div>
			</div>
		@else
			You have no equipment.
		@endif
		</div>
		<script>
		$(document).ready(function() {

			$("#start_time_request").kendoTimePicker({
			    min: new Date(2000, 0, 1, 8, 0, 0) //date part is ignored
			});
			$("#end_time_request").kendoTimePicker({
			    min: new Date(2000, 0, 1, 8, 0, 0) //date part is ignored
			});

			$('#start_date_request').datepicker().on('changeDate', function(ev){
		        $(this).datepicker('hide');
		    });

		    $('#end_date_request').datepicker().on('changeDate', function(ev){
		        $(this).datepicker('hide');
		    });
		});
		</script>
		{!! Form::close() !!}

	</div>

	<div class="modal-footer">
		<a class="modal-action modal-close btn ourscene-btn-plain-1">Cancel</a>
		<a class="modal-action btn ourscene-btn-plain-1" style="margin-right: 10px;" onClick="$('<input type=\'submit\'>').hide().appendTo('#request-for-performance-form').click().remove();">SUBMIT</a>
	</div>

	<!-- Hidden house equipments contents -->

	@foreach($all_equipments as $equipment)
		<div id="house-equipment-info-{{ $equipment->_id }}">
			<b>{{ $equipment->name }}</b>
			@if(count($equipment->inclusion))
				<br/><br/>
				@foreach($equipment->inclusion as $inclusion)
					<p>{{ $inclusion }}</p>
				@endforeach
			@endif
		</div>
	@endforeach

</div>


<script>
	var event_start_date = "{{ $start_date }}";
	var event_start_time = "{{ $start_time }}";
	var event_end_date = "{{ $end_date }}";
	var event_end_time = "{{ $end_time }}";

	var remove_icon_src = "{{ asset('images/icons/delete.svg') }}";
</script>
<script src="{{ asset('js/request-for-performance-modal.js') }}"></script>
