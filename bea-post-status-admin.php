<?php
/*
 Plugin Name: BEA Post status admin
 Version: 1.0.0
 Description: Add the custom post status admin interface
 Author: Be Api
 Author URI: http://www.beapi.fr
 Domain Path: languages
 Text Domain: bea-custom-post-status
 ----

 Copyright 2014 Beapi (technique@beapi.fr)

 This program is free software; you can redistribute it and/or modify
 it under the terms of the GNU General Public License as published by
 the Free Software Foundation; either version 2 of the License, or
 (at your option) any later version.

 This program is distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 GNU General Public License for more details.

 You should have received a copy of the GNU General Public License
 along with this program; if not, write to the Free Software
 Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
 */

// don't load directly
if ( !defined('ABSPATH') )
	die('-1');

// Plugin constants
define( 'BEA_PSA_VERSION', '1.0.0' );

// Plugin URL and PATH
define('BEA_PSA_URL', plugin_dir_url ( __FILE__ ));
define('BEA_PSA_DIR', plugin_dir_path( __FILE__ ));

// Function for easy load files
function _bea_psa_load_files( $dir, $files, $prefix = '' ) {
	foreach ( $files as $file ) {
		if ( is_file( $dir . $prefix . $file . ".php" ) ) {
			require_once( $dir . $prefix . $file . ".php" );
		}
	}
}

// Client API
_bea_psa_load_files( BEA_PSA_DIR . 'classes/', array( 'main' ) );

// Plugin admin classes
if ( is_admin() ) {
	_bea_psa_load_files( BEA_PSA_DIR . 'classes/admin/', array( 'main' ) );
}

add_action('plugins_loaded', 'init_bea_psa_plugin');
function init_bea_psa_plugin() {
	// Add the API
	new Bea_Post_Status_Client();

	if ( is_admin() ) {
		// Launch admin
		new Bea_Post_Status_Admin();
	}
}