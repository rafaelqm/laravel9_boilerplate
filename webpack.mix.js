const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.js('resources/js/app.js', 'public/js').
  extract([
    'bootstrap',
    'jquery',
    'lodash',
    'popper.js',
    'moment',
    'perfect-scrollbar',
    'datatables.net-bs4',
    'bootstrap4-toggle',
    'select2',
    'jquery-mask-plugin',
    'sweetalert2',
]).
  sass('resources/sass/app.scss', 'public/css').
  copy(
    'resources/js/libs/bootstrap-datetimepicker/bootstrap-datetimepicker.min.js',
    'public/js/bootstrap-datetimepicker.min.js').
  copy(
    'resources/js/libs/bootstrap-datetimepicker/bootstrap-datetimepicker.css',
    'public/css/bootstrap-datetimepicker.css').
  copy('resources/js/global_inits.js', 'public/js/global_inits.js').
  copy('resources/js/general-filters.js', 'public/js/general-filters.js');
