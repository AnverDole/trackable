const mix = require('laravel-mix');

mix.disableNotifications();
mix.browserSync("localhost:8000");

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

mix.sass("resources/scss/app.scss", "styles")
    .js("resources/js/app.js", "scripts");

mix.sass("resources/scss/menues/left-menu-page.scss", "styles/left-menu-page");
