
	
	<?

global $_navClass;
$_navClass ='sticky header-md clearfix';


get_header();

?>


		<section class="page-header light page-header-xs">
			<div class="container">

				<!-- breadcrumbs -->
				<ol class="breadcrumb breadcrumb-inverse">
					<li><a href="<?=site_url();?>">Home</a></li>
					<li class="active"><?php the_title();?></li>
				</ol><!-- /breadcrumbs -->

			</div>
		</section>
	<!-- /PAGE HEADER -->


		<!-- Zone Tag : LionhearTV 2016 LionhearTV Leaderboard -->
		<div style="text-align:center;padding: 10px 0px 0px 0px;">
		<br />
			<script type="text/javascript">
				new innity_adZone("7989edad14ebcd3adfacc7344dc6b739", "57593", {"width": "728", "height": "90"});
			</script>
		</div>

	
	
			
			<!-- -->
			<section>
				<div class="container">

					<div class="row">

						<!-- LEFT -->
						<div class="col-md-8 col-sm-8">
						
							<div class="post-data">
			<?php
				// Start the Loop.
				
				
			global $wp_query;
				
			$_excludeID = $_GET['id'];
			$_pageID = get_query_var( 'xyr_scroll_post');
			$xyr_scroll_category = get_query_var( 'xyr_scroll_category' );

			
			if(empty($_pageID) and !is_numeric($_pageID)){
				$_pageID = 1;
			}
			(int)$page = $_pageID; 
			$_categoryName = $xyr_scroll_category;
			
				 $_loadPost = new WP_Query(array(
					'posts_per_page' => 5,
					'post__not_in' => array($_excludeID),
					'offset' => $page,
					'category_name' => $_categoryName
				) );
				
				while ( $_loadPost->have_posts() ) : $_loadPost->the_post();
			?>
					
					<article class="loop">	
						<div class="blog-post-item">
							<?
							if(has_post_thumbnail()){
								echo '<!-- IMAGE -->
								<figure class="margin-bottom-20">';
								the_post_thumbnail('full','class=img-responsive'); 
								echo '</figure>
								<!-- /IMAGE -->';
							}?>

							<h2 class="blog-post-title uppercase"><a href="<?php the_permalink();?>"><?php the_title(); ?></a></h2>

							<ul class="blog-post-info list-inline">
								<li>
									<a href="#">
										<i class="fa fa-clock-o"></i> 
										<span class="font-lato"><time class="entry-date" datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>"><?php echo esc_html( get_the_date() ); ?></time></span>
									</a>
								</li>
								<?php 
								
								if ( $post->comment_count > 0 ): ?>
								<li>
									<a href="#">
										<i class="fa fa-comment-o"></i> 
										<span class="font-lato">
										<?=get_comments_number(); ?> Comment<?=$post->comment_count > 1 ? 's' : '';?></span>
									</a>
								</li>
								<?php endif; // Check for have_comments(). ?>
								
								<li class="font-lato">
									<i class="fa fa-folder-open-o"></i> 
									<?=get_the_category_list(' ');?>
								</li>
								
								<li>
									<a href="<?php echo esc_url( get_author_posts_url(get_the_author_meta('ID')) );?>">
										<i class="fa fa-user"></i> 
										<span class="font-lato"><?php the_author();?></span>
									</a>
								</li>
								
								<?php edit_post_link('<i class="fa fa-edit"></i> <span class="font-lato">'. __( 'Edit', XYR_SMARTY ) .'</span>', '<li>', '</li>' ); ?>
							</ul>

							
							<?php the_excerpt(); ?>
							
							
							<a href="<?php the_permalink();?>" class="btn btn-reveal btn-default">
								<i class="fa fa-plus"></i>
								<span>Read More</span>
							</a>

						</div>
					</article>
					
				<?php endwhile; // end of the loop. ?>
								
				
			</div>
			
							<?php  xyr_unliscroll(); ?>
							
						</div>

						<?php get_sidebar('main');?>

					</div>


				</div>
			</section>
			<!-- / -->


<?

get_footer();