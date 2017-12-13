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

mix.setPublicPath(path.normalize('public/frontend'))
    .js('resources/assets/js/app.js', 'js')
    .sass('resources/assets/sass/app.scss', 'css');

// Vendor extraction
mix.extract(['lodash', 'jquery', 'materialize-css']);

if (!mix.inProduction()) {
    mix.sourceMaps();
} else {
    mix.version();
}
