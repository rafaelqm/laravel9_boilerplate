@extends('layouts.app')

@section('content')
    <ol class="row breadcrumb">
        <li class="breadcrumb-item">
            <a href="{!! route('home') !!}">Home</a>
        </li>
        <li class="breadcrumb-item">
            <a href="{!! route('users.index') !!}">Usuários</a>
        </li>
        <li class="breadcrumb-item">Criar Usuários</li>
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
                            Criar Usuário
                        </div>
                        <div class="card-body">
                            {!! Form::open(['route' => 'users.store']) !!}
                            @include('users.fields')
                            {!! Form::close() !!}
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
