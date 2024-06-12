<?php class Uploads extends CI_Model{
	function __construct() {
		parent::__construct();
	}
	function imageInsert($dataArray) {
	    $this->db->insert('images', $dataArray);
	    return true;
	}
	function imageGet($login) {
		$this->db->where('userid',$login);
		$this->db->where('status','1');
		$query = $this->db->get('images');
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