@extends('auth.login')

@section('form')
    <div class="position-absolute" style="color: #9D9FB1; font-weight: 500; right: 25px; top: 25px"><a style="color: #5d78ff;" href="{{ route('login') }}">Авторизация</a></div>
    <div class="form-signin d-flex flex-row justify-content-center align-items-center">
        <form class="ml-lg-5" method="POST" action="{{ route('password.email') }}">
            @csrf
            <h1 class="h3 mb-3 font-weight-normal" style="color: #646c9a">{{ __('auth.Reset Password') }}</h1>
            <label for="email" class="sr-only">{{ __('auth.Confirm Password') }}</label>
            <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }} rounded" placeholder="Email адрес" name="email" required>
            @if ($errors->has('email'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('email') }}</strong>
                </span>
            @endif
            <button type="submit" class="button-submit btn-block mt-3">
                {{ __('auth.Send Password Reset Link') }}
            </button>
            @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            @endif
        </form>
    </div>
@endsection
