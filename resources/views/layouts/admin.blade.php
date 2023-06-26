<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="/css/styles.css">
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="{{ route('admin.index') }}">MUSCLE APP</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item active">
                    <a class="nav-link" href="{{ route('admin.index') }}">{{ __('Home') }}</a>
                </li>
                @auth
                    <li class="nav-item active">
                        <a class="nav-link" href="{{ route('users.index') }}">ユーザ管理</a>
                    </li>
                    <li class="nav-item active">
                        <a class="nav-link" href="{{ route('trainings.index') }}">トレーニング種目管理</a>
                    </li>
                    <li class="nav-item active mr-auto">
                        <a href="" class="nav-link" onclick="event.preventDefault();">
                            {{ __('ユーザ名：') }}{{ Auth::user()->name }}
                        </a>
                    </li>
                    <li class="nav-item active mr-auto">
                        <a href="#" id="logout" class="nav-link">{{ __('ログアウト') }}</a>
                        <form action="{{ route('logout') }}" method="post" id="logout-form" style="display: none;">
                            @csrf
                        </form>
                    </li>
                @endauth
            </ul>
        </div>
    </nav>
    <div class="container my-5">
        @yield('content')
    </div>

    @if (Auth::check())
        <script>
            document.getElementById('logout').addEventListener('click', function(event) {
                event.preventDefault();
                document.getElementById('logout-form').submit();
            });
        </script>
    @endif

    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd"></script>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
        integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous">
    </script>
    <script src="{{ asset('js/site.js') }}"></script>
