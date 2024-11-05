<?php

// Security check
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

class KCDC_CPT {
    public function __construct() {
        // Hook into WordPress 'init' action to register the post types
        add_action('init', [$this, 'register_housing_post_type']);
        add_action('init', [$this, 'register_landing_housing_post_type']);
    }

    // Register the Landing Housing Custom Post Type
    public function register_landing_housing_post_type() {
        $labels = [
            'name'               => 'Qualified Housing',
            'singular_name'      => 'Qualified Housing',
            'menu_name'          => 'Qualified Housing',
            'name_admin_bar'     => 'Qualified Housing',
            'add_new'            => 'Add New',
            'add_new_item'       => 'Add New Qualified Housing',
            'new_item'           => 'New Qualified Housing',
            'edit_item'          => 'Edit Qualified Housing',
            'view_item'          => 'View Qualified Housing',
            'all_items'          => 'All Qualified Housing',
            'search_items'       => 'Search Qualified Housing',
            'not_found'          => 'No Qualified Housing found',
            'not_found_in_trash' => 'No Qualified Housing found in Trash',
        ];

        $args = [
            'labels'             => $labels,
            'public'             => true,
            'has_archive'        => true,
            'rewrite'            => ['slug' => 'qualified-housing'],
            'supports'           => ['title'],  // Add 'page-attributes' to support hierarchy
            'hierarchical'       => true,
            'menu_position'      => 20,
            'menu_icon'          => 'dashicons-admin-home',  // Use WordPress' home icon for Housing
            'show_in_rest'       => true,  // Enable Gutenberg editor
        ];

        register_post_type('qualified-housing', $args);
    }

    // Register the Housing Custom Post Type
    public function register_housing_post_type() {
        $labels = [
            'name'               => 'Housing',
            'singular_name'      => 'Housing',
            'menu_name'          => 'Housing',
            'name_admin_bar'     => 'Housing',
            'add_new'            => 'Add New',
            'add_new_item'       => 'Add New Housing',
            'new_item'           => 'New Housing',
            'edit_item'          => 'Edit Housing',
            'view_item'          => 'View Housing',
            'all_items'          => 'All Housing',
            'search_items'       => 'Search Housing',
            'not_found'          => 'No Housing found',
            'not_found_in_trash' => 'No Housing found in Trash',
        ];

        $args = [
            'labels'             => $labels,
            'public'             => true,
            'has_archive'        => true,
            'rewrite'            => ['slug' => 'housing'],
            'supports'           => ['title', 'editor', 'thumbnail'],  // Add 'page-attributes' to support hierarchy
            'hierarchical'       => true,
            'menu_position'      => 20,
            'menu_icon'          => 'dashicons-admin-home',  // Use WordPress' home icon for Housing
            'show_in_rest'       => true,  // Enable Gutenberg editor
        ];

        register_post_type('housing', $args);
    }
}

// Initialize the class to register post types
new KCDC_CPT();
?>