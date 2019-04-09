<?php
/*
 * Template Name: Contact Page Template
 * Template Post Type: page
 */

get_header();

if ( have_posts() ) {
	the_post();

	get_template_part( 'templates/sections/contact' );
}

get_footer();