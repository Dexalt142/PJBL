<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
        <title>@yield('page-title', 'PJBL Siswa')</title>

        <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <link rel="stylesheet" href="{{ asset('assets/css/pjbl.css') }}">
    </head>
    <body>
        <nav class="top-navigation">
            <div class="container-fluid d-flex">
                @if (auth()->user()->detail)
                <div>
                    <button class="btn btn-link" id="toggle"><span class="material-icons">menu</span></button>
                </div>
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">{{ auth()->user()->detail->nama_lengkap }}</a>
                        <div class="dropdown-menu account-dropdown mr-2">
                            <div class="profile">
                                <div class="picture">
                                    <img src="{{ (auth()->user()->profile_picture) ? asset('profile_pictures/'.auth()->user()->profile_picture) : asset('assets/img/profile_picture.png') }}" alt="">
                                </div>
                                <div class="content">
                                    <div class="nama">{{ (strlen(auth()->user()->detail->nama_lengkap) >= 15) ? substr(auth()->user()->detail->nama_lengkap, 0, 15).'...' : auth()->user()->detail->nama_lengkap }}</div>
                                    <div class="email">{{ auth()->user()->email }}</div>
                                    <div class="title"><span class="badge badge-primary">{{ ucfirst(auth()->user()->user_type) }}</span></div>
                                </div>
                            </div>

                            <a href="{{ route('siswa-profile') }}" class="dropdown-item"><ion-icon name="person-circle-outline"></ion-icon> Profile</a>

                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="dropdown-item"><ion-icon name="power-outline"></ion-icon> Logout</button>
                            </form>
                        </div>
                    </li>
                </ul>
                @else
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-link">Logout</button>
                    </form>
                @endif
            </div>
        </nav>


        @if (auth()->user()->detail)            
            <div class="sidebar">
                <div class="sidebar-header">
                    <a href="{{ route('siswa-dashboard') }}" class="sidebar-brand">PJBL</a>
                </div>

                <ul class="sidebar-menu">
                    <li class="sidebar-item">
                        <a href="{{ route('siswa-dashboard') }}"><ion-icon name="home-outline"></ion-icon> Dashboard</a>
                    </li>
                    <li class="sidebar-item">
                        <a href="{{ route('siswa-kelas') }}"><ion-icon name="cube-outline"></ion-icon> Kelas</a>
                    </li>
                    <li class="sidebar-item">
                        <a href="{{ route('siswa-project') }}"><ion-icon name="albums-outline"></ion-icon> Project</a>
                    </li>
                </ul>
            </div>
        @endif
        
        <div id="content">
            <div class="content-header container-fluid">
                <span class="content-title">@yield('page-header')</span>
                <div>
                    <ol class="breadcrumb">
                        @yield('breadcrumb')
                    </ol>
                </div>
            </div>

            @yield('content')
        </div>
        
        <script src="{{ asset('assets/js/jquery-3.5.1.min.js') }}"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
        <script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
        <script src="https://unpkg.com/ionicons@5.0.0/dist/ionicons.js"></script>

        @if (auth()->user()->detail)
            <script>
                $(document).ready(function() {
                    if($(window).width() >= 960) {
                        toggleSidebar();
                    }
                });

                $(window).resize(function() {
                    if($(this).width() >= 960) {
                        $('.sidebar').addClass('show');
                        $('.top-navigation').addClass('shrink');
                        $('#content').addClass('shrink');
                    } else {
                        $('.sidebar').removeClass('show');
                        $('.top-navigation').removeClass('shrink');
                        $('#content').removeClass('shrink');
                    }
                })

                $("#toggle").on('click', function() {
                    toggleSidebar();
                })

                function toggleSidebar() {
                    $('.sidebar').toggleClass('show');
                    $('.top-navigation').toggleClass('shrink');
                    $('#content').toggleClass('shrink');
                }
            </script>      
        @endif

        @yield('scripts')
    </body>
</html>