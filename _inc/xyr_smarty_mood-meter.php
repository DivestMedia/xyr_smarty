<?






add_action( 'wp_ajax_mood_meter_add', 'mood_meter_add' );
add_action( 'wp_ajax_nopriv_mood_meter_add', 'mood_meter_add' );

function mood_meter_add() {
	
	if(!session_id()) {
        session_start();
    }
	
    // Handle request then generate response using WP_Ajax_Response
	$_data = $_POST;
	
	$_post_id = $_data['post_id'];
	$_choice_id = $_data['choice_id'];
	
	
	
	$_choice_data = get_post_meta( $_post_id, '_mood_meter', true);
	
	if(!is_array($_choice_data)) $_choice_data = array();
	$_choice = (int) $_choice_data[$_choice_id];
	$_update_choice = $_choice + 1;
	
	$_choice_data[$_choice_id] = $_update_choice;
	
	if(!empty($_SESSION['mood-meter'][$_post_id])){
		$_SESSION['mood-meter'][$_post_id] = $_choice_id;
	
		echo $_choice;
		exit;
	}
	update_post_meta($_post_id, '_mood_meter', $_choice_data);
	echo $_update_choice;
	
	//update the session
	$_SESSION['mood-meter'][$_post_id] = $_choice_id;
	
	exit;
}



function mood_meter(){
	
	global $post;
	?>
	
	
	<div class="divider"><!-- divider --></div>
	<h4>Whats your reaction?</h4>
	
	<div class="row box-gradient box-lion mood-meter" post_id="<?=get_the_ID();?>">
	
	
	
		<? 
		
		$_textVal = array(
			'fa-smile-o' => 'ABA\'Y MATINDI',
			'fa-thumbs-up' => 'OK LANG',
			'fa-heart' => 'LOL',
			'fa-star' => 'PAK NA PAK',
		);
		
		$_choice_data = get_post_meta( $post->ID, '_mood_meter', true);
		if(!is_array($_choice_data)) $_choice_data = array();
		
		$x=1;
		foreach($_textVal as $key => $val){ 
		?>
		
					<div class="col-xs-6 col-sm-3 mood-meter-choice" data-choice="<?=$x;?>">
						<i class="fa <?=$key;?> fa-4x"></i>
						<h2 class="font-raleway count_mood" data-speed="1800" data-count="<?=$_choice_data[$x];?>">0</h2>
						<p><?=$val;?></p>
					</div>

		<? 
		$x++;
		} ?>
			</div>
	<style>
			.box-lion>div:nth-child(1) {
		background-color:#003300;
	}
	.box-lion>div:nth-child(2) {
		background-color:#336600;
	}
	.box-lion>div:nth-child(3) {
		background-color:#339900;
	}
	.box-lion>div:nth-child(4) {
		background-color:#66cc00;
	}
	.box-lion>div{cursor:pointer}
	.box-lion>div:hover,
	.box-gray .selectchoice{background-color:#ffba00 !important;}
	</style>


			
	<script>
		
	jQuery( document ).ready( function(){
		$('.count_mood').each(function () {
		  var $this = $(this);
		  console.log(jQuery(this).data('count'));
		  jQuery({ Counter: 0 }).animate({ Counter: $this.data('count') }, {
			duration: 1000,
			easing: 'swing',
			step: function () {
			  $this.text(Math.ceil(this.Counter));
			}
		  });
		});
		
		
		jQuery( '.mood-meter-choice' ).on( 'click', function() {
		
			var current_choice = this;
			jQuery('.mood-meter-choice',document).unbind('click');
				
			var choice_id = jQuery(this).data('choice');
			var post_id = jQuery(this).parent().attr('post_id');
			
			//return false;
			jQuery.ajax({
				url : '<?=admin_url( 'admin-ajax.php' );?>',
				type : 'post',
				data : {
					action : 'mood_meter_add',
					post_id : post_id,
					choice_id : choice_id
				},
				success : function( response ) {
					if(jQuery.isNumeric(response)){
						console.log('mood meter success');
						jQuery('.countTo',current_choice).html(response);
						jQuery('.mood-meter').removeClass('box-lion');
						jQuery('.mood-meter').addClass('box-gray');
						jQuery('.mood-meter-choice',document).unbind('click');
					}
				},
				complete: function() {
					//jQuery('.mood-meter-choice').bind('click');
					jQuery(current_choice).addClass('selectchoice');
					
				}
			});
		});
		
	});
	
	
	
	
	</script>
	
	<?
}