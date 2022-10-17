<!DOCTYPE html>
<html lang="pt" xml:lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{ config('app.name') }}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('css/bootstrap-datetimepicker.css') }}">

    <!-- AdminLTE -->
    <link rel="stylesheet" href="{{ asset('css/adminlte.3.0.5.min.css') }}"/>
    <link rel="stylesheet" href="{{ asset('css/select2-bootstrap4.min.css') }}"/>
    <link rel="icon" type="image/x-icon" href="{{ asset('/images/logo.png') }}">

    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    @yield('third_party_stylesheets')

    @stack('page_css')
    <style>
        .select2-container {
            width: 100% !important;
        }
    </style>
</head>

<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">
    <!-- Main Header -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#" title="Reduzir/Expandir menu" role="button"
                   data-enable-remember="true"><i class="fas fa-bars"></i></a>
            </li>
        </ul>

        <ul class="navbar-nav ml-auto">
            <li class="nav-item dropdown user-menu">
                <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">
                    <img src="{{ asset('images/icon_user.png') }}"
                         class="user-image img-circle elevation-2" alt="User Image">
                    <span class="d-none d-md-inline">{{ Auth::user()->name }}</span>
                </a>
                <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                    <!-- User image -->
                    <li class="user-header bg-secondary">
                        <img src="{{ asset('images/icon_user.png') }}"
                             class="img-circle elevation-2"
                             alt="User Image">
                        <p>
                            {{ Auth::user()->name }}
                            <small>Cadastro desde {{ Auth::user()->created_at->format('M. Y') }}</small>
                        </p>
                    </li>
                    <!-- Menu Footer-->
                    <li class="user-footer">
                        <a href="/users/{{ auth()->id() }}/edit" class="btn btn-default btn-flat">Perfil</a>

                        <a href="#" class="btn btn-default btn-flat float-right"
                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            Sair
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </li>
                </ul>
            </li>
        </ul>
    </nav>

    <!-- Left side column. contains the logo and sidebar -->
@include('layouts.sidebar')

<!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <section class="content">
            @yield('content')
        </section>
    </div>

<!-- Main Footer -->
    <footer class="main-footer">
        <div class="float-right d-none d-sm-block" title="19/01/2022">
            <strong>Versão</strong> {{ env('APP_VERSION') }}1.0.0
        </div>
        <strong>
            <a href="https://www.somoszix.com.br" title="Criado por studioBRAVO! Sistemas Web">{{ env('APP_NAME') }}</a>
        </strong>
    </footer>
</div>
@yield('modal')

<script src="{{ asset('js/vendor.js') }}"></script>
<script src="{{ asset('js/manifest.js') }}"></script>
<script src="{{ asset('js/app.js') }}"></script>
<script src="{{ asset('js/global_inits.js') }}"></script>
<script src="{{ asset('js/bootstrap-datetimepicker.min.js') }}"></script>
<script src="{{ asset('vendor/datatables/dataTables.responsive.js') }}"></script>
<script src="{{ asset('js/bs-custom-file-input.min.js') }}"></script>

<!-- AdminLTE App -->
<script src="{{ asset('js/adminlte.3.0.5.min.js') }}"></script>

<script src="{{ asset('js/jquery.maskMoney3.0.2.min.js') }}"></script>

<script>
    $(function () {
        bsCustomFileInput.init();
    });

    $('input[data-bootstrap-switch]').each(function () {
        $(this).bootstrapSwitch('state', $(this).prop('checked'));
    });
</script>

@yield('third_party_scripts')

@stack('page_scripts')
@stack('scripts')
<script type="text/javascript">
    function askDelete (id, route) {
        Swal.fire({
            title: "{{ ucfirst( __('crud.are_you_sure') ) }}?",
            text: "{{ ucfirst( __('crud.you-will-not-be-able-to-recover-this-registry') ) }}!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc3545',
            // cancelButtonColor: '#f8f9fa',
            confirmButtonText: '{{ ucfirst( __('crud.yes') ) }}, {{ ucfirst( __('crud.delete') ) }}!',
            cancelButtonText: '{{ ucfirst( __('crud.cancel') ) }}',
            showLoaderOnConfirm: true,
            reverseButtons: true,
            preConfirm: function() {
                return new Promise(function(resolve, reject) {
                    sureDelete(id, route, resolve);
                });
            }
        }).then(function () {
            Swal.close();
        });
    }

    function sureDelete (id, route, finish) {
        $.post(route, {
            'id': id,
            '_method': 'DELETE',
            '_token': $('meta[name="csrf-token"]').attr('content'),
            type: 'POST',
        }).done(function (retorno) {
            if (retorno.success) {
                Swal.fire('{{ ucfirst( __('crud.deleted') ) }}', '', 'success');
                window.LaravelDataTables['dataTableBuilder'].draw(false);
                return finish();
            }
            Swal.fire('Erro', retorno.message, 'error');
            return finish();
        }).fail(function (response) {
            var text = response.responseJSON ? response.responseJSON.message : false;
            var link = response.responseJSON ? response.responseJSON.link_option : false;
            var type = response.responseJSON ? response.responseJSON.type : false;

            var options = {
                title: '',
                text: text || 'Error',
                type: type || 'error',
            };

            Swal.fire(options).then(function (isConfirm) {
                if (!isConfirm && link && link.length) {
                    location.href = link;
                }
            });
            return finish();
        });
    }

    function ativaFiltrosDT() {
        setTimeout(() => {
            iniciaSelect2('select2lazy');
        }, 500);
    }

    function startLoading () {
        if (!$('.loader').length) {
            $('body').append('<div class="loader"></div>');
        }
    }

    function stopLoading () {
        if ($('.loader').length) {
            $('.loader').fadeToggle(function () {
                $(this).remove();
            });
        }
    }

    $(document).on('select2:open', () => {
        document.querySelector('.select2-search__field').focus();
    });

    var userPermission = {!! json_encode(auth()->user()->getPermissions()->pluck('slug')) !!}
</script>

</body>
</html>
