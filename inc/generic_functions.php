<?php
function localhost()
{
	$whitelist = array('127.0.0.1', "::1");

	if(in_array($_SERVER['REMOTE_ADDR'], $whitelist)){
		return true;
	}
	else
	{
		return false;
	}
}

/******************************************/
/***** arrayToSerializeString **********/
/******************************************/
if(!function_exists("ArrayToSerializeString")){
	function ArrayToSerializeString($array){
		if(isset($array) && is_array($array) && count($array) >= 1)
			return serialize($array);
		else
			return serialize(array());
	}
}

/******************************************/
/***** SerializeStringToArray **********/
/******************************************/
if(!function_exists("SerializeStringToArray")){
	function SerializeStringToArray($string){
		if(isset($string) && is_array($string) && count($string) >= 1)
			return $string;
		elseif(isset($string) && $string && @unserialize($string)){
			return unserialize($string);
		}else
			return array();
	}
}

/******************************************/
/***** Debug functions start from here **********/
/******************************************/
function bb_shutdown()
{
echo '<div style="color:#fff;position:fixed;bottom:20px;left:0px; background-color:#000; z-index:9999;">'.$time = microtime(true) - $_SERVER["REQUEST_TIME_FLOAT"].'</div>';
}
if(! ( defined( 'DOING_AJAX' ) && DOING_AJAX ) && is_user_logged_in() && current_user_can( 'manage_options' )){
	register_shutdown_function('bb_shutdown');
}


/******************************************/
/***** sql ready function **********/
/******************************************/

function sql_ready($string)
{
	global $wpdb;
	$string = trim(stripcslashes($string));
	if ( isset( $wpdb->use_mysqli ) && !empty( $wpdb->use_mysqli ) )
	{
		  return mysqli_real_escape_string($wpdb->dbh, $string);
	}
	else
	{
		 return mysql_real_escape_string($string);
	}
}

function post_ready($string)
{
	return stripcslashes(trim($string));
}


if(!function_exists("alert")){
	function alert($alertText){
		echo '<script type="text/javascript">';
		echo "alert(\"$alertText\");";
		echo "</script>";
	}
}

if(!function_exists("db")){
	function db($array1){
		echo "<pre>";
		var_dump($array1);
		echo "</pre>";
	}
}


/******************************************/
/***** Update page Counter **********/
/******************************************/

function update_page_counter($id)
{
	$exist_value = get_post_meta($id,"page_views",true);

	if($exist_value && is_numeric($exist_value) && $exist_value >= 1)
	{
		update_post_meta($id,"page_views",(int)$exist_value+1);
	}else
	{
		update_post_meta($id,"page_views",1);
	}
}

/******************************************/
/***** generate random integre value **********/
/******************************************/
function generate_random_int($number_values)
{
	$number_values = $number_values-2;
	$lastid = rand(0,9);
	for($i=0; $i <= $number_values; $i++)
	{
		$lastid .= rand(0,9);
	}
	return $lastid;
}


/******************************************/
/***** function for send email start from here **********/
/******************************************/
function send_email($to,$subject,$message1){
	$host_address = $_SERVER['HTTP_HOST'];
	if(localhost() && 'dummyCondition' == 'delete it')
	{
		require_once(get_template_directory().'/lib/PHPMailer/PHPMailerAutoload.php');
		$message_body = $message1;
		$mail = new PHPMailer;

		$mail->IsSMTP();
		$mail->SMTPSecure = "ssl";
		$mail->Host       = "smtp.gmail.com"; // SMTP server
		$mail->SMTPAuth   = true;
		$mail->Port       = 465;
		$mail->Username   = "nasiranwar2020@gmail.com";
		$mail->Password   = "NasirBro";
		$mail->addAddress('nuqtadeveloptahir@gmail.com');

		$mail->isHTML(true);
		$mail->Subject = $subject;
		$mail->Body    = $message_body;
      $mail->From = get_option('admin_email');
      $mail->FromName = 'Byte Bunch';
		$mail->send();

	}
	else
	{
		$message = '<html><head><title></title></head><body>';
		$message .= $message1;
		$message .= '</body></html>';
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		$headers .= 'From: '.get_option('admin_email'). "\r\n";

		mail($to,$subject,$message,$headers);
	}
}// function send_email end here

/******************************************/
/***** get featured image url **********/
/******************************************/
function get_feature_image_url($post_id)
{
	if(has_post_thumbnail($post_id))
	{
		$image5 = wp_get_attachment_image_src( get_post_thumbnail_id( $post_id ), 'full' );
		return $image5[0];
	}
	else
	{
		return false;
	}
}


/******************************************/
/***** Logged in user data**********/
/******************************************/
if(is_user_logged_in())
{
	global $current_user;
	$current_user = wp_get_current_user();
}

/******************************************/
/***** Redirect logged in users to home page **********/
/******************************************/
function redirect_logged_in_users()
{
	if(is_user_logged_in())
	{
		header("Location: ".HOME_URL);
	}
}

function redirect_not_logged_in_users()
{
	if(!is_user_logged_in())
	{
		header("Location: ".HOME_URL);
	}
}

/******************************************/
/***** mycustom_logout hook start from here **********/
/******************************************/
add_action("wp_logout","mycustom_logout");
function mycustom_logout() {
	if(isset($_SESSION))
	{
		session_destroy();
	}
	wp_clear_auth_cookie();
}

/******************************************/
/***** get singl post data from database **********/
/******************************************/
function get_single_post_data($post_id, $key = 'post_content'){
	$post_data = get_post($post_id,ARRAY_A);
	if($post_data && is_array($post_data) && isset($post_data[$key])){
		return $post_data[$key];
	}else{
		return false;
	}
}

/******************************************/
/***** useer profile functions starts from here **********/
/******************************************/
function get_user_profile_image_url($user_id){
	$image_url = THEME_URI.'/images/profile_placeholder.png';
	if($image_relative_path = get_user_meta($user_id, 'profile_image_url', true))
	{
		$image_url = $image_relative_path;
	}
	return $image_url;
}

function delete_user_profile_image($user_id){
	if($image_relative_path = get_user_meta($user_id, 'profile_image_url', true))
	{
		$image_abs_path = str_replace(HOME_URL,ABSPATH,$image_relative_path);
		if(file_exists($image_abs_path))
		{
			unlink($image_abs_path);
			update_user_meta($user_id,'profile_image_url','');
		}
	}
}



function googleAnalytics($tracking_id){
?>
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

  ga('create', '<?php echo $tracking_id; ?>', 'auto');
  ga('send', 'pageview');

</script>
<?php
}
