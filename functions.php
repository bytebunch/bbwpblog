<?php
/*
 *  Author: Todd Motto | @toddmotto
 *  URL: html5blank.com | @html5blank
 *  Custom functions, support, custom post types and more.
 */
global $BBBThemeOptions, $wpdb;
define("HOME_URL",trailingslashit(home_url()));
define("THEME_URI",trailingslashit(get_template_directory_uri()));
define("THEME_ABS",trailingslashit(get_template_directory()));

$wpdb->bbb_email_list = $wpdb->prefix . 'bbb_email_list';
/*------------------------------------*\
	External Modules/Files
\*------------------------------------*/
if(!class_exists("BBWPSanitization"))
  include_once("inc/classes/BBWPSanitization.php");

require_once('inc/generic_functions.php');
require_once('inc/classes/BBBThemeOptions.php');
$BBBThemeOptions = new BBBThemeOptions();
define("USERS_URI", get_permalink(trailingslashit($BBBThemeOptions->get_option('page_users_id'))));
require_once('inc/ajax_functions.php');
require_once('inc/admin_functions.php');
//require_once('plugins/bb_author_url.php');
// Load any external files you have here

function bbwp_wp_login($user_login, $user) {
  global $wpdb;
   if(isset($user) && isset($user->caps) && is_array($user->caps) && count($user->caps) >= 1){
   }else{
     wp_update_user( array( 'ID' => $user->ID, 'role' => get_option('default_role') ) );
   }

}
add_action('wp_login', 'bbwp_wp_login', 10, 2);

/******************************************/
/***** Only administrator can get access to wpadmin **********/
/******************************************/
add_action( 'init', 'bb_blockusers_init' );
function bb_blockusers_init() {
	if ( is_admin() && is_user_logged_in() && !current_user_can( 'edit_posts' ) && !( defined( 'DOING_AJAX') && DOING_AJAX ) ) {
		wp_redirect( home_url() );
		exit;
	}
}

/******************************************/
/***** check if user's email is verified. **********/
/******************************************/
add_filter('wp_authenticate_user', 'bb_email_verify_auth_login',10,2);
function bb_email_verify_auth_login ($user, $password) {
	global $BBBThemeOptions;
	if ( !is_wp_error($user) &&  $BBBThemeOptions->get_option('verify_email') == 'yes' && $user->roles[0] != 'administrator'){
    $verify_email = get_user_meta($user->ID,'bb_verify_email',true);
		if($verify_email && $verify_email != "verified")
      return new WP_Error( 'verify_email', 'Please verify your email first.', $user );
	}
  return $user;
}


/******************************************/
/***** rewrite rules for forums start from here **********/
/******************************************/
add_action( 'init', 'bbb_rewrite_init' );
function bbb_rewrite_init() {
  global $BBBThemeOptions;
  $users_slug = get_single_post_data($BBBThemeOptions->get_option('page_users_id'),"post_name");
  add_rewrite_rule( $users_slug.'/([^/]+)/?$', 'index.php?pagename='.$users_slug.'&bbf_user=$matches[1]', 'top' );
  add_rewrite_rule( $users_slug.'/([^/]+)/edit/?$', 'index.php?pagename='.$users_slug.'&bbf_user=$matches[1]&edit=1', 'top' );
  add_rewrite_rule( $users_slug.'/([^/]+)/avatar/?$', 'index.php?pagename='.$users_slug.'&bbf_user=$matches[1]&avatar=1', 'top' );
  add_rewrite_rule( $users_slug.'/([^/]+)/settings/?$', 'index.php?pagename='.$users_slug.'&bbf_user=$matches[1]&settings=1', 'top' );
}


add_filter( 'query_vars', 'bbb_query_vars' );
function bbb_query_vars( $vars) {
  $vars[] = 'bbf_user';
  $vars[] = 'edit';
  $vars[] = 'avatar';
  $vars[] = 'settings';
  return $vars;
}
/*------------------------------------*\
	Theme Support
\*------------------------------------*/

if (!isset($content_width))
    $content_width = 900;

