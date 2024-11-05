<?php
// Security check
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
} 

// Add nonce for security
$nonce = wp_create_nonce('house_preferences_nonce');

// debugging line 
 


?>

<div
 id = "<?php echo esc_attr($meta_id); ?>"
class="meta-selection-wrapper"> 
   <h4>  <span id="meta-selection-title"  class="meta-selection-title">Preferred </span> Housing </h4>
    <div class="search-filter-container">
    <div class="search-container">
        <input type="text" id="posts-search" placeholder="Search for Housing...">
    </div>
    <div class="filter-contatiner">
        <select name="preferences-filter" id="preferences-filter">
            <?php foreach ($options as $key => $value): ?>
                <option value="<?php echo esc_attr($key); ?>">
                    <?php echo esc_html($value); ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    </div>

    <?php 
$first = true;

 foreach( $options as $key => $value ):
    
    // If value is empty, continue to the next iteration
    if (empty($value) || $key === '') {
        continue;
    }

    // Determine the class based on whether it's the first iteration
    $display_class = $first ? 'active' : 'none';
    
    // Set $first to false after the first iteration
    $first = false;
    ?>
    
    <div 
      id="<?php echo esc_attr($key); ?>-row"
      data-filter="<?php echo esc_attr($key); ?>"
      class="selection-row <?php echo esc_attr($display_class); ?>">
        
        <div class="selection">
            <!-- ul of choices with all the housing posts -->
            <ul class="choices">
                <?php foreach ($posts as $post):
                     $post_id = $post['id'];
                     $row_key = "$key-row";
                     $selection_array =  $meta_data[$row_key] ?? [];
                    $does_selection_exsist = in_array($post_id, $selection_array);

                    $disabled = $does_selection_exsist ? 'disabled' : '';
                    ?>
                    <li class="choice-item
                      <?php echo esc_attr($disabled); ?> 
                    " 
                     data-name="<?php echo esc_attr($post['title']); ?>"
                     data-id="<?php echo esc_attr($post['id']); ?>">
                        <span> 
                        <?php echo esc_html($post['title']); ?>
                        </span>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
        
        <div class="chosen">
            <ul class="choices">
            <?php foreach ($posts as $post):
                     $post_id = $post['id'];
                     $row_key = "$key-row";
                     $selection_array =  $meta_data[$row_key] ?? [];
                    $does_selection_exist = in_array($post_id, $selection_array);

                    $disabled = $does_selection_exsist ? 'disabled' : '';

                    if($does_selection_exist): ?>
 
                    <li class="chosen-item" data-id="<?php echo esc_attr($post['id']); ?>" data-name="<?php echo esc_attr($post['title']); ?>">
                        <input type="hidden" name="<?php echo esc_attr($row_key); ?>[]" value="<?php echo esc_attr($post['id']); ?>">
                        <span><?php echo esc_html($post['title']); ?></span>
                        <div class="cancel-button">-</div>
                    </li>
                            
                   
                <?php
                    endif;
            endforeach; ?>
            </ul>
        </div>
    </div>
    
<?php endforeach; ?>

    <!-- hidden nonce input -->
    <input type="hidden" name="house_preferences_nonce" value="<?php echo esc_attr($nonce); ?>" />
</div>

<script>
   let options = <?php echo json_encode($options); ?>;
  
</script>