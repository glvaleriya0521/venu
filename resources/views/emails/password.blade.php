Hi, {{ $user->name }}!

<br/><br/><br/><br/>

Your new password is:<br/>
<b>{{ $password }}</b>

<br/><br/><br/>

You may <a href="{{ action('UserController@getLogin') }}@if($user->user_type == 'venue')?type=venue @endif" style="color: rgba(26, 120, 246, 1.0); text-decoration: none;">log in</a> using your new pasword.

<br/><br/><br/><br/>

Cheers,

<br/><br/><br/>

VenU
