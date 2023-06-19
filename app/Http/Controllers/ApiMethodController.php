<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\API;
use App\Models\APIMethod;

class APIMethodController extends Controller
{
    public function index($apiId)
    {
        $api = API::findOrFail($apiId);
        $methods = $api->methods;
        return response()->json(['message' => 'API methods retrieved successfully', 'data' => $methods], 200);
    }
    
    public function store(Request $request, $apiId)
    {
        $api = API::findOrFail($apiId);
        $validatedData = $request->validate([
            'name' => 'required',
            'url' => 'required',
            'documentation' => 'required',
        ]);

        $method = new APIMethod($validatedData);
        $api->methods()->save($method);
        return response()->json(['message' => 'API method created successfully', 'data' => $method], 201);
    }

    public function show($apiId, $methodId)
    {
        $api = API::findOrFail($apiId);
        $method = $api->methods()->findOrFail($methodId);
        return response()->json(['message' => 'API method retrieved successfully', 'data' => $method], 200);
    }

    public function update(Request $request, $apiId, $methodId)
    {
        $api = API::findOrFail($apiId);
        $method = $api->methods()->findOrFail($methodId);

        $validatedData = $request->validate([
            'name' => 'required',
            'url' => 'required',
            'documentation' => 'required',
        ]);

        $method->update($validatedData);
        return response()->json(['message' => 'API method updated successfully', 'data' => $method], 200);
    }

    public function destroy($apiId, $methodId)
    {
        $api = API::findOrFail($apiId);
        $method = $api->methods()->findOrFail($methodId);
        
        $method->delete();
        return response()->json(['message' => 'API method deleted successfully'], 200);
    }

    public function getApiData(){
        $apiData = json_decode('{
            "api": {
                "name": "API de ejemplo",
                "base_url": "https://api.example.com",
                "methods": [
                    {
                        "name": "Obtener todas las APIs",
                        "url": "/apis",
                        "documentation": "Documentación de obtener todas las APIs",
                        "method": "GET",
                        "headers": {
                            "Accept": "application/json",
                            "authorization": "Bearer {access_token}"
                        },
                        "request_body": "Ninguno",
                        "response": "200 OK, JSON"
                    },
                    {
                        "name": "Crear una nueva API",
                        "url": "/apis",
                        "documentation": "Documentación de crear una nueva API",
                        "method": "POST",
                        "headers": {
                            "Accept": "application/json",
                            "Content-Type": "application/json",
                            "authorization": "Bearer {access_token}"
                        },
                        "request_body": "JSON con los detalles de la nueva API",
                        "response": "201 Created, JSON"
                    },
                    {
                        "name": "Obtener información de una API específica",
                        "url": "/apis/{id}",
                        "documentation": "Documentación de obtener información de una API específica",
                        "method": "GET",
                        "headers": {
                            "Accept": "application/json",
                            "authorization": "Bearer {access_token}"
                        },
                        "request_body": "Ninguno",
                        "response": "200 OK, JSON"
                    },
                    {
                        "name": "Actualizar información de una API específica",
                        "url": "/apis/{id}",
                        "documentation": "Documentación de actualizar información de una API específica",
                        "method": "PUT",
                        "headers": {
                            "Accept": "application/json",
                            "Content-Type": "application/json",
                            "authorization": "Bearer {access_token}"
                        },
                        "request_body": "JSON con los nuevos detalles de la API",
                        "response": "200 OK, JSON"
                    },
                    {
                        "name": "Eliminar una API específica",
                        "url": "/apis/{id}",
                        "documentation": "Documentación de eliminar una API específica",
                        "method": "DELETE",
                        "headers": {
                            "Accept": "application/json",
                            "authorization": "Bearer {access_token}"
                        },
                        "request_body": "Ninguno",
                        "response": "200 OK, JSON"
                    },
                    {
                        "name": "Iniciar sesión",
                        "url": "/login",
                        "documentation": "Documentación de iniciar sesión",
                        "method": "POST",
                        "headers": {
                            "Accept": "application/json"
                        },
                        "request_body": "JSON con las credenciales de inicio de sesión",
                        "response": "200 OK, JSON"
                    }
                ]
            }
        }');
    
        return response()->json($apiData, 200);
    }  

    public function generateMarkdownFromApiData($apiData) {
        $markdown = '';
    
        // Título y base URL
        $markdown .= "# " . $apiData->api->name . "\n\n";
        $markdown .= "Se verifican los métodos de la API\n\n";
        $markdown .= "## Base URL\n\n";
        $markdown .= "- Base URL: " . $apiData->api->base_url . "\n\n";
    
        // Métodos
        $markdown .= "## Métodos\n\n";
        foreach ($apiData->api->methods as $method) {
            $markdown .= "### " . $method->name . "\n\n";
            $markdown .= "- URL: `" . $method->url . "`\n";
            $markdown .= "- Descripción: " . $method->documentation . "\n";
            $markdown .= "- Método: " . $method->method . "\n";
            $markdown .= "- Headers:\n";
            foreach ($method->headers as $header => $value) {
                $markdown .= "  - " . $header . ": " . $value . "\n";
            }
            $markdown .= "- Cuerpo de la solicitud: " . $method->request_body . "\n";
            $markdown .= "- Respuesta: " . $method->response . "\n\n";
        }
    
        return $markdown;
    }
}
