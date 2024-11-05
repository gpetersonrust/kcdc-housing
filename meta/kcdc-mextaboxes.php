<?php
// Security header
if (!defined('ABSPATH')) {
    exit;
}

class KCDC_Metaboxes {
    public function __construct() {
        // Variables
        $this->text_fields = [
            ['id' => 'preferred_housing', 'label' => 'Preferred Housing Statement', 'key' => 'meta-preferred-housing-statement', 'type' => 'textarea', 'post' => 'qualified-housing'],
            ['id' => 'other_preferred_housing', 'label' => 'Other Preferred Housing Statement', 'key' => 'meta-other-preferred-housing-statement', 'type' => 'textarea', 'post' => 'qualified-housing'],
            ['id' => 'non_preferred_housing', 'label' => 'Non Preferred Housing Statement', 'key' => 'meta-non-preferred-housing-statement', 'type' => 'textarea', 'post' => 'qualified-housing'],

            // housing post meta
            ['id' => 'housing', 'label' => 'Housing Alias', 'key' => 'meta-housing-alias', 'type' => 'input:text', 'post' => 'housing'],
        ];

        // Meta boxes
        add_action('add_meta_boxes', [$this, 'add_text_metabox']);
        add_action('add_meta_boxes', [$this, 'add_housing_metabox']);
        // Save post meta
        add_action('save_post', [$this, 'save_preferred_housing_metabox']);
    }

    public function add_text_metabox() {
        foreach ($this->text_fields as $field) {
            add_meta_box(
                $field['id'], // ID
                $field['label'], // Title
                [$this, 'render_text_metabox'], // Callback
                $field['post'], // Post type
                'normal', // Context
                'high', // Priority
                $field // Callback arguments
            );
        }
    }

    public function render_text_metabox($post, $field) {
        // Retrieve current value from post meta
        $data = $field['args'];
        $value = get_post_meta($post->ID, $data['key'], true) ?? '';
        $type = $data['type'];
        $id = $data['id'];
        $key = $data['key'];
        

        // Include template for rendering
        include KCDC_HOUSING_DIR_PATH . 'meta/templates/text-metabox.php';
    }

    public function add_housing_metabox() {
        add_meta_box(
            'house_preferences', // ID
            'House Preferences', // Title
            [$this, 'render_housing_metabox'], // Callback
            'housing', // Post type
            'normal', // Context
            'high' // Priority
        );

        add_meta_box(
            'qualified-housing', // ID
            'Qualified Housing', // Title
            [$this, 'render_preferred_housing_metabox'], // Callback
            'qualified-housing', // Post type
            'normal', // Context
            'high' // Priority
        );
    }

    public function render_preferred_housing_metabox() {
        $posts = array_map(function ($post) {
            return ['id' => $post->ID, 'title' => $post->post_title];
        }, get_posts([
            'post_type' => 'housing',
            'numberposts' => -1,
            'post_status' => 'publish',
            'orderby' => 'title',
            'order' => 'ASC',
        ]));

        $options = [
            '' => 'Select a preference',
            'preferred' => 'Preferred',
            'other-preferred' => 'Other Preference',
            'non-preferred' => 'No Preference',
        ];

        $meta_data = get_post_meta(get_the_ID(), 'housing_preference', true);
        include KCDC_HOUSING_DIR_PATH . 'meta/templates/qualified-housing-metabox.php';
    }

    public function render_housing_metabox($post) {
        // Retrieve current values
        $selected_landing_page = get_post_meta($post->ID, 'selected_landing_page', true);
        $preferences = get_post_meta($post->ID, 'house_preferences', true);

        // Available landing pages
        $landing_pages = get_terms([
            'taxonomy' => 'housing_landing_page',
            'hide_empty' => false,
        ]);

        include KCDC_HOUSING_DIR_PATH . 'meta/templates/housing-metabox.php';
    }

    public function save_preferred_housing_metabox($post_id) {
        // Validate nonce
        if (!isset($_POST['house_preferences_nonce']) || !wp_verify_nonce($_POST['house_preferences_nonce'], 'house_preferences_nonce')) {
            return; // Nonce is invalid
        }

        // Initialize data array
        $data = [
            'preferred-row' => isset($_POST['preferred-row']) ? array_map('sanitize_text_field', $_POST['preferred-row']) : [],
            'other-preferred-row' => isset($_POST['other-preferred-row']) ? array_map('sanitize_text_field', $_POST['other-preferred-row']) : [],
            'non-preferred-row' => isset($_POST['non-preferred-row']) ? array_map('sanitize_text_field', $_POST['non-preferred-row']) : [],
        ];

        // Update post meta
        update_post_meta($post_id, 'housing_preference', $data);

        // Save text fields
        foreach ($this->text_fields as $field) {
            $key = $field['key'];
            $id = $field['id'];

            // Check nonce for each field
            $nonce_name = "meta_text_nonce-{$id}";
            $current_post_type = get_post_type($post_id);
            

            // Skip if current post type is not the field's post type
            if ($current_post_type !== $field['post']) {
                continue;
            }

      

            if (!isset($_POST[$nonce_name]) || !wp_verify_nonce($_POST[$nonce_name], $nonce_name)) {
                return; // Nonce is invalid
            }
 

            if (isset($_POST[$key])) {
                update_post_meta($post_id, $key, sanitize_text_field($_POST[$key]));
            }
        }
    }
}

// Instantiate the class
new KCDC_Metaboxes();
?>