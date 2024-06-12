<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class CI_Branch {
	var $CI;
    public function __construct()
    {
        $this->CI =&get_instance();
    }
    public function status($branch)
    {
    	$this->CI->db->select('rest_name,availability');
    	$this->CI->db->from('restaurants');
    	$this->CI->db->where('rest_id',$branch);
    	$this->CI->db->where('status','1');
    	$query = $this->CI->db->get();
		if ($query->num_rows() == 1)
		{
			return $query->row_array();
		}
		else
		{
			return false;
		}
    }
}