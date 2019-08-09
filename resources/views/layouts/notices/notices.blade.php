@extends('layouts.app')

@section('content-block')
    <div class="container-fluid">
        <div class="row mt-5 mt-md-3 block-white p-3">
            @if(count($notices) > 0)
                <div class="d-flex flex-column">
                    <div class="d-flex flex-row align-items-center">
                        <div class="group-name mr-3">Уведомления:</div>
                        <div id="check-all" class="button-submit">Отменить все как прочитанное</div>
                    </div>
                    @include('layouts.notices.notice')
                </div>
            @else
                <div class="col-12">
                    <h3 class="text-center mb-0">У вас нет уведомлений</h3>
                </div>
            @endif
        </div>
    </div>
@endsection

@section('script')
    @parent
    <script type="text/javascript">
        $('#check-all').click(function () {

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                url: '{{ route('notices.store') }}',
                method: 'POST',
                success: function () {
                    window.location.replace("/notices");
                }
            });
        });

        $('.list-group .list-group-item').click(function () {
            $('.list-group-item.active').removeClass('active');
            $(this).addClass('active');
        });
    </script>
@endsection