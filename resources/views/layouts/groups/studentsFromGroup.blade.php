@if (count($students) == 0)
    <h4 class="mt-2">Нет зарегистрированных студентов в группе</h4>
@endif
@foreach($students as $item)
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 group-user-info block-white mt-3">
        <div class="d-flex flex-wrap">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4 col-xl-4 border-right pl-0">
                <div class="d-flex flex-row align-items-center">
                    <div class="rounded-circle mr-3">
                        <img class="rounded-circle" src="{{ asset("/storage")."/".$item->avatar }}" alt="Аватар" height="64" width="64">
                    </div>
                    <span class="group-user-profile-name"><a href="{{ route('student.profile', ['id' => $item->id]) }}">{{ $item->name }}</a></span>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4 col-xl-4 border-right pl-0 pt-3 pb-3">
                <div class="d-flex flex-row align-items-center">
                                <span class="group-user-icon-email group-user-icon fa-stack fa-2x">
                                    <i class="fas fa-circle fa-stack-2x" style="color: #1dc9b7"></i>
                                    <i class="fas fa-envelope fa-stack-1x fa-inverse"></i>
                                </span>
                    <span class="group-user-profile-email">{{ $item->email }}</span>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4 col-xl-4 pt-3 pb-3 pl-0">
                <div class="d-flex flex-row align-items-center">
                                <span class="group-user-icon-email group-user-icon fa-stack fa-2x">
                                    <i class="fas fa-circle fa-stack-2x" style="color: #5d78ff"></i>
                                    <i class="fas fa-phone fa-stack-1x fa-inverse"></i>
                                </span>
                    <span class="group-user-profile-email">{{ $item->phone }}</span>
                </div>
            </div>
        </div>
        <div class="mt-4">
            <div class="d-flex flex-row justify-content-between group-user-date-profile">
                <div class="d-flex align-items-center p-0">
                    <div class="group-user-date p-2">
                        {{ Date::parse($item->created_at)->format('d F, Y') }}
                    </div>
                    <span class="group-user-date-start ml-2">Начало обучения</span>
                </div>
                <div class="row d-flex flex-row align-items-center">
            		@if (\App\Http\Controllers\Groups\GroupsController::getAvgScoreStudent($item->id) != 0)<span class="mr-3"><strong>Средняя оценка:</strong> {{ \App\Http\Controllers\Groups\GroupsController::getAvgScoreStudent($item->id) }}</span>@endif
                    <div class="button-default d-flex align-items-center mr-2"><a href="{{ route('tests.show.listTestResult', $item->id) }}">Тестирование</a></div>
                    <div class="button-default d-flex align-items-center mr-2"><a href="{{ route('scores.student', ['id' => $item->id]) }}">Лабораторные работы</a></div>
                    <div class="button-default d-flex align-items-center"><a href="{{ route('student.profile', ['id' => $item->id]) }}">Профиль</a></div>
                </div>
            </div>
        </div>
    </div>
@endforeach

<div class="container-fluid mt-3">
    <div class="row">
        <div class=" d-flex justify-content-center col-12">
            {{ $students->links() }}
        </div>
    </div>
</div>