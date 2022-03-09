@extends('layouts.app')

@section('content')
    <ol class="row breadcrumb">
        <li class="breadcrumb-item">
            <a href="{!! route('home') !!}">Home</a>
        </li>
        @level(5)
        <li class="breadcrumb-item">
            <a href="{!! route('users.index') !!}">Usuários</a>
        </li>
        @endlevel
        <li class="breadcrumb-item">Editar Usuário</li>
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
                            Editar Usuário {{ $user->id . ' - ' . $user->name }}
                        </div>
                        <div class="card-body">
                            {!! Form::model($user, ['route' => ['users.update', $user->id], 'method' => 'patch']) !!}
                            @include('users.fields')
                            {!! Form::close() !!}
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
