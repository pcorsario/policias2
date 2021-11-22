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

mix.sass('resources/scss/app.scss', 'public/css');


mix.js('resources/js/app.js', 'public/js').vue()
    .postCss('resources/css/_app.css', 'public/css', [
        require('postcss-import'),
        require('tailwindcss'),
    ])
    .webpackConfig(require('./webpack.config'));

mix.styles([
    'public/css/app.css',
    'public/css/_app.css'
], 'public/css/all.css')

if (mix.inProduction()) {
    mix.version();
}
