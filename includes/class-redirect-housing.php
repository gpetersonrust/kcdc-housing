<?php

// security check
if (!defined('ABSPATH')) {
    exit;
}

class KCDC_Qualified_Create_Page {

    public function __construct() {
        // Hook to initialize the rewrite rules and query variables
       
        add_action('init', [$this, 'create_qualified_housing_page']);
    }

    // Step 2: Add custom rewrite rule for /qualified-housing/level-X
 
    // create quaified housing page post type
    public function create_qualified_housing_page() {
        $page = get_page_by_path('qualified-housing');
        if (!$page) {
            $page = [
                'post_title' => 'Qualified Housing',
                'post_name' => 'qualified-housing',
                'post_type' => 'page',
                'post_status' => 'publish',
            ];
            wp_insert_post($page);
        }
    }

}

// Initialize the rewrite rules class
new KCDC_Qualified_Create_Page();?>