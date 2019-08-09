@extends('layouts.app')

@section('content-block')
    <div class="container-fluid">
        <div class="row mt-5 mt-md-4 block-white p-3">
            <div class="col-12">
                <div class="d-flex flex-column">
                    <span class="group-name">Тестирование выполненные студентом:</span>
                    @if (count($listTest) == 0)
                        <span class="alert alert-danger mb-0">
                            <strong>Студент не выполнял тестирование</strong>
                        </span>
                    @endif
                </div>
                <div>
                    <ul class="mb-0">
                        @foreach($listTest as $test)
                            <li><a href="{{ route('tests.show.student', ['taskId' => $test->getTask->id, 'userId' => $test->user_id]) }}">{{ $loop->iteration }}. {{ $test->getTask->name }}</a></li>
                        @endforeach
                    </ul>
                </div>
            </div>

        </div>
    </div>
@endsection