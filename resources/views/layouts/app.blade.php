<!--
=========================================================
 Light Bootstrap Dashboard - v2.0.1
=========================================================

 Product Page: https://www.creative-tim.com/product/light-bootstrap-dashboard
 Copyright 2019 Creative Tim (https://www.creative-tim.com) & Updivision (https://www.updivision.com)
 Licensed under MIT (https://github.com/creativetimofficial/light-bootstrap-dashboard/blob/master/LICENSE)

 Coded by Creative Tim & Updivision

=========================================================

 The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.  -->
<!DOCTYPE html>

<html lang="en">
    <head>
        <meta charset="utf-8" />
        <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('light-bootstrap/img/apple-icon.png') }}">
        <!--<link rel="icon" type="image/png" href="{{ asset('light-bootstrap/img/favicon.ico') }}">-->
        <link rel="icon" href="https://www.webdec.com.br/wp-content/uploads/2021/07/cropped-webdec-icon-3-32x32.png" sizes="32x32">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
        <title>{{ $title }}</title>
        <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
        <!--     Fonts and icons     -->
        <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,200" rel="stylesheet" />
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" />

       <!--<link href="//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.2/css/bootstrap-combined.no-icons.min.css" rel="stylesheet">
        <link href="//netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.css" rel="stylesheet">-->

        <!-- CSS Files -->
        <link href="{{ asset('light-bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" />
        <link href="{{ asset('light-bootstrap/css/light-bootstrap-dashboard.css?v=2.0.0') }} " rel="stylesheet" />
        <!-- CSS Just for demo purpose, don't include it in your project -->
        <link href="{{ asset('light-bootstrap/css/demo.css') }}" rel="stylesheet" />
    </head>

    <body>
        <div class="wrapper @if (!auth()->check() || request()->route()->getName() == "" || auth()->user()->customer->plan == null) wrapper-full-page @endif">

            @if (auth()->check() && request()->route()->getName() != "")
                @include('layouts.navbars.sidebar')
                @include('pages/sidebarstyle')
            @endif

            <div class="@if (auth()->check() && request()->route()->getName() != "" && auth()->user()->customer->plan != null) main-panel @endif">
                @include('layouts.navbars.navbar')
                @yield('content')
                @include('layouts.footer.nav')
            </div>

        </div>



    </body>
        <!--   Core JS Files   -->
    <script src="{{ asset('light-bootstrap/js/core/jquery.3.2.1.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('light-bootstrap/js/core/popper.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('light-bootstrap/js/core/bootstrap.min.js') }}" type="text/javascript"></script>

    <script src="{{ asset('light-bootstrap/js/plugins/jquery.sharrre.js') }}"></script>
    <!--  Plugin for Switches, full documentation here: http://www.jque.re/plugins/version3/bootstrap.switch/ -->
    <script src="{{ asset('light-bootstrap/js/plugins/bootstrap-switch.js') }}"></script>
    <script src="{{ asset('light-bootstrap/js/plugins/jquery.mask.js') }}" type="text/javascript"></script>
    <!--  Chartist Plugin  -->
    <script src="{{ asset('light-bootstrap/js/plugins/chartist.min.js') }}"></script>
    <!--  Notifications Plugin    -->
    <script src="{{ asset('light-bootstrap/js/plugins/bootstrap-notify.js') }}"></script>
    <!-- Control Center for Light Bootstrap Dashboard: scripts for the example pages etc -->
    <script src="{{ asset('light-bootstrap/js/light-bootstrap-dashboard.js?v=2.0.0') }}" type="text/javascript"></script>
    <!-- Light Bootstrap Dashboard DEMO methods, don't include it in your project! -->
    <script src="{{ asset('light-bootstrap/js/demo.js') }}"></script>
    <script>
    window.Laravel = {
      baseUrl : "{{ asset('/') }}",
      csrfToken: '{{ csrf_token() }}'
    }
    </script>
    <script src="{{ URL::asset('js/app.js') }}"></script>
    <script>
    const app = new Vue({
        el: '#app',
        @if (isset($user))
            data: {
                userId: {{ $user->id }},
                accountCode: {{$customer}}
            }
        @endif
    });
    </script>
    <script src="{{ asset('/js/softphone.js') }}"></script>
    @stack('js')
    <script>
      $(document).ready(function () {

       
      });
    </script>
</html>