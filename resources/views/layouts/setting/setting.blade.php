@extends('layouts.app')

@section('content-block')
    <div class="container-fluid">
        <div class="row block-white p-3 mt-5 mt-md-3">
            <div class="w-100">
                <div class="d-flex flex-column flex-lg-row">
                    <div class="col-12 col-lg-6">
                        <form action="{{ route('setting.about') }}" method="post">
                            @csrf
                            <div class="form-group">
                                <label for="city">Город</label>
                                <input type="text" class="form-control @if($errors->has('city')) is-invalid @endif" name="city" placeholder="Введите ваш город" value="{{ Auth::user()->city }}">
                                @if ($errors->has('city'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('city') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="status">Статус</label>
                                <input type="text" class="form-control @if($errors->has('status')) is-invalid @endif" name="status" placeholder="Введите статус" value="{{ Auth::user()->status }}">
                                @if ($errors->has('status'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('status') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <button type="submit" class="button-submit col-12 col-sm-4 col-md-4 col-lg-4 form-control @if(Session::has('success-about')) is-valid @endif">Сохранить</button>
                            @if (Session::has('success-about'))
                                <span class="valid-feedback">
                                    <strong>{!! Session::get('success-about') !!}</strong>
                                </span>
                            @endif
                        </form>
                        <form class="mt-3" action="{{ route('setting.social') }}" method="post">
                            @csrf
                            <div class="form-group">
                                <label for="city"><div class="d-flex align-items-center">Вконтакте <i class="fab fa-vk fa-lg ml-1" data-toggle="tooltip" title="Ссылка VK" data-placement="right"></i></div></label>
                                <input type="text" class="form-control @if($errors->has('vk')) is-invalid @endif" name="vk" placeholder="Ссылка на ваш профиль Вконтакте" value="{{ Auth::user()->vk }}">
                                @if ($errors->has('vk'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('vk') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="about"><div class="d-flex align-items-center">Facebook <i class="fab fa-facebook fa-lg ml-1" data-toggle="tooltip" title="Ссылка Facebook" data-placement="right"></i></div></label>
                                <input type="text" class="form-control @if($errors->has('facebook')) is-invalid @endif" name="facebook" placeholder="Ссылка на ваш профиль Facebook" value="{{ Auth::user()->facebook }}">
                                @if ($errors->has('facebook'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('facebook') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <button type="submit" class="button-submit col-12 col-sm-4 col-md-4 col-lg-4 form-control @if(Session::has('success-social')) is-valid @endif">Сохранить</button>
                            @if (Session::has('success-social'))
                                <span class="valid-feedback">
                                    <strong>{!! Session::get('success-social') !!}</strong>
                                </span>
                            @endif
                        </form>
                        <div class="mt-2">
                            <span class="font-weight-bold">Ваш текущий аватар:</span>
                            <div class="mt-2">
                                <img class="rounded" src="{{ asset("/storage")."/".Auth::user()->avatar }}" alt="Аватар" height="128" width="128">
                            </div>
                        </div>
                        <form class="mt-3" action="{{ route('setting.avatar') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="custom-file">
                                <input id="input-file" type="file" name="image" class="form-control custom-file-input @if($errors->has('image')) is-invalid @elseif (Session::has('success-avatar')) is-valid @endif" id="customFile">
                                <label id="label-file" class="overflow-hidden custom-file-label" for="customFile">Выбрать аватар</label>
                                @foreach($errors->all() as $message)
                                    <span class="invalid-feedback">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @endforeach
                                @if (Session::has('success-avatar'))
                                    <span class="valid-feedback">
                                        <strong>{!! Session::get('success-avatar') !!}</strong>
                                    </span>
                                @endif
                            </div>
                            <button type="submit" class="d-block button-submit mt-2 col-12 col-sm-4 col-lg-4">Загрузить</button>
                        </form>
                    </div>
                    <div class="col-12 col-lg-6 mt-2 mt-lg-0">
                        <span class="group-name">Смена пароля:</span>
                        <form role="form" method="POST" action="{{ route('setting.change.password') }}" class="form-horizontal mt-2">
                            <label for="current-password" class="control-label">Текущий пароль</label>
                            <div class="form-group">
                                @csrf
                                <input type="password" class="form-control @if($errors->has('current-password')) is-invalid @endif" name="current-password" placeholder="Текущий пароль">
                                @foreach($errors->get('current-password') as $message)
                                    <span class="invalid-feedback">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @endforeach
                            </div>
                            <label for="password" class="control-label">Новый пароль</label>
                            <div class="form-group">
                                <input type="password" class="form-control @if($errors->has('password')) is-invalid @endif" name="password" placeholder="Новый пароль">
                                @foreach($errors->get('password') as $message)
                                    <span class="invalid-feedback">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @endforeach
                            </div>
                            <label for="password_confirmation" class="control-label">Повторите пароль</label>
                            <div class="form-group">
                                <input type="password" class="form-control @if($errors->has('password_confirmation')) is-invalid @endif" name="password_confirmation" placeholder="Повторите новый пароль">
                                @foreach($errors->get('password_confirmation') as $message)
                                    <span class="invalid-feedback">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @endforeach
                            </div>
                            <button type="submit" class="button-submit col-12 col-sm-4 form-control @if (Session::has('success-new-password')) is-valid @endif">Поменять пароль</button>
                            @if (Session::has('success-new-password'))
                                <span class="valid-feedback">
                                    <strong>{!! Session::get('success-new-password') !!}</strong>
                                </span>
                            @endif
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    @parent
    <script type="text/javascript">
        $('#input-file').on('change', function() {
            var file = this.files[0];
            $('#label-file').html(file.name);
        });
    </script>
@endsection