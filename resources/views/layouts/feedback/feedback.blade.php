@extends('layouts.app')

@section('content-block')
    <div class="container-fluid">
        <div class="row mt-4">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 block-white p-4 mb-3">
                <form class="mt-3" action="{{ route('feedback-add-topic') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="topic">{{ __('user.Topic') }}</label>
                        <input name="topic" type="text" class="form-control{{ $errors->has('topic') ? ' is-invalid' : '' }}" id="topic" placeholder="{{ __('user.TopicPlaceholder')  }}">
                        @if ($errors->has('topic'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('topic') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="topic">{{ __('user.Section') }}</label>
                        <select name="section" class="form-control{{ $errors->has('section') ? ' is-invalid' : '' }}">
                            <option>Вопрос</option>
                            <option>Предложение</option>
                            <option>Баг</option>
                            <option>Другое</option>
                        </select>
                        @if ($errors->has('section'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('section') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="text-topic">{{ __('user.TopicText') }}</label>
                        <textarea name="text" class="form-control{{ $errors->has('text') ? ' is-invalid' : '' }}" id="text-topic" rows="4" style="overflow: auto; resize: none;" placeholder="{{ __('user.Topic Text Placeholder') }}"></textarea>
                        @if ($errors->has('text'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('text') }}</strong>
                            </span>
                        @endif
                    </div>
                    <button type="submit" class="button-submit mb-2">{{ __('user.Submit') }}</button>
                    @if (Session::has('success'))
                        <div class="alert alert-success mb-0">
                            {!! Session::get('success') !!}
                        </div>
                    @endif
                </form>
            </div>
        </div>
    </div>
@endsection

@section('script')
    @parent
@endsection