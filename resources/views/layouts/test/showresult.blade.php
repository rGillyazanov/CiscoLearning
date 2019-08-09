@extends('layouts.app')

@section('content-block')
    <div class="container-fluid">
        <div class="row mt-5 mt-md-4 block-white p-3">
            <div class="col-12">
                <div class="d-flex flex-column">
                    <span class="group-name">Количество верных ответов: <u>{{ $TrueAnswers }}/{{ count($Result) }}</u></span>
                    <span class="group-name">Выполненно верно: {{ round(($TrueAnswers / count($Result)) * 100, 2) }}%</span>

                    <div class="mt-2">
                        @foreach($Result as $key => $item)
                            @php $question = \App\Question::query()->find($key) @endphp
                            <div class="d-flex flex-column mt-1" style="font-size: 1rem">
                                <span style="font-weight: bold; font-size: 0.95rem">{{ $loop->iteration }}. {{ $question->text }}</span>
                                <span class="mt-1 mb-1">{{ \App\Answer::query()->find($Answers[$loop->index])->text }} - @if($item == 1) <span style="color: green">Правильный</span> @else <span style="color: red">Неправильный</span> @endif</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection