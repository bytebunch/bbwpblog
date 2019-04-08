<?php get_header(); ?>

	<main role="main" class="content_wrapper">
		<div class="container">
			<div class="row">
				<div class="col-xs-12 col-sm-12 col-md-8 col-lg-8 page_left_content">
					<div class="content" id="content">
							<div class="web_boxp headding_title">
								<h2 class="center"><?php _e( 'Archives', 'bbblank' ); ?></h2>
							</div>
              <?php get_template_part('loop'); ?>
					</div><!-- content div end here-->
				</div><!-- col 8 div end here-->
				<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4"><?php get_sidebar(); ?></div>
			</div><!-- row div end here-->
		</div><!-- container div end here-->
	</main>

<?php get_footer(); ?>
