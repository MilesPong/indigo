const { mix } = require('laravel-mix');

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

// Backend
mix.js('resources/assets/admin/js/admin.js', 'public/js')
   .sass('resources/assets/admin/sass/admin.scss', 'public/css')
   .less('resources/assets/admin/less/adminlte.less', 'public/css');

mix.copyDirectory('node_modules/admin-lte/plugins/', 'public/plugins/')
   .copy('node_modules/simplemde/dist/simplemde.min.css', 'public/css')
   .copy('node_modules/simplemde/dist/simplemde.min.js', 'public/js')
   .copy('node_modules/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css', 'public/css')
   .copy('node_modules/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js', 'public/js')
   .copy('node_modules/moment/min/moment.min.js', 'public/js');

// Frontend
mix.js('resources/assets/js/app.js', 'public/js')
   .sass('resources/assets/sass/app.scss', 'public/css');

// Vendor extraction, TODO to separate into multiple manifest files.
// See: https://stackoverflow.com/questions/45046696/laravel-mix-multiple-entry-points-generates-one-manifest-js
// mix.extract(['vue', 'jquery']);

if (!mix.inProduction()) {
	mix.sourceMaps();
} else {
    mix.version();
}
