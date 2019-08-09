<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Learning Cisco Emulation</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.0/css/all.css" integrity="sha384-Mmxa0mLqhmOeaE8vgOSbKacftZcsNYDjQzuCOm6D02luYSzBG8vpaOykv9lFQ51Y" crossorigin="anonymous">
    <link href="{{ asset('css/main.css') }}" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}" type="text/css">
</head>
<body>
<nav class="navbar navbar-dark fixed-top bg-dark flex-md-nowrap p-0 shadow" style="background-color: #1f2433 !important;">
    <a class="navbar-brand col-md-3 col-lg-3 col-xl-2 mr-0 text-center" href="{{ route('home') }}">Learning Cisco Emulation</a>
    <ul class="navbar-nav px-3 pt-2 pb-2 pt-md-0 pb-md-0">
        @if (Route::has('login'))
            <div class="top-right links d-flex flex-row">
                @auth
                    <li class="nav-item">
                        <span style="color: #fff" class="mr-3 d-md-none" id="menu-button">Меню</span>
                    </li>
                    <li class="nav-item text-nowrap">
                        <a class="mr-3" href="{{ route('profile.my') }}">Профиль</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('logout') }}"
                           onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                            {{ __('auth.Logout') }}
                        </a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </li>
                @else
                    <li class="nav-item text-nowrap mr-3">
                        <a href="{{ route('login') }}">{{ __('auth.Login') }}</a>
                    </li>
                    <li class="nav-item text-nowrap">
                        <a href="{{ route('register') }}">{{ __('auth.SingUp') }}</a>
                    </li>
                @endauth
            </div>
        @endif
    </ul>
