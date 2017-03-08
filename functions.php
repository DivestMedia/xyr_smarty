<?php

define('XYR_SMARTY','XYR_SMARTY');


//include_once('_inc/xyr_menu.php');
include_once('_inc/xyr_wp-override.php');
include_once('_inc/xyr_plugin-required.php');
include_once('_inc/xyr_smarty_settings.php');
include_once('_inc/xyr_smarty_share.php');
include_once('_inc/xyr_color-category.php');
include_once('_inc/xyr_smarty_mood-meter.php');
// include_once('_inc/xyr_smarty_tinypoll.php');
// include_once('_inc/xyr_smarty_tinypoll-widget.php');
include_once('_inc/xyr_smarty_unliscroll.php');


	function bootstrapsmarty_setup() {

		load_theme_textdomain( XYR_SMARTY, get_template_directory() . '/languages' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		add_theme_support( 'title-tag' );

		add_theme_support( 'post-thumbnails' );
		set_post_thumbnail_size( 825, 510, true );

		// This theme uses wp_nav_menu() in two locations.
		register_nav_menus( array(
			'main' => __( 'Main Menu',      XYR_SMARTY ),
			'footer'  => __( 'Footer Menu', XYR_SMARTY),
			) );

			add_theme_support( 'html5', array(
				'search-form', 'comment-form', 'comment-list', 'gallery', 'caption'
			) );

			add_theme_support( 'post-formats', array(
				'image', 'video', 'quote', 'gallery','audio'
			) );

	}
	add_action( 'after_setup_theme', 'bootstrapsmarty_setup' );


	function xyr_smarty_fonts_url() {
		$fonts_url = '';
		$fonts     = array();
		$subsets   = 'latin,latin-ext';

		if ( 'off' !== _x( 'on', 'Open Sans font: on or off',XYR_SMARTY ) ) {
			$fonts[] = 'Open Sans:300,400';
		}

		if ( 'off' !== _x( 'on', 'Raleway font: on or off', XYR_SMARTY) ) {
			$fonts[] = 'Raleway:300,400,500,600,700';
		}

		if ( 'off' !== _x( 'on', 'Lato font: on or off', XYR_SMARTY ) ) {
			$fonts[] = 'Lato:300,400,400italic,600,700';
		}



		if ( $fonts ) {
			$fonts_url = add_query_arg( array(
				'family' => urlencode( implode( '|', $fonts ) ),
				//'subset' => urlencode( $subsets ),
			), 'https://fonts.googleapis.com/css' );
		}

		return $fonts_url;
	}


	function xyr_smarty_scripts() {
		// Add custom fonts, used in the main stylesheet.
		wp_enqueue_style( 'xyr_smarty-webfonts', xyr_smarty_fonts_url(), array(), null );

		// Bootstrap Main stylesheet
		wp_enqueue_style( 'bootstrap-main-css', get_template_directory_uri() . '/assets/plugins/bootstrap/css/bootstrap.min.css', array(),null );

		// THEME CSS
		wp_enqueue_style( 'xyr_smarty-essentials', get_template_directory_uri() . '/assets/css/essentials.css', array(),null );
		wp_enqueue_style( 'xyr_smarty-layout', get_template_directory_uri() . '/assets/css/layout.css', array(),null );


		// THEME CSS - PAGE LEVEL SCRIPTS
		wp_enqueue_style( 'xyr_smarty-header', get_template_directory_uri() . '/assets/css/header-1.css', array(),null );

		// THEME MAIN CSS
		//wp_enqueue_style( 'xyr_smarty-main', get_template_directory_uri() . '/main.css', array(),null );
		
		// SWIPER SLIDER 
		wp_enqueue_style( 'xyr_smarty-swiper', get_template_directory_uri() . '/assets/plugins/slider.swiper/dist/css/swiper.min.css', array(),null );


		if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
			wp_enqueue_script( 'comment-reply' );
		}

		if ( is_singular() && wp_attachment_is_image() ) {
			wp_enqueue_script( 'twentysixteen-keyboard-image-navigation', get_template_directory_uri() . '/js/keyboard-image-navigation.js', array( 'jquery' ), '20150825' );
		}

		wp_deregister_script('jquery');
		wp_register_script( 'jquery', get_template_directory_uri() . '/assets/plugins/jquery/jquery-2.2.3.min.js','', '2.2.3');

		wp_enqueue_script( 'xyr_smarty-script', get_template_directory_uri() . '/assets/js/scripts.js', array( 'jquery' ), null, true );

		/*
		wp_localize_script( 'twentysixteen-script', 'screenReaderText', array(
		'expand'   => __( 'expand child menu', 'twentysixteen' ),
		'collapse' => __( 'collapse child menu', 'twentysixteen' ),
		) ); */
	}
	add_action( 'wp_enqueue_scripts', 'xyr_smarty_scripts' );

	function xyr_smarty_meta() {
		
		global $post;
		if ( is_single() ) {
			$meta = strip_tags( $post->post_content );
			$meta = strip_shortcodes( $post->post_content );
			$meta = str_replace( array("\n", "\r", "\t"), ' ', $meta );
			$meta = substr( $meta, 0, 125 );
			$keywords = get_the_category( $post->ID );
			$metakeywords = '';
			foreach ( $keywords as $keyword ) {
				$metakeywords .= $keyword->cat_name . ", ";
			}
			echo '<meta name="description" content="' . $meta . '" />' . "\n";
			echo '<meta name="keywords" content="' . $metakeywords . '" />' . "\n";
		}else{
			echo '<meta name="description" content="'. get_bloginfo().' - '. get_bloginfo('description').'">';
		}
		
	
		echo "\n\n    <!-- mobile settings -->";
		echo "\n    ".'<meta name="viewport" content="width=device-width, maximum-scale=1, initial-scale=1, user-scalable=0" />';
		echo "\n\t<!--[if IE]><meta http-equiv='X-UA-Compatible' content='IE=edge,chrome=1'><![endif]-->\n\n";
	}
	add_action( 'wp_head', 'xyr_smarty_meta', 0 );
	
	function xyr_smarty_javascript() {
		echo "<script type=\"text/javascript\">var plugin_path = '". get_template_directory_uri()."/assets/plugins/';</script>\n";
	}
	add_action( 'wp_footer', 'xyr_smarty_javascript', 0 );

