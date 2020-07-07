@extends('layouts.newapp')

@section('title')
    <div class="md:flex md:items-center md:justify-between">
        <div class="flex-1 min-w-0">
            <h2 class="text-2xl font-bold leading-7 text-white sm:text-3xl sm:leading-9 sm:truncate">
                Lista de usuarios
            </h2>
        </div>
    </div>
@endsection

@section('content')
    <div class="container">
        <form action="/members/search" method="post">
            {{ csrf_field() }}
            <div>Buscar estudiante:</div>
            <div class="input-group mb-3">
                <input name="search" type="text" class="form-control" placeholder="Nombre del estudiante" aria-label="Nombre del estudiante" aria-describedby="button-addon2" value="{{ request()->get('search','') }}">
                <div class="input-group-append">
                    <button class="btn btn-primary" type="submit" id="button-addon2"><i class="fal fa-search"></i></button>
                </div>
            </div>
        </form>
        <ul class="list-group list-group-flush">
            @foreach($members as $member)
                <li class="list-group-item">
                    <div class="row">
                        <div class="col-md-1">
                            <a href="/members/{{ $member->id }}"><img src="{{ $member->image }}" alt="{{ $member->name }}" class="rounded-circle img-fluid img-thumbnail" width="100"></a>
                        </div>
                        <div class="col-md-3">
                            {{ $member->first_name }} {{ $member->last_name }}<br>
                            Teléfono: {{ $member->phone}}<br>
                            Email: {{ $member->email }}
                        </div>
                        <div class="col-md-3">
                            @forelse($member->courses()->orderBy('period','desc')->get() as $course)
                                <div class="student-period period-{{ $course->period }} {{ $course->pivot->status }}">
                                    <span class="badge badge-info">{{ $course->period }}</span>
                                    <a href="/courses/{{ $course->id }}/students">{{ $course->name }}</a>
                                </div>
                            @empty
                                -
                            @endforelse
                        </div>
                        <div class="col-md-3">
                            @forelse($member->professorCourses()->orderBy('period','desc')->get() as $course)
                                <div class="professor-period period-{{ $course->period }}">
                                    <span class="badge badge-info">Profesor {{ $course->period }}</span>
                                    <a href="/courses/{{ $course->id }}/students">{{ $course->name }}</a>
                                </div>
                            @empty
                                -
                            @endforelse
                        </div>
                        <div class="col-md-2">
                            <a href="/members/{{ $member->id }}" class="btn btn-secondary">Ver Perfil</a>
                        </div>
                    </div>
                </li>
            @endforeach
        </ul>
    </div>
@endsection