if (function_exists('add_theme_support'))
{
  add_filter( 'show_admin_bar', '__return_false' );
  add_theme_support( 'title-tag' );
  add_theme_support('menus');
  // Enables post and comment RSS feed links to head
  add_theme_support('automatic-feed-links');
  // Add Thumbnail Theme Support
  add_theme_support('post-thumbnails');
  //add_image_size('large', 700, '', true); // Large Thumbnail
  //add_image_size('medium', 250, '', true); // Medium Thumbnail
  //add_image_size('small', 120, '', true); // Small Thumbnail
  //add_image_size('custom-size', 700, 200, true); // Custom Thumbnail Size call using the_post_thumbnail('custom-size');

  // Localisation Support
  load_theme_textdomain('bbblank', get_template_directory() . '/languages');
}

/*------------------------------------*\
	Functions
\*------------------------------------*/

// HTML5 Blank navigation
/*function html5blank_nav()
{
	wp_nav_menu(
	array(
		'theme_location'  => 'header-menu',
		'menu'            => '',
		'container'       => 'div',
		'container_class' => 'menu-{menu slug}-container',
		'container_id'    => '',
		'menu_class'      => 'menu',
		'menu_id'         => '',
		'echo'            => true,
		'fallback_cb'     => 'wp_page_menu',
		'before'          => '',
		'after'           => '',
		'link_before'     => '',
		'link_after'      => '',
		'items_wrap'      => '<ul>%3$s</ul>',
		'depth'           => 0,
		'walker'          => ''
		)
	);
}*/

add_action('wp_enqueue_scripts', 'html5blank_scripts_styles'); // Add Custom Scripts to wp_head
// Load HTML5 Blank scripts (header.php)
function html5blank_scripts_styles()
{
  // css syles
  wp_register_style('normalize', get_template_directory_uri() . '/normalize.min.css', array(), '3.0.3', 'all');
  wp_enqueue_style('normalize'); // Enqueue it!

  wp_register_style('bootstrap3.3.6.css', get_template_directory_uri() . '/bootstrap.min.css', array(), '3.3.6');
  wp_enqueue_style('bootstrap3.3.6.css'); // Enqueue it!

  wp_register_style('style.css', get_template_directory_uri() . '/style.css', array(), '1.0', 'all');
  wp_enqueue_style('style.css'); // Enqueue it!


  // javascript
  //wp_register_script('conditionizr', get_template_directory_uri() . '/js/lib/conditionizr-4.3.0.min.js', array(), '4.3.0'); // Conditionizr
  //wp_enqueue_script('conditionizr'); // Enqueue it!

  //wp_register_script('modernizr', get_template_directory_uri() . '/js/lib/modernizr-2.7.1.min.js', array(), '2.7.1'); // Modernizr
  //wp_enqueue_script('modernizr'); // Enqueue it!

  if(is_page('contact-us'))
	{
		wp_enqueue_script( 'maps', 'https://maps.googleapis.com/maps/api/js?key=AIzaSyA7dDYCCnttPOesPyXKVYLH3k_VywjhJgA', array('jquery'));
	}


  wp_register_script('bootstrap3.3.6.js', get_template_directory_uri() . '/js/lib/bootstrap.min.js', array('jquery'), '3.3.6'); // Custom scripts
  wp_enqueue_script('bootstrap3.3.6.js'); // Enqueue it!

  wp_register_script('bbblogscripts', get_template_directory_uri() . '/js/scripts.js', array('jquery'), '1.0.0'); // Custom scripts
  wp_enqueue_script('bbblogscripts'); // Enqueue it!

  $js_variables = array('ajax_url' => admin_url('admin-ajax.php'), 'theme_uri' => THEME_URI);
  wp_localize_script( 'bbblogscripts', 'bbblog', $js_variables );
}

function ErrorUpdateMessage($errorMessage = false, $updateMessage = false){
  if(isset($errorMessage) && $errorMessage != false){ ?>
    <div class="<?php if(isset($updateMessage) && $updateMessage != false){ echo 'update_message'; }else{ echo 'error_message'; } ?>"><?php echo $errorMessage; ?></div>
  <?php }

}



