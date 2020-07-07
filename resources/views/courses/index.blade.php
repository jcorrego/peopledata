@extends('layouts.newapp')

@section('title')
    <div class="md:flex md:items-center md:justify-between">
        <div class="flex-1 min-w-0">
            <h2 class="text-2xl font-bold leading-7 text-white sm:text-3xl sm:leading-9 sm:truncate">
                Lista de Cursos <small>{{ $period }}</small>
            </h2>
        </div>
    </div>
@endsection

@section('content')
    <div class="container">
        <div class="card mb-2">
            <div class="card-body">
                <div class="row">
                    <div class="col-md">
                        <select id="period" class="mb-2 form-control" onChange="document.location.href='/courses?period='+document.getElementById('period').options[document.getElementById('period').selectedIndex].value + '&ministry='+document.getElementById('ministry').options[document.getElementById('ministry').selectedIndex].value">
                            @foreach($periods as $row)
                                <option {{ $period==$row?'selected':'' }} value="{{ $row }}">{{ $row }}</option>
                            @endforeach
                        </select>
                        <select id="ministry" class="mb-2 form-control" onChange="document.location.href='/courses?period='+document.getElementById('period').options[document.getElementById('period').selectedIndex].value + '&ministry='+document.getElementById('ministry').options[document.getElementById('ministry').selectedIndex].value">
                            <option value="0">Todos los ministerios</option>
                            @foreach(\App\Ministry::orderBy('name')->get() as $row)
                                <option {{ $ministry==$row->id?'selected':'' }} value="{{ $row->id }}">{{ $row->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md">
                        <a href="/courses/export?period={{ $period }}" class="btn btn-block btn-secondary mb-2"><i class="fal fa-file-excel"></i> Exportar Lista de Estudiantes</a>
{{--                        <a href="/members/unfinished/{{ $period }}" class="btn btn-block btn-secondary mb-2"><i class="fal fa-user-slash"></i> Ver deserciones</a>--}}
                    </div>
                    <div class="col-md">
                        <compose-message label="Escribir a los Profes" :emails="{{ collect($professorEmails) }}"></compose-message>
                    </div>
                </div>
            </div>
        </div>
        @if($courses->count())
            @php
                $days = ['1'=>'Lunes','2'=>'Martes','3'=>'Miércoles','4'=>'Jueves','5'=>'Viernes','6'=>'Sábado','0'=>'Domingo'];
            @endphp
            @foreach($days as $index=>$day)
                @if(($daycourses = $courses->where('day',$index)->all()) && count($daycourses))
                    <div class="row">
                        <div class="col">
                            <h3>{{ $day }}</h3>
                        </div>
                    </div>
                    <div class="row">
                        @foreach($daycourses as $course)
                            <div class="col-md-4">
{{--                                @include('courses.summary')--}}
                                <course-summary :course="{{ $course }}" :students="{{ $course->members->whereNotIn('pivot.status',['didnt_start','didnt_finish'])->count() }}"></course-summary>
                            </div>
                        @endforeach
                    </div>
                @endif
            @endforeach
        @else
            <div class="card">
                <div class="card-header text-white bg-info">Clases</div>
                <div class="card-body">
                    <h4>No hay clases disponibles</h4>
                </div>
            </div>
        @endif
    </div>
@endsection
