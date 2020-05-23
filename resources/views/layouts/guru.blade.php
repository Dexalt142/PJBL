<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
        <title>@yield('page-title', 'PJBL Guru')</title>

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
                @endif
                <div class="ml-auto">
                    
                    <form action="{{ url('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-link">{{ (auth()->user()->detail) ? auth()->user()->detail->nama_lengkap : 'Logout' }} <span class="fa fa-chevron-down"></span></button>
                    </form>
                </div>
            </div>
        </nav>

        @if (auth()->user()->detail)            
            <div class="sidebar">
                <div class="sidebar-header">
                    <a href="{{ route('guru-dashboard') }}" class="sidebar-brand">PJBL</a>
                </div>

                <ul class="sidebar-menu">
                    <li class="sidebar-item">
                        <a href="{{ route('guru-dashboard') }}"><i class="material-icons">dashboard</i> Dashboard</a>
                    </li>
                    <li class="sidebar-item">
                        <a href=""><i class="fa fa-cube"></i> Kelas</a>
                    </li>
                    <li class="sidebar-item">
                        <a href="{{ route('guru-project') }}"><i class="fa fa-cube"></i> Project</a>
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
        @if (auth()->user()->detail)
            <script>
                $(document).ready(function() {
                    if($(window).width() >= 960) {
                        toggleSidebar();
                    }
                });

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