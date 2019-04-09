<?php


namespace WPLMixTheme\Framework;


abstract class AdminPostBase {


	/**
	 * Define the hooked action name by overriding this property in your concrete class.
	 *
	 * @var string|null
	 */
	protected $action = null;


	/**
	 * Returns the name of the admin post action this object will handle
	 *
	 * @return string
	 */
	public function action() {
		if ( $this->action ) {
			return $this->action;
		}

		$abs_class_name = get_class( $this );
		$class_name     = substr( strrchr( $abs_class_name, "\\" ), 1 );

		return preg_replace( '/\W+/', '', $class_name );
	}


	/**
	 * Call this method to hook handlers.
	 */
	public function init() {
		$action = $this->action();
		add_action( "admin_post_$action", [ $this, 'handle' ] );
		add_action( "admin_post_nopriv_$action", [ $this, 'handle_no_priv' ] );
	}


	/**
	 * Gets the full admin post URL for this handler
	 */
	public function get_admin_post_url() {
		return add_query_arg( [ 'action' => $this->action() ], admin_url( 'admin-post.php' ) );
	}


	/**
	 * Defines the handler for logged in users. Do what you need to in this method then redirect the user accordingly.
	 */
	public function handle() {
		wp_die( "You are not allowed to do that.", 'Whoops', [ 'back_link' => true ] );
	}


	/**
	 * Defines the handler for non-logged in users. Do what you need to in this method then redirect the user
	 * accordingly.
	 */
	public function handle_no_priv() {
		wp_die( "You are not allowed to do that.", 'Whoops', [ 'back_link' => true ] );
	}


}