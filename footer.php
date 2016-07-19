


			<!-- FOOTER -->
			<footer id="footer">
				<div class="container">

					<div class="row">
						
						<div class="col-md-3">
							<!-- Footer Logo -->
							<img class="footer-logo" src="<?=get_stylesheet_directory_uri();?>/assets/logo_light.png" alt="" />
							<? global $_xyr_smarty;?>
							<!-- Small Description -->
							<p><? _e($_xyr_smarty['company_info']['description']);?></p>
							<!-- Contact Address -->
							<address>
								<ul class="list-unstyled">
									<li class="footer-sprite address">
										<? 
											$_address = str_replace("\n",'<br/>',$_xyr_smarty['company_info']['address']);
											_e( $_address);?>
									</li>
									<li class="footer-sprite phone">
										<? _e('Phone',XYR_SMARTY);?>: <? _e($_xyr_smarty['company_info']['phone']);?>
									</li>
									<li class="footer-sprite email">
										<a href="mailto:<? _e($_xyr_smarty['company_info']['support']);?>"><? _e($_xyr_smarty['company_info']['support']);?></a>
									</li>
								</ul>
							</address>
							<!-- /Contact Address -->

						</div>


						<div class="col-md-2">

							<!-- Links -->
							<h4 class="letter-spacing-1"><? _e('EXPLORE',XYR_SMARTY);?> <? _e($_xyr_smarty['company_info']['name_small']);?></h4>
						
							<?php if ( has_nav_menu( 'footer' ) ) :
								wp_nav_menu( array(
									'theme_location' => 'footer',
									'container'     => 'ul',
									'menu_class'     => 'footer-links list-unstyled',
								) );
							endif; ?>
							<!-- /Links -->

						</div>
						
						
						<div class="col-md-3">

							<!-- COURSES -->
							<h4 class="letter-spacing-1">COURSES</h4>
							<ul class="footer-posts list-unstyled">
								<li>
									<a href="<?=site_url();?>/courses/share-options-trading-course/">Share Options Trading</a>
								</li>
								<li>
									<a href="<?=site_url();?>/courses/advanced-options-trading-course-101/">Advanced Options Trading 101</a>
								</li>
								<li>
									<a href="<?=site_url();?>/courses/12-month-premium-classroom/">12 Month Premium Classroom</a>
								</li>
								<li>
									<a href="<?=site_url();?>/courses/alumni/">Alumni</a>
								</li>
								<li>
									<small class="text-info">Coming Soon *<br/></small>
									Advanced Options Trading 102
								</li>
							</ul>
							<!-- /COURSES -->

						</div>

						<div class="col-md-4">
						
						
							<h4 class="letter-spacing-1 uppercase">Why Trading Institute?</h4>
							
							<p>All the research from the ground up is done for you!<br/>
								All the jargon is explained in simple terms!<br/>
								Perfect for the complete beginner, through to someone who’s done some research, but needs to know how the professionals do it. 
							</p>

							<!-- Newsletter Form -->
							<h4 class="letter-spacing-1">KEEP IN TOUCH</h4>
							<p>Subscribe to Our Newsletter to get Important News &amp; Offers</p>

							<form class="validate" action="php/newsletter.php" method="post" data-success="Subscribed! Thank you!" data-toastr-position="bottom-right">
								<div class="input-group">
									<span class="input-group-addon"><i class="fa fa-envelope"></i></span>
									<input type="email" id="email" name="email" class="form-control required" placeholder="Enter your Email">
									<span class="input-group-btn">
										<button class="btn btn-primary" type="submit">Subscribe</button>
									</span>
								</div>
							</form>
							<!-- /Newsletter Form -->

							<!-- Social Icons -->
							<div class="margin-top-20">
								<a href="#" class="social-icon social-facebook pull-left" data-toggle="tooltip" data-placement="top" title="Facebook">

									<i class="icon-facebook"></i>
									<i class="icon-facebook"></i>
								</a>

								<a href="#" class="social-icon social-twitter pull-left" data-toggle="tooltip" data-placement="top" title="Twitter">
									<i class="icon-twitter"></i>
									<i class="icon-twitter"></i>
								</a>

								<a href="#" class="social-icon social-gplus pull-left" data-toggle="tooltip" data-placement="top" title="Google plus">
									<i class="icon-gplus"></i>
									<i class="icon-gplus"></i>
								</a>

								<a href="#" class="social-icon social-linkedin pull-left" data-toggle="tooltip" data-placement="top" title="Linkedin">
									<i class="icon-linkedin"></i>
									<i class="icon-linkedin"></i>
								</a>

								<a href="#" class="social-icon social-rss pull-left" data-toggle="tooltip" data-placement="top" title="Rss">
									<i class="icon-rss"></i>
									<i class="icon-rss"></i>
								</a>
					
							</div>
							<!-- /Social Icons -->

						</div>

					</div>

				</div>

				<div class="copyright">
					<div class="container">
						<?php if ( has_nav_menu( 'footer_ext' ) ) :
							$_footerLink = wp_nav_menu( array(
								'theme_location' => 'footer_ext',
								'echo'     => false,
								'container'     => 'ul',
								'menu_class'     => 'pull-right nomargin list-inline mobile-block',
							) );
							echo str_replace('<li','<li>&bull;</li><li',$_footerLink);
						endif; ?>
					
					
						&copy; All Rights Reserved <?=date('Y');?>, <? bloginfo('name');?>
					</div>
				</div>
			</footer>
			<!-- /FOOTER -->

		</div>
		<!-- /wrapper -->


		<!-- SCROLL TO TOP -->
		<a href="#" id="toTop"></a>

<?/* 
		<!-- PRELOADER -->
		<div id="preloader">
			<div class="inner">
				<span class="loader"></span>
			</div>
		</div><!-- /PRELOADER -->

 */?>
	
		
		
		<?
		
		
		wp_footer();
		global $_footers;

		echo $_footers;
		?>	
		

	</body>
</html>