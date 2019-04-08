<?php get_header(); ?>

<main role="main" class="content_wrapper">
	<div class="container">
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-8 col-lg-8 page_left_content">
				<div class="content" id="content">
						<?php if (have_posts()): while (have_posts()) : the_post(); ?>
							<!-- article -->
							<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
								<div class="post_entry web_box">
										<div class="post_header">
											<div class="post_time">
												<span class="post_date"><?php echo get_the_date("d"); ?></span>
												<span class="post_month uppercase"><?php echo get_the_date("F"); ?></span>
											</div>
											<div class="title_wrap">
												<h2 class="title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
												<span class="post_author">Written by
													<a href="<?php get_the_author_meta('usr_url'); ?>"><?php the_author(); ?></a>
												</span>
											</div>
											<div class="clearboth"></div>
										</div><!-- post_header div end here-->
										<div class="post_content_container">
											<?php
											 /*if(get_feature_image_url(get_the_ID()))
												{ ?>
													<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>" class="image_wrapper">
														<img src="<?php echo get_feature_image_url(get_the_ID()); ?>" class="post_featured_image" alt="">
													</a>
											<?php } */ ?>

												<div class="post_content">
													<?php the_content(); ?>
													<p><?php the_tags( __( 'Tags: ', 'bbblank' ), ', ', '<br>'); // Separated by commas with a line break at the end ?></p>
													<?php //_e( 'Categorised in: ', 'bbblank' ); the_category(', '); // Separated by commas ?>
													<?php wp_link_pages(); edit_post_link(); // Always handy to have Edit Post Links available ?>
												</div>

										</div><!-- post_content_container div end here-->

										<div class="post_meta">
					 						 <span class="facebook_share">
					 							 <a href="https://www.facebook.com/sharer/sharer.php?u=<?php the_permalink(); ?>" data-url="<?php the_permalink(); ?>" class="image_wrapper"><img src="<?php echo THEME_URI; ?>images/facebook_like.png" alt="Facebook share"></a><!-- <span class="counter count">0</span> -->
					 							<?php /*<div class="fb-like" data-href="<?php the_permalink(); ?>" data-layout="button_count" data-action="like" data-show-faces="false" data-share="false"></div> <?php */ ?>
					 						 </span>
					 						 <span class="twitter_share">
					 							<?php /* <a href="https://twitter.com/intent/tweet?original_referer=http%3A%2F%2Falexanderhiggins.com%2Fst-louis-landfill-fire-could-reach-radioactive-waste-in-months-county-releases-public-emergency-plan%2F&amp;source=tweetbutton&amp;text=St. Louis Landfill Fire Could Reach Radioactive Waste in Months – County Releases Public Emergency Plan&amp;url=http%3A%2F%2Falexanderhiggins.com%2Fst-louis-landfill-fire-could-reach-radioactive-waste-in-months-county-releases-public-emergency-plan%2F&amp;via=higginsnewsnet">sd</a> */ ?>
					 							<?php /*<a href="https://twitter.com/share" class="twitter-share-button" data-url="<?php the_permalink(); ?>">Tweet</a> */ ?>
					 							<a href="https://twitter.com/intent/tweet?original_referer=<?php echo HOME_URL; ?>&ref_src=twsrc%5Etfw&text=<?php the_title(); ?>&tw_p=tweetbutton&url=<?php the_permalink(); ?>" data-url="<?php the_permalink(); ?>" class="image_wrapper"><img src="<?php echo THEME_URI; ?>images/tweet.png" alt="Twitter Share"></a>
					 						 </span>
					 						 <span class="linkedin_share hidden-xs">
					 							 <?php /* ?><a href="https://www.linkedin.com/cws/share?url=http%3A%2F%2Flocalhost%2Ftest%2Fwordpress%2Flatest-post%2F&original_referer=http%3A%2F%2Flocalhost%2Ftest%2Fwordpress%2F&token=&isFramed=false&lang=en_US&_ts=1454742590400.4482&xd_origin_host=http%3A%2F%2Flocalhost">sdf</a> <?php */ ?>
					 							 <a href="https://www.linkedin.com/shareArticle?mini=true&amp;url=<?php the_permalink(); ?>&amp;title=<?php the_title(); ?>&amp;summary=<?php echo substr(strip_tags(get_the_excerpt()),0,250).'...'; ?>" data-url="<?php the_permalink(); ?>" class="image_wrapper"><img src="<?php echo THEME_URI; ?>images/linked_share.png" alt="Linkedin Share" /></a><!-- <span class="counter count">0</span> -->
					 							 <?php /* <script type="IN/Share" data-url="<?php the_permalink(); ?>" data-counter="right"></script> */ ?>
					 						 </span>
					 						 <span class="google_share hidden-xs">
					 							 <a href="https://plus.google.com/share?url=<?php the_permalink(); ?>" data-url="<?php the_permalink(); ?>" class="image_wrapper" onclick="javascript:window.open(this.href,
					   '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;"><img src="<?php echo THEME_URI; ?>images/google-plus-icon.png" alt="GooglePlus share"></a>
					 							<?php /*<div class="g-plusone" data-size="medium" data-href="<?php the_permalink(); ?>"></div> */ ?>
					 						 </span>

					 						 <span class="post_comments">
					 							<a href="#comments" title="Comment on <?php the_permalink(); ?>"><?php comments_number( 'No comment', '1 comment', '% comments' ); ?></a>
					 						 </span>
											 <div class="clearboth"></div>
					 				 </div><!-- post_social_buttons end here-->

									</div><!-- post_entry div end here-->
									<?php comments_template(); ?>
							</article>
							<!-- /article -->
						<?php endwhile; ?>
						<?php else: ?>
							<!-- article -->
							<article>
								<h2><?php _e( 'Sorry, nothing to display.', 'bbblank' ); ?></h2>
							</article>
							<!-- /article -->
						<?php endif; ?>
				</div><!-- content div end here-->
			</div><!-- col 8 div end here-->


			<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
				<?php get_sidebar(); ?>
			</div>



		</div><!-- row div end here-->
	</div><!-- container div end here-->
</main>
<?php get_footer(); ?>
