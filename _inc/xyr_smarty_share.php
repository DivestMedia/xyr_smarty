<?php


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
