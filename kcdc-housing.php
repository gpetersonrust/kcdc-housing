<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://Moxcar.com
 * @since             1.0.0
 * @package           Kcdc_Housing
 *
 * @wordpress-plugin
 * Plugin Name:       KCDC Housing
 * Plugin URI:        https://kcdc.org
 * Description:       This plugin is used to control the landing pages for the website for housing units
 * Version:           1.0.0
 * Author:            Gino Peterson
 * Author URI:        https://Moxcar.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       kcdc-housing
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

// dir path and url 
define('KCDC_HOUSING_DIR_PATH', plugin_dir_path(__FILE__));
define('KCDC_HOUSING_URL', plugins_url('', __FILE__));

 
require_once KCDC_HOUSING_DIR_PATH . 'cpt/kcdc-cpt.php';
// includes/class-redirect-housing.php
require_once KCDC_HOUSING_DIR_PATH . 'includes/class-redirect-housing.php';
// looper/looper.php
require_once KCDC_HOUSING_DIR_PATH . 'looper/looper.php';
// shortcodes/kcdc-shortcode.php
require_once KCDC_HOUSING_DIR_PATH . 'shortcodes/kcdc-shortcode.php';

// require_once meta/kcdc-mextaboxes.php
require_once KCDC_HOUSING_DIR_PATH . 'meta/kcdc-mextaboxes.php';

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'KCDC_HOUSING_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-kcdc-housing-activator.php
 */
function activate_kcdc_housing() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-kcdc-housing-activator.php';
	Kcdc_Housing_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-kcdc-housing-deactivator.php
 */
function deactivate_kcdc_housing() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-kcdc-housing-deactivator.php';
	Kcdc_Housing_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_kcdc_housing' );
register_deactivation_hook( __FILE__, 'deactivate_kcdc_housing' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-kcdc-housing.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_kcdc_housing() {

	$plugin = new Kcdc_Housing();
	$plugin->run();

}
run_kcdc_housing();
