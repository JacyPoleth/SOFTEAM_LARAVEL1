@extends('adminlte::page')

@section('content')
    @if(session()->has('user_data'))
        <div class="container">
            <div class="row justify-content-center align-items-center" style="height: 100vh;">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">Cambiar Contraseña ({{ session('user_data')['NOM_PERSONA'] }})</div>

                        <div class="card-body">
                            @if(session('success'))
                                <div class="alert alert-success" role="alert">
                                    {{ session('success') }}
                                </div>
                            @endif <!-- Cambiar después-->

                            <form method="POST" action="{{ route('change.password.submit') }}">
                                @csrf

                                <div class="form-group row">
                                    <label for="current_password" class="col-md-4 col-form-label text-md-right">Contraseña Actual</label>

                                    <div class="col-md-6">
                                        <input id="PAS_USUARIO" type="password" name="PAS_USUARIO" required autocomplete="PAS_USUARIO">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="new_password" class="col-md-4 col-form-label text-md-right">Nueva Contraseña</label>

                                    <div class="col-md-6">
                                        <input id="newPassword" type="password" name="newPassword" required autocomplete="newPassword">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="new_password_confirmation" class="col-md-4 col-form-label text-md-right">Confirmar Contraseña</label>

                                    <div class="col-md-6">
                                        <input id="confPassword" type="password" name="confPassword" required autocomplete="confPassword">
                                    </div>
                                </div>

                                <div class="form-group row mb-0">
                                    <div class="col-md-6 offset-md-4">
                                        <button type="submit" class="btn btn-primary">Cambiar Contraseña</button>
                                        <a href="{{ route('home') }}" class="btn btn-secondary">Cancelar</a>
                                    </div>
                                </div>
                                <br>
                                @if(session('error'))
                                    <div class="alert alert-danger" role="alert">
                                        <div class="text-center">
                                            <strong>Error:</strong> {{ session('error') }}
                                        </div>
                                    </div>
                                @endif
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @else
        <!-- Contenido para usuarios no autenticados -->
        <script>
            window.location.href = "{{ route('login') }}"; // Cambia 'login' con la ruta correcta
        </script>
    @endif
@endsection
