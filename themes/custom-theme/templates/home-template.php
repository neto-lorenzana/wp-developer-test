<?php
/*
 * Template Name: Home Page Template
 * Template Post Type: page
 */

get_header();

if ( have_posts() ) {
	the_post();

	get_template_part( 'templates/sections/feature' );
	get_template_part( 'templates/sections/services' );
	get_template_part( 'templates/sections/cta' );
	get_template_part( 'templates/sections/our-team' );
}

get_footer();