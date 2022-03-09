@extends('layouts.app')

@section('content')
    <ol class="row breadcrumb">
        <li class="breadcrumb-item">
            <a href="{!! route('home') !!}">Home</a>
        </li>
        <li class="breadcrumb-item">
            <a href="{!! route('users.index') !!}">Usuários</a>
        </li>
        <li class="breadcrumb-item">Exibir Usuário</li>
    </ol>

    <div class="container-fluid">
        <div class="animated fadeIn">
            @include('adminlte-templates::common.errors')
            @include('flash::message')
            <div class="row">
                <div class="col-lg-12">

                    <div class="card">
                        <div class="card-header">
                            <i class="fa fa-users"></i>
                            Exibir Usuário {{ $user->id . ' - ' . $user->name }}
                            <a href="{{ route('users.index') }}" class="btn btn-light float-right">
                                <i class="fas fa-arrow-left"></i>
                                {{ __('crud.back') }}
                            </a>
                        </div>
                        <div class="card-body">
                            @include('users.show_fields')
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
