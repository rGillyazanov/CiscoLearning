@extends('layouts.app')

@section('content-block')
    <div class="container-fluid">
        <div class="row block-white p-3 mt-5 mt-md-3">
            <div class="d-flex flex-column">
                <form id="formSearch">
                    @csrf
                    <div class="form-group">
                        <label>Выберите группу:</label>
                        <select class="form-control @if($errors->has('group')) is-invalid @endif" name="group">
                            @foreach ($groups as $group)
                                <option value="{{ $group->id }}">{{ $group->name }}</option>
                            @endforeach
                        </select>
                        @foreach($errors->get('group') as $message)
                            <span class="invalid-feedback">
                                <strong>{{ $message }}</strong>
                            </span>
                        @endforeach
                    </div>

                    <button class="button-submit" type="submit">Показать студентов</button>
                </form>
            </div>
        </div>

        <div id="students" class="row">
        </div>
    </div>
@endsection

@section('script')
    @parent
    <script type="text/javascript">
        $('#formSearch').submit(function (event) {
            event.preventDefault();

            var query = $(this).serialize();

            $.ajax({
                url: '{{ route('groups.students') }}',
                method: 'get',
                data: query,
                success: function (data) {
                    $('#students').html(data);
                }
            });
        });

        $(function() {
            $('body').on('click', '.pagination a', function(e) {
                e.preventDefault();

                var url = $(this).attr('href');
                getArticles(url);
            });

            function getArticles(url) {
                $.ajax({
                    url : url
                }).done(function (data) {
                    $('#students').html(data);
                });
            }
        });
    </script>
@endsection