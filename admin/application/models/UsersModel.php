<?php class UsersModel extends CI_Model{
	function __construct() {
		parent::__construct();
	}
	function usersDetails($limit, $start) {
			$this->db->where('status', 'active');
			$this->db->order_by('sno','desc');
			$this->db->where_not_in('sno','1');
			$query = $this->db->get('admin', $limit, $start);
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
	function visit_count() {
		$this->db->where('status','active');
		$this->db->where('role !=','superadmin');
		$query = $this->db->get('admin');
		return $query->result();
    }
	function getAdmin($sno) {
    	$this->db->select('*');
        $this->db->from('admin');
		$this->db->where('sno',$sno);
		$this->db->where_not_in('sno','1');
		$this->db->where('status','active');
		$query = $this->db->get();
		if ($query->num_rows() == 1)
			{
				$result = $query->result();
				return $result;
			}
		else
			{
				return false;
			}
						}
	function updateAdminDetails($data) {
		$email = $data['email'];
		$id = $this->uri->segment(3);
        $this->db->from('admin');
		$this->db->where('email',$email);
		$this->db->where_not_in('sno',$id);
		$this->db->where('status','active');
		$query = $this->db->get();
		if ($query->num_rows() == 0)
			{
				$this->db->where('sno', $id);
				$query = $this->db->update('admin',$data);
				return true;
			}
		else
			{
				return false;
			}
						}
	function insertUsersDetails($data) {
		$email = $data['email'];
        $this->db->from('admin');
		$this->db->where('email',$email);
		$this->db->where('status','active');
		$query = $this->db->get();
		if ($query->num_rows() == 0)
			{
				$query = $this->db->insert('admin',$data);
				return true;
			}
		else
			{
				return false;
			}
						}
	function deleteAdmin($id) {
			$data = array(
					'status' => 'inactive',
					);
			$this->db->where('sno', $id);
			$this->db->where_not_in('sno','1');
			$query = $this->db->update('admin',$data);
			return true;
						}
						
	function menus() {
	    $this->db->select('cttitle,table_name,permissions');
        $this->db->from('create_table');
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