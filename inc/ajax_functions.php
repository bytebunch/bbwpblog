<?php

/* ******************************************* */
/*  ajax functon for search listing start from here  */
/* ******************************************* */

add_action( 'wp_ajax_nopriv_subscribe_ajax', 'subscribe_ajax' );
add_action( 'wp_ajax_subscribe_ajax', 'subscribe_ajax' );

function subscribe_ajax(){
	global $wpdb;
	$output = '';
	if(isset($_POST['email']) && $_POST['email'])
	{
		$email = BBWPSanitization::Email($_POST['email']);
		if($email)
		{
			$verification_key = generate_random_int(20);
      $sql = $wpdb->prepare("SELECT * from ".$wpdb->bbb_email_list." WHERE email = %s", $email);
      $results = $wpdb->get_results($sql, ARRAY_A);
      if($results)
      {
				if($results[0]['verified'] != 1)
					$output = 'This Email is already exist in our subscription list but its not verified. We sent the verification email, visit your inbox and follow the instructons to veryfiy your email address.';
				elseif($results[0]['verified'] == 1 && $results[0]['status'] != 1){
					$wpdb->update($wpdb->bbb_email_list, array('status' => 1), array('ID' => $results[0]['ID']), array("%d"), array("%d"));
					$output = 'Thanks for subscription. We will keep you updated with our newest products, updates and events.';
				}
				else
						$output = 'This email address is already exist in our subscription list.';

      }
      else
      {
				global $BBBThemeOptions;
				
        $verify_url = get_permalink($BBBThemeOptions->get_option('page_verify_id'))."?type=sub&key=".$verification_key;
        $subject = 'Activate your Email Subscription';
        $message = "<p>Hello there,</p>
<p>You recently requested an email subscription to Byte Bunch Blog. We can't wait to send the updates you want via email, so please click the following link to activate your subscription immediately:</p>
<p><a href='".$verify_url."'>".$verify_url."</a></p>
<p>(If the link above does not appear clickable or does not open a browser window when you click it, copy it and paste it into your web browser's Location bar.)</p>
<p>If you did not request this subscription, or no longer wish to activate it, take no action. Simply delete this message and that will be the end of it.</p>
<p>Cheers, <br /> Byte Bunch</p>";
        send_email($email, $subject, $message);

				$wpdb->insert($wpdb->bbb_email_list, array('email' => $email, 'verification_key' => $verification_key), array('%s','%s'));
				$output = 'A verfication E-mail has been sent, please visit your inbox and follow the instructons to veryfiy your email address.';
      }
		}
		else{
			$output = 'Please type your correct E-mail.';
		}
	}

	die($output);

}// subscribe_ajax function end here
