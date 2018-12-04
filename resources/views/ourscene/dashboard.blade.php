<?php
	use OurScene\Models\Service;
	use OurScene\Models\User;
	use OurScene\Helpers\DatetimeUtils;
?>


@extends('ourscene.layouts.main')

@section('head')

@endsection

@section('content')
			<div id="chart-container">FusionCharts XT will load here!</div>
@endsection

@section('scripts')

<script type="text/javascript" src="https://cdn.fusioncharts.com/fusioncharts/latest/fusioncharts.js"></script>
<script type="text/javascript" src="https://cdn.fusioncharts.com/fusioncharts/latest/themes/fusioncharts.theme.fusion.js"></script>
<script type="text/javascript">
	var user_name = [];
  	@foreach($books as $book)
		user_name.push ({
			"label": '{{ $book['name'] }}'
		});
	@endforeach
	var confirmed = [];
	@foreach($books as $book)
		confirmed.push ({
			"value": '{{ $book['confirmed'] }}'
		});
	@endforeach

	var pending = [];
	@foreach($books as $book)
		pending.push ({
			"value": '{{ $book['pending'] }}'
		});
	@endforeach

	var rejected = [];
	@foreach($books as $book)
		rejected.push ({
			"value": '{{ $book['rejected'] }}'
		});
	@endforeach
	console.log(user_name)
	

	// console.log(books);
    FusionCharts.ready(function(){

    var fusioncharts = new FusionCharts({
    type: 'scrollstackedcolumn2d',
    dataFormat: 'json',
    renderAt: 'chart-container',
    width: '1600',
    height: '600',
    dataSource: {
        "chart": {
            "theme": "fusion",
            "caption": "Booking Comparison",
            "subCaption": "(Artists)",
            "xaxisname": "User",
            "yaxisname": "book",
            "numberprefix": "",
            "lineThickness": "3",
            "flatScrollBars": "1",
            "scrollheight": "10",
            "numVisiblePlot": "12",
            "showHoverEffect": "1"
        },
        "categories": [{
            "category": user_name
        }],
        "dataset": [{
            "seriesname": "confirmed",
            "data": confirmed
        }, {
            "seriesname": "pending",
            "data": pending
        }, {
            "seriesname": "rejected",
            "data": rejected
        }]
    }
});
    fusioncharts.render();
    });
</script>

@endsection
