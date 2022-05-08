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

mix.js('resources/js/app.js', 'public/js')
    .vue()
    .sass('resources/sass/app.scss', 'public/css')/*
    .postCss('resources/css/app.css', 'public/css', [
        require('postcss-import'),
        require('autoprefixer'),
    ])*/
    .alias({
        '@': 'resources/js',
    });

if (mix.inProduction()) {
    mix.version();
}

//How to enable hot reloading on save in Laravel

// 1. Add the following to your webpack.mix.js and
// match the right port number from php artisan serve

mix.browserSync('127.0.0.1:8001');

// 2. run npx mix watch or npm run watch in the terminal
// to run the server and watch for changes

// Enjoy hot reloading ! - @MarienMupenda



