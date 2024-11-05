<?php

/**
 * Fired during plugin deactivation
 *
 * @link       https://Moxcar.com
 * @since      1.0.0
 *
 * @package    Kcdc_Housing
 * @subpackage Kcdc_Housing/includes
 */

/**
 * Fired during plugin deactivation.
 *
 * This class defines all code necessary to run during the plugin's deactivation.
 *
 * @since      1.0.0
 * @package    Kcdc_Housing
 * @subpackage Kcdc_Housing/includes
 * @author     Gino Peterson <gpeterson@moxcar.com>
 */
class Kcdc_Housing_Deactivator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function deactivate() {
		// flush rewrite rules
		flush_rewrite_rules();

		// SET qualified-housing page to draft
		$page = get_page_by_path('qualified-housing');
		if ($page) {
			$page->post_status = 'draft';
			wp_update_post($page);
		}
		

	}

}
