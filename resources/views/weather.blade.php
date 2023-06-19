@extends('layouts.layout')

@section('title')
    Consulta del clima
@endsection

@section('content')
    <div class="row col-12">
        <aside class="col-3">@include('layouts.aside')</aside>
        <main class="col-9 d-flex align-items-center justify-content-center flex-column py-2">
            <form method="GET" action="{{ route('getWeather') }}">
                <label for="city">Ciudad:</label>
                <input type="text" name="city" id="city" required>
                <button type="submit">Consultar</button>
            </form>
            @if (isset($weatherData))
            <div class="card mt-4">
                    <div class="card-header">
                        <h2>Resultado:</h2>
                    </div>
                    <div class="card-body">
                        <p><strong>Ciudad:</strong> {{ $weatherData['name'] }}</p>
                        <p><strong>Temperatura:</strong> {{ $weatherData['main']['temp'] }}°C</p>
                        <p><strong>Clima:</strong> {{ $weatherData['weather'][0]['description'] }}</p>
                    </div>
                </div>
            @endif
        </main>  
    </div>
@endsection
