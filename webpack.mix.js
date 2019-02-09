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

mix.js([
      'resources/js/app.js', 
      'resources/js/theme/jquery.easing.min.js', 
      'resources/js/theme/jqBootstrapValidation.min.js',
      'resources/js/theme/contact_me.min.js',
      'resources/js/theme/agency.min.js'
   ], 'public/js')
   .sass('resources/sass/app.scss', 'public/css')
   .styles([
      'resources/css/agency.min.css',
      'resources/fontawesome-free/css/all.min.css'
   ], 'public/css/theme.css');
