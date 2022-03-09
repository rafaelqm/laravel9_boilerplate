@extends('layouts.app')

@section('content')
    <ol class="row breadcrumb">
        <li class="breadcrumb-item">
            <a href="{!! route('home') !!}">Home</a>
        </li>
        <li class="breadcrumb-item">
            <a href="{!! route('roles.index') !!}">Papéis/Cargos</a>
        </li>
        <li class="breadcrumb-item active">Criar</li>
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">
            @include('adminlte-templates::common.errors')
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <i class="fa fa-users-cog"></i>
                            <strong>Criar Papel/Cargo</strong>
                        </div>
                        <div class="card-body">
                            {!! Form::open(['route' => 'roles.store']) !!}
                            <div class="row">
                                @include('roles.fields')
                            </div>

                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
