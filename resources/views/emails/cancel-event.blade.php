<?php use OurScene\Helpers\DatetimeUtils; ?>

Hi, {{ $artist->name }}!

<br/><br/><br/><br/>

We're informing you that {{ $venue->name }} cancelled this event.

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

<br/><br/><br/>

You may <a href="{{ action('UserController@getLogin') }}" style="color: rgba(26, 120, 246, 1.0); text-decoration: none;">log in</a> to view your calendar and check your requests section.

<br/><br/><br/><br/>

Cheers,

<br/><br/><br/>

VenU
