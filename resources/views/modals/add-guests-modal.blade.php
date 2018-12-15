<!-- Add house equipments modal -->

<div id="add-guests-modal" class="modal">
	<div class="modal-content">

		<div class="ourscene-modal-title-1">Add Guests</div>

		<div class="container">
			<div class="row">
				<div class="input-field col s12 m8 l4">
					<input type="text" name="guest_name" id="guest_name" placeholder="Guest name" value="" required/>
					<label for="guest_name" class="active"><span class="required-color">*</span> Guest Name:</label>
				</div>
			</div>
			<div class="row">
				<div class="input-field col s12 m8 l4">
					<input type="text" name="guest_number" id="guest_number" placeholder="Guest number" value="" required/>
					<label for="guest_number" class="active"><span class="required-color">*</span> Guest Number:</label>
				</div>
			</div>
		</div>

	</div>

	<div class="modal-footer">
		<a class="modal-action modal-close btn ourscene-btn-3">Cancel</a>
		<a class="modal-action modal-close btn" style="margin-right: 10px;" onClick="addGuest()">Add</a>

	</div>

</div>
