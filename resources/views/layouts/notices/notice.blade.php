<div class="list-group mt-3">

    @foreach($notices as $notice)

        <div class="list-group-item list-group-item-action flex-column align-items-start">
            <div class="d-flex w-100 justify-content-between align-items-center pb-1">
                <div style="font-size: 1rem !important; font-weight: 500">{{ Date::parse($notice->created_at)->format('d F Y, H:i:s') }}</div>
                <small>
                    <div class="d-flex flex-row">
                        @if($notice->status == 0)
                            <span class="ml-3" data-toggle="tooltip" data-placement="top" title="Нажмите, чтобы отметить как прочитанное">
                                <form action="{{ route('notices.update', $notice->id)}}" method="post">
                                    @csrf
                                    @method('PATCH')
                                    <button class="btn btn-success ml-2" style="font-size: 12px;padding: 0 4px;font-weight: 700;" type="submit">Непрочитано</button>
                                </form>
                            </span>
                        @endif
                        @if ($notice->user_id == Auth::id())
                        <form action="{{ route('notices.destroy', $notice->id)}}" method="post">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger ml-2" style="font-size: 12px;padding: 0 4px;font-weight: 700;" type="submit">Удалить</button>
                        </form>
                        @endif
                    </div>
                </small>
            </div>
            <p class="mb-1"><text style="font-size: 14px">{!! $notice->text !!}</text></p>
        </div>
    @endforeach

</div>
@if ($notices->lastItem() > 12)
<div class="container">
    <div class="row d-flex justify-content-center mt-2 mb-3">
        {{ $notices->links() }}
    </div>
</div>
@endif