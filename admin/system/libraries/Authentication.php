<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class CI_Authentication {
		var $CI;
        public function __construct()
        {
            $this->CI =&get_instance();
			//$this->permissions();
        }
	public function permissions()
	{
		$unlock = get_cookie("unlocked");
		if($unlock == 'be2280f69a5199998055f035523feedf') {
			return true; }
		else {
			//echo '<div onload="permission();"></div>';
			return false;
			}
	}
}