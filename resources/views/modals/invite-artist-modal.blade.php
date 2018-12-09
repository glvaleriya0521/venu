<div id="invite-artist-modal" class="modal">
	<div class="modal-content">

		<div class="ourscene-modal-title-1">Invite artist</div>
		
		<div id="error-no-selected-invited-artist" class="error-field" style="display: none;">
			There is no selected artist.
		</div>
		<br/>

		{!! Form::open(array(
			'id'			=> 'invite-artist-form',
		)) !!}

		<div class="input-field col s12 m8 l4">
		@if(Session::get('user_type') == 'venue')
			<input type="text" name="artist_name" placeholder="" required autocomplete="off">
			<input type="hidden" name="artist_id" id="artist-id" value=""/>
		@else	
			<input type="text" name="artist_name" placeholder="" value="{{ Session::get('name') }}" readonly required autocomplete="off">
			<input type="hidden" name="artist_id" id="artist-id" value="{{ Session::get('id') }}">
		@endif
			<label for="artist-name-autocomplete" class="active">
				Name
				<font style="color: #f00; font-style: normal; font-size: 13px;">*</font>
			</label>
			<div>
				<ul class="artist-name-autocomplete-dropdown dropdown-content autocomplete" style="top:35px;">
				</ul>
			</div>
		</div>

		<div class="input-field col s12 m8 l4">
			<label class="active">Start date <span class="required-color">*</span></label>
		</div>

		<div class="input-field col s12 m8 l4">
			<input type="text" name="start_date" id="invite-start-date" placeholder="" 
				class="date-input"  readonly="readonly"  value="<?= $start_date; ?>" required>
		</div>

		<div class="input-field col s12 m8 l4">
			<input type="text" class="" name="start_time" id="invite-start-time" placeholder="" value="<?= $start_time; ?>" required></br>
			<label for="" class="active">
				Start time
				<font style="color: #f00; font-style: normal; font-size: 13px;">*</font>
			</label>
		</div>

		<div class="input-field col s12 m8 l4">
			<label class="active">End date <span class="required-color">*</span></label>
		</div>

		<div class="input-field col s12 m8 l4">
			<input type="text" name="end_date" id="invite-end-date" placeholder=""
				class="date-input" readonly="readonly" value="<?= $end_date; ?>" required>
		</div>

		<div class="input-field col s12 m8 l4">
			<input type="text" class="" name="end_time" id="invite-end-time" placeholder="" value="<?= $end_time; ?>" required></br>
			<label for="" class="active">
				End time
				<font style="color: #f00; font-style: normal; font-size: 13px;">*</font>
			</label>
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
			var timezone_offset = new Date().getTimezoneOffset();
			$("#timezone_offset").val(timezone_offset);

			// $("#start-time").timepicker({
			// 	// timeFormat: 'h:mm p',
			// 	interval: 15,
			// 	scrollbar: true
			// });
			$("#invite-start-time").kendoTimePicker({
			    min: new Date(2000, 0, 1, 8, 0, 0) //date part is ignored
			});
			$("#invite-end-time").kendoTimePicker({
			    min: new Date(2000, 0, 1, 8, 0, 0) //date part is ignored
			});
			$("#invite-opening-time").kendoTimePicker({
			    min: new Date(2000, 0, 1, 8, 0, 0) //date part is ignored
			});

			$('#invite-start-date').datepicker().on('changeDate', function(ev){
		        $(this).datepicker('hide');
		    });

		    $('#invite-end-date').datepicker().on('changeDate', function(ev){
		        $(this).datepicker('hide');
		    });
		});
		</script>

		{!! Form::close() !!}
	</div>

	<div class="modal-footer">
		<a class="modal-action modal-close btn ourscene-btn-3">Cancel</a>
		<a class="modal-action btn" style="margin-right: 10px;" onClick="$('<input type=\'submit\'>').hide().appendTo('#invite-artist-form').click().remove();">Add artist</a>
	</div>
</div>