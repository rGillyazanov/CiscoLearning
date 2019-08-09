@extends('layouts.app')

@section('content-block')
    <div class="container-fluid">
        <div class="row mt-5 mt-md-3">
            <div class="d-flex flex-column">
                @if($avgScore != 0)
                <span class="group-name">@if(Auth::user()->role_id != 2)Оценки студента @else Мои оценки:@endif</span>
                <span style="font-size: 1rem">Средняя оценка: {{ $avgScore }}</span>
                @else
                <span class="group-name">У студента {{ $student->name }} нет проверенных работ</span>
                @endif
                @if (Session::has('success'))
                    <span class="alert alert-success mb-0 mt-1">
                        {!! Session::get('success') !!}
                    </span>
                @endif
                @if ($errors->has('labId'))<span class="mt-2 form-control is-invalid">:( Где же лаба?</span>@endif
                @if ($errors->has('delete'))<span class="mt-2 form-control is-invalid">Что-то не так</span>@endif
                @if ($errors->has('score'))<span class="mt-2 form-control is-invalid">Оценочка :*( куда ты?</span>@endif
                @if ($errors->has('user'))<span class="mt-2 form-control is-invalid">Студент убежал с лабы O_o</span>@endif
                @foreach($errors->all() as $message)
                    <span class="invalid-feedback">
                        <strong>{{ $message }}</strong>
                    </span>
                @endforeach
            </div>
            @foreach($scoreslab as $item)
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 group-user-info block-white mt-3">
                    <div class="d-flex flex-column" style="font-size: 1.1rem">
                        <a href="{{ route('lab', $item->getPractical->id) }}">{{ $item->getPractical->name }}</a>
                    </div>
                    <div class="d-flex flex-column mt-1" style="font-size: 1rem">
                        <span><strong>Оценка:</strong> {{ $item->getScore->score }} - {{ $item->getScore->name }}</span>
                        <span class="mt-1 mb-1"><strong>Добавление лабораторной работы в профиль:</strong> {{ Date::parse($item->created_at)->format('j F Y, H:i') }}</span>
                        @if ($item->file != null)
                            <span>Файл выполненной лабораторной работы: <a href="{{ asset('storage/'.$item->file) }}" download="{{ $item->getUser->name }} ({{ $item->getUser->getGroup->name }})-{{ $item->getPractical->name }}.{{ pathinfo($item->file, PATHINFO_EXTENSION) }}">скачать</a></span>
                            <form action="{{ route('lab.delete') }}" method="POST">
                                @csrf
                                <input name="delete" type="hidden" value="{{ $item->id }}">
                                <button class="button-default col-12 col-md-6 col-lg-3 col-xl-2 mt-2 form-control" type="submit">Удалить файл</button>
                            </form>
                        @endif
                    </div>
                    @if (Auth::user()->role_id == 1 || Auth::user()->role_id == 3)
                    <hr>
                    <div class="d-inline-flex flex-column">
                        <form action="{{ route('scores.set.score') }}" method="post">
                            @csrf
                            <input type="hidden" name="labId" value="{{ $item->getPractical->id }}">
                            <input type="hidden" name="user" value="{{ $item->user_id }}">
                            <div class="form-group">
                                <label style="font-size: 1rem">Оценка за работу</label>
                                <select class="form-control" name="score">
                                    @foreach($scores as $score)
                                        <option value="{{ $score->id }}">{{ $score->name }} ({{ $score->score }})</option>
                                    @endforeach
                                </select>
                            </div>
                            <button type="submit" class="button-submit">Поставить</button>
                        </form>
                    </div>
                    @endif
                    @if(count($item->getComments) > 0)
                    <!-- Комментарии -->
                        <h5 id="comments" class="mt-2">{{ count($item->getComments) }} {{ Lang::choice('комментарий|комментария|комментариев', count($item->getComments), [], 'ru') }}</h5>

                        @set($com, $item->getComments->groupBy('parent'))
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
                        <form action="{{ route('comment.storeLab') }}" method="POST" class="mt-3">
                            @csrf
                            <input type="hidden" id="comment_lab_id" name="comment_practical_user_id" value="{{ $item->id }}">
                            <input type="hidden" id="comment_parent" name="comment_parent" value="0">

                            <label for="comment" id="answer">Написать комментарий: <span id="length-comment" data-toggle="tooltip" title="Длина сообщения" data-placement="top">500</span><span id="clear" style="color: red" class="ml-1" data-toggle="tooltip" title="Отменить ответ" data-placement="top"></span></label>
                            <textarea placeholder="Введите текст комментария" name="comment_text" style="overflow: auto; resize: none;" class="form-control col-12 rounded" id="comment-text" rows="4" cols="5"></textarea>
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
            @endforeach
        </div>
    </div>
@endsection

@section('script')
    @parent
    <script type="text/javascript">
        $('.block-white').each(function () {
            $($(this).find('.media-body')).each(function (i) {
                $(this).find('span.comment-number').html(' — #' + (i + 1));
            });
        });

        $('.reply a').click(function(event) {
            var thisObj = $(event.currentTarget).parent('.block-white');

            thisObj.prevObject[0].offsetParent.childNodes[15][2].value = $(this).attr('id');
            thisObj.prevObject[0].offsetParent.childNodes[15].childNodes[7].childNodes[2].innerText = '✖';
        });

        $('.block-white #clear').click(function(event) {
            var thisObj = $(event.currentTarget).parent('.block-white');

            thisObj.prevObject[0].offsetParent.childNodes[15][2].value = 0;
            thisObj.prevObject[0].offsetParent.childNodes[15].childNodes[7].childNodes[2].innerText = '';
        });

        $('.block-white #comment-text').on('keyup', function(event) {

            var thisParentObj = $(event.currentTarget).parent('.block-white');

            var length = $(this).val().length;

            var length_text = 500 - length;

            if (length_text <= 0)
            {
                length_text = 0;
            }
            
            thisParentObj.prevObject[0].parentNode.childNodes[7].childNodes[1].innerText = length_text;
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