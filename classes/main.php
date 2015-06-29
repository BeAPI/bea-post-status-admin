<?php
namespace BEA\PSA;

class Main{

	/**
	 * Post statuses to add
	 * @var array
	 */
	private static $statuses = array();

	/**
	 * Add the post_status
	 *
	 * @param $post_status : the post_status slug
	 * @param $post_types : Post types where to display the post_status
	 * @param $action_name : the post_status action button name for the admin
	 *
	 * @return bool
	 * @author Nicolas Juen
	 */
	public static function register_status( $post_status, $post_types, $action_name ) {
		// Get the post_status
		$post_status_object = get_post_status_object( $post_status );

		// Check
		if( is_null( $post_status_object ) ) {
			return false;
		}

		// Add it to the list
		self::$statuses[$post_status] = array( 'post_status' => $post_status_object, 'action_name' => $action_name, 'post_types' => $post_types );
		return true;
	}

	/**
	 * Return the statuses registered
	 *
	 * @return array
	 * @author Nicolas Juen
	 */
	public static function get_statuses() {
		return self::$statuses;
	}
}