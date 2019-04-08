<?php 
global $BBBThemeOptions;
get_header(); ?>
<main role="main" class="content_wrapper">
	<div class="container">
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-8 col-lg-8 page_left_content">
				<div class="content" id="content">
					<div class="web_boxp headding_title">
						<h2 class="center">Error 404 - Not Found</h2>
					</div>
					<div class="page_entry web_boxp">
						<h3>Oops!</h3>
							<p>Something went wrong - we couldn't find what you were looking for.</p>
							<hr />
							<h3>Or why not take a look through the most recent posts?</h3>
							<ul>
								<?php
									$recent_posts = wp_get_recent_posts();
									foreach( $recent_posts as $recent ){
											echo '<li><a href="' . get_permalink($recent["ID"]) . '" title="Look '.esc_attr($recent["post_title"]).'" >' .   $recent["post_title"].'</a> </li> ';
									}
								?>
							</ul>
							<hr />
							<h3>No good?</h3>
							<p>Please use the search form to try again or start browsing from the <a href="<?php echo HOME_URL; ?>">Homepage.</a></p>

							<form method="get" class="searchform search_form" action="<?php echo HOME_URL; ?>">
							<fieldset>
								<p><input type="text" name="s" class="s" value="" placeholder="Search Now" style="width:100%; max-width:250px;"></p>
								<p><input class="search_button" type="submit" value="Submit" /></p>
								<div class="clearboth"></div>
							</fieldset>
						</form>
						<p>If you need further assistance please don't hesitate to <a href="<?php echo get_permalink($BBBThemeOptions->get_option('page_contact_us_id')); ?>">contact us</a>.</p>
					</div>
				</div><!-- content div end here-->
			</div><!-- col 8 div end here-->

			<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4"><?php get_sidebar(); ?></div>



		</div><!-- row div end here-->
	</div><!-- container div end here-->
</main>

<?php get_footer(); ?>
