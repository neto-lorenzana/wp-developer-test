<?php


namespace WPLMixTheme;


use WPLMixTheme\Framework\Singleton;


/**
 * Class Theme
 * @package WPLMixTheme
 *
 * @method static Theme get_instance
 */
class Theme {


	use Singleton;


	public function init() {
		$this->load_assets();
		$this->load_post_types();
		$this->load_theme_supports();
		$this->register_nav_menus();
	}


	private function load_assets() {
		require get_stylesheet_directory() . '/includes/scripts-and-styles.php';
	}


	private function load_post_types() {
		require get_stylesheet_directory() . '/includes/post-types/contact-form-entry.php';
	}


	private function load_theme_supports() {
		add_theme_support( 'post-thumbnails' );
	}


	private function register_nav_menus() {
		register_nav_menus( array(
			'main_nav' => 'Main Menu',
		) );
	}


}