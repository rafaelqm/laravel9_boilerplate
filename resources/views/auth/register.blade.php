@extends('layouts.guest')
@section('content')
    <div class="hold-transition login-page">
        <div class="login-box">
            <div class="login-logo">
                <h1>
                    <a href="{{ url('/home') }}">
                        <img src="{{ asset('/images/logo.png') }}" width="150" />
                    </a>
                </h1>
                {{ config('app.name') }}
            </div>

            <!-- /.login-logo -->

            <!-- /.login-box-body -->
            <div class="card">
                <div class="card-body login-card-body">

                    <p class="login-box-msg"></p>

                    <form method="post" action="{{ url('/login') }}">
                        @csrf

                        <div class="input-group mb-3">
                            <input type="email"
                                   name="email"
                                   value="{{ old('email') }}"
                                   placeholder="E-mail ou nome de usuário"
                                   class="form-control @error('email') is-invalid @enderror">
                            <div class="input-group-append">
                                <div class="input-group-text"><span class="fas fa-envelope"></span></div>
                            </div>
                            @error('email')
                            <span class="error invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="input-group mb-3">
                            <input type="password"
                                   name="password"
                                   placeholder="Senha"
                                   class="form-control @error('password') is-invalid @enderror">
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-lock"></span>
                                </div>
                            </div>
                            @error('password')
                            <span class="error invalid-feedback">{{ $message }}</span>
                            @enderror

                        </div>

                        <div class="row">
                            <div class="col-8">
                                <div class="icheck-primary">
                                    <input type="checkbox" id="remember">
                                    <label for="remember">Manter conectado</label>
                                </div>
                            </div>

                            <div class="col-4">
                                <button type="submit" class="btn btn-primary btn-block">
                                    Acessar
                                </button>
                            </div>

                        </div>
                    </form>

                    <p class="mb-1">
                        <a href="{{ route('password.request') }}">Esqueci a senha</a>
                    </p>
                    {{--<p class="mb-0">
                        <a href="{{ route('register') }}" class="text-center">Register a new membership</a>
                    </p>--}}
                </div>
                <!-- /.login-card-body -->
            </div>

        </div>
        <!-- /.login-box -->
    </div>
@stop
