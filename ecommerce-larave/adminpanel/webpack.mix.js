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

mix
.sass('resources/assets/scss/app.scss', 'public/web/css')
.sass('resources/assets/scss/app.theme.1.scss', 'public/web/css')
.sass('resources/assets/scss/app.theme.2.scss', 'public/web/css')
.sass('resources/assets/scss/app.theme.3.scss', 'public/web/css')
.sass('resources/assets/scss/app.theme.4.scss', 'public/web/css')
.sass('resources/assets/scss/app.theme.5.scss', 'public/web/css')
.sass('resources/assets/scss/app.theme.6.scss', 'public/web/css')
.sass('resources/assets/scss/app.theme.7.scss', 'public/web/css')
.sass('resources/assets/scss/app.theme.8.scss', 'public/web/css')
.sass('resources/assets/scss/app.theme.9.scss', 'public/web/css')
.sass('resources/assets/scss/app.theme.10.scss', 'public/web/css')
.sass('resources/assets/scss/app.theme.11.scss', 'public/web/css')
.sass('resources/assets/scss/app.theme.12.scss', 'public/web/css')
.sass('resources/assets/scss/app.theme.13.scss', 'public/web/css')
.sass('resources/assets/scss/app.theme.14.scss', 'public/web/css')
.sass('resources/assets/scss/app.theme.15.scss', 'public/web/css')
.sass('resources/assets/scss/app.theme.16.scss', 'public/web/css')
.sass('resources/assets/scss/app.theme.17.scss', 'public/web/css')
.sass('resources/assets/scss/app.theme.18.scss', 'public/web/css')
.sass('resources/assets/scss/app.theme.19.scss', 'public/web/css');
   

mix.copy('resources/assets/webfonts', 'public/web/webfonts');

mix.js('resources/assets/js/app.js', 'public/web/js')
.js('resources/assets/js/checkout.js', 'public/web/js')
.js('resources/assets/js/ecommerce.js', 'public/web/js')
.js('resources/assets/js/stripe.js', 'public/web/js')
.js('resources/assets/js/scripts.js', 'public/web/js')
.js('resources/assets/js/setup.js', 'public/web/js');
