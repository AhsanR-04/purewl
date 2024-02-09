<?php

// Function for adding upload field to category form
function custom_category_meta_fields($term) {
	$category_image = get_term_meta($term->term_id, 'category_image', true);
 ?>
 
	<tr class="form-field">
	  <th scope="row" valign="top"><label for="category_image">Category Image</label></th>
	  <td>
		 <div>
			<input type="text" name="category_image" id="category_image" value="<?php echo esc_attr($category_image); ?>">
			
 
			<?php if ($category_image) : ?>
			  <img src="<?php echo esc_url($category_image); ?>" alt="Category Image" style="max-width: 100px; max-height: 100px; margin-top: 10px; display: block;">
			  <br>
			  <?php endif; ?>
			  <br>
			<input type="button" class="button button-secondary" value="Upload Image" id="upload_image_button">
		
		 </div>
	  </td>
	</tr>
 

 
 <?php
 }
 add_action('category_edit_form_fields', 'custom_category_meta_fields', 10, 1);
 
 // Save custom category meta fields
 function save_custom_category_meta_fields($term_id) {
	$field = 'category_image';
 
	if (isset($_POST[$field])) {
	  update_term_meta($term_id, $field, sanitize_text_field($_POST[$field]));
	}
 }
 add_action('edited_category', 'save_custom_category_meta_fields', 10, 1);
 
 

// Enqueue JavaScript only on the category edit page in the admin
function enqueue_admin_js() {
	global $pagenow;

	if ($pagenow === 'term.php' && isset($_GET['taxonomy']) && $_GET['taxonomy'] === 'category') {
		wp_enqueue_media(); // Enqueue media scripts
		wp_enqueue_script('custom-category-admin-script', get_template_directory_uri() . '/js/category_img.js', array('jquery'), null, true);
	}
 }
 add_action('admin_enqueue_scripts', 'enqueue_admin_js');