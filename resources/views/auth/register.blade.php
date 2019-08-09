@extends('auth.login')

@section('css')
    <link href="{{ asset('css/register.css') }}" rel="stylesheet">
@endsection

@section('form')
    <div class="form-signin d-flex flex-row justify-content-center align-items-center">
        <form class="ml-lg-5" method="POST" action="{{ route('register') }}">
            @csrf
            <h1 class="h3 mb-3 font-weight-normal" style="color: #646c9a">Регистрация пользователя</h1>
            <label for="name" class="sr-only">{{ __('auth.Name') }}</label>
            <input id="name" name="name" type="text" autocomplete="off" class="form-control {{ $errors->has('name') ? ' is-invalid' : '' }}" placeholder="Фамилия Имя Отчество" value="{{ old('name') }}" required>
            <label for="email" class="sr-only">{{ __('auth.E-Mail Address') }}</label>
            <input name="email" type="email" autocomplete="off" class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }}" value="{{ old('email') }}" placeholder="Email адрес" required>
            <label for="phone" class="sr-only">{{ __('auth.Phone') }}</label>
            <input id="phone" type="text" autocomplete="off" class="form-control{{ $errors->has('phone') ? ' is-invalid' : '' }}" placeholder="Телефон" name="phone" value="{{ old('phone') }}" required>
            <label for="group" class="sr-only">{{ __('auth.Group') }}</label>
            <select name="group" class="form-control{{ $errors->has('group') ? ' is-invalid' : '' }}" required>
                @foreach ($groups as $group)
                    <option value="{{ $group->id }}">{{ $group->name }}</option>
                @endforeach
            </select>
            <label for="password" class="sr-only">{{ __('auth.Password') }}</label>
            <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" placeholder="Пароль" name="password" required>
            <label for="password-confirm" class="sr-only">{{ __('auth.Confirm Password') }}</label>
            <input id="password-confirm" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" placeholder="Подтвердите пароль" name="password_confirmation" required>
            @foreach ($errors->all() as $message)
                <span class="invalid-feedback mt-0 mb-2" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @endforeach
            <button type="submit" class="button-submit btn-block">
                {{ __('auth.Register') }}
            </button>
            <div class="mt-2" style="color: #9D9FB1; font-weight: 500;">Есть аккаунта? <a style="color: #5d78ff;" href="{{ route('login') }}">Войти</a></div>
        </form>
        <div class="d-none d-md-block">
            <img style="width: 100%; max-width: 360px;" class="ml-5 mt-2" src="{{ asset('svg/register.png') }}" alt="Фон">
        </div>
    </div>
@endsection
