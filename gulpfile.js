process.env.DISABLE_NOTIFIER = true;
var elixir = require('laravel-elixir');

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Sass
 | file for your application as well as publishing vendor resources.
 |
 */

elixir(function(mix) {
	mix.sass([
        "materialize/sass/materialize.scss",
        "app.scss"
    ],  'public/css/app.min.css');

    mix.scripts([
    	"jquery.js",
        "materialize.js"
    ],  'public/js/vendor.min.js');
    mix.scripts("app.js",'public/js/app.min.js');
});
