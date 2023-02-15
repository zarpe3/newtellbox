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

mix.js('resources/js/app.js', 'public/js')
    .vue()
    .sass('resources/sass/app.scss', 'public/css');
mix.js('resources/js/softphone.js', 'public/js');
mix.js('resources/js/routes.js', 'public/js');
mix.js('resources/js/trunks.js', 'public/js');
mix.js('resources/js/inbounds.js', 'public/js');
mix.js('resources/js/users.js', 'public/js');
mix.js('resources/js/queue.js', 'public/js');
mix.js('resources/js/voicemail.js', 'public/js');
mix.js('resources/js/mailing.js', 'public/js');