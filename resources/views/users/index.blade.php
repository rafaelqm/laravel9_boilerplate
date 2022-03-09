@extends('layouts.app')

@section('content')
    <ol class="row breadcrumb">
        <li class="breadcrumb-item">
            <a href="{!! route('home') !!}">Home</a>
        </li>
        <li class="breadcrumb-item">Usuários</li>
    </ol>

    <div class="container-fluid">
        <div class="animated fadeIn">
            @include('flash::message')
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <i class="fa fa-users"></i>
                            Usuários
                            @permission('create.users')
                            <a class="btn btn-primary btn-sm float-right" href="{{ route('users.create') }}">
                                <i class="fa fa-plus"></i> {{ __('crud.add_new') }}
                            </a>
                            @endpermission
                        </div>
                        <div class="card-body">
                            @include('users.table')
                            <div class="pull-right mr-3">

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
