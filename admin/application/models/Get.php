<?php class Get extends CI_Model{
	function __construct() {
		parent::__construct();
	}
	function management() {
		$this->db->from("admin");
		$this->db->where("status","active");
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
	function table($table,$where = NULL,$like = NULL) {
		$this->db->from($table);
		if($where != NULL)
		    $this->db->where($where);
		if($like != NULL)
		    $this->db->like($like);
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
	function updateTableDetails($table,$data) {
		$email = $data['emailid'];
		$id = $this->uri->segment(3);
        $this->db->from($table);
		$this->db->where('emailid',$email);
		$this->db->where_not_in('id',$id);
		$this->db->where('isActive','1');
		$query = $this->db->get();
		if ($query->num_rows() == 0)
		{
			$this->db->where('id', $id);
			$query = $this->db->update($table,$data);
			return true;
		}
		else
		{
			return false;
		}
	}
	function updateInsertTableDetails($table,$data,$where = NULL) {
		$id = $this->uri->segment(3);
        $this->db->from($table);
        if($where != NULL)
		    $this->db->where($where);
		$query = $this->db->get();
		if ($query->num_rows() > 0)
		{
			$this->db->where($where);
			$query = $this->db->update($table,$data);
			return true;
		}
		else
		{
			$query = $this->db->insert($table,$data);
			return true;
		}
	}
	function check_unique_field($table,$id, $where) {
        $this->db->where($where);
        if($id != NULL) {
            $this->db->where_not_in('id', $id);
        }
        return $this->db->get($table)->num_rows();
    }
    function insert($table,$data){
        $query = $this->db->insert($table,$data);
		return $this->db->insert_id();
    }
    function update($table,$data,$where = NULL){
        if($where != NULL)
            $this->db->where($where);
		$query = $this->db->update($table,$data);
		return true;
    }
    function like(){
        $this->db->like('title', $query);
        $res = $this->db->get('film');
    }
    function updateWhereIn($table,$data,$where = NULL,$field = NULL,$where_in = NULL){
        if($where != NULL)
            $this->db->where($where);
        if($where_in != NULL)
            $this->db->where_in($field,$where_in);
		$query = $this->db->update($table,$data);
		return true;
    }
	function tableArray($table,$where = NULL,$like = NULL) {
		$this->db->from($table);
		if($where != NULL)
		    $this->db->where($where);
		if($like != NULL)
		    $this->db->like($like);
		$query = $this->db->get();
		if ($query->num_rows() > 0)
		{
			$result = $query->result_array();
			return $result;
        }
        else
		{
			return false;
		}
	}
	function itemsExport($table,$where = NULL,$like = NULL) {
        $this->db->select('i.item_id,r.rest_name,c.res_cat_name,s.res_subcat_name,i.item_name,i.item_details,i.item_type,i.item_price,i.discount,i.today_special,i.status');
		$this->db->from('restaurant_items as i');
        $this->db->join('restaurants as r','r.rest_id = i.vendor_id');
        $this->db->join('restaurant_menu as c','c.rc_id = i.item_cat_id', 'left');
        $this->db->join('restaurant_submenu as s','s.rs_id = i.item_subcat_id', 'left');
		if($where != NULL)
		    $this->db->where($where);
		if($like != NULL)
		    $this->db->like($like);
		$query = $this->db->get();
        //print_r($this->db->last_query());exit;
		if ($query->num_rows() > 0)
		{
			$result = $query->result_array();
			return $result;
        }
        else
		{
			return false;
		}
	}
	function tableGroup($table,$where = NULL,$group = NULL){
		if($where != NULL)
			$this->db->where($where);
	    $this->db->from($table);
        if($group != NULL)
	       $this->db->group_by($group);
	    $query = $this->db->get();
	    if ($query->num_rows() > 0)
		{
			return $query->result();
		}
		else
		{
			return false;
		}
	}
}

?>