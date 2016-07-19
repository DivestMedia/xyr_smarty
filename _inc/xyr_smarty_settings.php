<?

function xyr_menu_item(){
	add_menu_page("Xyr-Smarty", "Xyr-Smarty", "manage_options", "xyr-smarty", "theme_settings_page", null, 99);
}
add_action("admin_menu", "xyr_menu_item");

function theme_settings_page(){
    echo '
	    <div class="wrap">
	    <h1>Theme Settings</h1>
	    <form method="post" action="options.php">
	';
	  
	            settings_fields("section");
	            do_settings_sections("theme-options");      
	            submit_button(); 
	echo '
	    </form>
		</div>
	';
}


function xyr_smarty_field($FieldName, $_fieldType= 'text'){
	?>
    	<input type="<?=$_fieldType;?>" name="xyr_smarty-<?=$FieldName;?>" id="<?=$FieldName;?>" value="<?php echo get_option('xyr_smarty-'.$FieldName); ?>" />
    <?php
}

function xyr_smarty_field_twitter_url(){
	xyr_smarty_field('twitter_url');
}


function xyr_smarty_field_facebook_url(){
	xyr_smarty_field('facebook_url');
}

function display_theme_panel_fields(){
	
	add_settings_section("section", "All Settings", null, "theme-options");
	
	$_data_fields = array(
		array('twitter_url','Twitter Profile Url'),
		array('facebook_url','Facebook Profile Url')
	);
	
	foreach($_data_fields as $key => $_val){
		add_settings_field("xyr_smarty-".$_val[0], $_val[1], "xyr_smarty_field_".$_val[0], "theme-options", "section");
		register_setting("section", "xyr_smarty-".$_val[0]);
	}
	
}

add_action("admin_init", "display_theme_panel_fields");