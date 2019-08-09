@extends('layouts.app')

@section('content-block')
    <div class="container-fluid">
        <div class="row mt-5 mt-md-3">
            @foreach($theories as $theory)

                <div class="card-group col-sm-12 col-md-6 col-lg-4 col-xl-4 mt-2 mb-3 pl-0">
                    <div class="card">
                        <a class="practical-link" href="{{ route('theory.show', ['id' => $theory->id]) }}"><img class="card-img-top rounded-top" height="190" src="{{ asset('/storage').'/'.$theory->image }}"></a>
                        <div class="card-body">
                            <div class="d-flex flex-row">
                                <div class="practical-date pr-3">{{ Date::parse($theory->created_at)->format('d F, Y') }}</div>
                            </div>
                            <h5 class="card-title practical-title-name">{{ $theory->name }}</h5>
                            <p class="card-text practical-description">{{ $theory->description }}</p>
                        </div>
                        <div class="card-footer">
                            <a class="practical-link" href="{{ route('theory.show', ['id' => $theory->id]) }}" style="font-size: 0.8rem">Читать далее</a>
                        </div>
                    </div>
                </div>

            @endforeach

            <div class="container">
                <div class="row d-flex justify-content-center mt-2 mb-2">
                    {{ $theories->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
