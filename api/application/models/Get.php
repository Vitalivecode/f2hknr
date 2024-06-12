<?php class Get extends CI_Model{
	function __construct() {
		parent::__construct();
			}
	function search() {
		$q = $this->input->get('q');
		$this->db->select('sno,fullname,company,id,phone,email,role');
		$this->db->where('role', $q);
		$this->db->where('status', 'active');
		$this->db->from('admin');
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
	function banner($rest_id) {
		$this->db->select('banner_name,banner_image,banner_des,category,banner_url');
		$this->db->where('status', '1');
		$this->db->where('vendor_id', $rest_id);
		$this->db->from('app_banners');
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
	function category($cid,$rest_id) {
		$this->db->select('rc_id,res_cat_name,item_img');
		if($cid != 'all')
		    $this->db->where('rc_id', $cid);
		$this->db->where('vendor_id', $rest_id);
		$this->db->where('status', '1');
		$this->db->from('restaurant_menu');
		$this->db->order_by('sequence','ASC');
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
	function subcategory($cid,$rest_id) {
		$this->db->select('rs_id as rc_id,cat_id,res_subcat_name as res_cat_name,item_img');
		if($cid != 'all')
		    $this->db->where('cat_id', $cid);
		$this->db->where('vendor_id', $rest_id);
		$this->db->where('status', '1');
		$this->db->from('restaurant_submenu');
		$this->db->order_by('sequence','ASC');
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
	function subproducts($cid,$sid,$rest_id) {
		$this->db->select('item_id,item_cat_id,item_name,item_details,item_type,item_img,item_price,discount,status,today_special');
		if($sid != 'all')
		    $this->db->where('item_subcat_id', $sid);
		$this->db->where('item_cat_id', $cid);
		$this->db->where('vendor_id', $rest_id);
		$this->db->where('status', '1');
		$this->db->from('restaurant_items');
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
	function products($cid) {
		$this->db->select('item_id,item_cat_id,item_name,item_details,item_type,item_img,item_price,discount,status,today_special');
		if($cid != 'all')
		    $this->db->where('item_cat_id', $cid);
		$this->db->where('status', '1');
		$this->db->from('restaurant_items');
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
	function todaySpecial($rest_id) {
		$this->db->select('item_id,item_cat_id,item_name,item_details,item_type,item_img,item_price,discount,status,today_special');
		$this->db->where('vendor_id', $rest_id);
		$this->db->where('today_special', '1');
		$this->db->where('status', '1');
		$this->db->from('restaurant_items');
		$this->db->order_by('discount','desc');
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
	function favorite($userid,$itemid,$rest_id) {
		$this->db->select('*');
		$this->db->where('user_id', $userid);
		if($itemid != 'all')
		    $this->db->where('item_id', $itemid);
		$this->db->where('vendor_id', $rest_id);
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
	function product($id) {
		$this->db->select('item_id,item_cat_id,item_name,item_details,item_type,item_img,item_price,discount,status,today_special');
		if($id != 'all')
		    $this->db->where_in('item_id', $id);
		$this->db->where('status', '1');
		$this->db->from('restaurant_items');
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
	function searchProducts($q,$rest_id) {
		$this->db->select('item_id,item_cat_id,item_name,item_details,item_type,item_img,item_price,discount,status,today_special');
		$this->db->like('item_name', $q, 'both'); 
		$this->db->where('vendor_id', $rest_id);
		$this->db->where('status', '1');
		$this->db->from('restaurant_items');
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
	function getOrders($userid,$oid,$res_id) {
		$this->db->select('c_id,order_id,product_id,address_id,name,item_details,thumbnail,price,quantity,discount,gst,delivery_charges,order_type,order_status,payment,payment_status,txt_id,created_at');
		if($oid != 'all')
		    $this->db->where('order_id', $oid);
		if($userid != 'all')
		    $this->db->where('user_id', $userid);
		$this->db->where('vendor_id', $res_id);
		$this->db->where('order_active', '1');
		$this->db->from('user_cart');
		$this->db->group_by('order_id');
		$this->db->order_by('c_id','desc');
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
	function orders($userid,$oid) {
		$this->db->select('c_id as cart_id,product_id as id,name as title,item_details as Weight,thumbnail as imageURL,price as price_total,quantity as cartCount,discount');
		if($oid != 'all')
		    $this->db->where('order_id', $oid);
		if($userid != 'all')
		    $this->db->where('user_id', $userid);
		$this->db->where('order_active', '1');
		$this->db->from('user_cart');
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
	function address($userid,$aid) {
		$this->db->select('id as addressId,user_id,name as addressName,mobile as addressMobile,street,hno,city,state,zip as pincode,type');
		if($aid != 'all')
		    $this->db->where('id', $aid);
		$this->db->where('user_id', $userid);
		$this->db->from('user_addresses');
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
	function users($userid) {
		$this->db->select('user_id,name,mobile,email');
		$this->db->where('user_id', $userid);
		$this->db->from('app_users');
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
	function topOrders($rest_id) {
		$this->db->select('c_id,product_id,SUM(quantity) as max_quantity');
		$this->db->where_in('vendor_id', $rest_id);
		$this->db->order_by('max_quantity','DESC');
		$this->db->group_by('product_id');
		$this->db->limit(20);
		$this->db->from('user_cart');
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
	function topProduct($ids,$commaIds,$rest_id) {
		$this->db->select('item_id,item_cat_id,item_name,item_details,item_type,item_img,item_price,discount,status,today_special');
		$this->db->where_in('item_id', $ids);
		$this->db->where_in('vendor_id', $rest_id);
		$this-> db->order_by('FIELD (item_id, '.$commaIds.' )');
		$this->db->where('status', '1');
		$this->db->from('restaurant_items');
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
	function specialdiscount($res_id) {
	    if((isset($_POST['user_id']) && $_POST['user_id'] != '') || (isset($_GET['user_id']) && $_GET['user_id'] != ''))
	    {
	        $userid = isset($_POST['user_id'])?$_POST['user_id']:$_GET['user_id'];
        	$fromdate = date('Y-m-d');
    	    $this->db->select('c_id');
    		$this->db->where('user_id', $userid);
    		$this->db->where('created_at >=', date('Y-m-d 00:00:00'));
    		$this->db->where('created_at <=', date('Y-m-d 23:59:00'));
    		$this->db->where('order_status !=','5');
    		$this->db->from('user_cart');
    		$query = $this->db->get();
    		//print_r($this->db->last_query());
    		if ($query->num_rows() == 0)
    		{
        		$this->db->select('from,to,discount');
        		$this->db->where('from <= ', $fromdate);
        		$this->db->where('to >= ', $fromdate);
        		$this->db->where('status', '1');
        		$this->db->where('res_id', $res_id);
        		$this->db->from('special_discounts'); 
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
    		else
    		{
    		    return false;
    		}
	    }
	    else
	    {
	        return false;
	    }
	}
	function updateToken($userid,$data) {
	    $this->db->where('user_id',$userid);
		$this->db->update('app_users',$data);
		return true;
	}
	function updateStore($userid,$data) {
	    $this->db->where('user_id',$userid);
		$this->db->update('app_users',$data);
		return true;
	}
	function getBranches($where = NULL) {
	    $this->db->select('rest_id as locationId, rest_name as location, rest_lng as longitude, rest_lat as latitude, del_distance as radius, rest_address as address, min_order, offerAmount, del_time as deliveryTime, del_charges as deliveryCharges, start_at as OpenTime, ends_at as closeTime, availability, status');
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
	function getRestaurants($where = NULL) {
	    $this->db->select('*');
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
	function getstore($userid){
	    $this->db->select('store');
	    $this->db->where('user_id',$userid);
	    $this->db->from('app_users');
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
	function getvendor($storeId){
	    $this->db->select('rest_id');
	    $this->db->where('rest_id',$storeId);
	    $this->db->from('restaurants');
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
	function table($table,$where = NULL,$select = NULL){
        if($select != NULL)
			$this->db->select($select);
		if($where != NULL)
			$this->db->where($where);
	    $this->db->from($table);
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
	function updateTable($table,$where,$data) {
	    $this->db->where($where);
		$this->db->update($table,$data);
		return true;
	}
	function table_in($table,$select,$where,$where_in = NULL){
		$this->db->select($select);
		if($where_in != NULL)
			$this->db->where_in($where,$where_in);
	    $this->db->from($table);
	    $query = $this->db->get();
	    if ($query->num_rows() > 0)
		{
			return $query->result_array();
		}
		else
		{
			return false;
		}
	}
	
}

?>