<?php
if(is_admin()){

add_action('admin_enqueue_scripts', 'adminpanel_scripts_styles'); // Add Theme Stylesheet
// Load HTML5 Blank styles
function adminpanel_scripts_styles()
{
  // admin css syles

  // admin javascript
  //wp_register_script('adminscript', get_template_directory_uri() . '/js/admin.js', array('jquery'), '1.0.0'); // Custom scripts
  //wp_enqueue_script('adminscript'); // Enqueue it!
}


/******************************************/
/***** installation of bbblog theme **********/
/******************************************/
add_action("after_switch_theme", "install_bbblog_theme");
function install_bbblog_theme(){
	include_once(THEME_ABS.'inc/theme_installation.php');
}


}
