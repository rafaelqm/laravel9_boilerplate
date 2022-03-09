<!DOCTYPE html>
<html>
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
</head>

<body class="hold-transition layout-fixed">
<div class="wrapper">
    <div class="">
        <section class="content" style="padding: 5px">
            @yield('content')
        </section>
    </div>
</div>

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

    var userPermission = {!! json_encode(auth()->user()->getPermissions()->pluck('slug')) !!}
</script>

</body>
</html>
