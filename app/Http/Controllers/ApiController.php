<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Api;

class ApiController extends Controller
{
    public function index()
    {
        $apis = Api::all();
        return response()->json(['message' => 'APIs retrieved successfully', 'data' => $apis], 200);
    }
    
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'base_url' => 'required|url',
        ]);

        $api = Api::create($validatedData);
        return response()->json(['message' => 'API created successfully', 'data' => $api], 201);
    }

    public function show($id)
    {
        $api = Api::findOrFail($id);
        return response()->json(['message' => 'API retrieved successfully', 'data' => $api], 200);
    }

    public function update(Request $request, $id)
    {
        $api = Api::findOrFail($id);
        $validatedData = $request->validate([
            'name' => 'required',
            'base_url' => 'required|url',
        ]);

        $api->update($validatedData);
        return response()->json(['message' => 'API updated successfully', 'data' => $api], 200);
    }

    public function destroy($id)
    {
        $api = Api::findOrFail($id);
        $api->delete();
        return response()->json(['message' => 'API deleted successfully'], 200);
    }
}