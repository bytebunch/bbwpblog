<footer id="footer" class="footer">
  <div class="container">
    <div class="row footer_widgets">
      <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3 widget_container">
        	<div class="widget">
            <h3>Popular Posts by comments</h3>
          <!-- START WIDGET -->
          <div class="category-posts-widget category_posts">
            <ul class="category-posts">
               <?php
               global $wpdb;
      $posts = $wpdb->get_results("SELECT * FROM $wpdb->posts WHERE post_type='post' AND post_status = 'publish' ORDER BY comment_count DESC LIMIT 3");

      foreach ($posts as $post) {
          setup_postdata($post);
          $id = $post->ID;
          $title = $post->post_title;
          $count = $post->comment_count;

          if ($count != 0) {
            echo '<li>';
            if(has_post_thumbnail($id)){
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
          }
      }
               ?>
            </ul>
          </div>
          </div><!-- widget div end here-->
      </div><!-- col div end here-->

      <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3 widget_container">
    	  <div class="widget">
          <h3>TAGS</h3>
          <div class="tagcloud">
            <?php
            $args = array(
                'number' =>10,
                'smallest' => 13,
                'largest' => 20,
                'unit' => 'px',
                'orderby' => 'name',
              'taxonomy' => array( 'post_tag'/*, 'category'*/ )
              );
            wp_tag_cloud($args); ?>
          </div>
        </div><!-- widget div end here-->
      </div><!-- col div end here -->
      <div class="clearboth hidden-md hidden-lg"></div>
      <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3 widget_container">
        	 <div class="widget">
            <h3>SUBSCRIBE</h3>
            <form action="#" method="post" class="subscribe_form">
              	<p>Sign up to be the first to know our newest products, updates and events.</p>
                 <input type="email" value="" placeholder="Email Address" name="email" required="required">
  				<input type="submit" value="Subscribe">
              <div style="margin-top:20px;">
                 <span class="ajax_loader display_none">
                    Processing... <img src="<?php echo THEME_URI; ?>images/loadingAnimation.gif" alt="Ajax Loader" style="width: 100%;margin-top:5px;" />
                 </span>
                 <p><span class="ajax_message display_none"></span></p>
              </div>
  			</form>
           </div><!-- widget div end here-->
      </div><!-- col div end here-->

      <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3 widget_container">
        	 <div class="widget">
            <h3>About us</h3>
        	 	<p>ByteBunch Blog is all about design, development, ideas, web trends, and tutorials. It is designed and maintained by ByteBunch staff. ByteBunch was founded in 18,August 2015 by Ghulam Server(GS) and Tahir.</p>
           </div><!-- widget div end here-->
      </div><!-- col div end here -->
    </div><!-- row div end here -->

  </div><!-- container div end here-->
  <div class="copyright_text">
    <div class="container">
      <?php wp_nav_menu( array("menu" => 'Footer Menu',"menu_class" => 'footer_menu', 'theme_location' => 'footer-menu') ); ?>
    <?php /* <ul class="footer_menu">
    	<li><a href="<?php echo HOME_URL; ?>">Home</a></li>
   	  <li><a href="#">Log in</a></li>
    	<li><a href="<?php HOME_URL; ?>/contact-us">Contact Us</a></li>
      <li><a href="<?php HOME_URL; ?>/privacy-policy">Privacy Policy</a></li>
      <li><a href="<?php HOME_URL; ?>/terms-of-use">Terms of Use</a></li>
<!--      <li><a href="#">Site Map</a></li>-->
    </ul> */?>
       <p>	&copy; Copyright <?php echo date('Y'); ?>. Theme by ByteBunch.</p> </div>
  </div>
  <!-- copyright_text div end here-->
</footer>
<!-- footer div end here-->
<?php wp_footer(); ?>

<?php /* ?>
<!-- facebook javascript sdk -->
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&appId=515492418532217&version=v2.0";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>

<!-- linkedin javascript sdk -->
<script src="//platform.linkedin.com/in.js" type="text/javascript">
  lang: en_US
</script>

<!-- twitter javascript sdk -->
<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>


<!-- google plus javascript sdk -->
<script type="text/javascript">
  (function() {
    var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
    po.src = 'https://apis.google.com/js/platform.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
  })();
</script>
<?php */ ?>
<?php googleAnalytics('UA-85656942-1'); ?>
</body>
</html>
