<?php

define( 'CUSTOM_THEME_TEXT_DOMAIN', basename( __DIR__ ) );

/*
 * Set up our auto loading class and mapping our namespace to the app directory.
 *
 * The autoloader follows PSR4 autoloading standards so, provided StudlyCaps are used for class, file, and directory
 * names, any class placed within the app directory will be autoloaded.
 *
 * i.e; If a class named SomeClass is stored in app/SomeDir/SomeClass.php, there is no need to include/require that file
 * as the autoloader will handle that for you.
 */
require get_stylesheet_directory() . '/app/AutoLoader.php';
$loader = new \WPLMixTheme\AutoLoader();
$loader->register();
$loader->addNamespace( 'WPLMixTheme', get_stylesheet_directory() . '/app' );


add_action( 'after_setup_theme', function () {

	\WPLMixTheme\Theme::get_instance()->init();
	\WPLMixTheme\AdminPost\ContactFormSubmissionHandler::get_instance()->init();
	\WPLMixTheme\AdminPost\SeedDatabase::get_instance()->init();
} );

function limit_excerpt_length( $length ) {
    return 30;
}
add_filter( 'excerpt_length', 'limit_excerpt_length');