<?

add_action('admin_menu', 'gmsharee_create_menu');
function gmsharee_create_menu() {
	add_options_page('Xyr-Smarty Settings', 'Xyr-Smarty', 'manage_options','xyr_smarty_settings','global_custom_options');
	
	if($_GET['page'] == 'xyr_smarty_settings'){
		wp_enqueue_script( array("jquery", "jquery-ui-sortable",) );
		add_action('admin_footer', 'gmsharee_scripts');
	}
}


function gmsharee_scripts(){
	?>
	<script type="text/javascript">
	jQuery(function($) {

		$('#social_buttons_ul').sortable( {
			placeholder: 'state-highlight',
			//accept: 'sortable',
			//axis: 'y',
			update: function (event, ui) {
				var datax = jQuery(this).sortable("serialize")+ '&action=gmsharee_savesort';;
				//console.log(datax);
				$.ajax({
					data: datax,
					type: 'POST',
					url: '/wp-admin/admin-ajax.php'
				});
			}
		});//.disableSelection();
		
	});
	</script><?

}


add_action('wp_ajax_gmsharee_savesort','gmsharee_savesort');
//add_action('wp_ajax_nopriv_question_add','gmsharee_savesort'); do not allow to public ajax
function gmsharee_savesort(){
	global $wpdb;
	$data = $_POST;
	unset($data['action']);
	update_option('_gm_sharee_sort',$data);
	echo 'sort saved.';
	exit();
	return;
}


function global_custom_options(){
	global $wpdb;
	$_xyr_smarty = get_option('_xyr_smarty');
	
	print_r($_xyr_smarty);
	/* 
	delete_option('_xyr_smarty');
	delete_option('_gm_sharee_sort'); */
	$_gm_sharee_order = get_option('_gm_sharee_sort');
	
	
	echo '
	<style>
		#social_buttons_ul li{border: 1px solid transparent;padding: 3px;max-width:350px;cursor:move}
		#social_buttons_ul li:hover{background-color:rgba(255,255,255,0.5);border: 1px solid #fff;}
		.state-highlight{background-color:#ddd;height:20px;padding:20px;display:block;
		}
	</style>
    <div class="wrap">
        <h2>Xyr-Smarty Theme Settings</h2>
        <form method="post" action="options.php">';
		
		
		
           wp_nonce_field('update-options');
			
			
			
			
		$_fields = array(
			'company_info' =>array(
				'address' => 'Office Address'
				),
				
			);
		?>	
			
		
		<h3><? _e('Company Info',XYR_SMARTY);?></h3>
		<table class="form-table">
			<tr valign="top">
				<th scope="row"><? _e('Company Name (max 8)',XYR_SMARTY);?></th>
				<td><input name="_xyr_smarty[company_info][name_small]" maxlength="8" type="text" value="<? esc_attr_e($_xyr_smarty['company_info']['name_small']);?>" class="regular-text" />
				</td>
			</tr>
			<tr valign="top">
				<th scope="row"><? _e('Description',XYR_SMARTY);?></th>
				<td><input name="_xyr_smarty[company_info][description]" type="text" value="<? esc_attr_e($_xyr_smarty['company_info']['description']);?>" class="large-text" />
				</td>
			</tr>
			<tr valign="top">
				<th scope="row"><? _e('Office Address',XYR_SMARTY);?></th>
				<td><textarea name="_xyr_smarty[company_info][address]" rows="3" class="large-text"><? esc_attr_e($_xyr_smarty['company_info']['address']); ?></textarea>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row"><? _e('Phone',XYR_SMARTY);?></th>
				<td><input name="_xyr_smarty[company_info][phone]" type="text" value="<? esc_attr_e($_xyr_smarty['company_info']['phone']);?>" class="regular-text" />
				</td>
			</tr>
			<tr valign="top">
				<th scope="row"><? _e('Support Email',XYR_SMARTY);?></th>
				<td><input name="_xyr_smarty[company_info][support]" type="text" value="<? esc_attr_e($_xyr_smarty['company_info']['support']);?>" class="regular-text" />
				</td>
			</tr>
			
		</table>
		<h3>Company Info</h3>
		<table class="form-table">
			<tr valign="top">
				<th scope="row">Address</th>
				<td><input name="_xyr_smarty[saved]" type="text" value="<? esc_attr_e($_xyr_smarty['saved']);?>" class="regular-text" />
				</td>
			</tr>
		</table>
		
		
		<table class="form-table">
		<?
		
		
		$_buttons = array(
			'email' 	=> 'Email',
			'linkedin' 	=> 'LinkedIn',
			'tumblr' 	=> 'Tumblr',
			'facebook' 	=> 'Facebook',
			'twitter'	=> 'Twitter',
			'googlePlus' => 'Google+',
			'pinterest' => 'Pinterest',
		);
			echo '<tr valign="top">
				<th scope="row">Social Buttons</th>
			<td>
				
				
				
				<ul id="social_buttons_ul">
				';
		
		
		/* if(!is_array($_gm_sharee_order)){
			$_gm_sharee_order = $_buttons;
		}
		
		foreach($_gm_sharee_order as $_key => $_val){
			$_valx = $_buttons[$_key];
			echo '<li id="'.$_key.'_1">
			<label for="check_'.$_key.'">
				<input type="checkbox" name="_gm_sharee[]" id="check_'.$_key.'" value="'.$_key.'" '.checked(in_array($_key, $_gm_sharee),'1',false).' />
				'.$_valx.'
			</label>
			</li>';
		}
			echo '</ul>
			</td></tr></table>';
			//print_r($_gm_sharee);
		
		echo '
			<label for="_debug_mode">
				<input type="checkbox" name="_gm_sharee[]" id="_debug_mode" value="_debug_mode" '.checked(in_array('_debug_mode', $_gm_sharee),'1',false).' />
				Debug Mode <i>Only visible if user is logged in.</i>
			</label> 
			';
			*/
	echo '
            <p class="submit"><input type="submit" class="button-primary" name="Submit" value="Save Changes" /></p>
            <input type="hidden" name="action" value="update" />
            <input type="hidden" name="page_options" value="_xyr_smarty" />
        </form>
    </div>';

}