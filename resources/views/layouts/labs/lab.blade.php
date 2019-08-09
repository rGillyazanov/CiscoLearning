@extends('layouts.app')

@section('content-block')
    <div class="container-fluid">
        <div class="row mt-5 mt-md-4">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 block-white p-4 mb-3">
                <div class="title-block">
                    <h3 class="mb-2">{{ $lab->name }}</h3>
                    <div class="row d-flex flex-row">
                        <div class="ml-3 pt-1 pb-1 pr-3 border-right" style="font-size: 0.95rem">{{ Date::parse($lab->created_at)->format('d F, Y') }}</div>
                        <div class="pt-1 pb-1 pl-3 pr-3 border-right" style="font-size: 0.95rem">{{ $lab->getUser->getRole->display_name }}</div>
                        <div class="pt-1 pb-1 pl-3" style="font-size: 0.95rem">{{ count($comments) }} {{ Lang::choice('комментарий|комментария|комментариев', count($comments), [], 'ru') }}</div>
                    </div>
                </div>
                <div class="d-flex justify-content-center mx-auto mt-4 mb-4">
                    <img class="img-thumbnail" style="height: 300px !important;" src="{{ asset('/storage').'/'.$lab->image }}">
                </div>
                <div class="practical-description">{!! $lab->body !!}</div>
                <div class="d-inline-flex flex-column">
                    <span class="mb-2">Файл лабораторной работы: <a href="{{ asset('storage/'.$file) }}" download="{{ $fileName }}">скачать</a></span>
                    @if ($checkStartLab == 0 && Auth::user()->role_id != 3)
                        <form action="{{ route('add.in.profile') }}" method="post">
                            @csrf
                            <input type="hidden" name="labId" value="{{ $lab->id }}">
                            <button class="button-submit form-control" type="submit">Добавить лабораторную работу в профиль</button>
                        </form>
                    @endif
                    @if (Session::has('success-add'))
                        <div class="alert alert-success mb-0">
                            {!! Session::get('success-add') !!}
                        </div>
                    @endif
                </div>
                <div class="d-flex flex-row align-items-center mt-3 mb-3"><img class="rounded-circle mr-2" src="{{ asset("/storage")."/".$lab->getUser->avatar }}" height="32" width="32" alt="Аватар"><a class="link-text" href="{{ route('student.profile', $lab->getUser->id) }}">{{ $lab->getUser->name }}</a>, <span class="ml-1" style="color: #646c9a">Автор</span></div>
                @if(count($comments) > 0)
                <!-- Комментарии -->
                    <h5 id="comments">{{ count($comments) }} {{ Lang::choice('комментарий|комментария|комментариев', count($comments), [], 'ru') }}</h5>

                    @set($com, $lab->getComments->groupBy('parent'))
                    <div class="comments">
                        @foreach($com as $k => $comment)

                            @if ($k !== 0)
                                @break
                            @endif

                            @include('layouts.comments.comment', ['items' => $comment])

                        @endforeach
                    </div>
                @endif

                @if(Auth::check())
                    <form action="{{ route('comments.store') }}" method="POST" class="mt-3">
                        @csrf
                        <input type="hidden" id="comment_lab_id" name="comment_lab_id" value="{{ $lab->id }}">
                        <input type="hidden" id="comment_parent" name="comment_parent" value="0">

                        <label for="comment" id="answer">Написать комментарий: <span id="length-comment" data-toggle="tooltip" title="Длина сообщения" data-placement="top">500</span><span id="clear" style="color: red" class="ml-1" data-toggle="tooltip" title="Отменить ответ" data-placement="top"></span></label>
                        <textarea placeholder="Введите текст комментария" name="comment_text" style="overflow: auto; resize: none;" class="form-control col-12 rounded{{ $errors->has('comment_text') ? ' is-invalid' : Session::has('success') ? ' is-valid' : ''}}" id="comment-text" rows="4" cols="5"></textarea>
                        @foreach($errors->all() as $message)
                            <span class="invalid-feedback">
                                <strong>{{ $message }}</strong>
                            </span>
                        @endforeach
                        @if (Session::has('success'))
                            <span class="valid-feedback">
                                <strong>{!! Session::get('success') !!}</strong>
                            </span>
                        @endif
                        <button type="submit" class="button-submit mb-2 mt-2">Отправить</button>
                    </form>
                @endif
            </div>
        </div>
    </div>
@endsection

@section('script')
    @parent
    <script type="text/javascript">
        $('.media-body').each(function (i) {
            $(this).find('span.comment-number').html(' — #' + (i + 1));
        });

        $('.reply a').click(function () {
            $('#comment_parent').val($(this).attr('id'));
            $('#clear').text('✖');
        });

        $('#clear').click(function () {
            $('#comment_parent').val(0);
            $('#clear').text('');
        });

        $('#comment-text').on('keyup', function() {
            var length = $('#comment-text').val().length;

            var length_text = 500 - length;

            if (length_text <= 0)
            {
                length_text = 0;
            }
            $('#length-comment').text(length_text);
        });

        var delete_id;

        $('.deletelink').click(function (event) {
            delete_id = event.target.id;
        });

        $('#deleteComment').click(function () {

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                url: '/comments/' + delete_id,
                type: 'DELETE',
                success: function () {
                    location.reload();
                }
            });
        });
    </script>
@endsection