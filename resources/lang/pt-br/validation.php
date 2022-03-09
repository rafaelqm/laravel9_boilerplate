<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    'accepted' => 'O campo :attribute deve ser aceito.',
    'active_url' => 'O campo :attribute é não uma URL válida.',
    'after' => 'O campo :attribute deve ser uma data após :date.',
    'after_or_equal' => 'O campo :attribute deve ser uma data igual ou posterior à :date.',
    'alpha' => 'O campo :attribute pode apenas conter letras.',
    'alpha_dash' => 'O campo :attribute pode apenas conter letras, números, e pontos.',
    'alpha_num' => 'O campo :attribute pode apenas conter letras e números.',
    'array' => 'O campo :attribute deve ser uma lista.',
    'before' => 'O campo :attribute deve ser um data anterior à :date.',
    'before_or_equal' => 'O campo :attribute deve ser uma data anterior ou igual à :date.',
    'between' => [
        'numeric' => 'O campo :attribute deve ser entre :min e :max.',
        'file' => 'O campo :attribute deve ser entre :min e :max kb.',
        'string' => 'O campo :attribute deve ser entre :min e :max caracteres.',
        'array' => 'O campo :attribute deve have entre :min e :max itens.',
    ],
    'boolean' => 'O campo :attribute deve ser verdadeiro ou falso.',
    'confirmed' => 'O campo :attribute confirmação não combina.',
    'date' => 'O campo :attribute é não um válida data.',
    'date_equals' => 'O campo :attribute deve ser uma data igual à :date.',
    'date_format' => 'O campo :attribute não está no formato :format.',
    'different' => 'O campo :attribute e :other devem ser diferentes.',
    'digits' => 'O campo :attribute deve ter :digits dígitos.',
    'digits_between' => 'O campo :attribute deve ter entre :min e :max dígitos.',
    'dimensions' => 'O campo :attribute tem dimensões de imagens erradas.',
    'distinct' => 'O :attribute campo tem um valor duplicado.',
    'email' => 'O campo :attribute deve ser um e-mail válido.',
    'exists' => 'O campo selected :attribute é inválido.',
    'file' => 'O campo :attribute deve ser um arquivo.',
    'filled' => 'O campo :attribute é requerido.',
    'gt' => [
        'numeric' => 'o campo :attribute deve ser maior que :value.',
        'file' => 'o campo :attribute deve ser maior que :value kilobytes.',
        'string' => 'o campo :attribute deve ter mais que :value caracteres.',
        'array' => 'o campo :attribute deve ter mais que :value itens.',
    ],
    'gte' => [
        'numeric' => 'o campo :attribute deve ser maior ou igual à :value.',
        'file' => 'o campo :attribute deve ser maior ou igual à :value kilobytes.',
        'string' => 'o campo :attribute deve ter mais a quantidade de :value caracteres.',
        'array' => 'o campo :attribute deve ter :value itens ou mais.',
    ],
    'image' => 'O campo :attribute deve ser uma imagem.',
    'in' => 'O campo selected :attribute é inválido.',
    'in_array' => 'O :attribute campo não existe em :other.',
    'integer' => 'O campo :attribute deve ser um inteiro.',
    'ip' => 'O campo :attribute deve ser um endereço de IP válido.',
    'ipv4' => 'O campo :attribute deve ser um endereço IPv4 válido.',
    'ipv6' => 'O campo :attribute deve ser um endereço IPv6 válido.',
    'json' => 'O :attribute precisa ser um texto JSON válido.',
    'lt' => [
        'numeric' => 'O campo :attribute deve ser menor que :value.',
        'file' => 'O campo :attribute deve ser menor que :value kilobytes.',
        'string' => 'O campo :attribute deve ser menor que :value caracteres.',
        'array' => 'O campo :attribute deve ter menos que :value itens.',
    ],
    'lte' => [
        'numeric' => 'O campo :attribute deve ser menor que or equal :value.',
        'file' => 'O campo :attribute deve ser menor ou igual à :value kilobytes.',
        'string' => 'O campo :attribute deve ser menor ou igual à :value caracteres.',
        'array' => 'O campo :attribute deve não deve ter mais que :value itens.',
    ],
    'max' => [
        'numeric' => 'O campo :attribute não pode ser maior que :max.',
        'file' => 'O campo :attribute não pode ser maior que :max kb.',
        'string' => 'O campo :attribute não pode ser maior que :max caracteres.',
        'array' => 'O campo :attribute não pode ter mais que :max itens.',
    ],
    'mimes' => 'O campo :attribute deve ser um arquivo do tipo: :values.',
    'mimetypes' => 'O campo :attribute deve ser um arquivo do tipo: :values.',
    'min' => [
        'numeric' => 'O campo :attribute deve ter no mínimo :min.',
        'file' => 'O campo :attribute deve ter no mínimo :min kb.',
        'string' => 'O campo :attribute deve ter no mínimo :min caracteres.',
        'array' => 'O campo :attribute deve ter no mínimo :min itens.',
    ],
    'not_in' => 'O campo selecionado :attribute é inválido.',
    'not_regex' => 'O campo :attribute tem o formato inválido.',
    'numeric' => 'O campo :attribute deve ser um número.',
    'present' => 'O campo :attribute deve estar presente.',
    'regex' => 'O campo :attribute formato é inválido.',
    'required' => 'O campo :attribute é requerido.',
    'required_if' => 'O campo :attribute é requerido quando :other é :value.',
    'required_unless' => 'O :attribute campo é requerido à menos que :other esteja em :values.',
    'required_with' => 'O campo :attribute é requerido quando :values está presente.',
    'required_with_all' => 'O campo :attribute é requerido quando :values está presente.',
    'required_without' => 'O campo :attribute é requerido quando :values está não presente.',
    'required_without_all' => 'O campo :attribute é requerido quando nenhum dos :values estão presente.',
    'same' => 'O campo :attribute e :other devem combinar.',
    'size' => [
        'numeric' => 'O campo :attribute deve ser :size.',
        'file' => 'O campo :attribute deve ser :size kb.',
        'string' => 'O campo :attribute deve ser :size caracteres.',
        'array' => 'O campo :attribute deve conter :size itens.',
    ],
    'starts_with' => 'O :attribute deve iniciar com algum dos seguintes valores: :values',
    'ends_with' => 'O campo :attribute deve terminar com algum dos seguintes valores: :values',
    'string' => 'O campo :attribute deve ser um texto.',
    'timezone' => 'O campo :attribute deve ser um Fuso Horário válido.',
    'unique' => 'O campo :attribute já está sendo usado.',
    'uploaded' => 'O campo :attribute falhou ao ser enviado.',
    'url' => 'O campo :attribute formato é inválido.',
    'uuid' => 'O campo :attribute deve ser um UUID válido.',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you can specify custom validation messages for attributes using O
    | convention "attribute.rule" to name O lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
