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

    <div class="card">
        <div class="card-body login-card-body">
            <p class="login-box-msg">Você está à um passo de sua nova senha, redefina uma nova.</p>

            <form action="{{ route('password.update') }}" method="POST">
                @csrf

                <input type="hidden" name="token" value="{{ $token }}">

                <div class="input-group mb-3">
                    <input type="email"
                           name="email"
                           value="{{ $email ?? old('email') }}"
                           class="form-control @error('email') is-invalid @enderror"
                           placeholder="E-mail">
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
                           class="form-control @error('password') is-invalid @enderror"
                           placeholder="Senha">
                    <div class="input-group-append">
                        <div class="input-group-text"><span class="fas fa-lock"></span></div>
                    </div>
                    @error('password')
                    <span class="error invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="input-group mb-3">
                    <input type="password"
                           name="password_confirmation"
                           class="form-control"
                           placeholder="Confirme sua senha">
                    <div class="input-group-append">
                        <div class="input-group-text"><span class="fas fa-lock"></span></div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary btn-block">Redefinir senha</button>
                    </div>
                    <!-- /.col -->
                </div>
            </form>

            <p class="mt-3 mb-1">
                <a href="{{ route('login') }}">Acessar</a>
            </p>
        </div>
        <!-- /.login-card-body -->
    </div>

</div>
</div>
@stop
