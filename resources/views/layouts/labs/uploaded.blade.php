@extends('layouts.app')

@section('content-block')
    <div class="container-fluid">
        <div class="row block-white p-3 mt-5 mt-md-3">
            <div class="d-flex flex-column">
                <form action="{{ route('upload.lab') }}" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label>Выберите лабораторную работу</label>
                        <select class="form-control @if($errors->has('lab')) is-invalid @endif" name="lab">
                            @foreach ($labs as $lab)
                                <option value="{{ $lab->getPractical->id }}">{{ $lab->getPractical->name }}</option>
                            @endforeach
                        </select>
                        @foreach($errors->get('lab') as $message)
                            <span class="invalid-feedback">
                                <strong>{{ $message }}</strong>
                            </span>
                        @endforeach
                    </div>
                    @csrf
                    <label>Файл лабораторной работы</label>
                    <div class="custom-file">
                        <input id="input-file" type="file" name="upload_file" class="custom-file-input @if($errors->has('file')) is-invalid @elseif (Session::has('success')) is-valid @endif">
                        <label id="label-file" class="overflow-hidden custom-file-label" for="customFile">Выбрать файл</label>
                        @foreach($errors->get('file') as $message)
                            <span class="invalid-feedback">
                                <strong>{{ $message }}</strong>
                            </span>
                        @endforeach
                        @if (Session::has('success'))
                            <span class="valid-feedback">
                                <strong>{!! Session::get('success') !!}</strong>
                            </span>
                        @endif
                    </div>
                    <button type="submit" class="btn btn-primary mb-2 mt-2">Загрузить</button>
                </form>
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