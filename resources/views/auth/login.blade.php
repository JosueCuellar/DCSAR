@extends('auth.layouts.app')

@section('content')
    <style>
        .divider:after,
        .divider:before {
            content: "";
            flex: 1;
            height: 1px;
            background: #eee;
        }

        .h-custom {
            height: 100%;
        }

        @media (max-width: 450px) {
            .h-custom {
                height: 100%;
            }
        }
    </style>

    <section style="background-color: #313945">
        <div class="container-fluid vh-100">
            <div class="row d-flex justify-content-center align-items-center h-custom">
                <div class="col-md-9 col-lg-6 col-xl-5 text-white">
                    <h3><b>DCSAR</b></h3>
                    <h4>Requisiciones y Almacén para la trazabilidad de las solicitudes de bienes y/o insumos
                    </h4>
                    <img src="{{ asset('img_login/20.png') }}" class="img-fluid" alt="Sample image">
                </div>
                <div class="col-md-8 col-lg-6 col-xl-4 offset-xl-1">
                    <div class="p-2">
                        <h3 class="text-center text-white">Inicio de sesión</h3>
                    </div>
                    <div class="p-3">
                        <form method="POST" action="{{ route('login') }}">
                            @csrf
                            <!-- Email input -->
                            <div class="form-outline mb-4">
                                <label class="form-label text-white" for="email">Correo Electronico</label>
                                <input id="email" type="email"
                                    class="form-control @error('email') is-invalid @enderror" name="email"
                                    placeholder="Ingresa un correo valido" value="{{ old('email') }}" required
                                    autocomplete="email" autofocus>
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <!-- Password input -->

                            <div class="form-outline mb-3">
                                <label class="form-label text-white" for="password">Contraseña</label>
                                <input id="password" type="password"
                                    class="form-control @error('password') is-invalid @enderror"
                                    placeholder="Ingresa una contraseña" name="password" required
                                    autocomplete="current-password">
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>


                            <div class="text-center mt-4 pt-2">
                                <button type="submit" class="btn btn-primary"
                                    style="padding-left: 2.5rem; padding-right: 2.5rem;">Ingresar</button>
                            </div>

                        </form>
                    </div>

                </div>
            </div>
        </div>
    </section>
@endsection
