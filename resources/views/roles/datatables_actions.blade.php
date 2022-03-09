<div class='btn-group'>
    <a href="{{ route('roles.show', $id) }}" title="Exibir" class='btn btn-sm btn-outline-primary'>
       <i class="fa fa-eye"></i>
    </a>
    @if($id !== 1)
        <a href="{{ route('roles.edit', $id) }}" title="Editar" class='btn btn-sm btn-outline-warning'>
           <i class="fa fa-edit"></i>
        </a>
        @if($id > 5)
            {!! Form::button('<i class="fa fa-trash"></i>', [
                'type' => 'button',
                'title' => 'Remover',
                'class' => 'btn btn-sm btn-outline-danger',
                'onclick' => "askDelete(".$id.", '".
                    route('roles.destroy', [$id]) .
                "')"
            ]) !!}
        @endif
    @endif
</div>
