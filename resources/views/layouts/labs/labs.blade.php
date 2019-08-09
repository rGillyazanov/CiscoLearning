@extends('layouts.app')

@section('content-block')
    <div class="container-fluid">
        <div class="row mt-5 mt-md-3">
            @if (count($labs) == 0)
                <h4>У вас нет доступа к лабораторным работам.</h4>
            @endif
            @foreach($labs as $lab)

                <div class="card-group col-sm-12 col-md-6 col-lg-4 col-xl-4 mt-2 mb-3 pl-0">
                    <div class="card">
                        <a class="practical-link" href="{{ route('lab', ['id' => $lab->getPractical->id]) }}"><img class="card-img-top rounded-top" height="190" src="{{ asset('/storage').'/'.$lab->getPractical->image }}"></a>
                        <div class="card-body">
                            <div class="d-flex flex-row">
                                <div class="practical-date pr-3 border-right">{{ Date::parse($lab->getPractical->created_at)->format('d F, Y') }}</div>
                                <div class="ml-3 practical-date">{{ count($lab->getPractical->getComments) }} {{ Lang::choice('комментарий|комментария|комментариев', count($lab->getPractical->getComments), [], 'ru') }}</div>
                            </div>
                            <h5 class="card-title practical-title-name">{{ $lab->getPractical->name }}</h5>
                            <p class="card-text practical-description">{{ $lab->getPractical->description }}</p>
                        </div>
                        <div class="card-footer">
                            <a class="practical-link" href="{{ route('lab', ['id' => $lab->getPractical->id]) }}" style="font-size: 0.8rem">Читать далее</a>
                        </div>
                    </div>
                </div>

            @endforeach
            <div class="container">
                <div class="row d-flex justify-content-center mt-2 mb-2">
                    {{ $labs->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection