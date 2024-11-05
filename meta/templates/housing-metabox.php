<?php
// Ensure you're in the WordPress environment
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

// Add nonce for security
$nonce = wp_create_nonce('house_preferences_nonce');
?>

<!-- Output the landing page checkboxes and radio buttons -->
<div id="landing-page-options" style="margin-top: 10px;">
    <input type="hidden" name="house_preferences_nonce" value="<?php echo esc_attr($nonce); ?>" /> <!-- Nonce Field -->
    <?php foreach ($landing_pages as $landing_page): ?>
        <div id="landing-page-<?php echo esc_attr($landing_page->slug); ?>" class="housing-option wrapper">

            <!-- Landing Page Checkbox -->
            <div class="housing-field-option">
                <input 
                    type="checkbox" 
                    name="landing_pages[<?php echo esc_attr($landing_page->slug); ?>]" 
                    id="landing-page-checkbox-<?php echo esc_attr($landing_page->slug); ?>" 
                    value="selected" 
                    <?php checked(isset($selected_landing_pages[$landing_page->slug])); ?>
                >
                <label for="landing-page-checkbox-<?php echo esc_attr($landing_page->slug); ?>">
                   <strong><?php echo esc_html($landing_page->name); ?> </strong> 
                </label>
            </div>

            <!-- Preferences (display block if checkbox is checked) -->
            <div id="preference-option-<?php echo esc_attr($landing_page->slug); ?>" class="housing-option-preference" style="display: <?php echo isset($selected_landing_pages[$landing_page->slug]) ? 'block' : 'none'; ?>;">
                <div class="housing-options-hr"></div>

                <!-- Radio for Preference -->
                <div class="housing-field-option">
                    <input 
                        type="radio" 
                        name="house_preferences[<?php echo esc_attr($landing_page->slug); ?>]" 
                        id="<?php echo esc_attr($landing_page->slug); ?>-preference" 
                        value="Preference" 
                        <?php checked($preferences[$landing_page->slug] ?? '', 'Preference'); ?>
                    >
                    <label for="<?php echo esc_attr($landing_page->slug); ?>-preference">Preference</label>
                </div>

                <!-- other preference -->
                <div class="housing-field-option">
                    <input 
                        type="radio" 
                        name="house_preferences[<?php echo esc_attr($landing_page->slug); ?>]" 
                        id="<?php echo esc_attr($landing_page->slug); ?>-other" 
                        value="Other" 
                        <?php checked($preferences[$landing_page->slug] ?? '', 'Other'); ?>
                    >
                    <label for="<?php echo esc_attr($landing_page->slug); ?>-other">Other Preference</label>
                </div>

                <!-- Radio for No Preference -->
                <div class="housing-field-option">
                    <input 
                        type="radio" 
                        name="house_preferences[<?php echo esc_attr($landing_page->slug); ?>]" 
                        id="<?php echo esc_attr($landing_page->slug); ?>-no-preference" 
                        value="No Preference" 
                        <?php checked($preferences[$landing_page->slug] ?? '', 'No Preference'); ?>
                    >
                    <label for="<?php echo esc_attr($landing_page->slug); ?>-no-preference">No Preference</label>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const checkboxes = document.querySelectorAll('input[type="checkbox"][name^="landing_pages"]');

    checkboxes.forEach(checkbox => {
        // Toggle visibility of the preference options based on the checkbox state
        checkbox.addEventListener('change', function() {
            const slug = this.id.replace('landing-page-checkbox-', '');
            const preferenceDiv = document.getElementById('preference-option-' + slug);
            const preferenceRadio = document.getElementById(slug + '-preference'); // Get the preference radio button
            const otherRadio = document.getElementById(slug + '-other'); // Get the other radio button
            const noPreferenceRadio = document.getElementById(slug + '-no-preference'); // Get the "No Preference" radio button

            if (this.checked) {
                preferenceDiv.style.display = 'block';
                preferenceRadio.checked = true; // Automatically select the "Preference" radio button
            } else {
                preferenceDiv.style.display = 'none';
                preferenceRadio.checked = false; // Deselect the radio button when unchecked
                noPreferenceRadio.checked = false; // Also deselect the "No Preference" radio button
            }
        });

         
    });
});
</script>
