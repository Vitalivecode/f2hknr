<?php class Loged extends CI_Model{
	function __construct() {
		parent::__construct();
			}
	function login($data) {
		$phone = $data['mobile'];
		$otp = rand(99999, 999999);
        // $otp = '000000';
        $message = $otp;
		$this->bulksms->index($phone,$message);
        $date = date('Y-m-d H:i:s');
		$this->db->select('*');
		$this->db->from('sms_codes');
		$this->db->where('mobile_number',$phone);
		$this->db->where('message','otp');
		$query = $this->db->get();
		if($query->num_rows() == 1)
		{
			$update = array('sms_code' => $otp, 'status' => 1, 'created_at' => $date);
			$this->db->where('mobile_number',$phone);
		    $this->db->where('message','otp');
			$this->db->update('sms_codes',$update);
			return $otp;
		}
		else
		{
		    $insert = array('mobile_number' => $phone, 'message' => 'otp', 'sms_code' => $otp, 'status' => 1, 'created_at' => $date);
		    $this->db->insert('sms_codes',$insert);
			return $otp;
		}
	}
	function verify($data)
	{
	    $phone = $data['mobile'];
	    $otp = $data['otp'];
        $date = date('Y-m-d H:i:s');
		$this->db->select('sms_code');
		$this->db->from('sms_codes');
		$this->db->where('mobile_number',$phone);
		$this->db->where('sms_code',$otp);
		$this->db->where('message','otp');
		$query = $this->db->get();
		if($query->num_rows() == 1)
		{
    		$appUser = $this->appUser($phone);
    		if($appUser != false)
    		{
    		    return $appUser;
    		}
    		else
    		{
    		    $insert = array('mobile' => $phone, 'login_status' => '1', 'created_at' => $date);
    		    $this->db->insert('app_users',$insert);   
    		    $appUser = $this->appUser($phone);
        		if($appUser != false)
        		{
        		    return $appUser;
        		}
    		}
		}
		else
		{
		    return false;
		}
	}
	function appUser($phone)
	{
	    $this->db->select('user_id as userid,name,email,mobile,store');
    	$this->db->from('app_users');
    	$this->db->where('mobile',$phone);
    	$userQuery = $this->db->get();
    	if($userQuery->num_rows() == 1)
    	{
    	    return $userQuery->result();
    	}
    	else
    	{
    	    return false;   
    	}
	}
	function singleAddress($userid)
	{
	    $this->db->select('id,name as addressName,mobile as addressMobile,street,hno,city,state,zip,type,isValidLocation');
    	$this->db->from('user_addresses');
    	$this->db->where('user_id',$userid);
    	$this->db->order_by('id',"desc");
    	$this->db->limit(1);
    	$res = $this->db->get();
    	if($res->num_rows() > 0)
    	{
    	    return $res->result();
    	}
    	else
    	{
    	    return false;   
    	}
	}
	function favorite($userid,$itemid) {
		$this->db->select('*');
		$this->db->where('user_id', $userid);
		if($itemid != 'all')
		    $this->db->where('item_id', $itemid);
		$this->db->where('status', '1');
		$this->db->from('favorite');
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
	function getBranches($where = NULL) {
	    $this->db->select('rest_id as locationId,rest_name as location,rest_lng as longitude,rest_lat as latitude,del_distance as radius');
		$this->db->from('restaurants');
	    if($where != NULL)
	        $this->db->where($where);
		$this->db->where('status','1');
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