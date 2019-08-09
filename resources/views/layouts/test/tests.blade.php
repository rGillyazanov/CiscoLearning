@extends('layouts.app')

@section('content-block')
    <div class="container-fluid">
        <div class="row mt-5 mt-md-3 block-white p-3">
            <div class="col-12">
                <span class="group-name">Тестирования:</span>
                @if ($errors->has('repeat'))
                    <span class="alert alert-danger">
                        {{ $errors->first('repeat') }}
                    </span>
                @endif
                <div>
                    <ul class="mb-0">
                        @foreach($tests as $test)
                            <li><a href="{{ route('tests.show', $test->getTask->id) }}">{{ $test->getTask->name }}</a></li>
                        @endforeach
                    </ul>
                </div>
            </div>

        </div>
    </div>
@endsection