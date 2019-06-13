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

//	ACF - Columns for Contact form entries
function contact_form_entries_page_columns($columns) {
	$columns = array(
		'cb'	 	=> '<input type="checkbox" />',
		'title'	=> 'Title',
		'name'	=> 'Person name',
		'email' => 'Email',
	);
	return $columns;
}
add_filter("manage_contact-form-entry_posts_columns", "contact_form_entries_page_columns");

add_filter('manage_contact-form-entry_posts_custom_column','contact_form_entries_column_data',1,2);

function contact_form_entries_column_data( $column, $post_id ) {
	
	// setup our return text
	$output = '';
	
	switch( $column ) {
		case 'name':
			// get the custom name data
			$name = get_field('name', $post_id );
			$output .= $name;
			break;
		case 'email':
			// get the custom email data
			$email = get_field('email', $post_id );
			$output .= $email;
			break;
		
	}
	
	// echo the output
	echo $output;
	
}

//	Get data from 
add_action( 'admin_post_ContactFormSubmissionHandler', 'prefix_admin_saveContactFormSubmissionHandler' );
add_action( 'admin_post_nopriv_ContactFormSubmissionHandler', 'prefix_admin_saveContactFormSubmissionHandler' );

function prefix_admin_saveContactFormSubmissionHandler() {
	$jsonData = file_get_contents(ABSPATH . 'wp-content/themes/custom-theme/acf-json/group_5c994a670c7b8.json');
	$acfData = json_decode($jsonData);
	//	Sanitize values
	$name = sanitize_text_field($_POST['name']);
	$email = sanitize_text_field($_POST['email']);
	$message = sanitize_textarea_field($_POST['message']);

	//	Get data from form
	$data = array(
		'name'=> esc_attr( $name ),
		'email'=> esc_attr( $email ),
		'message'=> esc_attr( $message ),
	);

	//	Save data to custom post type

	//	Save custom post type header
	$postID = wp_insert_post( 
		array(
			'post_type'=>'contact-form-entry',
			'post_title'=>$data['name'] .'|'. $data['email'],
			'post_status'=>'publish',
		), 
		true
	);
	//	Save custom post type fields
	update_field(getACFFieldKey($acfData, 'name'), $data['name'], $postID);
	update_field(getACFFieldKey($acfData, 'email'), $data['email'], $postID);
	update_field(getACFFieldKey($acfData, 'message'), $data['message'], $postID);

	return $postID;
}

function getACFFieldKey($jsonData, $field){
	for($index=0; $index<$jsonData->fields; $index++){
		$fieldEntry = $jsonData->fields[$index];
		if ($fieldEntry->name == $field){
			return $fieldEntry->key;
		}
	}
	return null;
}