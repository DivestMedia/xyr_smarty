<?php get_header();  ?>

<div class="page-container home-content">

	<?php //load_template_part( 'header','adds-970','_template'); ?>


	<div class="left-content align-left">
		
		<div class="widget">
			<h4 class="widget-title">
			<span> 
				<i><a href="/">Home</a> / Search / </i>
				<?
				echo get_search_query();
				?>
			</span> &nbsp;
			</h4>
		</div>	

		
		<div class="post-list new-layout">
				<div class="post">
					<h1>Search for: "<?php printf( __( '%s', 'simply-loud' ), get_search_query()  ); ?>"</h1>
				</div>
		</div>
		
		<?
			
			
			$_tag = $wp_query->query;
				
				
				
			$paged = empty($paged) ? 1 : $paged; 
			$per_page = get_option('posts_per_page',10);
			$args = array(
				'showposts' => $per_page,
				'post_type'  =>  array('news','category', 'post_tag', BAND_POSTTYPE, GIG_POSTTYPE, VENUE_POSTTYPE, ),
				'paged'      =>  $paged,
			);
			
			
			if(!empty($_GET['q'])){
			
				$reqSearch = $_GET['q'];
				if($reqSearch == 'news'){
					$args['post_type'] = array('news','category', 'post_tag');
				}elseif($reqSearch == 'bands'){
					$args['post_type'] = array('category', 'post_tag', BAND_POSTTYPE );
				}elseif($reqSearch == 'venue'){
					$args['post_type'] = array('category', 'post_tag',  VENUE_POSTTYPE, );
				}elseif($reqSearch == 'gigs'){
					$args['post_type'] = array('category', 'post_tag', GIG_POSTTYPE );
				}else{
					$args['post_type'] = array('category', 'post_tag', BAND_POSTTYPE, GIG_POSTTYPE, VENUE_POSTTYPE, );
				}
			}
			
			$resultCategory = array_merge((array)$args, (array)$_tag);
			query_posts( $resultCategory );
			
		?>
		<div class="post-meta ">
			<span class="data-info">
				<span>Total Topics found </span><b><?=number_format($wp_query->found_posts);?></b>
				<span>Current Page </span><b><?=$paged;?></b>
			</span>
		</div>
		
		
		<div class="post-list new-layout">
			
			<div class="post">
				
				
				<?php get_sidebar('band');  ?>
				
				<div class="post-new-content">
					<?php 
			
					if(have_posts()):
					
					echo '<ul class="archive-list">';
						while ( have_posts() ) : the_post();
							echo '<li>';
								include( TEMPLATEPATH .'/_template/single-archive.php');
							echo '</li>';
						endwhile;
						echo '</ul>';
					else:
						include( TEMPLATEPATH .'/_template/404-search.php');
					endif;
				?>
				</div>
				
				<div class="post-new-content">
					<?
					if(have_posts()):
						include( TEMPLATEPATH .'/_template/page-navigation.php');
					endif;
					wp_reset_postdata(); ?>
					
				</div>
			</div>
	
		</div>
	</div>
	
	<?php get_sidebar('news_main'); ?>

	
	<br class="clear"/>
</div>

<br class="clear"/>

<?php get_footer(); 