/******************************************/
/***** Custom Comments template start from here **********/
/******************************************/
add_filter( 'get_avatar', 'avatar_override_by_bb', 10, 5 );
function avatar_override_by_bb( $avatar, $id_or_email, $size, $default, $alt ) {
	$custom_avatar = "<img alt='' src='".get_template_directory_uri()."/images/profile_placeholder.png' class='avatar avatar-$size photo' height='$size' width='$size' />";
		//Get user data
		if ( is_numeric( $id_or_email ) ) {
			$user = get_user_by( 'id', ( int )$id_or_email );
		} elseif( is_object( $id_or_email ) )  {
			$comment = $id_or_email;
			if ( empty( $comment->user_id ) ) {
				$user = get_user_by( 'id', $comment->user_id );
			} else {
				$user = get_user_by( 'email', $comment->comment_author_email );
			}
			if ( !$user ) return $custom_avatar;
		} elseif( is_string( $id_or_email ) ) {
			$user = get_user_by( 'email', $id_or_email );
		} else {
			return $custom_avatar;
		}
		if ( !$user ) return $custom_avatar;
		$user_id = $user->ID;


		$porfile_image_meta_key = "profile_image_url";
		if(get_user_meta($user_id, $porfile_image_meta_key, true) && get_user_meta($user_id, $porfile_image_meta_key, true) != "")
		{
			$custom_avatar = "<img alt='".get_user_meta($user_id, "display_name", true)."' src='".get_user_meta($user_id, $porfile_image_meta_key, true)."' class='avatar avatar-$size photo' height='$size' width='$size' />";
		}

		if ( !isset($custom_avatar) ) return $avatar;

		return $custom_avatar;
} //end avatar_override



add_action('init', 'register_html5_menu'); // Add HTML5 Blank Menu
// Register HTML5 Blank Navigation
function register_html5_menu()
{
    register_nav_menus(array( // Using array to specify more menus if needed
        'header-menu' => __('Header Menu', 'bbblank'), // Main Navigation
        'footer-menu' => __('Footer Menu', 'bbblank'),
        //'sidebar-menu' => __('Sidebar Menu', 'bbblank'), // Sidebar Navigation
        //'extra-menu' => __('Extra Menu', 'bbblank') // Extra Navigation if needed (duplicate as many as you need!)
    ));
}

//add_filter('wp_nav_menu_args', 'my_wp_nav_menu_args'); // Remove surrounding <div> from WP Navigation
// Remove the <div> surrounding the dynamic navigation to cleanup markup
/*function my_wp_nav_menu_args($args = '')
{
    $args['container'] = false;
    return $args;
}*/

// add_filter('nav_menu_css_class', 'my_css_attributes_filter', 100, 1); // Remove Navigation <li> injected classes (Commented out by default)
// add_filter('nav_menu_item_id', 'my_css_attributes_filter', 100, 1); // Remove Navigation <li> injected ID (Commented out by default)
// add_filter('page_css_class', 'my_css_attributes_filter', 100, 1); // Remove Navigation <li> Page ID's (Commented out by default)
// Remove Injected classes, ID's and Page ID's from Navigation <li> items
/*function my_css_attributes_filter($var)
{
    return is_array($var) ? array() : '';
}*/

/*add_filter('the_category', 'remove_category_rel_from_category_list'); // Remove invalid rel attribute
// Remove invalid rel attribute values in the categorylist
function remove_category_rel_from_category_list($thelist){
    return str_replace('rel="category tag"', 'rel="tag"', $thelist);
}*/

//add_filter('body_class', 'add_slug_to_body_class'); // Add slug to body class (Starkers build)
// Add page slug to body class, love this - Credit: Starkers Wordpress Theme
/*function add_slug_to_body_class($classes)
{
    global $post;
    if (is_home()) {
        $key = array_search('blog', $classes);
        if ($key > -1) {
            unset($classes[$key]);
        }
    } elseif (is_page()) {
        $classes[] = sanitize_html_class($post->post_name);
    } elseif (is_singular()) {
        $classes[] = sanitize_html_class($post->post_name);
    }

    return $classes;
}*/

