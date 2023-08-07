@php($dir = in_array(app()->getLocale(), ['ar'])?'rtl':'ltr')
@php($dir_flag = $dir == 'rtl'?'rtl.':'')
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ $dir }}">
    <head>
        <meta charset="utf-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover"/>
        <meta http-equiv="X-UA-Compatible" content="ie=edge"/>
        <title>{{ __(config('app.name', 'Atheer Dashboard')) }}</title>

        <!-- CSS files -->
        @stack('css_libs_before')
        <link href="{{ Atheer::publicUrl() . '/themes/tabler/css/tabler.' }}{{  $dir_flag }}min.css" rel="stylesheet"/>
        <link href="{{ Atheer::publicUrl() . '/themes/tabler/css/tabler-flags.' }}{{  $dir_flag }}min.css" rel="stylesheet"/>
        <link href="{{ Atheer::publicUrl() . '/themes/tabler/css/tabler-payments.' }}{{  $dir_flag }}min.css" rel="stylesheet"/>
        <link href="{{ Atheer::publicUrl() . '/themes/tabler/css/tabler-vendors.' }}{{  $dir_flag }}min.css" rel="stylesheet"/>
        <link href="{{ Atheer::publicUrl() . '/themes/tabler/css/demo.' }}{{  $dir_flag }}min.css" rel="stylesheet"/>
        @stack('css_libs_after')

        <!-- Inject css -->
        @stack('styles')
    </head>
    <body class="border-top-wide border-primary d-flex flex-column">

        @yield('content')

        <!-- Libs JS -->
        @stack('libs')

        <!-- Tabler Core -->
        <script src="{{ Atheer::publicUrl() . '/themes/tabler/js/tabler.min.js' }}" defer></script>
        <script src="{{ Atheer::publicUrl() . '/themes/tabler/js/demo.min.js' }}" defer></script>
        <script src="{{ Atheer::publicUrl() . '/js/atheer.js' }}"></script>

        <!-- Inject js -->
        @stack('scripts')
    </body>
</html>