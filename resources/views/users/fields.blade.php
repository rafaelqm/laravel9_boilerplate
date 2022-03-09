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
    <!-- Email Field -->
    <div class="form-group col-sm-4">
        {!! Form::label('username', 'Nome de Usuário:') !!}
        {!! Form::text('username', null, ['class' => 'form-control']) !!}
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

    <div class="form-group col-sm-12">
        {!! Form::label('person_id', 'Vincular Pessoas') !!}
        <select style="width: 100%;" name="person_id" multiple
                id="person_id" class="form-control select2">
            @foreach($people as $person)
                <option selected value="{{ $person->id }}">{{ $person->name }} - {{ $person->cpf_cnpj }}</option>
            @endforeach
        </select>
    </div>
    @endlevel

</div>
@push('scripts')
    <script type="text/javascript">
        $(function () {

            $('#person_id').select2({
                allowClear: true,
                placeholder: "Informe o Nome, CPF ou CNPJ",
                language: "pt-BR",
                theme: 'bootstrap4',

                ajax: {
                    url: "{{ route('persons.search.associate.user') }}",
                    dataType: 'json',
                    delay: 250,
                    data: function (params) {
                        return {
                            q: params.term, // search term
                            page: params.page
                        };
                    },
                    processResults: function (result, params) {
                        params.page = params.page || 1;
                        return {
                            results: result.data,
                            pagination: {
                                more: (params.page * result.per_page) < result.total
                            }
                        };
                    },
                    cache: true
                },
                escapeMarkup: function (markup) {
                    return markup;
                },
                minimumInputLength: 1,
                templateResult: formatResult,
                templateSelection: formatResultSelection
            });
        });

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
