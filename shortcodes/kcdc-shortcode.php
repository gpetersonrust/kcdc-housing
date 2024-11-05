<?php
// Security header
if (!defined('ABSPATH')) {
    exit;
}

class KCDC_HOUSING_SHORTCODES {
    public function __construct(){
        // Existing shortcode
        add_shortcode('qualified-page-statement', [$this, 'qualified_page_statement']);
        
        // New shortcode for the eligibility form
        add_shortcode('housing_eligibility_form', [$this, 'housing_eligibility_form']);
        
        // Handle form submission
        add_action('init', [$this, 'handle_form_submission']);
        add_shortcode('housing-unit-exists', [$this, 'housing_unit_exists']);
        
    }

    public function qualified_page_statement($atts){

        $atts = shortcode_atts(
            [
                'key' => ''
            ],
            $atts
        );

      
        $ID = get_the_ID();
        $key = $atts['key'];
   
        // get post_meta
        $post_meta = get_post_meta($ID,  $key , true);

        
        

        return $post_meta ?? '';
       
    }

    // New method to generate the eligibility form
    public function housing_eligibility_form($atts){
        // Only display the form for GET requests

    //  shortcodes/templates/qualified-housing-form-template.php
      ob_start();
        include 'templates/qualified-housing-form-template.php';
        return ob_get_clean();
    }

    // Handle form submission
    public function handle_form_submission() {
        // Check if the form has been submitted
        if (isset($_POST['submit_eligibility_form'])) {
            // Verify nonce
            if (!isset($_POST['housing_eligibility_nonce']) || !wp_verify_nonce($_POST['housing_eligibility_nonce'], 'housing_eligibility_nonce_action')) {
                // Nonce verification failed
                wp_die('Security check failed!');
            }

            // Handle form processing here
            // You can retrieve form values using $_POST['field_name']
            // Example:
            $household_members = sanitize_text_field($_POST['household_members']);
            $income_bracket = sanitize_text_field($_POST['income_bracket']);
            $elderly_status = sanitize_text_field($_POST['elderly_status']);
            $disability_status = sanitize_text_field($_POST['disability_status']);
            $pbv_status = sanitize_text_field($_POST['pbv_status']);

            // Perform your calculations or redirects based on the values

            $this->kcdc_possiblities_to_redirect($income_bracket, $elderly_status, $disability_status, $pbv_status);
            

            // Redirect or output results here
        }
    }

