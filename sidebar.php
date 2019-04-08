<!-- sidebar -->
<aside class="sidebar" role="complementary">

	<div class="widget sidebar_widget widget_search">
	  <form method="get" class="searchform search_form" action="<?php echo HOME_URL; ?>">
	    <fieldset>
	      <input type="text" name="s" class="s" value="" placeholder="Search Now">
	      <input class="search_button" type="submit" value="&nbsp;" />
	      <div class="clearboth"></div>
	    </fieldset>
	  </form>
	</div><!-- widget search div end here-->

	<div class="widget sidebar_widget subscribe web_boxp">
		<h3 class="widget_title">SUBSCRIBE</h3>
	  <?php //echo wp_get_archives(); ?>
	  <?php
	  //echo wp_get_archives(array('type' => 'daily'));
	  //echo get_author_posts_url(1);
	   ?>


	    <form action="#" method="post" class="subscribe_form">
	        <p>Sign up to be the first to know our newest products, updates and events.</p>
	        <input type="email" value="" placeholder="Email Address" name="email" required="required">
	        <input type="submit" value="Subscribe">
	        <div style="margin-top:20px;">
	            <span class="ajax_loader display_none">
	               Processing... <img src="<?php echo THEME_URI; ?>images/loadingAnimation.gif" alt="Ajax Loader" style="width: 100%;margin-top:5px;" />
	            </span>
	            <span class="ajax_message display_none"></span>
	         </div>
	    </form>
	</div><!-- subscribe tags end here-->

	<div class="widget sidebar_widget tags">
		<h3 class="widget_title">Tags</h3>
	    <div class="tagcloud">
	       <?php
	       $args = array(
	           'number' => 20,
	           'smallest' => 13,
	           'largest' => 20,
	           'unit' => 'px',
	           'orderby' => 'name',
					 'taxonomy' => array( 'post_tag'/*, 'category' */)
	         );
	       wp_tag_cloud($args); ?>

	        <div class="clearboth"></div>
	    </div>
	</div><!-- widget tags end here-->


	<div class="widget sidebar_widget">
	</div><!-- widget empty end here-->

	<?php /*<div class="widget sidebar_widget social_icon_widget">
	  <h3 class="widget_title uppercase">Follow Us</h3>
	    <a href="#" target="_blank" class="facebook"></a>
	    <a href="#" target="_blank" class="twitter"></a>
	    <a href="#" target="_blank" class="gplus"></a>
	    <a href="#" target="_blank" class="rss"></a>
	    <a href="#" target="_blank" class="pinterest"></a>
	    <a href="#" target="_blank" class="linkedin"></a>
	    <a href="#" target="_blank" class="flickr"></a>
	    <a href="#" target="_blank" class="skype"></a>
	    <a href="#" target="_blank" class="youtube"></a>
	    <!--<a href="#" target="_blank" class="tumblr"></a>
	    <a href="#" target="_blank" class="dribble"></a>
	    <a href="#" class="xing"></a>-->
	  <div class="clearboth"></div>
	</div><!-- WIDGET social end here --> */ ?>

	<div class="widget sidebar_widget popular_posts">
	<ul class="tabbed_menu">
		<li><a href="#recent_posts">Recent Posts</a></li>
		<li><a href="#popular_posts">Popular Posts</a></li>
	</ul>
	<div class="clearboth"></div>
		<div class="tab_menu_content" id="popular_posts">
	    <ul class="">
	      <?php query_posts('meta_key=page_views&orderby=meta_value_num&order=DESC&posts_per_page=5');
		if (have_posts()) : while (have_posts()) : the_post();
	      echo '<li>';
	      if(has_post_thumbnail()){
	         echo '<div class="thumbnail">
	          <a class="widgetthumb image_wrapper" href="'.get_the_permalink().'">
	          <img src="'.get_feature_image_url(get_the_ID()).'" class="attachment-post-thumbnail wp-post-image" alt="right-sidebar"></a>
	          </div>';
	      }
	      echo '<div class="info"><span class="widgettitle">'
	            . '<a href="'.get_the_permalink().'" title="'.get_the_title().'">'.get_the_title().'</a>'
	            . '</span>
	          <span class="post_meta">'.  get_the_date("M d, Y").'</span>
	          </div>
	          <div class="clearboth"></div>';
	      echo '</li>';

		endwhile; endif;
		wp_reset_query(); ?>
	<!--        <li>
	          <div class="thumbnail">
	          <a class="widgetthumb image_wrapper" href="#">
	          <img src="http://demo.bloompixel.com/goblog/wp-content/uploads/sites/13/2014/03/right-sidebar-150x150.jpg" class="attachment-post-thumbnail wp-post-image" alt="right-sidebar"></a>
	          </div>
	          <div class="info">
	          <span class="widgettitle">
	          <a href="#" title="Blog Post with Right Sidebar">Blog Post with Right Sidebar</a></span>
	          <span class="post_meta">March 16, 2014</span>
	          </div>
	          <div class="clearboth"></div>
	        </li>-->
	      </ul>
	   </div><!-- tab menu content div end here-->

	   	<div class="tab_menu_content" id="recent_posts">
	    <ul class="">
	        <?php query_posts('posts_per_page=5');
	         if (have_posts()) : while (have_posts()) : the_post();
	            echo '<li>';
	            if(has_post_thumbnail()){

	               echo '<div class="thumbnail">
	                <a class="widgetthumb image_wrapper" href="'.get_the_permalink().'">
	                <img src="'.get_feature_image_url(get_the_ID()).'" class="attachment-post-thumbnail wp-post-image" alt="right-sidebar"></a>
	                </div>';
	            }
	            echo '<div class="info"><span class="widgettitle">'
	                  . '<a href="'.get_the_permalink().'" title="'.get_the_title().'">'.get_the_title().'</a>'
	                  . '</span>
	                <span class="post_meta">'.  get_the_date("M d, Y").'</span>
	                </div>
	                <div class="clearboth"></div>';
	            echo '</li>';

		endwhile; endif;
		wp_reset_query(); ?>
	      </ul>
	   </div><!-- tab menu content div end here-->
	</div><!-- widget popular posts end here-->


	<!--<div class="widget sidebar_widget web_box facebook_fan_page">
	    <div class="fb-like-box" data-href="https://www.facebook.com/BleachvsOnePieceClanBvO" data-colorscheme="light" data-show-faces="true" data-header="true" data-stream="false" data-show-border="true" data-width="307"></div>
	</div> widget facebook_fan_page end here-->

</aside>
<!-- /sidebar -->
