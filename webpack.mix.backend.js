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

mix.setPublicPath(path.normalize('public/backend'))
    .js('resources/assets/admin/js/admin.js', 'js')
    .sass('resources/assets/admin/sass/admin.scss', 'css');

mix.copy('node_modules/simplemde/dist/simplemde.min.css', 'public/css')
    .copy('node_modules/simplemde/dist/simplemde.min.js', 'public/js');

// Vendor extraction
mix.extract(['lodash', 'jquery', 'materialize-css', 'vue', 'axios']);

if (!mix.inProduction()) {
    mix.sourceMaps();
} else {
    mix.version();
}
