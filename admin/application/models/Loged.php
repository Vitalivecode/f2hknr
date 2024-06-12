<?php 
class Loged extends CI_Model{
	function __construct() {
		parent::__construct();
	}
	function login($data) {
	    $email = $data['email'];
	    $pass = md5($data['pass']);
		$this->db->from('admin');
		$this->db->where('email',$email);
		$this->db->where('pass',$pass);
		$this->db->where('status','active');
		$query = $this->db->get();
        if($query->num_rows() == 1)
    	{
			$token = urldecode($data['tokenid']);
		    $update = array('web_token' => $token);
			$this->db->where('email',$email);
		    $this->db->update('admin',$update);
			return $query->result();
		}
    	else
    	{
    		return false;
    	}
	}
}

?>