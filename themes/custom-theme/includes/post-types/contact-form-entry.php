<?php

/**
 * Register Custom Post Type: Contact Form Entry
 */
add_action( 'init', 'register_contact_form_entry_cpt', 0 );
function register_contact_form_entry_cpt() {
	register_post_type( 'contact-form-entry', [
		'label'                 => __( 'Contact Form Entry', CUSTOM_THEME_TEXT_DOMAIN ),
		'labels'                => [
			'name'                  => _x( 'Contact Form Entries', 'Contact Form Entry General Name', CUSTOM_THEME_TEXT_DOMAIN ),
			'singular_name'         => _x( 'Contact Form Entry', 'Contact Form Entry Singular Name', CUSTOM_THEME_TEXT_DOMAIN ),
			'menu_name'             => __( 'Contact Form Entries', CUSTOM_THEME_TEXT_DOMAIN ),
			'name_admin_bar'        => __( 'Contact Form Entry', CUSTOM_THEME_TEXT_DOMAIN ),
			'archives'              => __( 'Item Archives', CUSTOM_THEME_TEXT_DOMAIN ),
			'parent_item_colon'     => __( 'Parent Item:', CUSTOM_THEME_TEXT_DOMAIN ),
			'all_items'             => __( 'All Items', CUSTOM_THEME_TEXT_DOMAIN ),
			'add_new_item'          => __( 'Add New Item', CUSTOM_THEME_TEXT_DOMAIN ),
			'add_new'               => __( 'Add New', CUSTOM_THEME_TEXT_DOMAIN ),
			'new_item'              => __( 'New Item', CUSTOM_THEME_TEXT_DOMAIN ),
			'edit_item'             => __( 'Edit Item', CUSTOM_THEME_TEXT_DOMAIN ),
			'update_item'           => __( 'Update Item', CUSTOM_THEME_TEXT_DOMAIN ),
			'view_item'             => __( 'View Item', CUSTOM_THEME_TEXT_DOMAIN ),
			'search_items'          => __( 'Search Item', CUSTOM_THEME_TEXT_DOMAIN ),
			'not_found'             => __( 'Not found', CUSTOM_THEME_TEXT_DOMAIN ),
			'not_found_in_trash'    => __( 'Not found in Trash', CUSTOM_THEME_TEXT_DOMAIN ),
			'featured_image'        => __( 'Featured Image', CUSTOM_THEME_TEXT_DOMAIN ),
			'set_featured_image'    => __( 'Set featured image', CUSTOM_THEME_TEXT_DOMAIN ),
			'remove_featured_image' => __( 'Remove featured image', CUSTOM_THEME_TEXT_DOMAIN ),
			'use_featured_image'    => __( 'Use as featured image', CUSTOM_THEME_TEXT_DOMAIN ),
			'insert_into_item'      => __( 'INSERT INTO item', CUSTOM_THEME_TEXT_DOMAIN ),
			'uploaded_to_this_item' => __( 'Uploaded to this item', CUSTOM_THEME_TEXT_DOMAIN ),
			'items_list'            => __( 'Items list', CUSTOM_THEME_TEXT_DOMAIN ),
			'items_list_navigation' => __( 'Items list navigation', CUSTOM_THEME_TEXT_DOMAIN ),
			'filter_items_list'     => __( 'Filter items list', CUSTOM_THEME_TEXT_DOMAIN ),
		],
		'description'           => __( 'Contact Form Entry Description', CUSTOM_THEME_TEXT_DOMAIN ),
		'public'                => false,
		'hierarchical'          => false,
		'exclude_from_search'   => false,
		'publicly_queryable'    => false,
		'show_ui'               => true,
		'show_in_menu'          => true, // true, false, or parent menu slug e.g; edit.php
		'show_in_nav_menus'     => false,
		'show_in_admin_bar'     => false,
		'show_in_rest'          => false,
		'rest_base'             => 'contact-form-entry',
		'rest_controller_class' => 'WP_REST_Posts_Controller',
		'menu_position'         => 5,
		'menu_icon'             => '',
		'capability_type'       => 'page',
		//'capabilities'          => [], // @see get_post_type_capabilities()
		//'map_meta_cap'          => false,
		'supports'              => [
			'title',
			//'editor',
			//'comments',
			//'revisions',
			//'trackbacks',
			//'author',
			//'excerpt',
			//'page-attributes',
			//'thumbnail',
			//'custom-fields',
			//'post-formats'
		],
		'register_meta_box_cb'  => null,
		'taxonomies'            => [],
		'has_archive'           => false,
		'rewrite'               => [
			'slug'       => 'contact-form-entry',
			'with_front' => true,
			'feeds'      => false,
			'pages'      => false,
			'ep_mask'    => EP_PERMALINK,
		],
		'query_var'             => 'contact-form-entry',
		'can_export'            => true,
		'delete_with_user'      => false,
	] );
}