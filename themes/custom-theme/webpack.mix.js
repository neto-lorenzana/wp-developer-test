let mix = require('laravel-mix');
require('laravel-mix-versionhash');
let config = require('./config.json');

mix.setPublicPath('./build');

mix.browserSync({
    proxy: config.browserSync.proxy,
    injectChanges: true,
    open: false,
    files: [
        'build/**/*.{css,js}'
    ]
});

mix.js('assets/js/app.js', 'js');
mix.sass('assets/scss/app.scss', 'css');

if (mix.inProduction()) {
    mix.versionHash();
    mix.sourceMaps();
}