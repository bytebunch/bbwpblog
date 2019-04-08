<?php
//global $wpdb;


/******************************************/
/***** Edit user profile **********/
/******************************************/
if(isset($_POST['email']) && isset($_POST['display_name']) && isset($_POST['fname'])  && is_user_logged_in() && $current_user->ID == $user_profile_data->ID)
{

	$email = BBWPSanitization::Email($_POST['email']);
	$fname = BBWPSanitization::Textfield($_POST['fname']);
	$display_name = BBWPSanitization::Textfield($_POST['display_name']);
	$lname = '';
	$gender = '';
	if(isset($_POST['lname']) && $_POST['lname'] != "")
		$lname = BBWPSanitization::Textfield($_POST['lname']);
	if(isset($_POST['gender']) && ($_POST['gender'] === "Male" || $_POST['gender'] === "Female"))
		$gender = BBWPSanitization::Username($_POST['gender']);

	global $current_user;

	if(!$email)
			$errorMessage = "Please type your correct email address.";
	if(isset($_POST['lname']) && $_POST['lname'] != "" && (strlen($lname) > 20 || strlen($lname) < 3)){
		$errorMessage = "Your last name must be between 3 characters and 20 characters."; }
	if (!ctype_alnum ($fname) || strlen($fname) < 3 || strlen($fname) > 20)
		$errorMessage = "Your first name must be between 3 characters and 20 characters. You can use only alphabet and numeric characters.";
	if (!ctype_alnum ($display_name) || strlen($display_name) < 3 || strlen($display_name) > 20)
		$errorMessage = "Your Display Name must be between 3 characters and 20 characters. You can use only alphabet and numeric characters.";
	if ($email != $current_user->data->user_email && email_exists($email))
			$errorMessage = "That email is already registered to a user.";

	if($errorMessage == false)
	{
		$userdata = array("ID" => $current_user->ID, "first_name" => $fname, "last_name" => $lname, "user_email" => $email, "display_name" => $display_name);
		wp_update_user( $userdata );
		update_user_meta($current_user->ID, 'gender', $gender);
		$errorMessage = "Your data has been updated successfully.";
		$updateMessage = true;
	}
}

/******************************************/
/***** Change password start **********/
/******************************************/
if(isset($_POST['oldpassword']) && isset($_POST['password']) && isset($_POST['cpassword']) && is_user_logged_in() && $current_user->ID == $user_profile_data->ID)
{

	$oldpassword = $_POST['oldpassword'];
	$password = $_POST['password'];
	$cpassword = $_POST['cpassword'];

	if ( wp_check_password( $oldpassword, $current_user->data->user_pass, $current_user->ID) ){

		if(strlen($password) >= 6 && $password == $cpassword)
		{
			wp_set_password( $password, $current_user->ID );
			$errorMessage = 'Your password has been successfully changed. Please login again to get access to your account. <a href="'.get_permalink($BBBThemeOptions->get_option("page_login_id")).'">Login</a>';
			$updateMessage = true;
		}else
			$errorMessage = "Your password must be between 6 characters and 100 characters. Type same password in both fields.";
	}
	else
		 $errorMessage = 'Please type your correct old password.';
}

/******************************************/
/***** Profile image forms start **********/
/******************************************/
if((isset($_FILES["profile_image"]) || isset($_POST['profile_image_by_url'])) && is_user_logged_in() && $current_user->ID == $user_profile_data->ID)
{

	if(!class_exists("BBWPImageUpload"))
		include_once(THEME_ABS."inc/classes/BBWPImageUpload.php");
	if(!class_exists("BBWPImageResize"))
		include_once(THEME_ABS."inc/classes/BBWPImageResize.php");

		if(isset($_FILES["profile_image"]) && isset($_FILES["profile_image"]['tmp_name']) && $_FILES["profile_image"]['tmp_name']){
			$BBWPImageUpload = new BBWPImageUpload($_FILES["profile_image"]); }
		elseif(isset($_POST['profile_image_by_url']) && $_POST['profile_image_by_url'])
			$BBWPImageUpload = new BBWPImageUpload($_POST['profile_image_by_url']);

		if(isset($BBWPImageUpload)){
			$BBWPImageUpload->SetSize(2);
			$BBWPImageUpload->Set('name', ABSPATH."wp-content/uploads/users/".$current_user->ID."_".time('now')."_".generate_random_int(5));
			$BBWPImageUpload->Set('maxWidth', 2048);
			$BBWPImageUpload->Set('maxHeight', 2048);
			$BBWPImageUpload->Set('resize', true);
			$BBWPImageUpload->Set('width', 450);
			$BBWPImageUpload->Set('height', 450);
			$upload = $BBWPImageUpload->upload();
			if($upload == false)
				$errorMessage = $BBWPImageUpload->error;
			else{
				delete_user_profile_image($current_user->ID);
				$image_uri = str_replace(ABSPATH, HOME_URL,$upload);
				update_user_meta($current_user->ID, 'profile_image_url', $image_uri);
				$updateMessage = true;
				$errorMessage = 'Your profile image has been updated.';
			}
		}
}

/******************************************/
/***** Dashboard user profile menu **********/
/******************************************/
function user_dashboard_profile_menu(){
	global $wp_query, $user_profile_data, $BBBThemeOptions, $current_user;
?>

<div class="username">
	<span class=""><?php echo $user_profile_data->data->display_name; ?></span>
	<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".users_dashboard_menu">
		<span class="sr-only">Toggle Navigation</span>
		<span class="icon-bar"></span>
		<span class="icon-bar"></span>
		<span class="icon-bar"></span>
	</button>
	<div class="clearboth"></div>
</div>

<img src="<?php echo get_user_profile_image_url($user_profile_data->ID); ?>" alt="" class="profile_image hidden-xs" style="max-width:100%; display:block; margin:0 auto;" />
<div class="navbar-collapse collapse users_dashboard_menu" style="padding:0px;">
	<ul class="nav navbar-nav">
    <li><a href="<?php echo USERS_URI.$user_profile_data->ID; ?>/">Profile</a></li>
    <?php if(is_user_logged_in() && $current_user->ID == $user_profile_data->ID){ ?>
    <li class="<?php if(isset($wp_query->query_vars["edit"])){ echo 'current-menu-item'; } ?>"><a href="<?php echo USERS_URI.$user_profile_data->ID; ?>/edit/">Edit Profile</a></li>
    <li class="<?php if(isset($wp_query->query_vars["avatar"])){ echo 'current-menu-item'; } ?>"><a href="<?php echo USERS_URI.$user_profile_data->ID; ?>/avatar/">Edit Profile Image</a></li>
		<li class="<?php if(isset($wp_query->query_vars["settings"])){ echo 'current-menu-item'; } ?>"><a href="<?php echo USERS_URI.$user_profile_data->ID; ?>/settings/">Change Password</a></li>
    <?php } ?>
	</ul>
</div>
<?php
}
