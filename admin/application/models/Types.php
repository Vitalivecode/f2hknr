<?php 
class Types extends CI_Model{
	function __construct() {
		parent::__construct();
	}
	function type($type) {
				$this->db->select('tcondition,tformat');
				$this->db->from('type');
				$this->db->where('type',$type);
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