// If Dynamic Sidebar Exists
if (function_exists('register_sidebar'))
{
    // Define Sidebar Widget Area 1
    register_sidebar(array(
        'name' => __('Sidebar', 'bbblank'),
        //'description' => __('Description for this widget-area...', 'bbblank'),
        'id' => 'sidebar',
        'before_widget' => '<div id="%1$s" class="%2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h3>',
        'after_title' => '</h3>'
    ));

    // Define Sidebar Widget Area 2
    register_sidebar(array(
        'name' => __('Widget Area 2', 'bbblank'),
        'description' => __('Description for this widget-area...', 'bbblank'),
        'id' => 'widget-area-2',
        'before_widget' => '<div id="%1$s" class="%2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h3>',
        'after_title' => '</h3>'
    ));
}

//add_action('widgets_init', 'my_remove_recent_comments_style'); // Remove inline Recent Comment Styles from wp_head()
// Remove wp_head() injected Recent Comment styles
/*function my_remove_recent_comments_style()
{
    global $wp_widget_factory;
    remove_action('wp_head', array(
        $wp_widget_factory->widgets['WP_Widget_Recent_Comments'],
        'recent_comments_style'
    ));
}*/

add_action('init', 'html5wp_pagination'); // Add our HTML5 Pagination
// Pagination for paged posts, Page 1, Page 2, Page 3, with Next and Previous Links, No plugin
function html5wp_pagination()
{
    global $wp_query;
    $big = 999999999;
    echo paginate_links(array(
        'base' => str_replace($big, '%#%', get_pagenum_link($big)),
        'format' => '?paged=%#%',
        'current' => max(1, get_query_var('paged')),
        'total' => $wp_query->max_num_pages
    ));
}

// Custom Excerpts
function html5wp_index($length) // Create 20 Word Callback for Index page Excerpts, call using html5wp_excerpt('html5wp_index');
{
    return 20;
}

// Create 40 Word Callback for Custom Post Excerpts, call using html5wp_excerpt('html5wp_custom_post');
function html5wp_custom_post($length)
{
    return 40;
}

// Create the Custom Excerpts callback
function html5wp_excerpt($length_callback = '', $more_callback = '')
{
    global $post;
    if (function_exists($length_callback)) {
        add_filter('excerpt_length', $length_callback);
    }
    if (function_exists($more_callback)) {
        add_filter('excerpt_more', $more_callback);
    }
    $output = get_the_excerpt();
    $output = apply_filters('wptexturize', $output);
    $output = apply_filters('convert_chars', $output);
    $output = '<p>' . $output . '</p>';
    echo $output;
}

add_filter('excerpt_more', 'html5_blank_view_article'); // Add 'View Article' button instead of [...] for Excerpts
// Custom View Article link to Post
function html5_blank_view_article($more)
{
    global $post;
    //return '... <a class="view-article" href="' . get_permalink($post->ID) . '">' . __('View Article', 'bbblank') . '</a>';
    return ' ...';
}


add_filter('style_loader_tag', 'html5_style_remove'); // Remove 'text/css' from enqueued stylesheet
// Remove 'text/css' from our enqueued stylesheet
function html5_style_remove($tag)
{
    return preg_replace('~\s+type=["\'][^"\']++["\']~', '', $tag);
}

//add_filter('post_thumbnail_html', 'remove_thumbnail_dimensions', 10); // Remove width and height dynamic attributes to thumbnails
//add_filter('image_send_to_editor', 'remove_thumbnail_dimensions', 10); // Remove width and height dynamic attributes to post images
// Remove thumbnail width and height dimensions that prevent fluid images in the_thumbnail
/*function remove_thumbnail_dimensions( $html )
{
    $html = preg_replace('/(width|height)=\"\d*\"\s/', "", $html);
    return $html;
}*/

//add_filter('avatar_defaults', 'html5blankgravatar'); // Custom Gravatar in Settings > Discussion
// Custom Gravatar in Settings > Discussion
/*function html5blankgravatar ($avatar_defaults)
{
    $myavatar = get_template_directory_uri() . '/img/gravatar.jpg';
    $avatar_defaults[$myavatar] = "Custom Gravatar";
    return $avatar_defaults;
}*/

add_action('get_header', 'enable_threaded_comments'); // Enable Threaded Comments
// Threaded Comments
function enable_threaded_comments()
{
    if (!is_admin()) {
        if (is_singular() AND comments_open() AND (get_option('thread_comments') == 1)) {
            wp_enqueue_script('comment-reply');
        }
    }
}

/*------------------------------------*\
	Actions + Filters + ShortCodes
\*------------------------------------*/

