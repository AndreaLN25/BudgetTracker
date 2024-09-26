const mix = require('laravel-mix');

mix.js('resources/js/app.js', 'public/js')
   .react() // Enables React support
   .sass('resources/sass/app.scss', 'public/css'); // If using Sass
