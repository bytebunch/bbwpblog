<?php
/**
*Template Name: Verify
*/
get_header(); ?>

<main role="main" class="content_wrapper">
	<div class="container">
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-8 col-lg-8 page_left_content">
				<div class="content" id="content">
					<?php if (have_posts()): while (have_posts()) : the_post(); ?>
						<!-- article -->
						<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

							<div class="web_boxp headding_title">
									<h2 class="center"><?php the_title(); ?></h2>
							</div>
							<div class="web_boxp">

								<?php
								if(isset($_GET['key']) && ctype_digit($_GET['key']) && isset($_GET['type']) && $_GET['type'] == 'sub')
								{
									 $key = $_GET['key'];
									 global $wpdb;
									 $sql = $wpdb->prepare('SELECT email FROM '.$wpdb->bbb_email_list.' WHERE verification_key = %s LIMIT 1', $key);
									 $resulsts = $wpdb->get_results($sql, ARRAY_A);
									 if($resulsts){
										 $wpdb->update($wpdb->bbb_email_list, array('verified' => 1, 'status' => 1), array("verification_key" => $key), array("%d","%d"), array("%s"));
											/*$sql = "UPDATE ".$wpdb->prefix."email_list SET verified=1, status=1 WHERE verification_key = ".sql_ready($key)."";
											$wpdb->query($sql);*/
											echo '<p><strong>Welcome back, '.$resulsts[0]['email'].'</strong></p>'
											. '<h3>Email Subscription Confirmed!</h3>'
											. '<p>We will keep you updated with our newest products, updates and events</p>';
									 }else{
											echo 'This link has been expired.';
									 }

								}else{
									//the_content();
									 echo 'There is nothing on this page to show you.';
								}
								 ?>

							</div>

						<!-- article -->
						<article>
					<?php endwhile; ?>
					<?php else: ?>
						<article>
							<h2><?php _e( 'Sorry, nothing to display.', 'bbblank' ); ?></h2>
						</article>
					<?php endif; ?>
				</div><!-- content div end here-->
			</div><!-- col 8 div end here-->


			<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4"><?php get_sidebar(); ?></div>



		</div><!-- row div end here-->
	</div><!-- container div end here-->
</main>

<?php get_footer(); ?>
