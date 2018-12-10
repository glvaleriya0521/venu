<?php use OurScene\Helpers\DatetimeUtils; ?>

Hi, {{ $artist->name }}!

<br/><br/><br/><br/>

Sorry to say but {{ $venue->name }} declined your request for performance.

<br/><br/><br/>

<span style="color: rgba(26, 120, 246, 1.0); font-weight: bold;">Event details</span>

<br/><br/>

<b>Title</b><br/>
{{ $event->title }}

<br/><br/>

<b>Start</b><br/>
{{ date('F d, Y h:i A', DatetimeUtils::convertMongoUTCDatetimeToMongoClientDatetime($event['start_datetime'])->sec) }}

<br/><br/>

<b>End</b><br/>
{{ date('F d, Y h:i A', DatetimeUtils::convertMongoUTCDatetimeToMongoClientDatetime($event['end_datetime'])->sec) }}

<br/><br/>

<span style="color: rgba(26, 120, 246, 1.0); font-weight: bold;">Performance time</span>

<br/><br/>

<b>Start</b><br/>
{{ date('F d, Y h:i A', DatetimeUtils::convertMongoUTCDatetimeToMongoClientDatetime($service['start_datetime'])->sec) }}

<br/><br/>

<b>End</b><br/>
{{ date('F d, Y h:i A', DatetimeUtils::convertMongoUTCDatetimeToMongoClientDatetime($service['end_datetime'])->sec) }}

<br/><br/><br/>

Don't worry you can still <a href="{{ action('UserController@getLogin') }}" style="color: rgba(26, 120, 246, 1.0); text-decoration: none;">log in</a> and request to any event.

<br/><br/><br/><br/>

Cheers,

<br/><br/><br/>

VenU
