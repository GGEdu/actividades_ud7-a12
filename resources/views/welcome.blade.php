@extends('layouts.layout')

@section('title')
    Bienvenido
@endsection

@section('content')
    <div class="row">
        <aside class="col-3">@include('layouts.aside')</aside>
        <main class="col-9 d-flex align-items-center justify-content-center">
            @php
                $userName = Cookie::get('user_name');
            @endphp
            @if ($userName)
                <h2>Hola, {{ $userName }}!</h2>
            @endif
        </main>  
    </div>
@endsection
