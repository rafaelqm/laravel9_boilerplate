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
            </div>

            <!-- /.login-logo -->
            <div class="card">
                <div class="card-body login-card-body">
                    <p class="login-box-msg">Esqueceu sua senha? Aqui você consegue facilmente redefinir uma nova.</p>

                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form action="{{ route('password.email') }}" method="post">
                        @csrf

                        <div class="input-group mb-3">
                            <input type="email"
                                   name="email"
                                   class="form-control @error('email') is-invalid @enderror"
                                   placeholder="E-Mail">
                            <div class="input-group-append">
                                <div class="input-group-text"><span class="fas fa-envelope"></span></div>
                            </div>
                            @error('email')
                            <span class="error invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary btn-block">
                                    Redefinir senha
                                </button>
                            </div>
                            <!-- /.col -->
                        </div>
                    </form>

                    <p class="mt-3 mb-1">
                        <a href="{{ route("login") }}">Acessar</a>
                    </p>
                </div>
                <!-- /.login-card-body -->
            </div>
        </div>
        <!-- /.login-box -->

    </div>
@stop
