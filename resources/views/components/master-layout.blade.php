<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Asistencia APP') }}</title>
        <link rel="icon" type="image/jpg" href="img/redhcologo.png"/>
         <!-- Google Font: Source Sans Pro -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Source+Sans+Pro:ital,wght@0,300;0,400;0,700;1,400&display=swap" rel="stylesheet">

        <link rel="stylesheet" href="{{ asset("adminlte4/plugins/overlayscrollbars/css/overlayscrollbars.min.css") }}">

        <link type="text/css" rel="stylesheet" href="{{ asset("adminlte4/plugins/fontawesome-free/css/all.min.css") }}">

        <link type="text/css" rel="stylesheet" href="{{ asset("adminlte4/plugins/steps/steps.css") }}">

        <!--begin::Third Party Plugin(Bootstrap Icons)-->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.min.css" integrity="sha256-BicZsQAhkGHIoR//IB2amPN5SrRb3fHB8tFsnqRAwnk=" crossorigin="anonymous">
        <!--end::Third Party Plugin(Bootstrap Icons)-->

        <link type="text/css" rel="stylesheet" href="{{ asset("adminlte4/css/adminlte.min.css") }}">

        <!-- Scripts -->
        {{-- @routes --}}
        @vite(['resources/js/app.js'])
    </head>
    <body>
        <div class="wrapper" id="wrapper">
            <App></App>

            <script src="{{ asset("adminlte4/plugins/overlayscrollbars/js/overlayscrollbars.browser.es6.min.js") }}"></script>
            <script src="{{ asset("adminlte4/plugins/popper/popper.min.js") }}"></script>
            <script src="{{ asset("adminlte4/plugins/bootstrap/js/bootstrap.min.js") }}"></script>
            <script src="{{ asset("adminlte4/js/adminlte.min.js") }}"></script>
            <script src="{{ asset("adminlte4/plugins/steps/steps.js") }}"></script>

            <script>
                const SELECTOR_SIDEBAR_WRAPPER = ".sidebar-wrapper";
                const Default = {
                    scrollbarTheme: "os-theme-light",
                    scrollbarAutoHide: "leave",
                    scrollbarClickScroll: true,
                };

                document.addEventListener("DOMContentLoaded", function() {
                    const sidebarWrapper = document.querySelector(SELECTOR_SIDEBAR_WRAPPER);
                    if (
                        sidebarWrapper &&
                        typeof OverlayScrollbarsGlobal?.OverlayScrollbars !== "undefined"
                    ) {
                        OverlayScrollbarsGlobal.OverlayScrollbars(sidebarWrapper, {
                            scrollbars: {
                                theme: Default.scrollbarTheme,
                                autoHide: Default.scrollbarAutoHide,
                                clickScroll: Default.scrollbarClickScroll,
                            },
                        });
                    }
                });
            </script>
        </div>
    </body>
</html>
