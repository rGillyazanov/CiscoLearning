@extends('layouts.app')

@section('content-block')
    <div class="container-fluid">
        <div class="row mt-5 mt-md-4 block-white p-3">
            <div class="col-12">
                <div class="d-flex flex-column">
                    @if (count($testResult) == 0)
                        <span class="alert alert-danger">
                            <strong>Студент не выполнял тестирование</strong>
                        </span>
                    @endif
                    <span class="group-name text-center">Тест выполнен ({{ $testResult->first()->getUser->name }})</span>
                    <span class="group-name">Количество верных ответов: <u>{{ $countTrueAnswer }}/{{ count($testResult) }}</u></span>
                    <span class="group-name">Выполненно верно: {{ round(($countTrueAnswer / count($testResult)) * 100, 2) }}%</span>

                    <div class="mt-2">
                        @foreach($testResult as $item)
                            <div class="d-flex flex-column mt-1" style="font-size: 1rem">
                                <span style="font-weight: bold; font-size: 0.95rem">{{ $loop->iteration }}. {{ $item->getQuestion->text }}</span>
                                <span class="mt-1 mb-1">{{ $item->getAnswer->text }} - @if($item->getQuestion->getTrueAnswer->id == $item->getAnswer->id) <span style="color: green">Правильный</span> @else <span style="color: red">Неправильный</span> @endif</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection