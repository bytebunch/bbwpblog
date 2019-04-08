<?php
global $current_user, $BBBThemeOptions;
$bbblog_version = $BBBThemeOptions->get_option('theme_version');
$installed_ver = get_option('bbblog_version');

if ( $installed_ver != $bbblog_version ) {
  update_option( 'bbblog_version', $bbblog_version );
  // installation of tables start from here
  function install_db_tables () {
    global $wpdb;
    $charset_collate = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE ".$wpdb->bbb_email_list." (
      ID bigint(20) NOT NULL AUTO_INCREMENT,
      email varchar(250) NOT NULL,
      verified tinyint(1) NOT NULL,
      status tinyint(1) NOT NULL,
      verification_key varchar(50) NOT NULL,
      PRIMARY KEY  (ID)
    ) $charset_collate;";

    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
    dbDelta( $sql );
  }
  install_db_tables();
}

// check if uploads folder exist
if(!is_dir(ABSPATH."wp-content/uploads"))
 mkdir(ABSPATH."wp-content/uploads");
if(!is_dir(ABSPATH."wp-content/uploads/users"))
 mkdir(ABSPATH."wp-content/uploads/users");



// create all the necessory pages
$my_post = array(
 'post_title' => 'New Page',
 'post_content' => "",
 'post_status' => 'publish',
 'post_author' => $current_user->ID,
 'post_type' => 'page',
 'comment_status' => 'closed'
);



// contact us page
$get_page = $BBBThemeOptions->get_option('page_contact_us_id');
if(!($get_page && is_numeric($get_page) && $get_page >= 1 && get_permalink($get_page))){
  $get_page = NULL;
  if($get_page = get_page_by_path("contact-us"))
    $BBBThemeOptions->set_option('page_contact_us_id', $get_page->ID);
  elseif($get_page = get_page_by_title("Contact us"))
    $BBBThemeOptions->set_option('page_contact_us_id', $get_page->ID);
  else{
    $my_post['post_title'] = 'Contact us';
    $my_post['post_content'] = '';
    $my_post['page_template'] = 'page-contact-us.php';
    $postid = wp_insert_post( $my_post );
    $BBBThemeOptions->set_option('page_contact_us_id', $postid);
  }
}

// Privacy Policy
$get_page = $BBBThemeOptions->get_option('page_privacy_policy_id');
if(!($get_page && is_numeric($get_page) && $get_page >= 1 && get_permalink($get_page))){
  $get_page = NULL;
  if($get_page = get_page_by_path("privacy-policy"))
    $BBBThemeOptions->set_option('page_privacy_policy_id', $get_page->ID);
  elseif($get_page = get_page_by_title("Privacy policy"))
    $BBBThemeOptions->set_option('page_privacy_policy_id', $get_page->ID);
  else{
    $my_post['post_title'] = 'Privacy policy';
    $my_post['post_content'] = '<h3>Coming Soon</h3>';
    $my_post['page_template'] = '';
    $postid = wp_insert_post( $my_post );
    $BBBThemeOptions->set_option('page_privacy_policy_id', $postid);
  }
}

// Terms of use page
$get_page = $BBBThemeOptions->get_option('page_terms_of_use_id');
if(!($get_page && is_numeric($get_page) && $get_page >= 1 && get_permalink($get_page))){
  $get_page = NULL;
  if($get_page = get_page_by_path("terms-of-use"))
    $BBBThemeOptions->set_option('page_terms_of_use_id', $get_page->ID);
  elseif($get_page = get_page_by_title("Terms of use"))
    $BBBThemeOptions->set_option('page_terms_of_use_id', $get_page->ID);
  else{
    $my_post['post_title'] = 'Terms of use';
    $my_post['post_content'] = '<h3>Coming Soon</h3>';
    $my_post['page_template'] = '';
    $postid = wp_insert_post( $my_post );
    $BBBThemeOptions->set_option('page_terms_of_use_id', $postid);
  }
}

// Verify page
$get_page = $BBBThemeOptions->get_option('page_verify_id');
if(!($get_page && is_numeric($get_page) && $get_page >= 1 && get_permalink($get_page))){
  $get_page = NULL;
  if($get_page = get_page_by_path("verify"))
    $BBBThemeOptions->set_option('page_verify_id', $get_page->ID);
  elseif($get_page = get_page_by_title("Verify"))
    $BBBThemeOptions->set_option('page_verify_id', $get_page->ID);
  else{
    $my_post['post_title'] = 'Verify';
    $my_post['post_content'] = '';
    $my_post['page_template'] = 'page-verify.php';
    $postid = wp_insert_post( $my_post );
    $BBBThemeOptions->set_option('page_verify_id', $postid);
  }
}

// Verify page
$get_page = $BBBThemeOptions->get_option('page_login_id');
if(!($get_page && is_numeric($get_page) && $get_page >= 1 && get_permalink($get_page))){
  $get_page = NULL;
  if($get_page = get_page_by_path("login"))
    $BBBThemeOptions->set_option('page_login_id', $get_page->ID);
  elseif($get_page = get_page_by_title("Login"))
    $BBBThemeOptions->set_option('page_login_id', $get_page->ID);
  elseif($get_page = get_page_by_title("Sign in"))
    $BBBThemeOptions->set_option('page_login_id', $get_page->ID);
  elseif($get_page = get_page_by_title("Signin"))
    $BBBThemeOptions->set_option('page_login_id', $get_page->ID);
  else{
    $my_post['post_title'] = 'Login';
    $my_post['post_content'] = '';
    $my_post['page_template'] = 'page-login.php';
    $postid = wp_insert_post( $my_post );
    $BBBThemeOptions->set_option('page_login_id', $postid);
  }
}

// Forgot password page
$get_page = $BBBThemeOptions->get_option('page_forgot_password_id');
if(!($get_page && is_numeric($get_page) && $get_page >= 1 && get_permalink($get_page))){
  $get_page = NULL;
  if($get_page = get_page_by_path("forgot-password"))
    $BBBThemeOptions->set_option('page_forgot_password_id', $get_page->ID);
  elseif($get_page = get_page_by_title("Forgot password"))
    $BBBThemeOptions->set_option('page_forgot_password_id', $get_page->ID);
  elseif($get_page = get_page_by_title("Forgot your password"))
    $BBBThemeOptions->set_option('page_forgot_password_id', $get_page->ID);
  else{
    $my_post['post_title'] = 'Forgot password';
    $my_post['post_content'] = '';
    $my_post['page_template'] = 'page-forgot-password.php';
    $postid = wp_insert_post( $my_post );
    $BBBThemeOptions->set_option('page_forgot_password_id', $postid);
  }
}

// create account page
$get_page = $BBBThemeOptions->get_option('page_register_id');
if(!($get_page && is_numeric($get_page) && $get_page >= 1 && get_permalink($get_page))){
  $get_page = NULL;
  if($get_page = get_page_by_path("register"))
    $BBBThemeOptions->set_option('page_register_id', $get_page->ID);
  elseif($get_page = get_page_by_title("Register"))
    $BBBThemeOptions->set_option('page_register_id', $get_page->ID);
  elseif($get_page = get_page_by_title("Create account"))
    $BBBThemeOptions->set_option('page_register_id', $get_page->ID);
  elseif($get_page = get_page_by_title("Sign up"))
    $BBBThemeOptions->set_option('page_register_id', $get_page->ID);
  elseif($get_page = get_page_by_path("signup"))
    $BBBThemeOptions->set_option('page_register_id', $get_page->ID);
  else{
    $my_post['post_title'] = 'Register';
    $my_post['post_content'] = '';
    $my_post['page_template'] = 'page-register.php';
    $postid = wp_insert_post( $my_post );
    $BBBThemeOptions->set_option('page_register_id', $postid);
  }
}

// page users
$get_page = $BBBThemeOptions->get_option('page_users_id');
if(!($get_page && is_numeric($get_page) && $get_page >= 1 && get_permalink($get_page))){
  $get_page = NULL;
  if($get_page = get_page_by_path("users"))
    $BBBThemeOptions->set_option('page_users_id', $get_page->ID);
  elseif($get_page = get_page_by_title("Users"))
    $BBBThemeOptions->set_option('page_users_id', $get_page->ID);
  elseif($get_page = get_page_by_path("user-dashboard"))
    $BBBThemeOptions->set_option('page_users_id', $get_page->ID);
  else{
    $my_post['post_title'] = 'Users';
    $my_post['post_content'] = '';
    $my_post['page_template'] = 'page-users.php';
    $postid = wp_insert_post( $my_post );
    $BBBThemeOptions->set_option('page_users_id', $postid);
  }
}





/*
// create Register page
$get_page = $BBBThemeOptions->get_option('page_register_id');
if(!($get_page && is_numeric($get_page) && $get_page >= 1 && get_permalink($get_page))){
  $my_post['post_title'] = 'Register';
  $my_post['page_template'] = 'page-register.php';
  $postid = wp_insert_post( $my_post );
  $BBBThemeOptions->set_option('page_register_id', $postid);
}
// create login page
$get_page = $BBBThemeOptions->get_option('page_login_id');
if(!($get_page && is_numeric($get_page) && $get_page >= 1 && get_permalink($get_page))){
  $my_post['post_title'] = 'Login';
  $my_post['page_template'] = 'page-login.php';
  $postid = wp_insert_post( $my_post );
  $BBBThemeOptions->set_option('page_login_id', $postid);
}
// create Forgot Password page
$get_page = $BBBThemeOptions->get_option('page_forgot_password_id');
if(!($get_page && is_numeric($get_page) && $get_page >= 1 && get_permalink($get_page))){
  $my_post['post_title'] = 'Forgot Password';
  $my_post['page_template'] = 'page-forgot-password.php';
  $postid = wp_insert_post( $my_post );
  $BBBThemeOptions->set_option('page_forgot_password_id', $postid);
}
// create users page
$get_page = $BBBThemeOptions->get_option('page_users_id');
if(!($get_page && is_numeric($get_page) && $get_page >= 1 && get_permalink($get_page))){
  $my_post['post_title'] = 'Users';
  $my_post['page_template'] = '';
  $postid = wp_insert_post( $my_post );
  $BBBThemeOptions->set_option('page_users_id', $postid);
}
// create verify page
$get_page = $BBBThemeOptions->get_option('page_verify_id');
if(!($get_page && is_numeric($get_page) && $get_page >= 1 && get_permalink($get_page))){
  $my_post['post_title'] = 'Verify';
  $my_post['page_template'] = 'page-verify.php';
  $postid = wp_insert_post( $my_post );
  $BBBThemeOptions->set_option('page_verify_id', $postid);
}

*/
