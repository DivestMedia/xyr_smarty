<?php

define('XYR_SMARTY','XYR_SMARTY');


//include_once('_inc/xyr_menu.php');
include_once('_inc/xyr_plugin-required.php');
include_once('_inc/xyr_smarty_settings.php');
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


		if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
			wp_enqueue_script( 'comment-reply' );
		}

		if ( is_singular() && wp_attachment_is_image() ) {
			wp_enqueue_script( 'twentysixteen-keyboard-image-navigation', get_template_directory_uri() . '/js/keyboard-image-navigation.js', array( 'jquery' ), '20150825' );
		}

		wp_deregister_script('jquery');
		wp_register_script( 'jquery', get_template_directory_uri() . '/assets/plugins/jquery/jquery-2.1.4.min.js','', '2.1.4');

		wp_enqueue_script( 'xyr_smarty-script', get_template_directory_uri() . '/assets/js/scripts.js', array( 'jquery' ), null, true );

		/*
		wp_localize_script( 'twentysixteen-script', 'screenReaderText', array(
		'expand'   => __( 'expand child menu', 'twentysixteen' ),
		'collapse' => __( 'collapse child menu', 'twentysixteen' ),
		) ); */
	}
	add_action( 'wp_enqueue_scripts', 'xyr_smarty_scripts' );

	function xyr_smarty_javascript() {
		echo "<script type=\"text/javascript\">var plugin_path = '". get_template_directory_uri()."/assets/plugins/';</script>\n";
	}
	add_action( 'wp_footer', 'xyr_smarty_javascript', 0 );


	function sharee_buttons(){

		global $post;
		$_buttons = array();


		$title = $post->post_title;
		$_title = urlencode($title);

		$subject = 'Check this out: '. $title;
		$_subject = urlencode($subject);

		$url = get_permalink();
		//$url = 'http://www.facebook.com';
		$_url = urlencode($url);

		$_img = '';
		if (has_post_thumbnail($post->ID)){
			$thumb = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'medium' );
			$_img = $thumb['0'];
		}

		$_buttons['email'] = 'mailto:?subject='.$_subject.'&amp;body='.$_url;
		$_buttons['facebook'] = 'https://www.facebook.com/sharer/sharer.php?u='.$_url;
		$_buttons['tumblr'] = 'http://tumblr.com/share/link?url='.$_url.'&name='.$_title;
		$_buttons['linkedin'] = 'http://www.linkedin.com/shareArticle?mini=true&amp;url='.$_url.'&amp;title='.$_title.'&amp;summary='.$_title;
		$_buttons['twitter'] = 'https://twitter.com/intent/tweet?text='.$_url.' - '. $_img;
		$_buttons['reddit'] = 'http://www.reddit.com/submit?url='.$url.'&title='.$_title.'&text='.$_subject;
		$_buttons['gplus'] = 'https://plus.google.com/share?url='.$_title.'-'.$_url;
		$_buttons['pinterest'] = 'http://pinterest.com/pin/create/button/?url='.$url.'&amp;media='.$_img.'&amp;description='.$_title;

		global $wpdb;
		$_shareeButton = $_active_social = array();

		$_gm_sharee = array(
			'email',
			'pinterest',
			'linkedin',
			'tumblr',
			'googlePlus',
			'twitter',
			'facebook'
		);

		foreach($_gm_sharee as $_key => $_val){
			$_shareeButton[$_val]= $_buttons[$_val];
			//$_active_social[$_val] = "{$_val}: true";
		}
		return $_shareeButton;
	}



	function xyr_smarty_comments($comment, $args, $depth) {
		$GLOBALS['comment'] = $comment; ?>

		<!-- comment item -->
		<div class="comment-item nomargin nopadding" id="comment-<?php comment_ID() ?>">

			<!-- user-avatar -->
			<span class="user-avatar">
				<img class="pull-left media-object" src="<?php echo get_avatar_url( get_comment_author_email(), '64' ); ?>" width="64" height="64" alt="">
			</span>

			<div class="media-body">
				<small class="scrollTo comment-reply pull-right uppercase">
					<?php comment_reply_link(array_merge( $args, array('depth' => $depth, 'max_depth' => $args['max_depth']))) ?>
				</small>
				<h4 class="media-heading bold"><?php echo get_comment_author_link();?></h4>
				<small class="block">

					<?php if ($comment->comment_approved == '0') : ?>
						<em><?php _e('Your comment is awaiting moderation.') ?></em>
						<br />
					<?php endif; ?>

					<?php printf(__('%1$s at %2$s'), get_comment_date(),  get_comment_time()) ?>
					<?php edit_comment_link(__('(Edit)'),'  ','') ?>

				</small>

				<?php comment_text(); ?>

			</div>
		</div>


		<?php
	}

	function xyr_smarty_limit_words($string, $word_limit=30,$_hellip = true){
		$words = explode(' ', $string, ($word_limit + 1));
		if(count($words) > $word_limit){
			array_pop($words);
			if($_hellip == true){
				$words[] = '&hellip;';
			}
		}
		return implode(' ', $words);
	}

	function xyr_smarty_limit_chars($string, $char_limit=30,$_hellip = true){
		if ( mb_strlen( $string, 'utf8' ) > $char_limit ) {
			$last_space = strrpos( substr( $string, 0, $char_limit ), ' ' ); // find the last space within 35 characters
			$string = substr( $string, 0, $last_space );

			if($_hellip == true){
				$string .= '&hellip;';
			}
		}
		return $string;

	}

	add_filter( 'excerpt_length', 'xyr_smarty_excerpt_length' );
	function xyr_smarty_excerpt_length( $length ) {
		return 85;
	}

	/* add_filter('get_the_excerpt', 'xyr_smarty_trim_excerpt');
	function xyr_smarty_trim_excerpt($text) {
	if(empty($text)) return;
	return rtrim($text,'[&hellip;]') .'&hellip;';
}
*/

