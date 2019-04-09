<?php


namespace WPLMixTheme\AdminPost;


use WPLMixTheme\Framework\AdminPostBase;
use WPLMixTheme\Framework\Singleton;


/**
 * Class ContactFormSubmissionHandler
 * @package WPLMixTheme\AdminPost
 *
 * @method static ContactFormSubmissionHandler get_instance()
 */
class ContactFormSubmissionHandler extends AdminPostBase {


	use Singleton;


	public function handle() {
		$this->handle_submission();
	}


	public function handle_no_priv() {
		$this->handle_submission();
	}


	public function handle_submission() {

		$name    = $_REQUEST['name'] ?? '';
		$email   = $_REQUEST['email'] ?? '';
		$message = $_REQUEST['message'] ?? '';

		// need to save entry and email here

		$redirect = wp_get_referer() ?: wp_get_raw_referer();

		wp_redirect( add_query_arg( [ 'status' => 'success' ], $redirect ) );
		die();
	}


}