@extends('atheer::emails.simple.layouts.app')

@section('content')
<div style="background-color: #FFF; padding:10px;">
	<h2 style="text-align: center; color: green;">{{ __('Register Success') }}</h2>
	<p>
		<h4>{{ __('Hi') }} {{ $user->name }},</h4>
		{{ __('Thank you for your registration with us') }}.
	</p>
	<div style="text-align: center;">
		<h5>{{ __('Press the button below to active your E-mail') }}</h5>
		<div><a href="{{ $activationLink }}" style="{{ $style['button-success'] }}">{{ __('Active E-mail') }}</a></div>
	</div>
</div>
@endsection