function xyr_smarty_pagination($numpages = '', $pagerange = '', $paged='',$_class='') {

	if (empty($pagerange)) {
		$pagerange = 2;
	}

	global $paged;
	if (empty($paged)) {
		$paged = 1;
	}
	if ($numpages == '') {
		global $wp_query;
		$numpages = $wp_query->max_num_pages;
		if(!$numpages) {
			$numpages = 1;
		}
	}


	//$wp_query->query_vars[ 'paged' ] > 1 ? $current = $wp_query->query_vars[ 'paged' ] : $current = 1;

	$pagination_args = array(
		//'base'            => get_pagenum_link(1) . '%_%',
		'base' => 			@add_query_arg( 'paged', '%#%' ),
		'format'          => 'page/%#%',
		'total'           => $numpages,
		'current'         => $paged,
		'show_all'        => False,
		'end_size'        => 1,
		'mid_size'        => $pagerange,
		'prev_next'       => True,
		'prev_text'       => __('Prev'),
		'next_text'       => __('Next'),
		'type'            => 'array',

	);
	/*

	$paginate_links = paginate_links($pagination_args);

	if ($paginate_links) {
	echo '<ul class="pagination '.$_class.'">';
	foreach($paginate_links as $_val){
	echo '<li>'.$_val.'</li>';
}
echo "</ul>";
} */
}

function xyr_smarty_embed_video($post_id) {

	$post = get_post($post_id);
	$content = do_shortcode( apply_filters( 'the_content', $post->post_content ) );
	//$content = $post->post_content ) );
	$embeds = get_media_embedded_in_content( $content );

	if( !empty($embeds) ) {
		//check what is the first embed containg video tag, youtube or vimeo
		foreach( $embeds as $embed ) {
			if( strpos( $embed, 'video' ) || strpos( $embed, 'youtube' ) || strpos( $embed, 'vimeo' ) ) {
				return $embed;
			}
		}

	} else {
		//No video embedded found
		return false;
	}

}


function xyr_smarty_get_youtube_videos($string,$_single = true){

	$ids = array();

	// find all urls
	preg_match_all('/(http|https)\:\/\/[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,3}(\/\S*)?/', $string, $links);

	foreach ($links[0] as $link) {
		if (preg_match('~youtube\.com~', $link)) {
			if (preg_match('/[^=]+=([^?]+)/', $link, $id)) {
				if($_single == true){
					return $id[1];
				}
				$ids[] = $id[1];
			}
		}
	}

	return $ids;
}


