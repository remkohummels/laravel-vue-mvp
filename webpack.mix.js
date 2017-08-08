const {mix} = require('laravel-mix');

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

mix.js('resources/assets/js/app.js', 'public/js')
    .extract(['vue'])
    .scripts([
        'resources/assets/js/vendors/jquery.min.js',
        'resources/assets/js/vendors/bootstrap.min.js',
        'resources/assets/js/vendors/jquery.mixitup.js',
        'resources/assets/js/vendors/owl.carousel.js',
        'resources/assets/js/vendors/wow.min.js',
        'resources/assets/js/vendors/jquery.magnific-popup.js'
    ], 'public/js/all.js')
    .copy('resources/assets/images', 'public/images')
    .copy('resources/assets/css', 'public/css')
    .sass('resources/assets/sass/app.scss', 'public/css')
    .sass('resources/assets/sass/pages/frontend/pdf/product_mix_table.scss', 'public/css')
    .sass('resources/assets/sass/pages/frontend/pdf/sales_input_table.scss', 'public/css')
    .sass('resources/assets/sass/pages/frontend/pdf/cooking_schedule_table.scss', 'public/css');
