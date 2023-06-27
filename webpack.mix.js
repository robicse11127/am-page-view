const mix = require( 'laravel-mix' );


/**
 * Setup public path to generate assets
 */
mix.setPublicPath( 'assets' );

/**
 * Autoload jQuery
 */
mix.autoload({
    jquery: [ '$', 'window.jQuery', 'jQuery' ]
});

/**
 * Compile JavaScript
 */
mix.js( 'src/admin/admin.js', 'assets/build/js/admin.js' ).sourceMaps( false ).vue();

/**
 * Compile Sass
 */
mix.sass( 'assets/sass/admin.scss', 'assets/build/css/admin.css' );
