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

        .notification-container {
            position: relative;
        }

        .notification-items-container {
            position: absolute;
            display: none;
            flex-direction: column;
            overflow-y: auto;
            width: 300px;
            max-height: 300px;
            background-color: whitesmoke;
            z-index: 99;
            /* color: wheat; */
            right: 0;
            border: 1px solid #dee2e6;
            border-radius: 4px;
            padding: 8px;
        }

        .item-notif {
            display: flex;
            flex-direction: row;
            gap: 6px;
            border-bottom: 1px solid #7b809a;
            padding: 6px 0;
        }

        .notification-item {}

        .notification {
            display: none;
            width: 8px;
            height: 8px;
            background: #D81B60;
            border-radius: 5px;
            position: absolute;
            top: 0;
            right: 0;
        }

        .notification.notification-exists {
            display: block;
        }

        .custom-scrollbar {
            overflow-y: auto;
            /* border: 1px solid #ccc; */

            /* Firefox */
            scrollbar-width: thin;
            scrollbar-color: #888 #f1f1f1;
        }

        /* WebKit browsers */
        .custom-scrollbar::-webkit-scrollbar {
            width: 12px;
        }

        .custom-scrollbar::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb {
            background-color: #888;
            border-radius: 10px;
            border: 2px solid #ccc;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background-color: #555;
        }

        .hide {
            display: none !important;
        }

        .loader {
            border: 8px solid #f3f3f3;
            /* Light grey */
            border-top: 8px solid #3498db;
            /* Blue */
            border-radius: 50%;
            width: 100px;
            height: 100px;
            animation: spin 2s linear infinite;
        }

        /* Keyframes untuk animasi berputar */
        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        /* Pusatkan loader di tengah layar */
        .center {
            display: none;
            justify-content: center;
            align-items: center;
            height: 100%;
            position: fixed;
            z-index: 9999;
            /* left: 50%; */
            /* height: 50%; */
            width: 100%;
            background: #55555598;
        }
    </style>
    @yield('custom-css')
</head>

<body class="g-sidenav-show  bg-gray-200">
    <div class="center" id="loading-animation">
        <div class="loader"></div>
    </div>

    @include('master.part.menu-navbar-main')
    <main class="main-content position-relative h-100 border-radius-lg ">
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
    @include('master.part.change-modal-password')
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
            // Toggle submenus for specific menu items
            $("#menuSmartPica, #menuSHE, #menuIC, #menuSM, #menuPLANT, #menuProduksi, #menuUnderCarriage, .nav-menu-utama")
                .on("click", function(e) {
                    e.preventDefault();
                    $(this).next(".submenu").slideToggle();
                });

            // Highlight active menu based on current URL
            var currentUrl = window.location.href;
            $('.nav-link').each(function() {
                if (this.href === currentUrl) {
                    $(this).addClass('bg-gradient-faded-primary');
                    // Ensure the parent submenu is visible
                    $(this).closest('.submenu').show();
                    // Add a class to the parent nav-item to keep the submenu open
                    $(this).closest('.nav-item').addClass('active');
                }
            });

            // Toggle notification dropdown
            $("#notification-icon").on("click", function() {
                var notificationContainer = $("#notification-item").closest(
                    ".notification-items-container");
                if (notificationContainer.css('display') === "flex") {
                    notificationContainer.css('display', 'none');
                } else {
                    notificationContainer.css('display', 'flex');
                }
            });

            // Search functionality in the navbar
            $('#navbarSearch').on('keyup', function() {
                var input = $(this).val().toLowerCase();

                // Loop through each nav-item or its parent li and check for text match
                $('#sidenav-collapse-main .nav-item').each(function() {
                    var text = $(this).text().toLowerCase();
                    if (text.includes(input)) {
                        $(this).show(); // Show the matching menu items
                    } else {
                        $(this).hide(); // Hide those that don't match
                    }
                });
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

    <script>
        function OpenModalChangePasswordUser() {
            $('#changePasswordUserModal').modal("show");
        }

        function sendDataChangePasswordUser() {
            let oldPassword = $('#old_passwordChangePassword').val();
            let newPassword = $('#new_passwordChangePassword').val();
            let confirmPassword = $('#konfirmation_passwordChangePassword').val();
            if (!oldPassword || !newPassword || !confirmPassword) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Form Tidak Lengkap',
                    text: 'Pastikan semua field sudah terisi!'
                });
                return false;
            }

            if (newPassword.length < 7) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Password Terlalu Pendek',
                    text: 'Password baru harus minimal 7 karakter.'
                });
                return;
            }

            if (newPassword !== confirmPassword) {
                Swal.fire({
                    icon: 'error',
                    title: 'Password Tidak Cocok',
                    text: 'Konfirmasi password tidak sama dengan password baru.'
                });
                return false;
            }

            let dataKirim = {
                p1: oldPassword,
                p2: newPassword
            }

            $.ajax({
                type: 'post',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "/helper/change-password-pegawai",
                data: dataKirim,
                dataType: 'json',
                success: function(response) {
                    if (response.code == 200) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: response.message,
                        }).then((result) => {
                            window.location.href = `/logout`
                        })
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: `Error 00003`,
                            html: response.message,
                            confirmButtonText: 'OK'
                        });
                    }
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    Swal.fire({
                        icon: 'error',
                        title: `Error 00002`,
                        html: message,
                        confirmButtonText: 'OK'
                    });
                }
            })


        }
    </script>
</body>

</html>
