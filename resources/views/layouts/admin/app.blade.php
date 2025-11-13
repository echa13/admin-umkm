<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>UMKM ADMIN</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    @include('layouts.admin.css')
</head>

<body>
    <div class="container-fluid position-relative bg-white d-flex p-0">
        <!-- Spinner Start -->
        <div id="spinner"
            class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
            <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
        <!-- Spinner End -->

        @include('layouts.admin.sidebar')

        <!-- Content Start -->
        <div class="content">
            @include('layouts.admin.navbar')

            @yield('content')

            @include('layouts.admin.footer')
        </div>
        <!-- Content End -->


        <!-- Back to Top -->
         <a href="https://wa.me/628123456789?text=Halo%20saya%20ingin%20bertanya" class="whatsapp-float" target="_blank">
            <ion-icon name="logo-whatsapp"></ion-icon>
        </a>
      </div>

    @include('layouts.admin.js')
</body>

</html>
