const mix = require('laravel-mix');

mix.js('resources/js/app.js', 'public/js').react();
mix.css('resources/css/app.css', 'public/css');

// mix.extract([
//     'axios',
// ]);

mix.disableNotifications();
