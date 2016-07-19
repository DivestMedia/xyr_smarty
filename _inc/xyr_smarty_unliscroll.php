<?



add_filter('rewrite_rules_array', 'xyr_unliscroll_rewriteRules'); 
function xyr_unliscroll_rewriteRules($rules){
	$newrules = array();
	$newrules['loadajax/(.*)/(.*)$'] = 'index.php?xyr_scroll=1&xyr_scroll_category=$matches[1]&xyr_scroll_post=$matches[2]';
	return $newrules + $rules;
}

add_filter( 'query_vars', 'xyr_unliscroll_register_query_var');	
function xyr_unliscroll_register_query_var($vars){
	$vars[] = 'xyr_scroll_post';
	$vars[] = 'xyr_scroll';
	$vars[] = 'xyr_scroll_category';
	return $vars;
}

add_filter('template_include', 'xyr_unliscroll_template_include' ,1,1);  
function xyr_unliscroll_template_include($template){
		
	$_templateDir = get_stylesheet_directory() .'/ajax-single.php';
	$xyr_scroll_category = get_query_var( 'xyr_scroll_category' );
	$xyr_scroll = get_query_var( 'xyr_scroll' );
	$_post = get_query_var( 'xyr_scroll_post' );
	$_function = get_query_var('func');
	if($xyr_scroll == "1"){
		if(file_exists($_templateDir)){
			return $_templateDir;
		}else{
			$_templateDir = get_template_directory() .'/ajax-single.php';
			return $_templateDir;
		}
	}
	
	return $template;
	
	
}


add_action( 'wp_ajax_xyr_unliscroll_jx', 'xyr_unliscroll_jx' );
add_action( 'wp_ajax_nopriv_xyr_unliscroll_jx', 'xyr_unliscroll_jx' );
function xyr_unliscroll_jx() {
	
    // Handle request then generate response using WP_Ajax_Response
	$_data = $_POST;
	
	$_post_id = $_data['post_id'];
	$_choice_id = $_data['choice_id'];
	
	
	$_choice_data = get_post_meta( $_post_id, '_xyrpoll', true);
	
	if(!is_array($_choice_data)){
		$_choice_data = array(0 => 0,1 => 0,2 => 0);
	}
	//update the session
	if(!empty($_SESSION['xyr-poll'][$_post_id])){
		
		$total = (int)$_choice_data[1] + (int)$_choice_data[2];
		$data = array_merge($_choice_data , array('totals' => $total , 'bluevote' =>$_choice_data[1]  , 'redvote' =>$_choice_data[2] )); 
		echo json_encode($data);
		
		exit;
	}
}



function xyr_unliscroll() {
	global $post; 
	
	
	$category = get_the_category();
	$cat_slug = $category[0]->slug;
	
	?>


		<div class="clearfix infinite-scroll " data-nextSelector="#inf-load-next" data-itemSelector=".post-data">

			<div class="post-data"><!-- item -->
			</div><!-- /item -->

		</div>

		<!-- INFINITE SCROLL LOAD -->
		<div id="inf-load-next" class="center margin-bottom-100">
			<a href="/loadajax/<?=$cat_slug;?>/2/?id=1" class="btn btn-3d btn-xlg btn-dirtygreen block size-25 weight-300 font-lato nomargin noradius">
				load more...
			</a>

		</div>
			

<?
	
}



function xyr_unliscroll_home(){
//function xyr_infiscroll(){
	
	$cat_slug = 'home';
	
	$_paged = get_query_var('paged',1);
	$_paged = $_paged + 1;
	global $wp_query, $post;
	?>

	<?php
				if (function_exists(xyr_smarty_pagination)) {
					xyr_smarty_pagination($custom_query->max_num_pages,"",$paged,'noradius');
				}
				
				wp_reset_postdata(); ?>
				
			<div class="posts"><div class="row-mason"></div></div>

		<!-- INFINITE SCROLL LOAD -->
		
		
		<script>
		
		

		jQuery(document).ready(function(){
			
			var ias = jQuery.ias({
				container:  '.posts',
				item:       '.row-mason',
				pagination: '.pagination',
				next:       '.page-numbers'
			});
			
			ias.extension(new IASSpinnerExtension());	
			ias.extension(new IASTriggerExtension({
				offset: 5, text: '<button class="next-page btn btn-sm btn-default btn-bordered noradius padding-20 width-300">LOAD MORE</button>', // optionally
			}));
			ias.extension(new IASNoneLeftExtension({text: "You reached the end"}));
			jQuery.ias().extension(new IASPagingExtension());
			jQuery.ias().on('pageChange', function(pageNum, scrollOffset, url) {
				var page_title = 'Page: '  + pageNum + ' | <? bloginfo();?> | <? bloginfo('description');?>';
				history.pushState('home-scroll', page_title , url);
				document.title = page_title ;
			});

		});
		
		</script>
		
		<?
}


function xyr_unliscroll_homex() {
	//global $post; 
	
	//$category = get_the_category();
	//$cat_slug = $category[0]->slug;
	$cat_slug = 'home';
	
	$_paged = get_query_var('paged',1);
	$_paged = $_paged + 1;
	?>


		<div class="clearfix infinite-scroll-home" data-nextSelector="#inf-home-next" data-itemSelector=".post-data">

			<div class="post-data"><!-- item -->
			</div><!-- /item -->

		</div>

		<!-- INFINITE SCROLL LOAD -->
		
		<div id="inf-home-next" class="center margin-bottom-100 text-center">
			<a href="/page/2/?id=1" class="btn btn-sm btn-default btn-bordered noradius padding-10 width-300">
				LOAD MORE
			</a>

		</div>
		
		
		<script>
		
		function _infiniteScrollHome() {
		var _container 	= jQuery(".infinite-scroll-home");

		if(_container.length > 0) {

			loadScript(plugin_path + 'infinite-scroll/jquery.infinitescroll.min.js', function() {

					_navSelector	= _container.attr('data-nextSelector') || "#inf-load-nex",
					_itemSelector	= _container.attr('data-itemSelector') || ".item",
					_nextSelector	= _navSelector + " a";

				_container.infinitescroll({
					loading: {
						finishedMsg	: '<i class="fa fa-check"></i>',
						msgText		: '',
						//msgText		: '<i class="fa fa-refresh fa-spin"></i>',
						img			: "data:image/gif;base64,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",
						speed		: 'normal'
					},
					nextSelector	: _nextSelector,
					navSelector		: _navSelector,
					itemSelector	: _itemSelector,
					behavior		: '',
					maxPage			: 7,

					state: {
						isDone		: false
					}
				},

				function(newElements) {

					Init(true);

					if(jQuery().isotope) {

						_container.isotope('appended', jQuery(newElements));

						setTimeout( function(){ 
							_container.isotope('layout'); 
						}, 2000);

					}

				});

			});

		}

		}

		jQuery(document).ready(function(){
			
			_infiniteScrollHome();
			
		});
		
		</script>
<?
	
}
