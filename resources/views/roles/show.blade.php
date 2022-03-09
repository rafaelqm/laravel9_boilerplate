@extends('layouts.app')

@section('content')
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="{!! route('home') !!}">Home</a>
        </li>
        <li class="breadcrumb-item">
            <a href="{!! route('roles.index') !!}">Papéis/Cargos</a>
        </li>
        <li class="breadcrumb-item active">Detalhes</li>
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">
            @include('adminlte-templates::common.errors')
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <i class="fa fa-users-cog"></i>
                            <strong>Detalhe</strong>
                            <a href="{{ route('roles.index') }}" class="btn btn-light float-right">
                                <i class="fas fa-arrow-left"></i>
                                {{ __('crud.back') }}
                            </a>
                        </div>
                        <div class="card-body">
                            @include('roles.show_fields')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
