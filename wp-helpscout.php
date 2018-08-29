<?php
/*
Plugin Name: WordPress Dynamic Data for HelpScout
Plugin URI: https://verygoodplugins.com/
Description: Allows displaying WordPress user information alongside a HelpScout conversation
Version: 1.0
Author: Very Good Plugins
Author URI: https://verygoodplugins.com
License: GPL v3

Easy Digital Downloads integration for HelpScout
Copyright (C) 2013-2015, Danny van Kooten, hi@dannyvankooten.com

This program is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program.  If not, see <http://www.gnu.org/licenses/>.
*/

// Prevent direct file access
if ( ! defined( 'ABSPATH' ) ) {
	header( 'Status: 403 Forbidden' );
	header( 'HTTP/1.1 403 Forbidden' );
	exit;
}

class WP_HelpScout {

	/**
	 * @const VERSION
	 */
	const VERSION = "1.0";

	/**
	 * @const FILE
	 */
	const FILE = __FILE__;

	/**
	 * Constructor
	 */
	public function __construct() {

		require_once plugin_dir_path( __FILE__ ) . 'includes/endpoint.php';
		require_once plugin_dir_path( __FILE__ ) . 'includes/request.php';

		add_action( 'init', array( $this, 'listen' ) );

	}


	/**
	 * Initialise the rest of the plugin
	 */
	public function listen() {

		// if this is a HelpScout Request, load the Endpoint class
		if ( $this->is_helpscout_request() && ! is_admin() ) {
			new WP_HelpScout_Endpoint();
		}

	}

	/**
	 * Is this a request we should respond to?
	 *
	 * @return bool
	 */
	private function is_helpscout_request() {

		/**
		 * @since 1.1
		 */
		$trigger = stristr( $_SERVER['REQUEST_URI'], '/wp-helpscout/api' ) !== false;

		/**
		 * Filter so you can set the plugin to trigger at your own URL endpoint
		 *
		 * @since 1.1
		 */
		return (bool) apply_filters( 'wp_helpscout_is_helpscout_request', $trigger );
		
	}

}

new WP_HelpScout();



