<?php
namespace BEA\PSA;
class Compatibility {
	/**
	 * admin_init hook callback
	 *
	 * @since 0.1
	 */
	public static function admin_init() {
		// Not on ajax
		if ( defined( 'DOING_AJAX' ) && DOING_AJAX ) {
			return;
		}

		// Check activation
		if ( ! current_user_can( 'activate_plugins' ) ) {
			return;
		}

		// Load the textdomain
		load_plugin_textdomain( 'bea-post-status-admin', false, BEA_PSA_DIR . 'languages' );

		trigger_error( sprintf( __( 'BEA post status admin requires PHP version %s or greater to be activated.', 'bea-post-status-admin' ), BEA_PSA_MIN_PHP_VERSION ) );

		// Deactive self
		deactivate_plugins( BEA_PSA_DIR . 'bea-post-status-admin.php' );

		unset( $_GET['activate'] );

		add_action( 'admin_notices', array( __CLASS__, 'admin_notices' ) );
	}

	/**
	 * Notify the user about the incompatibility issue.
	 */
	public static function admin_notices() {
		echo '<div class="notice error is-dismissible">';
		echo '<p>' . esc_html( sprintf( __( 'BEA post status admin require PHP version %s or greater to be activated. Your server is currently running PHP version %s.', 'bea-post-status-admin' ), BEA_PSA_MIN_PHP_VERSION, PHP_VERSION ) ) . '</p>';
		echo '</div>';
	}
}