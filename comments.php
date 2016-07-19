<?php
/**
 * The template for displaying comments
 *
 * The area of the page that contains both current comments
 * and the comment form.
 *
 * @package WordPress
 * @subpackage Xyr-Smarty
 */

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if ( post_password_required() ) {
	return;
}
?>



			<!-- COMMENTS -->
			<div id="comments" class="comments">

				<?php
					/* Run some checks for bots and password protected posts */ 
					$req = get_option('require_name_email'); // Checks if fields are required.
					if ( 'comments.php' == basename($_SERVER['SCRIPT_FILENAME']) )
						die ( 'Please do not load this page directly. Thanks!' );
					if ( ! empty($post->post_password) ) :
						if ( $_COOKIE['wp-postpass_' . COOKIEHASH] != $post->post_password ) :
							_e('This post is password protected. Enter the password to view any comments.', XYR_SMARTY); 
						return;
					endif;
				endif; ?>
				
				<h4 class="page-header margin-bottom-60 size-20">
					<? comments_number('NO COMMENT', '<span>1</span> COMMENT', '<span>%</span> COMMENTS'); ?>
				</h4>
				
				
				<?php if ( have_comments() ) : ?>
					<ul class="pagination pagination-sm">
					<?php 
					$pages = paginate_comments_links( array( 'echo' => false, 'type' => 'array' ) );
					if($pages){
						foreach($pages as $page){
							echo "<li>" . $page . "</li>";
						}
					}
					?></ul>
					
					
					<?php wp_list_comments('type=comment&callback=xyr_smarty_comments'); ?>
					
					
					<ul class="pagination pagination-sm">
					<?php 
					if($pages){
						foreach($pages as $page){
							echo "<li>" . $page . "</li>";
						}
					}
					?></ul>
					
					
				<?php endif; // Check for have_comments(). ?>

				<?php include_once('comment-form.php'); ?>

			</div>
			<!-- /COMMENTS -->
							
			
	
	