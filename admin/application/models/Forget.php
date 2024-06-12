<?php class Forget extends CI_Model{
	
	function __construct() {
		parent::__construct();
		$this->load->database();
		$this->load->library('email');
	}

	function forgot($data) {
		$email = $data['email'];
		$this->db->select('fullname');
		$this->db->select('sno');
		$this->db->select('email');
		$this->db->from('admin');
		$this->db->where('email',$email);
		$this->db->where('status','active');
		$query = $this->db->get();
		if ($query->num_rows() == 1)
		{
			$row = $query->row();
			return $query->result();
		}
		else
		{
			return false;
		}
	}
	function updateForgotkey($id) {
		$randomkey = base64_encode(rand(1000,9999));
		$data = array(
              'forgot_key' => $randomkey
        );
		$this->db->where('sno', $id);
		$this->db->update('admin', $data);
		return $randomkey;
	}
	function changepass($data) {
		$id = $data['id'];
		$forgot_key = $data['forgot_key'];
		$new_pass = $data['new_pass'];
		$this->db->select('pass');
		$this->db->from('admin');
		$this->db->where('sno',$id);
		$this->db->where('forgot_key',$forgot_key);
		$this->db->where('status','active');
		$query = $this->db->get();
		$row = $query->row();
		if ($query->num_rows() == 1)
		{
			$new_pass_key = md5($new_pass);
			$data = array(
               'pass' => $new_pass_key,
			   'forgot_key' => ''
            );
			$this->db->where('sno', $id);
			$this->db->update('admin', $data);
			return true;
		}
		else
		{
			return false;
		}
	}
	function checkLostPassword($id,$forgot_key) {
		$this->db->select('status');
		$this->db->from('admin');
		$this->db->where('sno',$id);
		$this->db->where('forgot_key',$forgot_key);
		$this->db->where('status','active');
		$query = $this->db->get();
		if ($query->num_rows() == 1)
		{
			return true;
		}
		else
		{
			return false;
		}
	}


}

?>