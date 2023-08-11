@php($locale = Atheer::getLocale())
<!doctype html>
<html dir="{{ $locale->dir }}">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>{{ __('Atheer') }}</title>
  </head>
  <body>
        <div style="background-color: #EEE; padding: 5px">
            <div style="text-align: center; padding: 10px;">
                <img src="{{ $message->embed(public_path().'/atheer_public/static/logo6.png') }}" height="150" />
            </div>
            
            @yield('content')

            @include("atheer::emails.simple.layouts.footer")
        </div>
  </body>
</html>
