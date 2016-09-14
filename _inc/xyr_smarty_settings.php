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
    	<input type="<?=$_fieldType;?>" name="xyr_smarty-<?=$FieldName;?>" id="<?=$FieldName;?>" value="<?php echo get_option('xyr_smarty-'.$FieldName); ?>" style="width: 300px;" />
    <?php
}

function xyr_smarty_field_textarea($FieldName){
	?>
    	<textarea name="xyr_smarty-<?=$FieldName;?>" id="<?=$FieldName;?>" style="width: 300px;height: 100px;"><?php echo get_option('xyr_smarty-'.$FieldName); ?></textarea>
    <?php
}

function xyr_smarty_field_twitter_url(){
	xyr_smarty_field('twitter_url');
}

function xyr_smarty_field_facebook_url(){
	xyr_smarty_field('facebook_url');
}

function xyr_smarty_field_youtube_api_key(){
	xyr_smarty_field('youtube_api_key');
}

function xyr_smarty_field_copyright_text(){
	xyr_smarty_field('copyright_text');
}

function xyr_smarty_field_disclaimer(){
	xyr_smarty_field_textarea('disclaimer');
}

function display_theme_panel_fields(){

	add_settings_section("section", "All Settings", null, "theme-options");
	$_data_fields = array(
		array('twitter_url','Twitter Profile Url'),
		array('facebook_url','Facebook Profile Url'),
		array('youtube_api_key','Youtube API Key'),
		array('copyright_text','Copyright Text'),
		array('disclaimer','Disclaimer')
	);
	foreach($_data_fields as $key => $_val){
		add_settings_field("xyr_smarty-".$_val[0], $_val[1], "xyr_smarty_field_".$_val[0], "theme-options", "section");
		register_setting("section", "xyr_smarty-".$_val[0]);
	}

}

add_action("admin_init", "display_theme_panel_fields");


class GetCoreSettings{
    public function __construct(){
      self::custom_template_init();
    }

    public function custom_template_init(){
      add_filter( 'rewrite_rules_array',[$this,'rewriteRules'] );
      add_filter( 'template_include', [ $this, 'template_include' ],1,1 );
      add_filter( 'query_vars', [ $this, 'prefix_register_query_var' ] );
    }

    public function prefix_register_query_var($vars){
      $vars[] = '_ts';
      return $vars;
    }

    public function rewriteRules($rules){
      $newrules = self::rewrite();
      return $newrules + $rules;
    }

    public function rewrite(){
      $newrules = array();
      $newrules['xyr-theme'] = 'index.php?_ts=getsettings';

      return $newrules;
    }

    public function removeRules($rules){
      $newrules = self::rewrite();
      foreach ($newrules as $rule => $rewrite) {
            unset($rules[$rule]);
        }
      return $rules;
    }
    public function change_the_title() {
        $_cus_title = ucwords(get_query_var('tem'));
        return $_cus_title;
    }
    public function filter_title_part($title) {
        return array('a', 'b', 'c');
    }

    public function template_include($template){
		$_ts = sanitize_text_field(get_query_var( '_ts' ));
		if(!empty($_ts)){
			if(!strcasecmp($_ts, 'getsettings')){
				$this->get_all_options();
			}
			die();
		}else{
			return $template;
		}

    }

    public function get_all_options(){
		$all_options = wp_load_alloptions();
		$_settings = [];
		foreach ($all_options as $key => $_val) {
			if(strpos($key,'xyr_smarty')!==false){
				if(!isset($_settings[$key]))
					$_settings[$key] = [];
				$_settings[$key] = $_val;
			}
		}
		echo json_encode($_settings,JSON_PRETTY_PRINT);
	}
}

$GetCoreSettings = New GetCoreSettings();
