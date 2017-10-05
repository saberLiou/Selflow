<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">

        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Raleway', sans-serif;
                font-weight: 100;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 84px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 15px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }
        </style>
    </head>
    <body>
        <div class="flex-center position-ref full-height">
            <div class="content">
                <div class="title m-b-md">
                    <b>Selflow</b>
                </div>
                <div class="body">
                    @if (Route::has('login'))
                        @auth
                            <b>{{ Auth::user()->name }}.</b>
                        @else
                            <b>Follow your self, surf the flow.</b>
                        @endauth
                    @endif
                    <br><br><br><br>
                </div>
                @if (Route::has('login'))
                    @auth
                        <b>Self</b><hr>
                            @if (Auth::user()->isAdmin())
                                <div class="links" style="padding:10px;">
                                    <a href="{{ route('admin.users.index') }}">Admin Panel</a>
                                </div>
                            @endif
                            @if (Auth::user()->isAuthor())
                                <div class="links" style="padding:10px;">
                                    <a href="{{ route('posts.create') }}">Write a post</a>
                                </div>
                            @endif
                        <div class="links" style="padding:10px;">
                            <a href="{{ route('users.index') }}">Profile</a>
                        </div>
                        <div class="links" style="padding:10px;">
                            <a href="{{ route('logout') }}"
                                onclick="event.preventDefault();
                                            document.getElementById('logout-form').submit();">
                                Logout
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                {{ csrf_field() }}
                            </form>
                        </div>
                        <br><br><b>Flow</b><hr>
                        @foreach ($categories as $category)
                            <div class="links" style="padding:10px;">
                                <a href="{{ route('home', $category->slug) }}">{{ $category->name }}</a>
                            </div>
                        @endforeach
                    @else
                        <br><br><br><br><br>
                        <div class="links">
                            <a href="{{ route('login') }}">Login</a>
                            <a href="{{ route('register') }}">Register</a>
                        </div>
                    @endauth
                @endif
            </div>
        </div>
    </body>
</html>
