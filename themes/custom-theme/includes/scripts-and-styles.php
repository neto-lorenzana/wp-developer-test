<?php

use WPLMixTheme\AssetResolver;

add_action( 'wp_enqueue_scripts', function () {

	// registers scripts and stylesheets
	wp_register_style( 'google-fonts', 'https://fonts.googleapis.com/css?family=Raleway:400,700,700i,800', [], false );
	wp_register_style( 'app', AssetResolver::resolve( 'css/app.css' ), [], false );
	wp_register_script( 'app', AssetResolver::resolve( 'js/app.js' ), [], false, true );

	// enqueue global assets
	wp_enqueue_script( 'jquery' );
	wp_enqueue_style( 'google-fonts' );
	wp_enqueue_style( 'app' );
	wp_enqueue_script( 'app' );

} );