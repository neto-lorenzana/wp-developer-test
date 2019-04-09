<?php


namespace WPLMixTheme\AdminPost;


use WPLMixTheme\Framework\AdminPostBase;
use WPLMixTheme\Framework\Singleton;
use WPLMixTheme\Utils\RemoteImage;


/**
 * Class SeedDatabase
 * @package WPLMixTheme\AdminPost
 *
 * @method static SeedDatabase get_instance()
 */
class SeedDatabase extends AdminPostBase {


	use Singleton;


	public function init() {

		add_action( 'admin_notices', [ $this, '_render_admin_notices' ] );

		if ( $this->has_seeded() ) {
			return;
		}

		parent::init();
	}


	public function handle() {

		if ( ! current_user_can( 'administrator' ) ) {
			parent::handle_no_priv();
		}

		try {
			$this->seed();
			$redirect = wp_get_referer();
			wp_redirect( add_query_arg( [ 'theme_seed_status' => 'success' ], $redirect ) );
			die();
		} catch ( \Exception $e ) {
			wp_die(
				'There was a problem with the seeding process. Message reads: ' . $e->getMessage(),
				'Seed Failed',
				[ 'back_link' => true ]
			);
		}
	}


	public function _render_admin_notices() {

		$seed_url = $this->get_admin_post_url();

		if ( ! $this->has_seeded() ): ?>
            <div class="notice notice-warning">
                <p>
                    <a href="<?= $seed_url ?>"><?php _e( 'Click here to seed the database with 14 posts.', CUSTOM_THEME_TEXT_DOMAIN ); ?></a>
                </p>
            </div>
		<?php endif;

		if ( $this->seed_complete() ): ?>
            <div class="notice notice-success">
                <p><?php _e( 'Database was successfully seeded.', CUSTOM_THEME_TEXT_DOMAIN ); ?></p>
            </div>
		<?php endif;
	}


	/**
	 * @throws \Exception
	 */
	private function seed() {

		$words = $this->get_title_words();

		for ( $x = 0; $x < 14; $x ++ ) {

			$id = wp_insert_post( [
				'post_content' => $this->generate_content(),
				'post_title'   => $this->generate_title_from_words( $words ),
				'post_status'  => 'publish',
			] );

			if ( is_wp_error( $id ) ) {
				throw new \Exception( 'Failed to insert post' );
			}

			$image_index = $x + 1;

			$image = new RemoteImage( "https://files.philkurth.com.au/dev-test-images/image-$image_index.jpeg" );
			$image->set_file_name( 'unsplash-' . random_int( 11111, 99999 ) . '.jpg' );
			$image->import();

			set_post_thumbnail( $id, $image->get_attachment_id() );
		}

		update_option( '_db_seeded', 1 );
	}


	private function has_seeded() {
		return false; // NOTE: let the admin message persist in case the user wants to create more
		//return get_option( '_db_seeded' );
	}


	private function seed_complete() {
		return isset( $_GET['theme_seed_status'] ) and $_GET['theme_seed_status'] === 'success';
	}


	private function generate_content() {
		$n_paras = random_int( 4, 12 );

		return file_get_contents( "http://loripsum.net/api/$n_paras/medium/headers/ul" );
	}


	private function get_title_words() {
		$text  = file_get_contents( 'https://loripsum.net/api/1/plaintext/verylong' );
		$text  = strtolower( preg_replace( '/[^a-zA-Z\s]/', '', $text ) );
		$words = explode( ' ', $text );

		return $words;
	}


	private function generate_title_from_words( Array $words ) {
		$n_words = rand( 5, 15 );
		$slice   = array_rand( array_flip( $words ), $n_words );

		return ucfirst( implode( ' ', $slice ) );
	}


}