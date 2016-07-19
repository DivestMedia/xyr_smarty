<?
add_action('admin_init','my_meta_init');

function my_meta_init(){
    $post_id = $_GET['post'] ? $_GET['post'] : $_POST['post_ID'] ;

    // checks for post/page ID
    if ( $post_id && in_category( 1336, $post_id ) ){
		
        add_meta_box('xyr_poll_meta', 'Poll Button', 'xyr_poll_meta', 'post', 'side', 'low');

		
	}


}



function xyr_poll_meta(){
	global $post;
	// Noncename needed to verify where the data originated
	echo '<input type="hidden" name="poll_eventmeta_noncename" id="poll_eventmeta_noncename" value="' . 
	wp_create_nonce( plugin_basename(__FILE__) ) . '" />';

	// Get the location data if its already been entered
	$xyr_poll_meta_button_blue = get_post_meta($post->ID, '_xyr_poll_meta_button_blue', true);
	$xyr_poll_meta_button_red = get_post_meta($post->ID, '_xyr_poll_meta_button_red', true);
	$xyr_poll_meta_subtitle = get_post_meta($post->ID, '_xyr_poll_meta_subtitle', true);

	$xyr_poll_meta_button_blue = empty($xyr_poll_meta_button_blue) ? 'Yes' : $xyr_poll_meta_button_blue;
	$xyr_poll_meta_button_red = empty($xyr_poll_meta_button_red) ? 'No' : $xyr_poll_meta_button_red;
	// Echo out the field
	echo '<labelfor="xyr_poll_meta_button_blue">Button Blue
			<input type="text" name="_xyr_poll_meta_button_blue" id="xyr_poll_meta_button_blue" class="form-required form-input-tip" value="'.$xyr_poll_meta_button_blue.'" aria-required="true"/>
		
		</label>
	<br/>';
	
	echo '<labelfor="xyr_poll_meta_button_red">Button Blue
			<input type="text" name="_xyr_poll_meta_button_red" id="xyr_poll_meta_button_red" class="form-required form-input-tip" value="'.$xyr_poll_meta_button_red.'" aria-required="true"/>
		
		</label>
	<br/>';
	echo '<labelfor="xyr_poll_meta_subtitle">Subtitle
			<input type="text" name="_xyr_poll_meta_subtitle" id="xyr_poll_meta_subtitle" class="form-required form-input-tip" value="'.$xyr_poll_meta_subtitle.'" aria-required="true"/>
		
		</label>
	<br/>';
	
	
		
}

add_action('save_post','xyr_poll_meta_save');
function xyr_poll_meta_save($post_id) {
	global $post;
	// verify this came from the our screen and with proper authorization,
	// because save_post can be triggered at other times
	if ( !wp_verify_nonce( $_POST['poll_eventmeta_noncename'], plugin_basename(__FILE__) )) {
	//return $post->ID;
	}

	// Is the user allowed to edit the post or page?
	//if ( !current_user_can( 'edit_post', $post->ID ))
		//return $post->ID;

	// OK, we're authenticated: we need to find and save the data
	// We'll put it into an array to make it easier to loop though.

	$button_meta['_xyr_poll_meta_button_blue'] = $_POST['_xyr_poll_meta_button_blue'];
	$button_meta['_xyr_poll_meta_button_red'] = $_POST['_xyr_poll_meta_button_red'];
	$button_meta['_xyr_poll_meta_subtitle'] = $_POST['_xyr_poll_meta_subtitle'];
	// Add values of $events_meta as custom fields

	foreach ($button_meta as $key => $value) { // Cycle through the $events_meta array!
		if( $post->post_type == 'revision' ) return; // Don't store custom data twice
		$value = implode(',', (array)$value); // If $value is an array, make it a CSV (unlikely)
		if(get_post_meta($post->ID, $key, FALSE)) { // If the custom field already has a value
			update_post_meta($post->ID, $key, $value);
		} else { // If the custom field doesn't have a value
			add_post_meta($post->ID, $key, $value);
		}
		if(!$value) delete_post_meta($post->ID, $key); // Delete if blank
	}
	//exit;
	
	

}
		


add_action( 'wp_ajax_xyr_poll_add', 'xyr_poll_add' );
add_action( 'wp_ajax_nopriv_xyr_poll_add', 'xyr_poll_add' );
function xyr_poll_add() {
	
	if(!session_id()) {
        session_start();
    }
	
    // Handle request then generate response using WP_Ajax_Response
	$_data = $_POST;
	
	$_post_id = $_data['post_id'];
	$_choice_id = $_data['choice_id'];
	
	
	$_choice_data = get_post_meta( $_post_id, '_xyrpoll', true);
	
	if(!is_array($_choice_data)){
		$_choice_data = array(0 => 0,1 => 0,2 => 0);
	}
	//update the session
	if(!empty($_SESSION['xyr-poll'][$_post_id])){
		
		$total = (int)$_choice_data[1] + (int)$_choice_data[2];
		$data = array_merge($_choice_data , array('totals' => $total , 'bluevote' =>$_choice_data[1]  , 'redvote' =>$_choice_data[2] )); 
		echo json_encode($data);
		
		exit;
	}
	
	
	$_SESSION['xyr-poll'][$_post_id] = $_choice_id;
	
	$_choice = (int) $_choice_data[$_choice_id];
	$_update_choice = $_choice + 1;
	
	$_choice_data[$_choice_id] = $_update_choice;
	
	update_post_meta($_post_id, '_xyrpoll',$_choice_data);
	
	$total = (int)$_choice_data[1] + (int)$_choice_data[2];
	$data = array_merge($_choice_data , array('totals' => $total , 'bluevote' =>$_choice_data[1]  , 'redvote' =>$_choice_data[2] )); 
	echo json_encode($data);
	
	
	exit;
}
