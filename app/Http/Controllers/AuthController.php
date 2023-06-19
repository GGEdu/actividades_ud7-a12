<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Cookie;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    /**
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator->errors())->withInput($request->all()); 
        }

        $user = User::create([
            'name' => $request->input('name') . ' ' . $request->input('last_name'),
            'email' => $request->input('email'),
            'password' => bcrypt($request->input('password'))
        ]);
        return redirect("/")->withSuccess('Usuario registrado correctamente.');
    }

    /**
     * Handle a login request for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            return $this->errorResponse($validator->errors(), $request);
        }

        $credentials = $request->only(['email', 'password']);
        Auth::attempt($credentials);
        if (! $token = JWTAuth::attempt($credentials)) {
            return $this->errorResponse(['error' => 'Credenciales inválidas.'], $request);
        }

        return $this->respondWithToken($token, $request);
    }

    protected function respondWithToken($token, Request $request)
    {
        if($request->wantsJson()){
            return response()->json([
                'access_token' => $token,
                'token_type' => 'bearer',
                'expires_in' => auth('api')->factory()->getTTL() * 60
            ]);
        }
        $user = Auth::user();
        Cookie::queue('user_name', $user->name, 60);
        return redirect()->route('welcome');
    }


    protected function errorResponse($error, Request $request)
    {
        if($request->wantsJson()){
            return response()->json($error, 401);
        }

        return back()->withErrors($error);
    }

    public function logout(Request $request)
    {
        JWTAuth::invalidate(JWTAuth::getToken());

        // Eliminar la cookie
        Cookie::queue(Cookie::forget('user_name'));
        return redirect()->route('login');
    }
}
