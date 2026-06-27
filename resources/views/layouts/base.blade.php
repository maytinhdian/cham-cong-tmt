<!--
=========================================================
* Material Dashboard 2 - v3.0.0
=========================================================

* Product Page: https://www.creative-tim.com/product/material-dashboard
* Copyright 2021 Creative Tim (https://www.creative-tim.com) & UPDIVISION (https://www.updivision.com)
* Licensed under MIT (https://www.creative-tim.com/license)
* Coded by www.creative-tim.com & www.updivision.com

=========================================================

* The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.
-->
<!DOCTYPE html>
<html lang='en' dir="{{ Route::currentRouteName() == 'rtl' ? 'rtl' : '' }}">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('assets') }}/img/apple-icon.png">
    <link rel="icon" type="image/png" href="{{ asset('assets') }}/img/favicon.png">
    <title>
        TMT Time Attendance
    </title>

    <!-- Metas -->
    @if (env('IS_DEMO'))
        <meta name="keywords"
            content="TMT Time Attendance, time attendance, cham cong, HRM, Laravel, Livewire, Bootstrap" />
        <meta name="description"
            content="TMT Time Attendance system for employee, shift, department and attendance management" />
        <meta itemprop="name" content="TMT Time Attendance" />
        <meta itemprop="description"
            content="TMT Time Attendance system for employee, shift, department and attendance management" />
        <meta itemprop="image"
            content="https://s3.amazonaws.com/creativetim_bucket/products/601/original/material-dashboard-pro-laravel-livewire.jpg" />
        <meta name="twitter:card" content="product" />
        <meta name="twitter:site" content="@tmt" />
        <meta name="twitter:title" content="TMT Time Attendance" />
        <meta name="twitter:description"
            content="TMT Time Attendance system for employee, shift, department and attendance management" />
        <meta name="twitter:creator" content="@tmt" />
        <meta name="twitter:image"
            content="https://s3.amazonaws.com/creativetim_bucket/products/601/original/material-dashboard-pro-laravel-livewire.jpg" />
        <meta property="fb:app_id" content="655968634437471" />
        <meta property="og:title" content="TMT Time Attendance" />
        <meta property="og:type" content="article" />
        <meta property="og:url" content="{{ url('/') }}" />
        <meta property="og:image"
            content="https://s3.amazonaws.com/creativetim_bucket/products/601/original/material-dashboard-pro-laravel-livewire.jpg" />
        <meta property="og:description"
            content="TMT Time Attendance system for employee, shift, department and attendance management" />
        <meta property="og:site_name" content="TMT Time Attendance" />
    @endif

    <!--     Fonts and icons     -->
    <link rel="stylesheet" type="text/css"
        href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700,900|Roboto+Slab:400,700" />
    <!-- Nucleo Icons -->
    <link href="{{ asset('assets') }}/css/nucleo-icons.css" rel="stylesheet" />
    <link href="{{ asset('assets') }}/css/nucleo-svg.css" rel="stylesheet" />
    <!-- Font Awesome Icons -->
    <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
    <!-- Material Icons -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet">
    <!-- CSS Files -->
    <link id="pagestyle" href="{{ asset('assets') }}/css/material-dashboard.css?v=3.0.1" rel="stylesheet" />
    <link href="{{ asset('assets') }}/css/tmt-ui.css" rel="stylesheet" />
    <!-- Quill -->
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">

    @livewireStyles
</head>

<body class="g-sidenav-show bg-gray-200 {{ Route::currentRouteName() == 'rtl' ? 'rtl' : '' }}">

    {{ $slot }}

    <script src="{{ asset('assets') }}/js/core/popper.min.js"></script>
    <script src="{{ asset('assets') }}/js/core/bootstrap.min.js"></script>
    <script src="{{ asset('assets') }}/js/plugins/smooth-scrollbar.min.js"></script>
    <!-- Kanban scripts -->
    <script src="{{ asset('assets') }}/js/plugins/dragula/dragula.min.js"></script>
    <script src="{{ asset('assets') }}/js/plugins/jkanban/jkanban.js"></script>
    @stack('js')
    <script>
        var win = navigator.platform.indexOf('Win') > -1;
        if (win && document.querySelector('#sidenav-scrollbar')) {
            var options = {
                damping: '0.5'
            }
            Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
        }
    </script>
    <!-- Github buttons -->
    <script async defer src="https://buttons.github.io/buttons.js"></script>
    <!-- Control Center for Material Dashboard: parallax effects, scripts for the example pages etc -->
    <script src="{{ asset('assets') }}/js/material-dashboard.min.js?v=3.0.1"></script>
    <script src="{{ asset('assets') }}/js/tmt-ui.js"></script>
    @livewireScripts
</body>

</html>
