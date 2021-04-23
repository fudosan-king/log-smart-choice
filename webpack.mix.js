const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel applications. By default, we are compiling the CSS
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.js('resources/js/app.js', 'public/js');
mix.js('resources/js/frontend.js', 'public/js');
mix.js('resources/js/globalHelper.js', 'public/js');
mix.styles('resources/css/app.css', 'public/css/app.css');
mix.styles('resources/css/estates_images.css', 'public/css/estate.css');
mix.styles('resources/css/custom-css-voyager.css', 'public/css/custom-css-voyager.css');