// Remove Actions
remove_action('wp_head', 'feed_links_extra', 3); // Display the links to the extra feeds such as category feeds
remove_action('wp_head', 'feed_links', 2); // Display the links to the general feeds: Post and Comment Feed
remove_action('wp_head', 'rsd_link'); // Display the link to the Really Simple Discovery service endpoint, EditURI link
remove_action('wp_head', 'wlwmanifest_link'); // Display the link to the Windows Live Writer manifest file.
remove_action('wp_head', 'index_rel_link'); // Index link
remove_action('wp_head', 'parent_post_rel_link', 10, 0); // Prev link
remove_action('wp_head', 'start_post_rel_link', 10, 0); // Start link
remove_action('wp_head', 'adjacent_posts_rel_link', 10, 0); // Display relational links for the posts adjacent to the current post.
remove_action('wp_head', 'wp_generator'); // Display the XHTML generator that is generated on the wp_head hook, WP version
remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);
//remove_action('wp_head', 'rel_canonical');
remove_action('wp_head', 'wp_shortlink_wp_head', 10, 0);


/* disable rest api wordpress 4.4+*/
// Filters for WP-API version 1.x
add_filter('json_enabled', '__return_false');
add_filter('json_jsonp_enabled', '__return_false');
// Filters for WP-API version 2.x
add_filter('rest_enabled', '__return_false');
add_filter('rest_jsonp_enabled', '__return_false');
remove_action( 'wp_head', 'rest_output_link_wp_head', 10 );



// Remove the REST API endpoint.
remove_action('rest_api_init', 'wp_oembed_register_route');
// Turn off oEmbed auto discovery.
// Don't filter oEmbed results.
remove_filter('oembed_dataparse', 'wp_filter_oembed_result', 10);
// Remove oEmbed discovery links.
remove_action('wp_head', 'wp_oembed_add_discovery_links');
// Remove oEmbed-specific JavaScript from the front-end and back-end.
remove_action('wp_head', 'wp_oembed_add_host_js');

remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
remove_action( 'wp_print_styles', 'print_emoji_styles' );

// Remove Filters
remove_filter('the_excerpt', 'wpautop'); // Remove <p> tags from Excerpt altogether





/******************************************/
/***** Custom Comments template start from here **********/
/******************************************/
function mytheme_comment($comment, $args, $depth) {
	$GLOBALS['comment'] = $comment;
	extract($args, EXTR_SKIP);
	if ( 'div' == $args['style'] ) {
		$tag = 'div';
		$add_below = 'comment';
	} else {
		$tag = 'li';
		$add_below = 'div-comment';
	}
?>
	 <<?php echo $tag ?> <?php comment_class(empty( $args['has_children'] ) ? '' : 'parent') ?> id="comment-<?php comment_ID() ?>">
	<?php if ( 'div' != $args['style'] ) : ?>
	<div id="div-comment-<?php comment_ID() ?>" class="comment-body yeah">
	<?php endif; ?>

    <div class="thumbnail">
		<?php if ($args['avatar_size'] != 0) echo get_avatar( $comment, 50 ); ?>
    </div>
	<div class="info">
    	<span>
		<?php printf(__('<cite class="fn">%s</cite>', 'bbblank'), get_comment_author_link()) ?>
        </span>
        <?php if ($comment->comment_approved == '0') : ?>
            <em class="comment-awaiting-moderation"><?php _e('Your comment is awaiting moderation.', 'bbblank') ?></em><br />
        <?php endif; ?>
        <?php
			/* translators: 1: date, 2: time */
			printf( __('%1$s at %2$s', 'bbblank'), get_comment_date(),  get_comment_time()) ?><?php edit_comment_link(__('(Edit)', 'bbblank'),'  ','' );
		?>
    </div>
   <div class="clearboth"></div>
	<div class="comment_text"><?php comment_text() ?></div>
	<!--<div class="reply">-->
	<?php comment_reply_link(array_merge( $args, array('add_below' => $add_below, 'depth' => $depth, 'max_depth' => $args['max_depth']))) ?>
	<!--</div>-->
	<?php if ( 'div' != $args['style'] ) : ?>
	</div>
	<?php endif; ?>
<?php
}
