<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://Moxcar.com
 * @since      1.0.0
 *
 * @package    Kcdc_Housing
 * @subpackage Kcdc_Housing/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Kcdc_Housing
 * @subpackage Kcdc_Housing/admin
 * @author     Gino Peterson <gpeterson@moxcar.com>
 */
class Kcdc_Housing_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
		$this->dynamic_hash = $this->dynamic_hash();
		$this->kcdc_housing_url =  KCDC_HOUSING_URL . '/dist/kcdc-housing/';

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Kcdc_Housing_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Kcdc_Housing_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

 

		// css 
		$kcdc_css = $this->kcdc_housing_url . '/kcdc-housing' . $this->dynamic_hash . '.css';


		wp_enqueue_style( 'kcdc-housing', $kcdc_css, array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Kcdc_Housing_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Kcdc_Housing_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
 

		// js
		$kcdc_js = $this->kcdc_housing_url . '/kcdc-housing' . $this->dynamic_hash . '.js';


		wp_enqueue_script( 'kcdc-housing', $kcdc_js, array( 'jquery' ), $this->version, true );
		// localize script input name, and id 
		wp_localize_script('kcdc-housing', 'kcdc_housing_meta', array(
			'selections' => [
				['id' => 'preferred_housing'],
				 
			],
		));

	}

	/**
	 * Get the dynamic hash generated for assets.
	 *
	 * This function retrieves the dynamic hash generated for assets by following these steps:
	 * 1. Read the 'dist/app' directory and get the first file.
	 * 2. Extract the hash from the file name by splitting it with '-wp'.
	 * 3. Further extract the hash by splitting it with '.' to remove the file extension.
	 * 4. Combine the hash with the '-wp' prefix and return the final dynamic hash.
	 *
	 * @since    1.0.0
	 *
	 * @return   string   The dynamic hash for assets.
	 */
	function dynamic_hash() {
		// Get the path to the 'dist/app' directory.
		$directory_path = plugin_dir_path( dirname( __FILE__, 1 ) ) . 'dist/app/';
	
		// Get the files in the 'dist/app' directory.
		$files = scandir( $directory_path );
	
		// Find the first file in the directory.
		$first_file = '';
		foreach ( $files as $file ) {
			if ( ! is_dir( $directory_path . $file ) ) {
				$first_file = $file;
				break;
			}
		}
	
		// Extract the hash from the file name.
		$hash_parts = explode( '-wp', $first_file );
		$hash = isset( $hash_parts[1] ) ? $hash_parts[1] : '';
	
		// Further extract the hash by splitting it with '.' to remove the file extension.
		$hash_parts = explode( '.', $hash );
		$hash = isset( $hash_parts[0] ) ? $hash_parts[0] : '';
	
		// Combine the hash with the '-wp' prefix and return the final dynamic hash.
		$dynamic_hash = '-wp' . $hash;
	
		return $dynamic_hash;
	}

}