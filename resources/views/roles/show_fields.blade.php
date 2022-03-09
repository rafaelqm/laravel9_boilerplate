<div class="row">
    <!-- Id Field -->
    <div class="form-group col-sm-1">
        {!! Form::label('id', 'Id:') !!}
        <p class="form-control text-right">{!! $role->id !!}</p>
    </div>

    <!-- Name Field -->
    <div class="form-group col-sm-5">
        {!! Form::label('name', 'Nome:') !!}
        <p class="form-control">{!! $role->name !!}</p>
    </div>

    <!-- Slug Field -->
    <div class="form-group col-sm-6">
        {!! Form::label('slug', 'Slug:') !!}
        <p class="form-control">{!! $role->slug !!}</p>
    </div>

    <!-- Description Field -->
    <div class="form-group col-sm-6">
        {!! Form::label('description', 'Descrição:') !!}
        <p class="form-control">{!! $role->description !!}</p>
    </div>

    <!-- Level Field -->
    <div class="form-group col-sm-6">
        {!! Form::label('level', 'Nível:') !!}
        <p class="form-control">{!! \App\Models\Role::NIVEIS[$role->level] !!}</p>
    </div>


    <!-- Created At Field -->
    <div class="form-group col-sm-4">
        {!! Form::label('created_at', 'Cadastrado em:') !!}
        <p class="form-control text-center">{!! $role->created_at->format('d/m/Y H:i:s') !!}</p>
    </div>

    <!-- Updated At Field -->
    <div class="form-group col-sm-4">
        {!! Form::label('updated_at', 'Atualizado em:') !!}
        <p class="form-control text-center">{!! $role->updated_at->format('d/m/Y H:i:s') !!}</p>
    </div>

    <!-- Active Field -->
    <div class="form-group col-sm-4">
        {!! Form::label('active', 'Ativo:') !!}
        <p class="form-control text-center">{!! visualYesNo($role->active) !!}</p>
    </div>
</div>

<!-- Active Field -->
<div class="form-group">
    {!! Form::label('Permissões', 'Permissões:') !!}
    <p class="form-control">
        @if($role->permissions->count())
        <span class="badge bg-primary">
            {!! $role->permissions()->pluck('permissions.name')->implode('</span> <span class="badge bg-primary">') !!}
        </span>
        @endif
    </p>
</div>


