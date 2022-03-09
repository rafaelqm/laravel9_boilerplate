@extends('layouts.app')

@section('content')
    <ol class="row breadcrumb">
        <li class="breadcrumb-item">
            <a href="{!! route('home') !!}">Home</a>
        </li>
        <li class="breadcrumb-item">Papéis</li>
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">
             @include('flash::message')
             <div class="row">
                 <div class="col-lg-12">
                     <div class="card">
                         <div class="card-header">
                             <i class="fa fa-users-cog"></i>
                             Papéis / Cargos
                             @permission('roles.create')
                             <a class="btn btn-primary btn-sm float-right" href="{{ route('roles.create') }}">
                                <i class="fa fa-plus"></i> {{ __('crud.add_new') }}
                             </a>
                             @endpermission
                         </div>
                         <div class="card-body">
                             @include('roles.table')
                              <div class="pull-right mr-3">

                              </div>
                         </div>
                     </div>
                  </div>
             </div>
         </div>
    </div>
@endsection

