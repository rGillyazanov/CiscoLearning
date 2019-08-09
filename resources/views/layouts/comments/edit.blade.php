@extends('layouts.app')

@section('content-block')
    <div class="container-fluid">
        <div class="row mt-3 block-white p-3">
            <div class="col-12 pl-0 pr-0">
                <div class="card">
                    <div class="card-header">
                        Редактирование комментария
                    </div>
                    <div class="card-body">
                        @if ($errors->any())
                            <div class="alert alert-danger mb-0">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <form method="post" action="{{ route('comments.update', $comment->id) }}">
                            @method('PATCH')
                            @csrf
                            <div class="form-group">
                                <label for="name">Текст комментария:</label>
                                <input type="text" class="form-control col-12 rounded @if (Session::has('success')) is-valid @endif" name="comment_text" value="{!! $comment->text !!}"/>
                                @if (Session::has('success'))
                                    <span class="valid-feedback">
                                        <strong>{!! Session::get('success') !!}</strong>
                                    </span>
                                @endif
                            </div>
                            <button type="submit" class="btn btn-primary">Обновить</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection