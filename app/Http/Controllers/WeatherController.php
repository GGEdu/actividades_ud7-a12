<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WeatherController extends Controller
{
    public function getWeather(Request $request)
    {
        $apiKey = '56a359e94e66f9448f3c67ab2e149cfc'; // Reemplaza con tu clave de API de OpenWeatherMap
        $city = $request->input('city');

        // Verifica si se proporcionó una ciudad en la solicitud
        if (empty($city)) {
            return redirect()->back()->with('error', 'City parameter is required');
        }

        $weatherData = $this->getWeatherData($apiKey, $city);

        // Verifica si se obtuvo una respuesta válida de la API de OpenWeatherMap
        if ($weatherData === null) {
            return redirect()->back()->with('error', 'Unable to fetch weather data');
        }

        return view('weather')->with('weatherData', $weatherData);
    }

    private function getWeatherData($apiKey, $city)
    {
        $url = "http://api.openweathermap.org/data/2.5/weather?q=" . urlencode($city) . 
                "&appid=" . $apiKey;
        // Realizar la solicitud HTTP a la API
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);
        // Decodificar la respuesta JSON
        $weatherData = json_decode($response, true);
        return $weatherData;
    }

    public function showWeatherForm()
    {
        return view('weather');
    }
}