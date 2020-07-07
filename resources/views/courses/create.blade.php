@extends('layouts.newapp')

@section('title')
    <div class="md:flex md:items-center md:justify-between">
        <div class="flex-1 min-w-0">
            <h2 class="text-2xl font-bold leading-7 text-white sm:text-3xl sm:leading-9 sm:truncate">
                Crear un curso
            </h2>
        </div>
    </div>
@endsection

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-body">
                <form action="/courses" method="post">
                    {{ csrf_field() }}
                    @include('forms.text', ['field'=>'name', 'label'=>'Nombre','value'=>old('name',''),'placeholder'=>'Escriba aquí','help'=>'Escriba el nombre del curso a crear'])
                    <button type="submit" class="btn btn-primary">Crear</button>
                </form>
            </div>
        </div>
    </div>
@endsection
