<div class="row">

    <!-- Name Field -->
    <div class="form-group col-sm-3">
        {!! Form::label('name', 'Nome:') !!}
        {!! Form::text('name', null, ['class' => 'form-control', 'required']) !!}
    </div>

    <!-- Slug Field -->
    <div class="form-group col-sm-3">
        {!! Form::label('slug', 'Slug:') !!}
        {!! Form::text('slug', null, ['class' => 'form-control', 'required']) !!}
    </div>

    <!-- Description Field -->
    <div class="form-group col-sm-6">
        {!! Form::label('description', 'Descrição:') !!}
        {!! Form::text('description', null, ['class' => 'form-control']) !!}
    </div>

    <!-- Level Field -->
    <div class="form-group col-sm-6">
        {!! Form::label('level', 'Nível:') !!}
        {!! Form::select('level', \App\Models\Role::NIVEIS , null, ['class' => 'form-control select2', 'required']) !!}
    </div>

    <!-- Active Field -->
    <div class="col-sm-6">
        {!! Form::label('active', 'Ativo:') !!}
        <div class="form-control text-center">
            {!! Form::hidden('active', '0', ['id'=>'activehidden']) !!}
            <div class="icheck-primary">
                {!! Form::checkbox('active', '1', null, ['class' => '']) !!}
                <label for="active">Ativo</label>
            </div>
        </div>
    </div>

    <!-- Roles Field -->
    <div class="form-group col-sm-12">
        {!! Form::label('permissions', 'Permissões:') !!}
        {!! Form::select(
            'permissions[]',
            \App\Models\Permission::orderBy('slug')->pluck('name', 'id')->toArray(),
             isset($role) ? $role->permissions()->pluck('permission_id') : null,
             [
                'class' => 'form-control select2',
                'multiple' => 'multiple'
             ]
             ) !!}
    </div>
    @include('layouts.submit-buttons', ['back_route' => route('roles.index')])
</div>
