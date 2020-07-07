@extends('layouts.newapp')

@section('title')
    <div class="md:flex md:items-center md:justify-between">
        <div class="flex-1 min-w-0">
            <h2 class="text-2xl font-bold leading-7 text-white sm:text-3xl sm:leading-9 sm:truncate">
                Agregar estudiantes a: <small>{{ $course->name }}</small>
            </h2>
        </div>
    </div>
@endsection

@section('content')
    <members-search add_url="/courses/{{ $course->id }}/add/"></members-search>
@endsection
