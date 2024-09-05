@php($locale = Atheer::getLocale())
@php($dir_flag = $locale->dir == 'rtl'?'rtl.':'')
@php($layout = config('atheer.layout'))
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ $locale->dir }}">
    <head>
        <meta charset="utf-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover"/>
        <meta http-equiv="X-UA-Compatible" content="ie=edge"/>
        <title>{{ $atheer->title ?? '' }}</title>

        <!-- CSS files -->
        @stack('css_libs_before')
        <link href="{{ Atheer::publicUrl() . '/themes/tabler/css/tabler.' }}{{  $dir_flag }}min.css" rel="stylesheet"/>
        <link href="{{ Atheer::publicUrl() . '/themes/tabler/css/tabler-flags.' }}{{  $dir_flag }}min.css" rel="stylesheet"/>
        <link href="{{ Atheer::publicUrl() . '/themes/tabler/css/tabler-payments.' }}{{  $dir_flag }}min.css" rel="stylesheet"/>
        <link href="{{ Atheer::publicUrl() . '/themes/tabler/css/tabler-vendors.' }}{{  $dir_flag }}min.css" rel="stylesheet"/>
        <link href="{{ Atheer::publicUrl() . '/themes/tabler/css/demo.' }}{{  $dir_flag }}min.css" rel="stylesheet"/>
        <link href="{{ Atheer::publicUrl() . '/libs/Toastr/toastr.min.css' }}" rel="stylesheet"/>
        <link href="{{ Atheer::publicUrl() . '/libs/simplemde/simplemde.min.css' }}" rel="stylesheet"/>

        @stack('css_libs_after')
        <link href="{{ url('/') . '/dp/css/style.css' }}" rel="stylesheet"/>

        <!-- Inject css -->
        @stack('styles')
    </head>
    <body class=" {{ in_array($layout, ['boxed', 'fluid'])?'layout-'.$layout:'' }}{{ $layout == 'fluid-vertical'?'layout-fluid':'' }}">
        @include("atheer::layouts.headers.$layout")

        @yield('content')

        @include("atheer::layouts.footer")
        @stack('models')

        <!-- Libs JS -->
        @stack('libs')

        <!-- Tabler Core -->
        <script src="{{ Atheer::publicUrl() . '/themes/tabler/js/tabler.min.js' }}" defer></script>
        <script src="{{ Atheer::publicUrl() . '/themes/tabler/js/demo.min.js' }}" defer></script>
        <script src="{{ Atheer::publicUrl() . '/libs/jQuery/jquery_3.7.0.min.js' }}"></script>
        <script src="{{ Atheer::publicUrl() . '/libs/Sweetalert/sweetalert2_11.7.19.all.min.js' }}"></script>
        <script src="{{ Atheer::publicUrl() . '/js/fValidation.js' }}"></script>
        <script src="{{ Atheer::publicUrl() . '/js/atheer.js' }}"></script>
        <script src="{{ Atheer::publicUrl() . '/libs/Toastr/toastr.min.js' }}"></script>
        <script src="{{ Atheer::publicUrl() . '/libs/simplemde/simplemde.min.js' }}"></script>

        @stack('js_after')

        <!-- Inject js -->
        @stack('scripts')
        
        <!-- Inject modals -->
        @stack('modals')

        <!-- Ajax spinner -->
        @include("atheer::layouts.spinner")
        
    </body>
</html>