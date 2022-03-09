@extends('layouts.app')

@section('content')
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="{!! route('home') !!}">Home</a>
        </li>
        <li class="breadcrumb-item">
            <a href="{!! route('roles.index') !!}">Papéis/Cargos</a>
        </li>
        <li class="breadcrumb-item active">Editar</li>
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">
            @include('adminlte-templates::common.errors')
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <i class="fa fa-users-cog"></i>
                            <strong>Editar Papel/Cargo</strong>
                        </div>
                        <div class="card-body">
                            {!! Form::model($role, ['route' => ['roles.update', $role->id], 'method' => 'patch']) !!}
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
