$(document).ready(function() {

	//event colors

	const CREATED_EVENT_BY_VENUE_COLOR = '#46bfa7'; //green

	const CONFIRMED_REQUEST_OF_VENUE_COLOR = '#46bfa7'; //green
	const PENDING_REQUEST_OF_VENUE_COLOR = 'rgba(238, 143, 31, 1.0)'; //orange
	const REJECTED_REQUEST_OF_VENUE_COLOR = 'rgba(139, 0, 0, 1.0)'; //darkred

	const CONFIRMED_REQUEST_OF_ARTIST_COLOR = '#46bfa7';//green
	const PENDING_REQUEST_OF_ARTIST_COLOR = 'rgba(238, 143, 31, 1.0)'; //orange

	const DEFAULT_EVENT_COLOR = '#2CA5E0'; //blue

	const PROMOTION_COLOR = '#E34C66'; //red

	var $create_event_from_drag_and_drop_form = $('#create-event-from-drag-and-drop-form');

	$('#calendar').fullCalendar({

		defaultView: 'month',
		header: {
			left: 'prev,next month agendaWeek'
		},
		selectable: true,
		selectHelper: true,
		select: function(start, end) {

			var check = start._d.toJSON().slice(0,10);
			var today = new Date().toJSON().slice(0,10);
		    if(check < today){
		        // Previous Day. show message if you want otherwise do nothing.
		        // So it will be unselectable
		    }else{
		       //initialize and submit create event from drag and drop form
				$('#start-datetime').val(Date.parse(start));
				$('#end-datetime').val(Date.parse(end));

				$create_event_from_drag_and_drop_form.submit();
		    }

		},
		eventLimit: true,
		eventLimitText: 'event',
		viewRender: function(view, element){

			$('#calendar-title').html(view.title); //show calendar title

			//set content height
			if(view.name == "month")
				$('#calendar').fullCalendar('option', 'contentHeight', '');
			else
				$('#calendar').fullCalendar('option', 'contentHeight', 'auto');
    	},
		events: function (start, end, timezone, callback){

			$.ajax({
				url: ROOT+'/event/ajax-fetch-private-events-by-user-id?start_datetime='+start+'&end_datetime='+end,
				type: "POST",
				data: "_token="+CSRF_TOKEN,
				success: function(data){

					var calendar_events = []; //container of events and promotions

					var json_data = JSON.parse(data);

					//get events
					var events = json_data['events'];

					//get promotions
					var promotions = json_data['promotions'];

					//check if calendar events exist
					if (events.length + promotions.length > 0){ }

					//process events

					for (var index in events){

						var event = events[index];

						//format event details

						var title = event['title'];

						var age_requirements = event['age_requirements'];
						var type = event['event_type'];
						var payment_status = event['payment_status'];
						var status = event['status'];

						var start_datetime = event['start_datetime']['sec'];
						var start_time = moment().startOf('day').seconds(start_datetime).format('HH:mm:ss');
						var start_date = moment.utc(start_datetime*1000).format('YYYY-MM-DD');
						start_datetime = start_date + 'T' + start_time;

						var end_datetime = event['end_datetime']['sec'];
						var end_time = moment().startOf('day').seconds(end_datetime).format('HH:mm:ss');
						var end_date = moment.utc(end_datetime*1000).format('YYYY-MM-DD');
						end_datetime = end_date + 'T' + end_time;

						var color = DEFAULT_EVENT_COLOR;

						switch(event['color_code']) {
							case 'created-event-by-venue-color':
								color = CREATED_EVENT_BY_VENUE_COLOR;
								break;
							case 'confirmed-request-of-venue-color':
								color = CONFIRMED_REQUEST_OF_VENUE_COLOR;
								break;
							case 'pending-request-of-venue-color':
								color = PENDING_REQUEST_OF_VENUE_COLOR;
								break;
							case 'rejected-request-of-venue-color':
								color = REJECTED_REQUEST_OF_VENUE_COLOR;
								break;
							case 'confirmed-request-of-artist-color':
								color = CONFIRMED_REQUEST_OF_ARTIST_COLOR;
								break;
							case 'pending-request-of-artist-color':
								color = PENDING_REQUEST_OF_ARTIST_COLOR;
								break;
						}

						calendar_events.push({
								classification: 'event',
								id: event['id'],
								title: title,
								start: start_datetime,
								end: end_datetime,
								color: color
						});

					}

					//process promotions

					for (var index in promotions){

						var promotion = promotions[index];

						//format promotion details

						var title = promotion['title'];

						var age_requirements = promotion['age_requirements'];
						var type = promotion['promotion_type'];
						var payment_status = promotion['payment_status'];
						var status = promotion['status'];

						var start_datetime = promotion['start_datetime']['sec'];
						var start_time = moment().startOf('day').seconds(start_datetime).format('HH:mm:ss');
						var start_date = moment.utc(start_datetime*1000).format('YYYY-MM-DD');
						start_datetime = start_date + 'T' + start_time;

						var end_datetime = promotion['end_datetime']['sec'];
						var end_time = moment().startOf('day').seconds(end_datetime).format('HH:mm:ss');
						var end_date = moment.utc(end_datetime*1000).format('YYYY-MM-DD');
						end_datetime = end_date + 'T' + end_time;

						var color = PROMOTION_COLOR;

						//add promotion to calendar events

						calendar_events.push({
								classification: 'promotion',
								id: promotion['id'],
								title: title,
								start: start_datetime,
								end: end_datetime,
								color: color
						});

					}

					callback(calendar_events);
				}
			});
		},
		eventClick: function(calEvent, jsEvent, view){

			// Check calendar event classification

			if(calEvent.classification == 'event'){
				//redirect to event page
				window.location.href = ROOT+"/event/"+calEvent.id;
				return;
			}
			else if(calEvent.classification == 'promotion'){
				//redirect to promotion page
				window.location.href = ROOT+"/promotion/"+calEvent.id;
				return;
			}
		}
	});
});
