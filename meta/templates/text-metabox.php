<?php
// Security check
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

// Add nonce for security
$nonce_name = "meta_text_nonce-{$id}";
$nonce_value = wp_create_nonce($nonce_name);

// Render the meta field based on type
if ($type == 'input:text') {
?>
    <div class="meta-field-option">
        <input 
            type="text" 
            name="<?php echo esc_attr($key); ?>" 
            id="<?php echo esc_attr($id); ?>" 
            value="<?php echo esc_attr($value); ?>" 
            class="regular-text"
        >
    </div>
<?php 
} elseif ($type == 'textarea') { 
?>
    <div class="meta-field-option">
        <textarea 
            name="<?php echo esc_attr($key); ?>" 
            id="<?php echo esc_attr($id); ?>" 
            class="large-text"
        ><?php echo esc_textarea($value); ?></textarea>
    </div>
<?php 
} 
?>

<input type="hidden" name="<?php echo esc_attr($nonce_name); ?>" value="<?php echo esc_attr($nonce_value); ?>" /> <!-- Nonce Field -->