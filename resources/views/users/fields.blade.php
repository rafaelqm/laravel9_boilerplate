<div class="row">
    <!-- Name Field -->
    <div class="form-group col-sm-6">
        {!! Form::label('name', 'Nome:') !!}
        {!! Form::text('name', null, ['class' => 'form-control', 'required']) !!}
    </div>


    <!-- Email Field -->
    <div class="form-group col-sm-6">
        {!! Form::label('email', 'E-mail:') !!}
        {!! Form::email('email', null, ['class' => 'form-control', 'required']) !!}
    </div>


    <!-- Password Field -->
    <div class="form-group col-sm-4">
        {!! Form::label('password', 'Senha:') !!}
        {!! Form::password('password', ['class' => 'form-control', 'required']) !!}
    </div>

    {{--Apenas SuperAdmin--}}
    @level(5)
    <!-- Active Field -->
    <div class="form-group col-sm-4">
        {!! Form::label('active', 'Ativo:') !!}
        <div class="form-control text-center">
            {!! Form::hidden('active', false, ['id'=>'activehidden']) !!}
            <div class="icheck-primary">
                {!! Form::checkbox('active', '1', null, ['class' => '']) !!}
                <label for="active">Ativo</label>
            </div>
        </div>
    </div>


    <!-- Active Field -->
    <div class="form-group col-sm-12">
        {!! Form::label('roles', 'Papéis/Cargos:') !!}
        {!! Form::select(
            'roles[]',
            \App\Models\Role::where('active', 1)->pluck('name', 'id')->toArray(),
             null,
             [
                'class' => 'form-control select2',
                'multiple' => 'multiple'
             ]
             ) !!}
    </div>

    @endlevel

</div>
@push('scripts')
    <script type="text/javascript">
        // $(function () {
        //
        // });

        function formatResult(obj) {
            if (obj.loading) return obj.text;
            var markup = "<div class='select2resultobj clearfix'>" +
                "   <div class='select2resultobj__meta'>" +
                "       <div class='select2resultobj__title'>" +
                obj.name
            "</div>" +
            "   </div>" +
            "</div>";

            return markup;
        }

        function formatResultSelection(obj) {
            if (obj.name) {
                return obj.name
            }
            return obj.text;
        }
    </script>
@endpush
@include('layouts.submit-buttons', ['back_route' => (auth()->user()->level() > 4 ? route('users.index') : '/')])