//        'addresses.*.zipcode' => [
//            'required' => 'O campo CEP é requerido.',
//        ],
//        'addresses.*.street' => [
//            'required' => 'O campo Rua é requerido.',
//        ],
//        'addresses.*.number' => [
//            'required' => 'O campo Número é requerido.',
//        ],
//        'addresses.*.neighborhood' => [
//            'required' => 'O campo Bairro é requerido.',
//        ],
//        'addresses.*.city_id' => [
//            'required' => 'O campo Cidade é requerido.',
//        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | O following language lines are used to swap attribute place-holders
    | with something more reader friendly such as E-Mail Address instead
    | of "email". This simply helps us make messages a little cleaner.
    |
    */

    'attributes' => [
        'client_id' => 'Cliente',
        'start_date_scheduled' => 'Data Início',
        'end_date_scheduled' => 'Data Final',
        'place_address' => 'Endereço',
        'user_id' => 'Usuário',
        'schedule_status_id' => 'Status',
        'council' => 'Conselho',
        'council_number' => 'Número do Conselho',
        'council_state' => 'Estado do Conselho',
        'person_id' => 'Pessoa',
        'city_id' => 'Cidade',
        'code' => 'Código',
        'sus_card' => 'Cartão do SUS',
        'files_pdf' => 'Arquivos PDF',
        'name' => 'Nome',
        'password' => 'Senha',
        'email' => 'E-mail',
        'slug' => 'Slug',
        'description' => 'Descrição',
        'level' => 'Nível',
        'full_name' => 'Nome Completo',
        'zipcode' => 'CEP',
        'state' => 'Estado',
        'type' => 'Tipo',
        'color' => 'Cor',
        'gender' => 'Sexo',
        'birthday' => 'Data Nascimento'
    ],
];
