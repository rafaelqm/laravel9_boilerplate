<!DOCTYPE html>
<html>
<head>
    <meta charset=utf-8/>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="robots" content="noindex">
    <title>Impressão</title>
    <link rel="stylesheet" href="{{public_path('css/bootstrap3.4.1.min.css')}}">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <style media="print">
        .form-control{
            height: auto !important;
            min-height: 38px;
        }
        @page {
            size: A4;
            margin: 1cm 2cm; /* use centimeters or inches depending on your needs */
        }
        @page {
            @bottom-center {
                content: "Página " counter(page) " de " counter(pages);
            }
        }

        .page-break { height:0;page-break-after: always; margin:0; border-top:none;}

        .col-sm-1, .col-sm-2, .col-sm-3, .col-sm-4, .col-sm-5, .col-sm-6, .col-sm-7, .col-sm-8, .col-sm-9, .col-sm-10, .col-sm-11, .col-sm-12 {
            float: left !important;
        }
        .col-sm-12 {
            width: 100% !important;
        }
        .col-sm-11 {
            width: 91.66666667% !important;
        }
        .col-sm-10 {
            width: 83.33333333% !important;
        }
        .col-sm-9 {
            width: 75% !important;
        }
        .col-sm-8 {
            width: 66.66666667% !important;
        }
        .col-sm-7 {
            width: 58.33333333% !important;
        }
        .col-sm-6 {
            width: 50% !important;
        }
        .col-sm-5 {
            width: 41.66666667% !important;
        }
        .col-sm-4 {
            width: 33.33333333% !important;
        }
        .col-sm-3 {
            width: 25% !important;
        }
        .col-sm-2 {
            width: 16.66666667% !important;
        }
        .col-sm-1 {
            width: 8.33333333% !important;
        }

        @media print {
            .container {
                width: auto;
            }
        }
    </style>
</head>
<body>
<div style="page-break-before:always;">
    <div class="content" style="padding-left: 30px; padding-right: 30px; background-color: #ffffff">
        @yield('content')
    </div>
</div>

@yield('scripts')
</body>
</html>
