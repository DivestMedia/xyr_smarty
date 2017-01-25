<?php

class xyr_smarty_tinypoll_Widget extends WP_Widget {
 
    public function __construct() {
     
        parent::__construct(
            'tutsplustext_widget',
            __( 'TinyPoll', XYR_SMARTY ),
            array(
                'classname'   => 'tutsplustext_widget',
                'description' => __( 'A basic text widget to demo the Tutsplus series on creating your own widgets.', 'tutsplustextdomain' )
                )
        );
       
        load_plugin_textdomain( 'tutsplustextdomain', false, basename( dirname( __FILE__ ) ) . '/languages' );
       
    }
 
    /**  
     * Front-end display of widget.
     *
     * @see WP_Widget::widget()
     *
     * @param array $args     Widget arguments.
     * @param array $instance Saved values from database.
     */
    public function widget( $args, $instance ) {   
         
        extract( $args );
         
        $postID      = apply_filters( 'widget_postID', $instance['postID'] );
        $title    = $instance['title'];
        $message    = $instance['message'];
         
        //echo $before_widget;
         
        if ( $postID ) {
            echo $before_widget ;//. $postID . $after_postID;
			
			
			if(!empty($title)){
				echo '<div class="heading-title heading-dotted margin-bottom-10">
					<h3><i class="fa fa-chevron-circle-right text-grey"></i> <span> '.$title.'</span></h3>
				</div>';
			}
			
			?>
			
			<div class="size-13 nopadding">
			
				<?
				global $wpdb;
				$the_query = new WP_Query(array( 'posts_per_page' => 1 , 'p' => $postID/*, 'category_name'=>'Movies'  */));

				//global $query_string; query_posts( $query_string . '&posts_per_page=3&category_name=Music' );
				while ( $the_query->have_posts() ) : $the_query->the_post(); ?>
					
					<?
				
						$_postID = get_the_ID();
						// Get the location data if its already been entered
						$xyr_poll_meta_button_blue = get_post_meta($_postID, '_xyr_poll_meta_button_blue', true);
						$xyr_poll_meta_button_red = get_post_meta($_postID, '_xyr_poll_meta_button_red', true);
						$xyr_poll_meta_subtitle = get_post_meta($_postID, '_xyr_poll_meta_subtitle', true);


						$xyr_poll_meta_button_blue = empty($xyr_poll_meta_button_blue) ? 'Yes' : $xyr_poll_meta_button_blue;
						$xyr_poll_meta_button_red = empty($xyr_poll_meta_button_red) ? 'No' : $xyr_poll_meta_button_red;
						
						
						?>
					
					
					<?php if(has_post_thumbnail()) { ?>
						<a class="image-hover" href="<?php the_permalink() ?>">
							<span class="image-hover-icon image-hover-dark">
								<i class="fa fa-link"></i>
							</span>
							<?php the_post_thumbnail('mid-image',array('class' => 'img-responsive'));?>
							
						</a>
					<?php } ?>
					
					<div class="callout callout-dark noradius padding-10">

						<h4 class=" white-text nomargin"><?php the_title(); ?></h4>
						<?
						if(!empty($xyr_poll_meta_subtitle)){
							echo '<p class="lead margin-bottom-20">'. $xyr_poll_meta_subtitle .'</p>';
						}?>
						<br/>
					</div>	
						
					<div class="padding-20 alert alert-dark noradius">

						<div class="row vote-side-<?=$_postID;?>">
											
							<div class="col-md-6 padding-left-10" style="padding:0 10px 0 0;">
								<button type="button" class="vote-button btn-block btn btn-info btn-lg vote-button-blue" data-choice="1" data-postid="<?=$_postID;?>" data-caps="<?=$xyr_poll_meta_button_blue;?>"><?=$xyr_poll_meta_button_blue;?></button>
							</div>
							
							<div class="col-md-6 nopadding">
								<button type="button" class="vote-button btn-block btn btn-danger btn-lg vote-button-red" data-choice="2" data-postid="<?=$_postID;?>" data-caps="<?=$xyr_poll_meta_button_red;?>"><?=$xyr_poll_meta_button_red;?></button>
								
							</div>
						</div>
					</div>
						
				<?php 	
				endwhile;
				wp_reset_postdata();
				?>
	
	
				
			</div>
			<?
        }
                             
       // echo $message;
        echo $after_widget;
         
    }
 
    public function update( $new_instance, $old_instance ) {        
         
        $instance = $old_instance;
         
        $instance['postID'] = strip_tags( $new_instance['postID'] );
        $instance['title'] = strip_tags( $new_instance['title'] );
        $instance['message'] = strip_tags( $new_instance['message'] );
         
        return $instance;
         
    }
  
    public function form( $instance ) {    
     
        $postID      = esc_attr( $instance['postID'] );
        $title    = esc_attr( $instance['title'] );
        $message    = esc_attr( $instance['message'] );
        ?>
         
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label> 
            <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
        </p>
		<p>
            <label for="<?php echo $this->get_field_id('postID'); ?>"><?php _e('Post ID:'); ?></label> 
            <input class="widefat" id="<?php echo $this->get_field_id('postID'); ?>" name="<?php echo $this->get_field_name('postID'); ?>" type="text" value="<?php echo $postID; ?>" />
        </p>
        
    <?php 
    }
     
}
 
/* Register the widget */
add_action( 'widgets_init', function(){
     register_widget( 'xyr_smarty_tinypoll_Widget' );
});