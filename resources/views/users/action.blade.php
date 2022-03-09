<div class='btn-group'>
    <a href="{{ route('users.show', [$id]) }}" title="Exibir" class='btn btn-sm btn-outline-primary'>
        <i class="far fa-eye"></i>
    </a>
    <a href="{{ route('users.edit', [$id]) }}" title="Editar" class='btn btn-sm btn-outline-warning'>
        <i class="far fa-edit"></i>
    </a>
    {!! Form::button('<i class="fa fa-trash"></i>', [
        'type' => 'button',
        'title' => 'Remover',
        'class' => 'btn btn-sm btn-outline-danger',
        'onclick' => "askDelete(".$id.", '". route('users.destroy', [$id])."')"
    ]) !!}
</div>
