<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Learning Cisco Emulation - Вход</title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <style>
        .button-submit {
            font-size: 0.8rem;
            background: #646c9a;
            color: #fff;
            border: 1px solid #646c9a;
            border-radius: 3px;
            padding: 7px 13px;
            font-weight: 700;
        }

        .button-submit:hover {
            cursor: pointer;
            font-size: 0.8rem;
            color: #ffffff;
            background-color: #5d78ff !important;
            border: 1px solid #5d78ff;
            border-radius: 3px;
            padding: 7px 13px;
            transition: all 0.3s;
        }
    </style>

    @section('css')
    <link href="{{ asset('css/login.css') }}" rel="stylesheet">
    @show
</head>
<body class="text-center">
@section('form')
    <div class="position-absolute" style="color: #9D9FB1; font-weight: 500; right: 25px; top: 25px">Нет аккаунта? <a style="color: #5d78ff;" href="{{ route('register') }}">Регистрация</a></div>
    <div class="form-signin d-flex flex-row justify-content-center align-items-center">
        <form class="ml-lg-5" method="POST" action="{{ route('login') }}">
            @csrf
            <h1 id="site-name" class="h3 mb-3 font-weight-normal" style="color: #5d78ff">Learning Cisco Emulation</h1>
            <h1 class="h3 mb-3 font-weight-normal" style="color: #646c9a">Пожалуйста, войдите.</h1>
            <label for="inputEmail" class="sr-only">Email адрес</label>
            <input name="email" type="email" id="inputEmail" autocomplete="off" class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }}" placeholder="Email адрес" value="{{ old('email') }}" required autofocus>
            <label for="inputPassword" class="sr-only">Пароль</label>
            <input name="password" type="password" id="inputPassword" class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }}" placeholder="Пароль" required>
            @if ($errors->has('email'))
                <span class="invalid-feedback mb-2" role="alert">
                    <strong>{{ $errors->first('email') }}</strong>
                </span>
            @endif
            <div class="custom-control custom-checkbox mb-2">
                <input name="remember" id="remember" type="checkbox" class="custom-control-input" value="remember-me" {{ old('remember') ? 'checked' : '' }}>
                <label class="custom-control-label" for="remember"> {{ __('auth.Remember Me') }}</label>
            </div>
            <button class="button-submit btn-block" type="submit">Войти</button>
            @if (Route::has('password.request'))
                <a style="color: #9D9FB1; font-weight: 500;" class="mt-2 d-inline-block" href="{{ route('password.request') }}">
                    {{ __('auth.Forgot Your Password?') }}
                </a>
            @endif
        </form>
        <div class="d-none d-md-block">
            <img style="width: 100%; max-width: 360px;" class="ml-5" src="{{ asset('svg/bg_login.svg') }}" alt="Фон">
        </div>
        @show
    </div>
</body>
</html>
