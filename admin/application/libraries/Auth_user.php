<?php if( ! defined('BASEPATH')) exit('No direct script access allowed');
class Auth_user {
	var $CI;
    public function __construct()
    {
        $this->CI =&get_instance();
    }
    public function checkLogin()
    {
		$session_value = $this->CI->session->userdata('logged_in');
		if((isset($session_value) && $session_value != false) && ($session_value['role'] == 'superadmin' || $session_value['role'] == 'admin' || $session_value['role'] == 'vendor'))
		{
    		$email = $session_value['email'];
    		$this->CI->db->select('sno,branch,email,fullname,img,phone,role,permissions');
    		$this->CI->db->from('admin');
    		$this->CI->db->where('email',$email);
    		$this->CI->db->where('status','active');
    		$query = $this->CI->db->get();
			if ($query->num_rows() == 1)
			{
				return $query->result();
			}
			else
			{
				return false;
			}			
		}
		else
		{
		    $this->CI->session->unset_userdata('logged_in');
	        $this->CI->session->sess_destroy();
			redirect(base_url().'login','refresh');			
		}
    }
    public function permissions($userper,$tablename){
        $permissions = json_decode($userper);
    	$table = $tablename;
        $perm = '';
        $p = array();
        $view = 0;
        $add = 0;
        $edit = 0;
        $delete = 0;
        foreach($permissions as $permsn ) {  
            $perm = isset($permsn->$table)?$permsn->$table:'';
            if(!empty($perm))
            {
            	$p[$table][] = $perm;
            }
        }
        if(!empty($p))
        {
            $view = in_array('view', $p[$table])?1:0;
            $add = in_array('add', $p[$table])?1:0;
            $edit = in_array('edit', $p[$table])?1:0;
            $delete = in_array('delete', $p[$table])?1:0;
        }
        if(!empty($view) || !empty($add) || !empty($edit) || !empty($delete) )
            return true;
        else
            return false;
    }
    public function givenPermissions($userper,$tablename){
        $permissions = json_decode($userper);
    	$table = $tablename;
        $perm = '';
        $p = '';
        $view = '';
        $add = '';
        $edit = '';
        $delete = '';
        foreach($permissions as $permsn ) {  
            $perm = isset($permsn->$table)?$permsn->$table:'';
            if(!empty($perm))
            {
            	$p[$table][] = $perm;
            }
        }
        if(!empty($p))
        {
            $view = in_array('view', $p[$table])?'view':'';
            $add = in_array('add', $p[$table])?'add':'';
            $edit = in_array('edit', $p[$table])?'edit':'';
            $delete = in_array('delete', $p[$table])?'delete':'';
        }
        $mergeArray = array($view,$add,$edit,$delete);
        return $mergeArray;
    }
}