@extends('layouts.app')

@section('content-block')
    <div class="container-fluid">
        <div class="row mt-5 mt-md-3 block-white p-3">
            @if(count($comments) > 0)
                <div class="d-flex flex-column">
                    <div class="d-flex flex-row align-items-center">
                        <div class="group-name">Ваши комментарии:</div>
                    </div>
                    <div class="list-group mt-2">

                        @foreach($comments as $comment)

                            <div class="list-group-item list-group-item-action flex-column align-items-start">
                                <div class="d-flex flex-row align-items-center">
                                    <div style="font-size: 1rem !important; font-weight: 500">{{ Date::parse($comment->created_at)->format('d F Y, H:i:s') }}</div>
                                </div>
                                <p class="pt-1 mb-1"><text>{!! $comment->text !!}</text></p>
                            </div>
                        @endforeach

                    </div>
                    @if ($comments->lastItem() > 10)
                        <div class="container">
                            <div class="row d-flex justify-content-center mt-2 mb-3">
                                {{ $comments->links() }}
                            </div>
                        </div>
                    @endif
                </div>
            @else
                <div class="col-12">
                    <h3 class="text-center">Вы не оставляли комментарий</h3>
                </div>
            @endif
        </div>
    </div>
@endsection


@section('script')
    @parent
    <script type="text/javascript">
        $('.list-group .list-group-item').click(function () {
            $('.list-group-item.active').removeClass('active');
            $(this).addClass('active');
        });
    </script>
@endsection