@extends('layouts.newapp')

@section('title')
    <div class="md:flex md:items-center md:justify-between">
        <div class="flex-1 min-w-0">
            <h2 class="text-2xl font-bold leading-7 text-white sm:text-3xl sm:leading-9 sm:truncate">
                {{ $member->name }}
            </h2>
        </div>
    </div>
 @endsection

@section('content')
    <div class="container">
        <member-show :member="{{ $member }}" :old_courses="{{ $courses }}" :marital_statuses="{{ $marital_statuses }}"></member-show>
    </div>
@endsection
