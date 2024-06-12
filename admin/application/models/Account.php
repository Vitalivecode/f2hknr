<?php 

class Account extends CI_Model{
	function __construct() {
		parent::__construct();
	}
	function detailsupdate($data,$updatedata) {
	$email = $data['email'];
	$id = $data['id'];
			$this->db->select('sno');
			$this->db->select('fullname');
			$this->db->from('admin');
			$this->db->where('sno', $id);
			$this->db->where('status', 'active');
			$query = $this->db->get();
			if ($query->num_rows() == 1)
			{
			$this->db->where('sno', $id);
			$this->db->update('admin', $updatedata);
			$result = $query->result();
			return true;
			}
			else
			{
				return false;
			}
							}
}

?>