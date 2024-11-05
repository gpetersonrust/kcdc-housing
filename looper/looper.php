<?php

// security check

if (!defined('ABSPATH')) {
    exit;
}

class KCDC_Looper {
    public function __construct(){
        add_filter( 'cs_looper_custom_housing_units', [$this, 'looper_housing_units'], 10, 2 );
        

 
    }

    public function looper_housing_units($results, $params) {
    //  get key from params
      $key = $params['key'];
      $ID = get_the_ID();


      $housing_preferences = get_post_meta($ID, 'housing_preference', true);

     

      $preference_data  = $housing_preferences[$key] ?? 0; 



      if($preference_data == 0) {
        return 0;
      }

       $results  = [];

       foreach ($preference_data as $preference__ID) {
        $thumbnail_id = get_post_thumbnail_id($preference__ID);
 

        $object = [
            'ID' => $preference__ID,
            'title' => get_the_title($preference__ID),
            'permalink' => get_the_permalink($preference__ID),
            'thumbnail_id' => $thumbnail_id,  
            'excerpt' => get_the_excerpt($preference__ID),
            'alias_name' => get_post_meta($preference__ID, 'meta-housing-alias', true),
        ];
 
        $results[] = $object;
       }

     

     

         return $results;
        }
    
    
}


new KCDC_Looper();?>

