@extends('layouts.main')

@section('main')
    @if (Auth::check())
        <p>Vea sus tareas <a href="{{ route('dashboard') }}">aqui</a></p>
    @else
        <p>Inicie sesión para poder guardar sus tareas.</p>
    @endif
@endsection
