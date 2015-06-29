<?php
/*
 Plugin Name: BEA Post status admin
 Version: 2.0.1
 Description: Add the custom post status admin interface
 Author: Be Api
 Author URI: http://www.beapi.fr
Plugin URI: https://github.com/Beapi/bea-post-status-admin
 Domain Path: languages
 Text Domain: bea-post-status-admin
 ----

 Copyright 2014 Beapi (human@beapi.fr)

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
define( 'BEA_PSA_VERSION', '2.0.1' );
define( 'BEA_PSA_MIN_PHP_VERSION', '5.4' );

// Plugin URL and PATH
define('BEA_PSA_URL', plugin_dir_url ( __FILE__ ));
define('BEA_PSA_DIR', plugin_dir_path( __FILE__ ));

// Check PHP min version
if ( version_compare( PHP_VERSION, BEA_PSA_MIN_PHP_VERSION, '<' ) ) {
	require_once( BEA_PSA_DIR . 'compat.php' );

	// possibly display a notice, trigger error
	add_action( 'admin_init', array( 'BEA\PSA\Compatibility', 'admin_init' ) );

	// stop execution of this file
	return;
}

/**
 * Autoload all the things \o/
 */
require BEA_PSA_DIR.'autoload.php';

add_action('plugins_loaded', 'init_bea_psa_plugin');
function init_bea_psa_plugin() {
	// Add the API
	new \BEA\PSA\Main();

	if ( is_admin() ) {
		// Launch admin
		new \BEA\PSA\Admin\Main();
	}
}