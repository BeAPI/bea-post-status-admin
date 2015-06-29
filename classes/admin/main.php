<?php
namespace BEA\PSA\Admin;
use \BEA\PSA\Client as Client;

class Main{

	/**
	 * statuses registered
	 *
	 * @var array
	 */
	private static $statuses = array();

	function __construct() {
		// Add the filters
		add_filter( 'display_post_states', array( __CLASS__, 'display_post_states' ), 1, 2 );
		add_action( 'admin_footer', array( __CLASS__, 'add_post_status' ) );

		// Add the contents
		add_action( 'admin_init', array( __CLASS__, 'admin_init' ) );
	}

	/**
	* Register the script based on the  
	* 
	* @author Nicolas Juen
	* @return void
	*/
	public static function admin_init() {
		$suffix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG === true ? '' : '.min' ;

		// Add the script
		wp_register_script( 'bea-post-status-admin', BEA_PSA_URL.'assets/js/admin'.$suffix.'.js', array( 'jquery', 'underscore' ), BEA_PSA_VERSION, true );
	}

	/**
	 * Add the new post_status
	 *
	 * @param $posts_states
	 * @param $post
	 *
	 * @return mixed
	 * @author Nicolas Juen
	 */
	public static function display_post_states( $posts_states, $post ) {

		// Get all the statuses
		$statuses = Client::get_statuses();

		if( isset( $statuses[$post->post_status] ) ) {
			$post_status = get_post_status_object( $post->post_status );
			$posts_states[$post->post_status] = $post_status->label;
		}
		return $posts_states;
	}

	/**
	 * Add the post_status to the screen
	 *
	 * @author Nicolas Juen
	 */
	public static function add_post_status() {
		// Get all the statuses
		$statuses = Client::get_statuses();

		$screen = get_current_screen();
		if( 'edit' !== $screen->parent_base || 'post' !== $screen->base ) {
			return false;
		}

		$js_vars = array();
		foreach( $statuses as $status ) {
			if( !in_array( $screen->post_type, $status['post_types'] ) ) {
				continue;
			}
			$vars = $status['post_status'];
			$vars->action = $status['action_name'];
			$js_vars['statuses'][] = $vars;

		}

		if( empty( $js_vars ) ) {
			return false;
		}

		// add the post_status
		$js_vars['post_status'] =  get_post_status();

		// Enqueue the script
		wp_enqueue_script( 'bea-post-status-admin' );

		// Localize it
		wp_localize_script( 'bea-post-status-admin', 'bea_post_status_vars', $js_vars );
	}
}