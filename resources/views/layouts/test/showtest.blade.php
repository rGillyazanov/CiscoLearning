@extends('layouts.app')

@section('content-block')
    <div class="container-fluid">
        <div class="row mt-5 mt-md-4 block-white p-3">
            <div class="col-12">
                <form action="{{ route('tests.answers') }}" method="POST" id="testForm">
                    @csrf
                    <input type="hidden" value="{{ $test->id }}" name="taskId">
                    @foreach($test->getQuestions as $question)
                        <div class="d-flex flex-column pb-3 test-questions">
                            <span style="font-weight: bold; font-size: 0.95rem">{{ $loop->iteration }}. {{ $question->text }}</span>
                            @foreach($question->getAnswers as $answer)
                                <div class="form-check mt-1">
                                    <input class="form-check-input" type="radio" name="{{ $question->id }}" id="Question{{ $question->id }}Answer{{ $answer->id }}" value="{{ $answer->id }}" required>
                                    <label class="form-check-label" for="Question{{ $question->id }}Answer{{ $answer->id }}">
                                        {{ $answer->text }}
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    @endforeach
                    <button class="button-submit form-control{{ $errors->has('taskId') ? ' is-invalid' : '' }}" type="submit">Закончить тестирование</button>
                    @if ($errors->has('taskId'))
                        <span class="invalid-feedback">
                            <strong>{{ $errors->first('taskId') }}</strong>
                        </span>
                    @endif
                </form>
            </div>
        </div>
    </div>
@endsection