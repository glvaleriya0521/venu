<div id="main-navigation-3" class="center-align">
	<div class="btn-group" role="group" aria-label="">
	@foreach($items as $item)
		<a href="{{ $item['url'] }}" class="btn btn-default @if(Request::url() == $item['url']) active @endif" style="text-transform: none; font-size: 12px;">
		@if(Request::url() == $item['url'])
			<img src="{{ $item['image-active'] }}"/>
		@else
			<img src="{{ $item['image'] }}"/>
		@endif
			{{ $item['text'] }}
			<?php
		 		$pending_requests = OurScene\Models\Service::servicesByReceiverId(Session::get('id'))->pending()->get();
            	$pending_requests_counter = count($pending_requests);
		 	?>
		 	@if($pending_requests_counter > 0 && $item['text'] == "Requests")
		 		<span class="badge red"> {{$pending_requests_counter}}</span>
		 	@endif
		</a>
	@endforeach
	</div>
</div>	
