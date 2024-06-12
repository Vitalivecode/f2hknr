<?php 

class DashboardModel extends CI_Model{
	function __construct() {
		parent::__construct();
	}
	function unitcount() {
		$this->db->select("count(sno) as unit");
		$this->db->from('unit');
		$this->db->where('u_status','1');
		$query = $this->db->get();
		return $query->result();
	}
	function earnings() {
		$this->db->select("amount");
		$this->db->from('earnings');
		$this->db->select_sum('amount');
		$query = $this->db->get();
		return $query->result();
	}
	function expenses() {
		$this->db->select("amount");
		$this->db->from('expenses');
		$this->db->select_sum('amount');
		$query = $this->db->get();
		return $query->result();
	}
	function leaves() {
	    $date = date('Y-m-d');
		$this->db->select("*");
		$this->db->from('attendance');
		$this->db->where('day',$date);
		$this->db->where('attendance','Absent');
		
		$query = $this->db->get();
	if ($query->num_rows() > 0)
		{
			$result = $query->result();
			return $result;
        }
        else
		{
			return false;
		}
	}
}

?>