    public function kcdc_possiblities_to_redirect($income_bracket, $elderly_status, $disability_status, $pbv_status){

        
       $possibilities  =  [
        //   Income Bracke 1, landing page landing-page 1 
        $this->kcdc_possiblity_array('ib1', null, null, null, '/81-ami-and-above/'),   // landing page 1
        // ib2, yes,yes, yes, landing-page-2
        $this->kcdc_possiblity_array('ib2', 'yes', 'yes', 'yes', '/disabled-elderly-61-80-ami-pbv/'),  // landing page 2
        // // ib2 yes, yes, no, landing-page-3
        $this->kcdc_possiblity_array('ib2', 'yes', 'yes', 'no', '/disabled-elderly-61-80-ami-no-pbv/'), // landing page 3
        // ib2 yes, no, yes, landing-page-4
        $this->kcdc_possiblity_array('ib2', 'yes', 'no', 'yes', '/elderly-non-disabled-61-80-ami-pbv/'), // landing page 4
        // ib2 yes, no, no, landing-page-5
        $this->kcdc_possiblity_array('ib2', 'yes', 'no', 'no', '/elderly-non-disabled-61-80-ami-no-pbv/'), // landing page 5
        // ib2 no, yes, yes, landing-page-6
        $this->kcdc_possiblity_array('ib2', 'no', 'yes', null, '/disabled-non-elderly-61-80-ami/'), //  landing page 6
        // ib2 no, no null, 'landing-page-7'
        $this->kcdc_possiblity_array('ib2', 'no', 'no', null, '/non-disabled-non-elderly-61-80-ami/'), //  landing page 7 
        //  ib3 yes, yes, yes 'landing-page-8'
        $this->kcdc_possiblity_array('ib3', 'yes', 'yes', 'yes', '/disabled-elderly-60-ami-or-below-pbv/'), // landing page 8
        // ib3 yes, yes, no 'landing-page-9'
        $this->kcdc_possiblity_array('ib3', 'yes', 'yes', 'no', '/disabled-elderly-60-ami-or-below-no-pbv/'), // landing page 9
        // ib3 yes, no, yes 'landing-page-10'
        $this->kcdc_possiblity_array('ib3', 'yes', 'no', 'yes', '/non-disabled-elderly-60-ami-or-below-pbv/'), // landing page 10
        // ib3 yes, no, no 'landing-page-11'
        $this->kcdc_possiblity_array('ib3', 'yes', 'no', 'no', '/non-disabled-elderly-60-ami-or-below-no-pbv/'), // landing page 11
        // ib3 no, yes, yes 'landing-page-12'
        $this->kcdc_possiblity_array('ib3', 'no', 'yes', null, '/disabled-non-elderly-60-ami-or-below/'), // landing page 12
        // ib3 no, no, null 'landing-page-13'
        $this->kcdc_possiblity_array('ib3', 'no', 'no', null, '/non-disabled-non-elderly-60-ami-or-below/'), // landing page 13

       ];

       

      
    //    Loop through the possibilities for a match using the parameters
    foreach ($possibilities as $possibility) {
        $match = true; 
    
        $matching_income_bracket = $possibility['income_bracket'];
      
        if($possibility['income_bracket'] != $income_bracket  
        && $possibility['income_bracket'] != 0
        ) $match = false;

 
   
    


        if($possibility['elderly_status'] != $elderly_status  &&
           $possibility['elderly_status']  != 0
        ) $match = false;

       
      
     
        if($possibility['disability_status'] != $disability_status && 
        $possibility['disability_status'] != 0
        ) $match = false;

    
        if($possibility['pbv_status'] != $pbv_status &&
        $possibility['pbv_status'] != 0
        ) $match = false;


 
     

        if($match){
             $landing_page = $possibility['landing_page'];
             $site_url = get_site_url();
             $housing_url = $site_url . "/qualified-housing/" . $landing_page;

          
             wp_redirect($housing_url);
            exit;
        }
    }


 
      
    }

    // helper functions

    private function kcdc_possiblity_array($income_bracket, $elderly_status, $disability_status, $pbv_status, $landing_page){
        $results = [
            // null values 
            'income_bracket' => 0,
            'elderly_status' => 0,
            'disability_status' => 0,
            'pbv_status' => 0,
        ];

        if ($income_bracket) $results['income_bracket'] = $income_bracket;
        if ($elderly_status) $results['elderly_status'] = $elderly_status;
        if ($disability_status) $results['disability_status'] = $disability_status;
        if ($pbv_status) $results['pbv_status'] = $pbv_status;
        if ($landing_page) $results['landing_page'] = $landing_page;
        
        return $results;
    }


    /**
 * Get the landing page from the request URI.
 *
 * @return string|null The landing page or null if not found.
 */
private function get_landing_page_from_uri() {
    // Get the request URI
    $request_uri = $_SERVER['REQUEST_URI'];

    // Split on "/"
    $request_uri = explode("/", $request_uri);

    // Remove empty values
    $request_uri = array_filter($request_uri);

    // Reset the array keys
    $request_uri = array_values($request_uri);

    // If 2 values exist, get the second value
    return isset($request_uri[1]) ? $request_uri[1] : null;
}



public function housing_unit_exists($atts) {
    // Set default attributes and extract them
    $atts = shortcode_atts(['key' => ''], $atts, 'count_housing_units');
    $key = $atts['key'];
    
    // Get the current post ID
    $ID = get_the_ID();

    // Retrieve the housing preferences from post meta
    $housing_preferences = get_post_meta($ID, 'housing_preference', true);

    // Get specific preference data based on the key
    $preference_data = isset($housing_preferences[$key]) ? $housing_preferences[$key] : [];

    // Return the count of items in preference_data
    $count = count($preference_data);
    $state = $count > 0 ? 'Yes' : 'No';
    return  $state;
    
}




}


new KCDC_HOUSING_SHORTCODES();
