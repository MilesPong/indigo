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

mix.browserSync({
    proxy: 'indigo.dev'
});

mix.setPublicPath(path.normalize('public/frontend'))
    .js('resources/assets/js/app.js', 'js')
    .js('resources/assets/js/main.js', 'js')
    .sass('resources/assets/sass/app.scss', 'css');

// Vendor extraction
mix.extract(['lodash', 'jquery', 'materialize-css', 'vue']);

if (!mix.inProduction()) {
    mix.sourceMaps();
} else {
    mix.version();
}

mix.browserSync('indigo.test');