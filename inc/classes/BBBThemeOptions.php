<?php
class BBBThemeOptions
{
	private $theme_options_key = 'bbb_theme_options';
	private $theme_options_values = array();
	private $theme_default_values = array(
		'theme_version'=>'0.02',
		'verify_email' => 'yes'
	);

	function __construct()
	{
		$this->BBBThemeOptions_constructor();
	}// constructor end here

	function __destruct()
	{
		update_option($this->theme_options_key, serialize($this->theme_options_values));
	}// destructor functoin end here

	private function BBBThemeOptions_constructor()
	{
		$this->theme_options_values = SerializeStringToArray(get_option($this->theme_options_key));

		if(count($this->theme_options_values) < 1)
			$this->theme_options_values = $this->theme_default_values;

		//$this->theme_options_values['theme_version'] = '0.02';
		//$this->theme_options_values['verify_email'] = 'yes';
		//$this->theme_options_values['nodejs_live_chat'] = '0';
	}// listingPostMeta_constructor function end here

	public function get_option($option_value = 'theme_version'){
		if(isset($this->theme_options_values[$option_value])){
			return $this->theme_options_values[$option_value];
		}else{
			return NULL;
		}
	}

	public function set_option($option_key = false, $option_value = false){
		if($option_key != false && $option_value != false)
			$this->theme_options_values[$option_key] = $option_value;
	}

}// class ListingPostMeta end here
