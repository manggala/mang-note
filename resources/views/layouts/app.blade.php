<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Mang-Notes</title>

    <!-- Styles -->
    <link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!--Import materialize.css-->
    <link type="text/css" rel="stylesheet" href="{{asset('materialize/css/materialize.min.css')}}"  media="screen,projection"/>
    <!--Let browser know website is optimized for mobile-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>

    <!-- Scripts -->
    <style type="text/css">
        body{
            background-color: rgb(250,250,250);
        }
        .brand-logo{
            font-size: 1.5rem !important;
        }
        .brand-prefix{
            color: #ff5;
        }
        @media screen and (min-height: 200px){
            .container {
                margin-top: 64px;
            }
            .unauth{
                margin-top: 20vh;
            }
            .panel {
                background-color: #fff;
                margin: -15px;
                padding: 15px;
                border-radius: 2px;
                box-shadow: 0px 3px 5px rgb(230,230,230);
            }
        }
    </style>
    <script>
        window.Laravel = {!! json_encode([
            'csrfToken' => csrf_token(),
        ]) !!};
    </script>
    @yield('custom-head')
</head>
<body>
    <div id="app">
        <nav class="yellow darken-2">
            <div class="nav-wrapper">
                <a href="{{ url('/') }}" class="brand-logo"><span class="brand-prefix">Mang</span>-Notes</a>
                <ul id="nav-mobile" class="right hide-on-med-and-down">
                    @if (Auth::guest())
                        <li><a href="{{ route('login') }}">Login</a></li>
                        <li><a href="{{ route('register') }}">Register</a></li>
                    @else
                        <li>
                            <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                Logout
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">{{ csrf_field() }}</form>
                        </li>
                    @endif
                </ul>
            </div>
        </nav>

        @yield('content')
    </div>
    <div class="fixed-action-btn">
    <a class="btn-floating btn-large red">
    <i class="large material-icons">add</i>
    </a>
    <ul>
        <li>
            <a href="#basicModal" class="modal-trigger btn-floating tooltipped yellow" data-position="bottom" data-delay="50" data-tooltip="Add Label">
                <i class="material-icons">turned_in_not</i>
            </a>
        </li>
        <li>
              <a href="#basicModal" class="modal-trigger btn-floating tooltipped orange" data-position="bottom" data-delay="50" data-tooltip="Add Notes">
                <i class="material-icons">assignment</i>
            </a>
        </li>
    </ul>
    </div>
    @include('layouts.modals')
    <!-- Scripts -->
    <script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
    <script type="text/javascript" src="{{asset('materialize/js/materialize.min.js')}}"></script>
    <script type="text/javascript">
        $('.modal').modal();
    </script>
    @yield('custom-footer')
</body>
</html>
