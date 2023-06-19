@extends('layouts.layout')
@section('title')
    Inicio de sesión
@endsection
@section('content')
    <main class="login-form my-5">
        <div class="cotainer">
            <div class="row justify-content-center">
                <div class="col-md-4">
                    <div class="card">
                        <h3 class="card-header text-center">Formulario Login</h3>
                        <div class="card-body">
                            <form method="POST" action="{{ route('login') }}">
                                @csrf
                                <div class="form-group mb-3">
                                    <input type="text" placeholder="Email" id="email" class="form-control" name="email" required
                                        autofocus>
                                    @if ($errors->has('email'))
                                      <div class="alert alert-danger mt-3" role="alert">{{ $errors->first('email') }}</div>
                                    @endif
                                </div>
                                <div class="form-group mb-3">
                                    <input type="password" placeholder="Password" id="password" class="form-control" name="password" required>
                                    @if ($errors->has('password'))
                                      <div class="alert alert-danger mt-3" role="alert">{{ $errors->first('password') }}</div>
                                    @endif
                                </div>
                                <div class="form-group mb-3">
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" name="remember"> Recuerdame
                                        </label>
                                    </div>
                                    @if (session('error'))
                                        <div class="alert alert-danger mt-3">
                                            {{ session('error') }}
                                        </div>
                                    @endif
                                    @if(session('success'))
                                        <div class="alert alert-success mt-3">
                                            {{session('success')}}
                                        </div>
                                    @endif
                                </div>
                                <div class="d-grid mx-auto">
                                    <button type="submit" class="btn btn-primary btn-block">Enviar</button>
                                </div>
                                <div class="d-grid mx-auto mt-2">
                                    <a href="{{ route('register') }}" class="btn btn-secondary btn-block">Registrarse</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
