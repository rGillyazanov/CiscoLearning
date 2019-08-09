@foreach($items as $item)
    <div class="media mt-1 pt-2" id="comment-{{ $item->id }}">
        <img class="mr-2 rounded" src="{{ asset('/storage').'/'.$item->getUser->avatar }}" height="64" width="64">
        <div class="media-body">
            <h6 class="mt-0 mb-1"><a class="link-text" href="{{ route('student.profile', $item->getUser->id) }}">{{ $item->getUser->name }}</a>@if(Auth::check() && $item->user_id == Auth::user()->id)<span class="my-comment" data-toggle="tooltip" title="Ваш комментарий" data-placement="top"></span>@endif<span class="comment-number ml-1" style="font-size: 12px; color: grey"></span>
                @if(Auth::check() && $item->user_id == Auth::id())
                    <a style="font-size: 12px; cursor: pointer; color: #3b4369;" href="{{ route('comments.edit', $item->id) }}">
                        ✎
                    </a>
                    <a class="deletelink" style="font-size: 12px; cursor: pointer; color: red;" data-toggle="modal" id="{{ $item->id }}" data-target="#exampleModalCenter">
                        ✖
                    </a>
                @endif
            </h6>
            <span style="word-break: break-word;">{{ $item->text }}</span>
            <div class="mt-1" style="font-size: 12px; color: grey;">{{ Date::parse($item->created_at)->format('d F Y, H:i:s') }}</div>
            @if(Auth::check() && Auth::id() !== $item->getUser->id)<div id="deleteDiv" class="reply d-flex align-items-center"><a id="{{ $item->id }}" href="#form-comment">Ответить</a></div>@endif
            @if(isset($com[$item->id]))
                @include('layouts.comments.comment', ['items' => $com[$item->id]])
            @endif
        </div>
    </div>
@endforeach

@if(Auth::check())
    <!-- Modal -->
    <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle">Удалить комментарий?</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Вы действительно хотите удалить ваш комментарий?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Нет</button>
                    <button type="button" class="btn btn-primary" id="deleteComment">Да</button>
                </div>
            </div>
        </div>
    </div>
@endif