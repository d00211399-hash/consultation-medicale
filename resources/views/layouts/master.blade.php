<!doctype html>
<html lang="en" class="remember-theme">
  <head>
    <meta charset="utf-8">

    <meta name="viewport" content="width=device-width,initial-scale=1.0">

    <title>Consultation | @yield('title')</title>

    <meta name="description" content="OneUI - Bootstrap 5 Admin Template &amp; UI Framework created by pixelcave">
    <meta name="author" content="pixelcave">
    <meta name="robots" content="index, follow">

    <!-- Open Graph Meta -->
    <meta property="og:title" content="OneUI - Bootstrap 5 Admin Template &amp; UI Framework">
    <meta property="og:site_name" content="OneUI">
    <meta property="og:description" content="OneUI - Bootstrap 5 Admin Template &amp; UI Framework created by pixelcave">
    <meta property="og:type" content="website">
    <meta property="og:url" content="">
    <meta property="og:image" content="">

    <!-- Icons -->
    <!-- The following icons can be replaced with your own, they are used by desktop and mobile browsers -->
    <link rel="shortcut icon" href="{{ asset('assets/media/favicons/favicon.png') }}">
    <link rel="icon" type="image/png" sizes="192x192" href="{{ asset('assets/media/favicons/favicon-192x192.png') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('assets/media/favicons/apple-touch-icon-180x180.png') }} ">
    <!-- END Icons -->
    <link rel="stylesheet" id="css-main" href="{{ asset('assets/css/oneui.min.css') }}">
    @yield('CSS')

  </head>

  <body>

    <div id="page-container" class="@yield('page-class') sidebar-dark enable-page-overlay side-scroll page-header-fixed main-content-narrow">

      <!-- Sidebar -->
          <x-sidebar />
      <!-- END Sidebar -->


      <!-- Header -->
      <x-navbar />
      <!-- END Header -->

      <!-- Main Container -->
      <main id="main-container">

        @yield('content')

      </main>
      <!-- END Main Container -->

      <!-- Footer -->
      <x-footer />
      <!-- END Footer -->
    </div>
    <!-- END Page Container -->

   <script src="{{asset('/assets/js/lib/jquery.min.js')}}"></script>
   <script src="{{asset('/assets/js/oneui.app.min.js')}}"></script>

    @yield('JS')

  </body>
</html>
