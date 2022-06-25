<!doctype html>
    <html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="dns-prefetch" href="//fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">

        <!-- Styles -->
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        <link href="{{ asset('css/main.css') }}" rel="stylesheet">
        <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />

        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.12.1/b-2.2.3/b-html5-2.2.3/b-print-2.2.3/datatables.min.css"/>

     </head>
 <body class="main-bg-color">
    <div id="preloader">
        <div class="text-center">
            <div class="spinner-border text-danger" style="width: 8rem; height: 8rem;" role="status">
              <span class="sr-only">Loading...</span>
          </div>
      </div>
  </div>
  <div id="app">
    <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="#">
                <img src="{{ asset('img/oncon.png') }}" width="30" height="30" alt="">
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <!-- Left Side Of Navbar -->
                <ul class="navbar-nav mr-auto">
                    <a href="{{ url('/') }}" class="ml-5 nav-link font-weight-bold">Home</a>
                    <a href="{{ route('about') }}" class="ml-5 nav-link font-weight-bold">About Us</a>
                    {{-- <a href="{{ route('services') }}" class="ml-5 nav-link font-weight-bold">Services We Offer</a> --}}
                    <li class="nav-item dropdown">
                        <a class="ml-5 nav-link font-weight-bold dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                          Services We Offer
                      </a>
                      <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="{{ route('online') }}">Online Consultation</a>
                        <a class="dropdown-item" href="{{ route('offline') }}">Offline Consultation</a>
                    </div>
                </li>
                <a href="{{ route('contact') }}" class="ml-5 nav-link font-weight-bold">Contact Us</a>
            </ul>

            <!-- Right Side Of Navbar -->
            <ul class="navbar-nav ml-auto">
                <!-- Authentication Links -->
                @guest
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                </li>
                @if (Route::has('register'))
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                </li>
                @endif
                @else
                <li class="nav-item dropdown">
                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre style="text-transform:capitalize;">
                        {{ Auth::user()->first_name }} {{ Auth::user()->last_name }}
                    </a>

                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">

                        @if( Auth()->user()->role_id == 3 )
                        <a href="{{ route('admin.dashboard') }}" class="dropdown-item">{{ __('Admin Dashboard') }}</a>
                        @endif
                        <a href="{{ route('user.profile') }}" class="dropdown-item">{{ __('myAccount') }}</a>

                        @if( Auth()->user()->role_id != 3 )
                        <a href="{{ route('user.queries') }}" class="dropdown-item">{{ __('My Transaction') }}</a>
                        @else
                        <a href="{{ route('user.queries') }}" class="dropdown-item">{{ __('All Transaction') }}</a>
                        @endif



                        <a class="dropdown-item" href="{{ route('logout') }}"
                        onclick="event.preventDefault();
                        document.getElementById('logout-form').submit();">
                        {{ __('Logout') }}
                    </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </div>
            </li>
            @endguest
        </ul>
    </div>
</div>
</nav>

{{-- <main class="py-4">
    @yield('content')
</main> --}}
<main>
    @yield('content')
</main>
</div>

<!-- Scripts -->
{{-- <script src="{{ asset('js/app.js') }}" defer></script> --}}
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

<script src="https://unpkg.com/aos@next/dist/aos.js"></script>
<script>
    AOS.init();
</script>
@include('sweetalert::alert', ['cdn' => "https://cdn.jsdelivr.net/npm/sweetalert2@9"])

<script>
    var loader = document.getElementById("preloader")

    window.addEventListener("load", function(){
        loader.style.display = "none"
    })
</script>

<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script src="https://use.fontawesome.com/ef5b8efae4.js"></script>

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/v/bs4/dt-1.12.1/b-2.2.3/b-html5-2.2.3/b-print-2.2.3/datatables.min.js"></script>


<script>
 $(document).ready(function(){
        $('input[type="radio"]').click(function(){
            var inputValue = $(this).attr("id");
            var resoType = $("." + inputValue);
            $(".type").not(resoType).hide();
            $(resoType).show();
        });
    });
</script>

<script>
    $('table').DataTable()
</script>
@yield('scripts')
</body>
</html>
