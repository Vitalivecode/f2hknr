<?php class Alert extends CI_Model{
	function __construct() {
		parent::__construct();
	}
	function notifications() {
		$form_hms = date('d-m-Y');
		$to_hms = date("d-m-Y", strtotime($form_hms ."+15 days"));
		$frm_timestamp = strtotime($form_hms);
		$to_timestamp = strtotime($to_hms);
		$this->db->select('*');
		$this->db->from('renewals');
		$this->db->where("expire_date BETWEEN '$frm_timestamp' AND '$to_timestamp' ");
		$this->db->where('status','1');
		$query = $this->db->get();
		//print_r($this->db->last_query());
		return $query->result();
	}
	function limitnotifications() {
		$form_hms = date('d-m-Y');
		$to_hms = date ("d-m-Y", strtotime ($form_hms ."+15 days"));
		$frm_timestamp = strtotime($form_hms);
		$to_timestamp = strtotime($to_hms);
		$this->db->select('*');
		$this->db->from('renewals');
		$this->db->where("expire_date BETWEEN '$frm_timestamp' AND '$to_timestamp' ");
		$this->db->where('status','1');
		$this->db->order_by('id','desc');
		$this->db->limit(5, 0);
		$query = $this->db->get();
		return $query->result();
	}
}

?>