<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('master/img/apple-icon.png') }}">
    <link rel="icon" type="image/png" href="{{ asset('img/logo.png') }}">
    <title>
        BINA SARANA SUKSES SMART DASHBOARD
    </title>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <!--     Fonts and icons     -->
    <link rel="stylesheet" type="text/css"
        href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700,900|Roboto+Slab:400,700" />
    <!-- Nucleo Icons -->
    <link href="{{ asset('master/css/nucleo-icons.css') }}" rel="stylesheet" />
    <link href="{{ asset('master/css/nucleo-svg.css') }}" rel="stylesheet" />
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
        integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Material Icons -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet">
    <!-- CSS Files -->
    <link id="pagestyle" href="{{ asset('master/css/material-dashboard.css?v=3.1.0') }}" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Nepcha Analytics (nepcha.com) -->
    <!-- Nepcha is a easy-to-use web analytics. No cookies and fully compliant with GDPR, CCPA and PECR. -->
    {{-- <script defer data-site="YOUR_DOMAIN_HERE" src="https://api.nepcha.com/js/nepcha-analytics.js"></script> --}}
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        .reset-bg {
            background-image: none;
        }
    </style>
    @yield('custom-css')
</head>

<body class="g-sidenav-show  bg-gray-200">
    @include('master.part.menu-navbar-main')
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <!-- Navbar -->
        @include('master.part.navbar-master')

        <!-- End Navbar -->
        <input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}">
        <div class="container-fluid py-4">
            @yield('content')
        </div>
    </main>
    @yield('modal')
    @include('master.part.config-template')
    <!--   Core JS Files   -->
    <script src="https://cdn.jsdelivr.net/npm/jquery/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="{{ asset('master/js/core/popper.min.js') }}"></script>
    <script src="{{ asset('master/js/core/bootstrap.min.js') }}"></script>
    <script src="{{ asset('master/js/plugins/perfect-scrollbar.min.js') }}"></script>
    <script src="{{ asset('master/js/plugins/smooth-scrollbar.min.js') }}"></script>
    <script src="{{ asset('master/js/plugins/chartjs.min.js') }}"></script>
    <script src="{{ asset('master/js/jsplumb-tree.js') }}"></script>
    <script>
        $(document).ready(function() {
            $("#menuSmartPica").on("click", function(e) {
                e.preventDefault();
                $(this).next(".submenu").slideToggle();
            });
            $("#menuSHE").on("click", function(e) {
                e.preventDefault();
                $(this).next(".submenu").slideToggle();
            });
            $("#menuIC").on("click", function(e) {
                e.preventDefault();
                $(this).next(".submenu").slideToggle();
            });
            $("#menuSM").on("click", function(e) {
                e.preventDefault();
                $(this).next(".submenu").slideToggle();
            });
            $("#menuPLANT").on("click", function(e) {
                e.preventDefault();
                $(this).next(".submenu").slideToggle();
            });
            $("#menuProduksi").on("click", function(e) {
                e.preventDefault();
                $(this).next(".submenu").slideToggle();
            });
            $(".nav-menu-utama").on("click", function(e) {
                e.preventDefault();
                $(this).next(".submenu").slideToggle();
            });
            var currentUrl = window.location.href;
            $('.nav-link').each(function() {
                if (this.href === currentUrl) {
                    $(this).addClass('bg-gradient-danger');
                    // Ensure the parent submenu is visible
                    $(this).closest('.submenu').show();
                    // Add a class to the parent nav-item to keep the submenu open
                    $(this).closest('.nav-item').addClass('active');
                }
            });
        });
        var win = navigator.platform.indexOf('Win') > -1;
        if (win && document.querySelector('#sidenav-scrollbar')) {
            var options = {
                damping: '0.5'
            }
            Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
        }
        $('.back-button-by-history').click(function() {
            if (window.history.length > 1) {
                window.history.back(); // Goes back to the previous page in the browser's history
            } else {
                window.location.href = '/smart-pica'; // Redirect to a default page if no history
            }
        });
    </script>
    <!-- Github buttons -->
    <script async defer src="https://buttons.github.io/buttons.js"></script>
    <!-- Control Center for Material Dashboard: parallax effects, scripts for the example pages etc -->
    <script src="{{ asset('master/js/material-dashboard.min.js?v=3.1.0') }}"></script>
    @yield('custom-js')
</body>

</html>