class xyren_smarty_walker_nav_menu extends Walker_Nav_Menu {


	// add main/sub classes to li's and links
	function start_el(&$output, $page, $depth = 0, $args = [], $current_page = 0) {
		global $wp_query;
		$indent = ( $depth > 0 ? str_repeat( "\t", $depth ) : '' ); // code indent

		// depth dependent classes
		$depth_classes = array(
			( $depth == 0 ? 'main-menu-item' : 'sub-menu-item' ),
			( $depth >=2 ? 'sub-sub-menu-item' : '' ),
			( $depth % 2 ? 'menu-item-odd' : 'menu-item-even' ),
			'menu-item-depth-' . $depth
		);
		$depth_class_names = esc_attr( implode( ' ', $depth_classes ) );




		$active = $page->current ? ' active' : '';

		// passed classes
		$classes = empty( $page->classes ) ? array() : (array) $page->classes;
		$class_names = esc_attr( implode( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $page ) ) );

		// build html
		$output .= $indent . '<li id="nav-menu-item-'. $page->ID . '" class="' . $depth_class_names . ' ' . $class_names . ' '. $active .'">';

		// link attributes
		$attributes  = ! empty( $page->attr_title ) ? ' title="'  . esc_attr( $page->attr_title ) .'"' : '';
		$attributes .= ! empty( $page->target )     ? ' target="' . esc_attr( $page->target     ) .'"' : '';
		$attributes .= ! empty( $page->xfn )        ? ' rel="'    . esc_attr( $page->xfn        ) .'"' : '';

		$children = get_posts(array('post_type' => 'nav_menu_item', 'nopaging' => true, 'numberposts' => 1, 'meta_key' => '_menu_item_menu_item_parent', 'meta_value' => $page->ID));
		if( !empty($children )){
			$attributes .= ' class="dropdown-toggle"';
			$attributes .= ' href="#"';
		}else{
			$attributes .= ! empty( $page->url )        ? ' href="'   . esc_attr( $page->url        ) .'"' : '';
			$attributes .= ' class="menu-link ' . ( $depth > 0 ? 'sub-menu-link' : 'main-menu-link' ) . '"';
		}


		$page_output = sprintf( '%1$s<a%2$s>%3$s%4$s%5$s</a>%6$s',
		$args->before,
		$attributes,
		$args->link_before,
		apply_filters( 'the_title', $page->title, $page->ID ),
		$args->link_after,
		$args->after);

		// build html
		$output .= apply_filters( 'walker_nav_menu_start_el', $page_output, $page, $depth, $args, $current_page);
	}



	function start_lvl(  &$output, $depth = 0, $args = array() ){
		$indent = str_repeat("\t", $depth);
		$output .= "\n$indent<ul class=\"dropdown-menu\">\n";
	}
	function end_lvl(  &$output, $depth = 0, $args = array() ) {
		$indent = str_repeat("\t", $depth);
		$output .= "$indent</ul>\n";
	}

}


function xyren_smarty_wp_link_pages_link( $link ){

	global $page, $numpages, $more, $pagenow;

	if($page == $link){
		return "\n".'<li class="active"><a href="#">' . $link . '</a></li>';
	}
	return '<li>' . $link . '</li>';



}
add_filter( 'wp_link_pages_link',  'xyren_smarty_wp_link_pages_link' );

function xyren_smarty_search_url_redirect() {
	if ( is_search() && !empty( $_GET['s'] ) ) {

		//echo 'wow';
		wp_redirect( home_url( "/search/" . urlencode( get_query_var( 's' ) ) .'/') );
		exit;
	}
}
add_action( 'template_redirect', 'xyren_smarty_search_url_redirect' );


/* Add Next Page Button in First Row */
function xyr_add_next_page_button( $buttons, $id ){
	/* only add this for content editor */
	if ( 'content' != $id )
	return $buttons;

	/* add next page after more tag button */
	array_splice( $buttons, 13, 0, 'wp_page' );

	return $buttons;
}

add_filter( 'mce_buttons', 'xyr_add_next_page_button', 1, 2 ); // 1st row
