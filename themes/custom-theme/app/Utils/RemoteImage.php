<?php


namespace WPLMixTheme\Utils;


/**
 * Class RemoteImage
 *
 * A nice class for importing remote images into the WordPress media library.
 */
class RemoteImage {


	/**
	 * @var string
	 */
	private $remote_url;


	/**
	 * @var string
	 */
	private $file_name;


	/**
	 * @var array|\WP_Error
	 */
	private $response;


	/**
	 * @var array
	 */
	private $imported_file;


	/**
	 * @var int
	 */
	private $attachment_id;


	/**
	 * @param $remote_url
	 */
	public function __construct( $remote_url ) {
		$this->remote_url = $remote_url;
	}


	public function set_file_name( $file_name ) {
		$file_name       = $this->ensure_file_name_has_extension( $file_name );
		$this->file_name = sanitize_file_name( $file_name );
	}


	/**
	 * This is the main function needed to import the image. Run this then check if the import was successful using
	 * $this->is_imported(). Other $this->get_imported_*() public methods on this class can then be used to get
	 */
	public function import() {
		$this->ensure_dependencies_are_loaded();

		$this->response = $this->fetch();

		if ( $this->fetched_successfully() ) {
			$this->upload_file();
			$this->create_attachment();
		}
	}


	/**
	 * @return int
	 */
	public function get_attachment_id() {
		return $this->attachment_id;
	}


	private function ensure_file_name_has_extension( $file_name ) {
		if ( pathinfo( $this->file_name, PATHINFO_EXTENSION ) ) {
			return $file_name;
		}

		$remote_extension = pathinfo( $this->remote_url, PATHINFO_EXTENSION );

		return "{$file_name}.{$remote_extension}";
	}


	/**
	 * @return bool
	 */
	private function is_imported() {
		if ( isset( $this->imported_file['error'] ) and $this->imported_file['error'] ) {
			return false;
		}

		return true;
	}


	private function ensure_dependencies_are_loaded() {
		if ( ! class_exists( 'WP_Http' ) ) {
			require_once( ABSPATH . WPINC . '/class-http.php' );
		}

		require_once( ABSPATH . 'wp-admin/includes/image.php' );
	}


	/**
	 * @return array|\WP_Error
	 */
	private function fetch() {
		$http = new \WP_Http();

		return $http->request( $this->remote_url );
	}


	/**
	 * @return bool
	 */
	private function fetched_successfully() {
		if ( is_wp_error( $this->response ) ) {
			return false;
		}

		if ( ! isset( $this->response['response']['code'] ) ) {
			return false;
		}

		return $this->response['response']['code'] === 200;
	}


	private function upload_file() {
		$this->imported_file = wp_upload_bits( $this->get_file_name(), null, $this->response['body'] );
	}


	/**
	 * Returns a sanitized file name. The file_name object property is sanitized on its way in so we don't need to
	 * sanitize it again here.
	 *
	 * @return string
	 */
	private function get_file_name() {
		if ( $this->file_name ) {
			return $this->file_name;
		}

		return sanitize_file_name( basename( $this->imported_file['file'] ) );
	}


	private function create_attachment() {
		if ( $this->is_imported() ) {

			$file_path        = $this->imported_file['file'];
			$file_name        = $this->get_file_name();
			$file_type        = wp_check_filetype( $file_name, null );
			$attachment_title = pathinfo( $file_name, PATHINFO_FILENAME );
			$wp_upload_dir    = wp_upload_dir();

			$post_info = array(
				'guid'           => $wp_upload_dir['url'] . '/' . $file_name,
				'post_mime_type' => $file_type['type'],
				'post_title'     => $attachment_title,
				'post_content'   => '',
				'post_excerpt'   => '',
				'post_status'    => 'inherit',
			);

			$this->attachment_id = wp_insert_attachment( $post_info, $file_path );
			$attach_data         = wp_generate_attachment_metadata( $this->attachment_id, $file_path );
			wp_update_attachment_metadata( $this->attachment_id, $attach_data );
		}
	}


}