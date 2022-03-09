<div class="row">
    <!-- Id Field -->
    <div class="form-group col-sm-6">
        {!! Form::label('id', 'Id:') !!}
        <p class="form-control">{!! $user->id !!}</p>
    </div>

    <!-- Name Field -->
    <div class="form-group col-sm-6">
        {!! Form::label('name', 'Nome:') !!}
        <p class="form-control">{!! $user->name !!}</p>
    </div>

    <!-- Email Field -->
    <div class="form-group col-sm-6">
        {!! Form::label('email', 'E-Mail:') !!}
        <p class="form-control">{!! $user->email !!}</p>
    </div>

    <!-- Email Verified At Field -->
    <div class="form-group col-sm-6">
        {!! Form::label('email_verified_at', 'E-Mail Verificado em:') !!}
        <p class="form-control">{!! $user->email_verified_at !!}</p>
    </div>
    <div class="form-group col-sm-12">
        {!! Form::label('created_at', 'Usuários:') !!}
        <p class="form-control">
            @foreach($user->userPeople as $person)
                <span class="badge bg-secondary">{{ $person->name }} - {{ $person->cpf_cnpj }}</span>
            @endforeach
        </p>
    </div>
    <!-- Created At Field -->
    <div class="form-group col-sm-6">
        {!! Form::label('created_at', 'Criado em:') !!}
        <p class="form-control">{!! $user->created_at->format('d/m/Y H:i:s') !!}</p>
    </div>

    <!-- Updated At Field -->
    <div class="form-group col-sm-6">
        {!! Form::label('updated_at', 'Atualizado em:') !!}
        <p class="form-control">{!! $user->updated_at->format('d/m/Y H:i:s') !!}</p>
    </div>

    <!-- Active Field -->
    <div class="form-group col-sm-6">
        {!! Form::label('active', 'Ativo:') !!}
        <p class="form-control">{!! visualYesNo($user->active) !!}</p>
    </div>

    <!-- Roles Field -->
    <div class="form-group col-sm-12">
        {!! Form::label('roles', 'Papéis/Cargos:') !!}
        <p class="form-control">
            @if($user->roles->count())
                @foreach($user->roles as $role)
                    <span class="badge badge-secondary">
                    {{ $role->name }}
                </span> &nbsp;
                @endforeach
            @endif
        </p>
    </div>
</div>



