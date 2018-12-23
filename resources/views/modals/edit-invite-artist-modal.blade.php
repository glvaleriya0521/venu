<div id="edit-invite-artist-modal" class="modal">
	<div class="modal-content">

		<div class="ourscene-modal-title-1">Edit Invite artist</div>
		
		<div id="error-no-selected-invited-artist" class="error-field" style="display: none;">
			There is no selected artist.
		</div>
		<br/>

		{!! Form::open(array(
			'id'			=> 'edit-invite-artist-form',
		)) !!}

		<input type="hidden" name="edit_id"/>
		
		<div class="input-field col s12 m8 l4">
			<input type="text" id="edit-artist-name-autocomplete" name="artist_name" placeholder="" required>
			<input type="hidden" name="artist_id" id="artist-id" value=""/>
			<label for="edit-artist-name-autocomplete" class="active">
				Name
				<font style="color: #f00; font-style: normal; font-size: 13px;">*</font>
			</label>
		</div>

		<div class="row input-row">
			<div class="input-field col s12 m8 l4">
				<input type="text" name="start_date" id="start_date_edit_invite" placeholder=""
					class="date-input"  readonly="readonly"  value="<?= $start_date; ?>" required>
				<label for="start_date_edit_invite" class="active time-label"><span class="required-color">*</span> Start date</label>
			</div>
			<div class="input-field col s12 m8 l4">
				<input type="text" class="" name="start_time" id="start_time_edit_invite" placeholder="" value="<?= $start_time; ?>" required>
				<label for="start_time_edit_invite" class="active"><span class="required-color">*</span> Start time</label>
			</div>
		</div>
		<div class="row input-row">
			<div class="input-field col s12 m8 l4">
				<input type="text" name="end_date" id="end_date_edit_invite" placeholder=""
					class="date-input" readonly="readonly" value="<?= $end_date; ?>" required>
				<label for="end_date_edit_invite" class="active  time-label"><span class="required-color">*</span> End date</label>
			</div>
			<div class="input-field col s12 m8 l4">
				<input type="text" class="" name="end_time" id="end_time_edit_invite" placeholder="" value="<?= $end_time; ?>" required>
				<label for="end-time_invited" class="active"><span class="required-color">*</span> End time</label>
			</div>
		</div>
		
		<div class="input-field col s12 m8 l4" style="display: none;">
			<input type="number" name="price" min="0.00" step="0.01" value="0.00" required></input>
			<label for="" class="active">
				Price
				<font style="color: #f00; font-style: normal; font-size: 13px;">*</font>
			</label>
		</div>
		<script>
		$(document).ready(function() {

			$("#start_time_edit_invite").kendoTimePicker({
			    min: new Date(2000, 0, 1, 8, 0, 0) //date part is ignored
			});
			$("#end_time_edit_invite").kendoTimePicker({
			    min: new Date(2000, 0, 1, 8, 0, 0) //date part is ignored
			});

			$('#start_date_edit_invite').datepicker().on('changeDate', function(ev){
		        $(this).datepicker('hide');
		    });

		    $('#end_date_edit_invite').datepicker().on('changeDate', function(ev){
		        $(this).datepicker('hide');
		    });
		});
		</script>

		{!! Form::close() !!}
	</div>

	<div class="modal-footer">
		<a class="modal-action modal-close btn ourscene-btn-3">Cancel</a>
		<a class="modal-action btn" style="margin-right: 10px;" onClick="$('<input type=\'submit\'>').hide().appendTo('#edit-invite-artist-form').click().remove();">Update</a>
	</div>
</div>