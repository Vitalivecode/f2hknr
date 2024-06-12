<?php class Insert extends CI_Model{
	function __construct() {
		parent::__construct();
	}
	function favorite($userid,$itemid,$status,$rest_id) {
		$date = date('Y-m-d H:i:s');
	    $this->db->from('favorite');
		$this->db->where('user_id', $userid);
		$this->db->where('item_id', $itemid);
		$this->db->where('vendor_id', $rest_id);
		//$this->db->where('status','1');
		$query = $this->db->get();
		if ($query->num_rows() == 0)
		{
		    $data = array('user_id' => $userid, 'item_id' => $itemid, 'datetime' => $date, 'status' => $status, 'vendor_id' => $rest_id);
			$this->db->insert('favorite',$data);
			return true;
		}
		else
		{
		    $data = array('datetime' => $date,'status' => $status);
    		$this->db->where('user_id', $userid);
		    $this->db->where('item_id', $itemid);
		    $this->db->where('vendor_id', $rest_id);
    		$this->db->update('favorite',$data);
    		return true;
		}
	}
	function address($data) {
		$this->db->insert('user_addresses',$data);
		return $this->db->insert_id();
	}
	function orders($data) {
		$this->db->insert('user_cart',$data);
		return true;
	}
	function profile($data) {
	    $userid = $data['user_id'];
	    $mobile = $data['mobile'];
	    $this->db->where('user_id',$userid);
	    $this->db->where('mobile',$mobile);
	    $this->db->update('app_users',$data);
		return true;	
	}
	function feedback($data) {
		$this->db->insert('feedback',$data);
		return true;
	}
	function order_feedback($data) {
		$this->db->insert('order_feedback',$data);
		return true;
	}
	function table($table,$data) {
		$this->db->insert($table,$data);
		return $this->db->insert_id();
	}
	
}

?>