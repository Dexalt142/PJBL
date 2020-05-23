<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
        <title>@yield('page-title', 'PJBL Siswa')</title>

        <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="{{ asset('assets/css/pjbl.css') }}">
    </head>
    <body>
        <nav class="top-navigation">
            <div class="container-fluid d-flex">
                <div>
                    <button class="btn btn-primary" id="toggle"><i class="fa fa-list"></i></button>
                </div>
                <div class="ml-auto">
                    
                    <form action="{{ url('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-primary shadow-sm"><i class="fa fa-user"></i></button>
                    </form>
                </div>
            </div>
        </nav>

        <div class="sidebar">
            <div class="sidebar-header">
                <a href="{{ url('/') }}" class="sidebar-brand">PJBL</a>
            </div>

            <ul class="sidebar-menu">
                <li class="sidebar-item">
                    <a href=""><i class="fa fa-home"></i> Dashboard</a>
                </li>
                <li class="sidebar-item">
                    <a href=""><i class="fa fa-cube"></i> Kelas</a>
                </li>
            </ul>
        </div>
        
        <div id="content">
            @yield('content')
        </div>

        <script src="{{ asset('assets/js/jquery-3.5.1.min.js') }}"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
        <script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
        <script>
            $("#toggle").on('click', function() {
                $('.sidebar').toggleClass('show');
                $('.top-navigation').toggleClass('shrink');
                $('#content').toggleClass('shrink');
            })
        </script>

        @yield('scripts')
    </body>
</html>