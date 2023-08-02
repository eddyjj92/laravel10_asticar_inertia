<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <title inertia>{{ config('app.name', 'Asticar') }}</title>
    <!-- Favicon -->
    <link href="{{asset('img/asticar.png')}}" rel="icon">

    <link href="{{asset('vendor/Heebo/fonts.googleapis.com_css2_family=Heebo_wght@400;500;600;700&display=swap.css')}}" rel="stylesheet">
    <!-- Icon Font Stylesheet -->
    <link href="{{asset('vendor/fontawesome/css/all.min.css')}}" rel="stylesheet">
    <link href="{{asset('vendor/bootstrap-icons/bootstrap-icons.min.css')}}" rel="stylesheet">
    <!-- Libraries Stylesheet -->
    <link href="{{asset('lib/animate/animate.min.css')}}" rel="stylesheet">
    <link href="{{asset('lib/owlcarousel/assets/owl.carousel.min.css')}}" rel="stylesheet">
    <!-- Customized Bootstrap Stylesheet -->
    <link href="{{asset('css/bootstrap.min.css')}}" rel="stylesheet">
    <!-- Template Stylesheet -->
    <link href="{{asset('css/style.css')}}" rel="stylesheet">
    <!--Datatables-->
    <link href="{{asset('vendor/datatables/jquery.dataTables.min.css')}}" rel="stylesheet">
    <link href="{{asset('vendor/datatables/buttons.dataTables.min.css')}}" rel="stylesheet">
    <!--Swiper-->
    <link href="{{asset('vendor/swiper/swiper-bundle.min.css')}}" rel="stylesheet">

    <!-- JavaScript Libraries -->
    <script type="module" src="{{asset('vendor/jquery/jquery.min.js')}}"></script>
    <script type="module" src="{{asset('vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
    <script src="{{asset('lib/wow/wow.min.js')}}"></script>
    <script type="module" src="{{asset('lib/easing/easing.min.js')}}"></script>
    <script type="module" src="{{asset('lib/waypoints/waypoints.min.js')}}"></script>
    <script type="module" src="{{asset('lib/counterup/counterup.min.js')}}"></script>
    <script type="module" src="{{asset('lib/owlcarousel/owl.carousel.min.js')}}"></script>
    <!--Datatables-->
    <script type="module" src="{{asset('vendor/jquery/jquery.min.js')}}"></script>
    <script type="module" src="{{asset('vendor/datatables/jquery.dataTables.min.js')}}"></script>
    <script type="module" src="{{asset('vendor/datatables/dataTables.buttons.min.js')}}"></script>
    <script type="module" src="{{asset('vendor/datatables/buttons.html5.min.js')}}"></script>
    <script type="module" src="{{asset('vendor/datatables/buttons.print.min.js')}}"></script>
    <script type="module" src="{{asset('vendor/datatables/jszip.min.js')}}"></script>
    <script type="module" src="{{asset('vendor/datatables/buttons.colVis.min.js')}}"></script>
    <script type="module" src="{{asset('vendor/datatables/buttons.print.min.js')}}"></script>
    <script type="module" src="{{asset('vendor/datatables/dataTables.rowGroup.min.js')}}"></script>
    <!--Swiper-->
    <script type="module" src="{{asset('vendor/swiper/swiper-bundle.min.js')}}"></script>
    <!-- Template Javascript -->
    <script type="module" src="{{asset('js/main.js')}}"></script>
    <script type="module" src="{{asset('vendor/xlsx/xlsx.core.min.js')}}"></script>
    <script type="module" src="{{asset('vendor/axios/axios.min.js')}}"></script>

    @vite('resources/js/app.js') @inertiaHead
  </head>

  <body class="font-sans antialiased">
    @inertia
  </body>
</html>