</nav>
<div class="container-fluid">
    <div class="row">
        @section('sidebar')
            @if (Auth::check())
            <nav id="menu" class="mt-3 mt-md-0 col-md-3 col-lg-3 col-xl-2 d-none d-md-block sidebar">
                <div class="sidebar-sticky">
                    <div class="p-3">
                        <div class="profile-info d-flex flex-column flex-wrap justify-content-center">
                            <div class="profile-avatar d-flex justify-content-center mb-1">
                                <img class="rounded-circle" src="{{ asset("/storage")."/".Auth::user()->avatar }}" alt="Аватар" height="64" width="64">
                            </div>
                            <div class="profile-name-email d-flex justify-content-center align-items-center">
                                <div class="d-flex flex-row align-items-center">
                                    <div class="d-flex flex-column justify-content-center align-items-center">
                                        <span>{{ Auth::user()->name }}</span>
                                        <span>{{ Auth::user()->getGroup->name }}</span>
                                        <span>{{ Auth::user()->email }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="profile-icon mt-4 d-flex flex-row justify-content-center align-items-center pl-xl-4 pr-xl-4" style="margin-top: 15px">
                            <span data-toggle="tooltip" data-placement="top" title="Уведомления"><a href="{{ route('notices.index') }}"><svg class="svg-profile" xmlns="http://www.w3.org/2000/svg" x="0px" y="0px"
                                       width="24" height="24"
                                       viewBox="0 0 24 24"
                                       style=" fill:#e4e2f4;"><path d="M 4 3 C 2.9 3 2 3.9 2 5 L 2 17 L 5 14 L 14 14 C 15.1 14 16 13.1 16 12 L 16 5 C 16 3.9 15.1 3 14 3 L 4 3 z M 18 8 L 18 12 C 18 14.206 16.206 16 14 16 L 8 16 L 8 17 C 8 18.1 8.9 19 10 19 L 19 19 L 22 22 L 22 10 C 22 8.9 21.1 8 20 8 L 18 8 z"></path></svg></a></span>
                            <span class="ml-5" data-toggle="tooltip" data-placement="top" title="Настройки"><a href="{{ route('setting.profile') }}"><svg class="svg-profile" xmlns="http://www.w3.org/2000/svg" x="0px" y="0px"
                                       width="24" height="24"
                                       viewBox="0 0 24 24"
                                       style=" fill:#e4e2f4;"><path d="M 11.423828 2 C 11.179828 2 10.969688 2.1769687 10.929688 2.4179688 L 10.646484 4.1230469 C 10.159736 4.2067166 9.689176 4.3360771 9.2363281 4.5039062 L 8.1347656 3.1679688 C 7.9797656 2.9789688 7.7100469 2.9297344 7.4980469 3.0527344 L 6.5019531 3.6289062 C 6.2899531 3.7509062 6.1972031 4.0083281 6.2832031 4.2363281 L 6.8886719 5.8535156 C 6.513238 6.1663963 6.1663963 6.513238 5.8535156 6.8886719 L 4.2363281 6.2832031 C 4.0083281 6.1972031 3.7509062 6.2899531 3.6289062 6.5019531 L 3.0527344 7.4980469 C 2.9297344 7.7100469 2.9789688 7.9797656 3.1679688 8.1347656 L 4.5039062 9.2363281 C 4.3360771 9.689176 4.2067166 10.159736 4.1230469 10.646484 L 2.4179688 10.929688 C 2.1769687 10.970688 2 11.178828 2 11.423828 L 2 12.576172 C 2 12.820172 2.1769687 13.030312 2.4179688 13.070312 L 4.1230469 13.353516 C 4.2067166 13.840264 4.3360771 14.310824 4.5039062 14.763672 L 3.1679688 15.865234 C 2.9789687 16.020234 2.9307344 16.289953 3.0527344 16.501953 L 3.6289062 17.498047 C 3.7509062 17.710047 4.0083281 17.802797 4.2363281 17.716797 L 5.8535156 17.111328 C 6.1663963 17.486762 6.513238 17.833604 6.8886719 18.146484 L 6.2832031 19.763672 C 6.1972031 19.992672 6.2909531 20.249094 6.5019531 20.371094 L 7.4980469 20.947266 C 7.7100469 21.069266 7.9797656 21.020031 8.1347656 20.832031 L 9.234375 19.496094 C 9.6877476 19.664236 10.15912 19.793178 10.646484 19.876953 L 10.929688 21.582031 C 10.970688 21.823031 11.178828 22 11.423828 22 L 12.576172 22 C 12.820172 22 13.030312 21.823031 13.070312 21.582031 L 13.353516 19.876953 C 13.840264 19.793283 14.310824 19.663923 14.763672 19.496094 L 15.865234 20.832031 C 16.020234 21.021031 16.289953 21.069266 16.501953 20.947266 L 17.498047 20.371094 C 17.710047 20.249094 17.802797 19.991672 17.716797 19.763672 L 17.111328 18.146484 C 17.486762 17.833604 17.833604 17.486762 18.146484 17.111328 L 19.763672 17.716797 C 19.992672 17.802797 20.249094 17.709047 20.371094 17.498047 L 20.947266 16.501953 C 21.069266 16.289953 21.020031 16.020234 20.832031 15.865234 L 19.496094 14.765625 C 19.664236 14.312252 19.793178 13.84088 19.876953 13.353516 L 21.582031 13.070312 C 21.823031 13.029312 22 12.821172 22 12.576172 L 22 11.423828 C 22 11.179828 21.823031 10.969688 21.582031 10.929688 L 19.876953 10.646484 C 19.793283 10.159736 19.663923 9.689176 19.496094 9.2363281 L 20.832031 8.1347656 C 21.021031 7.9797656 21.069266 7.7100469 20.947266 7.4980469 L 20.371094 6.5019531 C 20.249094 6.2899531 19.991672 6.1972031 19.763672 6.2832031 L 18.146484 6.8886719 C 17.833604 6.513238 17.486762 6.1663963 17.111328 5.8535156 L 17.716797 4.2363281 C 17.802797 4.0073281 17.709047 3.7509062 17.498047 3.6289062 L 16.501953 3.0527344 C 16.289953 2.9307344 16.020234 2.9799687 15.865234 3.1679688 L 14.765625 4.5039062 C 14.312252 4.3357635 13.84088 4.2068225 13.353516 4.1230469 L 13.070312 2.4179688 C 13.029312 2.1769687 12.821172 2 12.576172 2 L 11.423828 2 z M 11 6.0898438 L 11 9.1738281 A 3 3 0 0 0 9 12 A 3 3 0 0 0 9.0507812 12.548828 L 6.3789062 14.089844 C 6.1382306 13.438833 6 12.736987 6 12 C 6 9.0161425 8.1553612 6.5637988 11 6.0898438 z M 13 6.0898438 C 15.844639 6.5637988 18 9.0161425 18 12 C 18 12.737875 17.86037 13.440133 17.619141 14.091797 L 14.947266 12.546875 A 3 3 0 0 0 15 12 A 3 3 0 0 0 13 9.1757812 L 13 6.0898438 z M 13.947266 14.277344 L 16.628906 15.826172 C 15.530388 17.156023 13.868625 18 12 18 C 10.131375 18 8.4696124 17.156023 7.3710938 15.826172 L 10.050781 14.279297 A 3 3 0 0 0 12 15 A 3 3 0 0 0 13.947266 14.277344 z"></path></svg></a></span>
                        </div>
                    </div>
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <hr class="mr-3 ml-3 mt-0">
                            <a class="nav-link" href="{{ route('theory.index') }}">
                                <span class="ml-3" style="padding-left: 2px;"><i class="far fa-file-word fa-lg"></i></span>
                                <span class="menu-text">Теория</span>
                            </a>
                            <a class="nav-link" href="{{ route('labs') }}">
                                <span class="ml-3"><i class="fas fa-flask fa-lg"></i></span>
                                <span class="menu-text">Лабораторные работы</span>
                            </a>
                            <a class="nav-link" href="{{ route('tests.index') }}">
                                <span class="ml-3"><i class="fas fa-cubes fa-lg"></i></span>
                                <span class="menu-text">Тестирование</span>
                            </a>
                            @if (Auth::user()->role_id == 2 || Auth::user()->role_id == 1)
                            <hr class="mr-3 ml-3">
                            <a class="nav-link" href="{{ route('groups.my') }}">
                                <span class="ml-3"><i class="fas fa-layer-group fa-lg"></i></span>
                                <span class="menu-text">Моя группа</span>
                            </a>
                            <a class="nav-link" href="{{ route('scores.index') }}">
                                <span class="ml-3"><i class="far fa-grimace fa-lg"></i></span>
                                <span class="menu-text">Оценки</span>
                            </a>
                            <a class="nav-link" href="{{ route('filelab') }}">
                                <span class="ml-3"><i class="fas fa-cloud-upload-alt"></i></span>
                                <span class="menu-text">Загрузить работу</span>
                            </a>
                            @endif
                            <hr class="mr-3 ml-3">
                            <a class="nav-link" href="{{ route('comments.index') }}">
                                <span class="ml-3"><i class="far fa-comment fa-lg"></i></span>
                                <span class="menu-text">Комментарии</span>
                            </a>
                            @if (Auth::user()->role_id == 3 || Auth::user()->role_id == 1)
                                @if (Auth::user()->role_id == 1)
                                    <hr class="mr-3 ml-3">
                                    <span class="ml-3" style="font-size: 12px; color: #b4b8c5; padding-left: 16px">Преподаватель</span>
                                @endif
                                <a class="nav-link" href="{{ route('groups.teacher') }}">
                                    <span class="ml-3"><i class="fas fa-user-friends"></i></span>
                                    <span class="menu-text">Мои группы</span>
                                </a>
                            @endif
                        </li>
                    </ul>
                    <div class="footer-info d-flex flex-column">
                        @if (Auth::user()->role_id == 1)
                        <span class="ml-4"><a href="{{ route('voyager.dashboard') }}" target="_blank">Панель управления</a></span>
                        @endif
                        <span class="ml-4"><a href="{{ route('feedback') }}">Обратная связь</a></span>
                    </div>
                </div>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarToggleExternalContent" aria-controls="navbarToggleExternalContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
            </nav>
            @endif
        @show

        @section('content')
            <main role="main" class="col-md-9 ml-md-auto col-lg-9 col-xl-10 px-4 mb-3">
                @section('content-block')
                    <div class="block-white p-4 mt-5 mt-md-3 d-flex justify-content-center">
                        <div class="main-hello">Cisco Learning Emulation — ценные практические навыки в области сетевых технологий</div>
                    </div>
                @show
            </main>
        @show
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.3.1.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
@section('script')
    <script type="text/javascript">
        $(function () {
            $('[data-toggle="tooltip"]').tooltip()
        });
        $(".nav-link").hover(
            function() {
                $(this).children().children().css("color", "#5d78ff");
                $(this).children(".menu-text").css("color", "#fff");
            }, function() {
                $(this).children().children().css("color", "#434d6b");
                $(this).children(".menu-text").css("color", "#b4b8c5");
            }
        );
        $( document ).ready(function() {
            $.ajax({
                url: '{{ route('notices.check') }}',
                dataType: 'JSON',
                success: function (data) {
                    const notices = $(".profile-icon > span");
                    if (data.count > 0) {
                        notices.toggleClass('changed');
                    } else {
                        notices.toggleClass('');
                    }
                }
            });
        });
        $("#menu-button").click(function () {
            $("#menu").toggleClass("d-none");
        });
    </script>
@show
</body>
</html>
