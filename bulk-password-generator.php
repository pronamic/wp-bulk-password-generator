<?php
/*
Plugin Name: Bulk Password Generator
Plugin URI:
Description: Generate passwords for large groups of users in a single click.
Version: 1.0.0
Requires at least: 3.0
Author: Pronamic, RemcoTolsma, StefanBoonstra
Author URI: http://pronamic.eu/
License: GPLv2
*/

/**
 * Main class that bootstraps the application
 *
 * @version 22-08-12
 */
class Bulk_Password_Generator {

	/**
	 * Bootstraps the plugin
	 */
	static function bootstrap(){
		// Translate
		add_action('init', array( __CLASS__, 'localize' ));
		
		add_action('admin_menu', array( __CLASS__, 'admin_menu') );
	}
	
	/**
	 * Called on admin_menu hook. Adds admin pages.
	 */
	static function admin_menu(){
		add_submenu_page(
			'tools.php',
			__('Generate Passwords', 'bulk-password-generator'),
			__('Generate Passwords', 'bulk-password-generator'),
			'manage_options',
			'bulk-password-generator',
			array( __CLASS__, 'admin_page')
		);
	}
	
	/**
	 * Builds the bulk password generator tool page
	 */
	static function admin_page(){
		global $wp_roles;
		
		// Get roles and check if it is an array
		$roles = $wp_roles->roles;
		if( ! is_array( $roles ) )
			return;
		
		// Check if a password generation request has been sent.
		if( isset( $_POST['submit'] ) &&
			isset( $_POST['user-role'] ) &&
			$_POST['user-role'] != -1 &&
			$_GET['page'] == 'bulk-password-generator') {
			
			// Get users with specific role
			$user_query = new WP_User_Query( array(
				'role' => $_POST['user-role'],
				'exclude' => array( wp_get_current_user()->ID )
			) );
			$users = $user_query->results;
			if( count( $users ) > 0 ) {
				// Generate password and save user for output
				$adapted_users = array();
				foreach( $users as $user ) {
					// Create user array for storing
					$adapted_user = array(
						'id' => $user->ID,
						'login' => $user->user_login,
						'mail' => $user->user_email,
						'pass' => wp_generate_password(8, false)
					);
					
					// Set password for user
					wp_set_password(
						$adapted_user['pass'],
						$adapted_user['id']
					);
					
					// Save to adapted users
					$adapted_users[] = $adapted_user;
				}
			}
		}
		
		include_once('admin-page.php');
	}

	/**
	 * Translates the plugin
	 */
	static function localize(){
		load_plugin_textdomain(
			'bulk-password-generator',
			false,
			dirname(plugin_basename(__FILE__)) . '/languages/'
		);
	}
}

/*
 * Bootsrap application
 */
Bulk_Password_Generator::bootstrap();