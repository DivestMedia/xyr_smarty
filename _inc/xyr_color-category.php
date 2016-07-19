<?php
/** Add Custom Field To Category Form */
add_action( 'category_add_form_fields', 'category_form_custom_field_add', 10 );
add_action( 'category_edit_form_fields', 'category_form_custom_field_edit', 10, 2 );
 
function category_form_custom_field_add( $taxonomy ) {
?>
<div class="form-field">
  <label for="category_color">Color Value</label>
  <input name="category_color" id="category_color" type="text" value="" size="40" aria-required="true" />
  <p class="description">Enter a bootstrap Class Value Value.</p>
</div>
<?php
}
 
function category_form_custom_field_edit( $tag, $taxonomy ) {
 
    $option_name = 'category_color_' . $tag->term_id;
    $category_color = get_option( $option_name );
 
?>
<tr class="form-field">
  <th scope="row" valign="top"><label for="category_color">Color Value</label></th>
  <td>
    <input type="text" name="category_color" id="category_color" value="<?php echo esc_attr( $category_color ) ? esc_attr( $category_color ) : ''; ?>" size="40" aria-required="true" />
    <p class="description">Enter a bootstrap Class Value Value.</p>
  </td>
</tr>
<?php
}
 
/** Save Custom Field Of Category Form */
add_action( 'created_category', 'category_form_custom_field_save', 10, 2 ); 
add_action( 'edited_category', 'category_form_custom_field_save', 10, 2 );
 
function category_form_custom_field_save( $term_id, $tt_id ) {
    if ( isset( $_POST['category_color'] ) ) {           
        $option_name = 'category_color_' . $term_id;
        update_option( $option_name, $_POST['category_color'] );
    }
}



function manage_my_category_columns($columns){
	$columns['bg_color'] = 'BG Color';
	return $columns;
}
add_filter('manage_edit-category_columns','manage_my_category_columns');

function manage_category_custom_fields($deprecated,$column_name,$term_id){
	if ($column_name == 'bg_color') {
		$option_name = 'category_color_' . $term_id;
		$category_color = get_option( $option_name );
		if(!empty($category_color )){
			echo '<span style="display:block;background-color:'.$category_color.';color:#333;padding:2px 5px;">'.$category_color.'</span>';
		}
	}
}

add_filter ('manage_category_custom_column', 'manage_category_custom_fields', 10,3);


