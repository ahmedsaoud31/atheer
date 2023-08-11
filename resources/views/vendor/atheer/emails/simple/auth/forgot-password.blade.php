@extends('atheer::emails.simple.layouts.app')

@section('content')
<div style="background-color: #FFF; padding:10px;">
    <h2 style="text-align: center; color: green;">{{ __('Password reseting') }}</h2>
    <div style="text-align: center;">
        <h5>{{ __('Press the button below') }}</h5>
        <div><a href="{{ $resetLink }}" style="{{ $style['button-success'] }}">{{ __('Reset password') }}</a></div>
    </div>
</div>
@endsection
