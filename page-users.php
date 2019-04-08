<?php
session_start();
/**
*Template Name: Users Dashboard
*/
redirect_not_logged_in_users();
$errorMessage = false;
$updateMessage = false;
global $BBBThemeOptions, $wp_query, $user_profile_data, $current_user;
if(isset($wp_query->query_vars["bbf_user"]) && is_numeric($wp_query->query_vars["bbf_user"]) &&  $wp_query->query_vars["bbf_user"] >= 1){
	$url_user_id = BBWPSanitization::Int($wp_query->query_vars["bbf_user"]);
	if($url_user_id){
		if($url_user_id === $current_user->ID)
			$user_profile_data = $current_user;
		else{
			//$user_profile_data = get_user_by("id",$url_user_id);
			//if(!$user_profile_data)
				wp_redirect(HOME_URL);
		}
	}
	else
		wp_redirect(HOME_URL);
}
else
	wp_redirect(HOME_URL);


include_once(THEME_ABS.'page-users/users-functions.php');
get_header(); ?>

<main role="main" class="content_wrapper">
	<div class="container">
				<!-- alert messaaaaage start from here -->
				<?php ErrorUpdateMessage($errorMessage, $updateMessage); ?>
				<!-- alert messaaaaage end here -->

					<?php if (have_posts()): while (have_posts()) : the_post(); ?>
						<div class="users_dashboard">
							<div class="dashboard_content_container">
								<div class="row">
									<div class="col-xs-12 col-sm-3 col-md-3 col-lg-3 left_content"><?php user_dashboard_profile_menu(); ?></div>
									<div class="col-xs-12 col-sm-9 col-md-9 col-lg-9" style="background-color:#fff;">
										<div class="right_content">
										<?php
										if(isset($wp_query->query_vars["avatar"]) && is_user_logged_in() && $current_user->ID == $user_profile_data->ID){
											include_once(THEME_ABS.'page-users/users-profile-avatar.php');
										}
										else if(isset($wp_query->query_vars["settings"]) && is_user_logged_in() && $current_user->ID == $user_profile_data->ID){
											include_once(THEME_ABS.'page-users/users-profile-settings.php');
										}
										else if(isset($wp_query->query_vars["edit"]) && is_user_logged_in() && $current_user->ID == $user_profile_data->ID){
											include_once(THEME_ABS.'page-users/users-profile-edit.php');
										}else{ ?>
											<div class="user_profile_view">
		                    <h2>About</h2>
		                    <p><span>Display Name:</span> <?php echo $user_profile_data->data->display_name; ?></p>
		                    <p><span>First Name:</span> <?php echo get_user_meta($user_profile_data->ID,'first_name',true); ?></p>
		                    <p><span>Last Name:</span> <?php echo get_user_meta($user_profile_data->ID,'last_name',true); ?></p>
		                    <p><span>Join Date: </span> <?php echo date("d F Y h:i A",strtotime($user_profile_data->data->user_registered)); ?><!--14th October 2014 03:26 AM--></p>
		                    <p><span>Gender:</span> <?php echo get_user_meta($user_profile_data->ID,'gender',true); ?></p>
		                    <?php
												$profile_views = 1;
												if(get_user_meta($user_profile_data->ID,'profile_views',true)){
													$profile_views = get_user_meta($url_user_id,'profile_views',true)+1;
													update_user_meta($user_profile_data->ID,'profile_views',$profile_views);
												}else
													update_user_meta($user_profile_data->ID,'profile_views',$profile_views);
												?>
		                    <p><span>Profile Views:</span> <?php echo $profile_views; ?></p>
			                </div>
										<?php }
										?>
									</div><!-- right content div end here -->
									</div>
								</div>
							</div><!-- div dashboard_content_container end here -->
						</div><!-- users_dashboard div end here -->

					<?php endwhile; ?>
					<?php else: ?>
						<article>
							<h2><?php _e( 'Sorry, nothing to display.', 'bbblank' ); ?></h2>
						</article>
					<?php endif; ?>

	</div><!-- container div end here-->
</main>

<?php get_footer(); ?>
