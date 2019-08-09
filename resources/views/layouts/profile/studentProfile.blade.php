@extends('layouts.app')

@section('content-block')
    <div class="container-fluid">
        <div class="row block-white p-3 mt-5 mt-md-3">
            <div class="col-12">
                <div class="d-flex flex-column flex-wrap justify-content-center">
                    <div class="d-flex justify-content-center mb-1">
                        <img class="rounded-circle" src="{{ asset("/storage")."/".$user->avatar }}" alt="Аватар" height="128" width="128">
                    </div>
                    <div class="d-flex justify-content-center align-items-center">
                        <div class="d-flex flex-row align-items-center">
                            <div class="d-flex flex-column justify-content-center align-items-center">
                                <h5>{{ $user->name }}</h5>
                                <h6>{{ $user->getGroup->name }}</h6>
                                <div class="d-flex flex-row icons-soc">
                                    @if($user->vk != "")<a style="color: #4a76a8" href="{{ $user->vk }}" target="_blank"><i class="fab fa-vk fa-2x"></i></a>@endif
                                    @if($user->facebook != "")<a style="color: #29487d" href="{{ $user->facebook }}" target="_blank"><i class="ml-2 fab fa-facebook fa-2x"></i></a>@endif
                                </div>
                                @if($user->status)<span>{{ $user->status }}</span>@endif
                            </div>
                        </div>
                    </div>
                    <div>
                        <span class="d-block"><strong>Email:</strong> {{ $user->email }}</span>
                        <span class="d-block"><strong>Роль:</strong> {{ $user->getRole->display_name }}</span>
                        <span class="d-block"><strong>Телефон:</strong> {{ $user->phone }}</span>
                        @if($user->city)<span class="d-block"><strong>Город:</strong> {{ $user->city }}</span>@endif
                        @if($user->about)<span class="d-block">Немного о себе: {{ $user->about }}</span>@endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection