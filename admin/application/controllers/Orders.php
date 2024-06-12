<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Orders extends CI_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->library('Site');
		$this->site->maintenance();
		$this->load->library('Auth_user');
		$this->auth_user->checkLogin();
        $this->load->model('adminpanel');
        $this->load->model('get');
        $this->load->model('ordersModel');
	}
	public function index()
	{
		$this->load_header();
		$this->load_body();
		$this->load_footer();
	}
	public function load_header()
	{
        $data['site']=$this->site->settings();
		$data['userdata']=$this->auth_user->checkLogin(); 
		$data['tables']=$this->adminpanel->tables();
        $data['ct']=$this->adminpanel->createtable();
        if($this->uri->segment(2) == 'accept')
            $data['title']="Accepted Orders";
        else
		  $data['title']="Orders";
		$this->load->view('include/header',$data);
	}
	public function load_body()
	{
	    $data['title']="Orders";
		$data['branches'] = $this->get->table('restaurants');
        $this->load->view('orders',$data);
	}	
	public function online()
	{
	    $data['title']="Orders";
		//$data['vendors'] = $this->get->table('admin',array('role' => 'vendor'));
        $data['controller'] = $this; 
		$data['orders'] = $this->ordersModel->getData();
        $this->load->view('online-orders',$data);
	}
	public function single()
	{
		if(isset($_GET['txn_id']) && $_GET['txn_id'] != ''){
			$this->load_header();
			$txn_id = $_GET['txn_id'];
			$data['title']="Orders";
			if($this->session->userdata('logged_in')['role'] == 'vendor'){
				$this->get->updateWhereIn('user_cart', array('notification_status' => '1'), array('vendor_id' => $this->session->userdata('logged_in')['branch'], 'order_id' => $txn_id));
				$data['vendors'] = $this->get->table('restaurants',array('rest_id' => $this->session->userdata('logged_in')['branch'], 'status' => '1', 'availability' => '1'));
				$orders = $this->get->tableArray('user_cart',array('vendor_id' => $this->session->userdata('logged_in')['branch'], 'order_id' => $txn_id));
			}
			else{
				$data['vendors'] = $this->get->table('restaurants',array('status' => '1', 'availability' => '1'));
				$orders = $this->get->tableArray('user_cart',array('order_id' => $txn_id));
			}
			if($orders != false)
			{
				$data['row'] = $orders[0];
				$data['txn_id'] = $txn_id;
                $gps = gps_get_instance(); 
                $gps->table('order_images');
                $login_id = $this->session->userdata('logged_in')['id'];
                $role = $this->session->userdata('logged_in')['role'];
                $name = $this->session->userdata('logged_in')['name'];
                $branchID = $this->session->userdata('logged_in')['branch'];
                $vendorsData = array('' => '- none -');
                if($this->session->userdata('logged_in')['role'] == 'vendor')
                    $branches = $this->get->table('restaurants',array('rest_id' => $branchID));
                else
                    $branches = $this->get->table('restaurants');
                if($branches != false)
                {
                    foreach($branches as $branch)
                        $vendorsData[$branch->rest_id] = $branch->rest_name;
                }
                $gps->unset_title();
                $gps->unset_csv();
                $gps->unset_print();
                $gps->unset_search();
                $gps->label(array('created_at' => 'Created Date'));
                $gps->columns(array('image','created_at','status'),false);
                $gps->fields(array('image','status'),false);
                $gps->validation_required('image');
                $gps->change_type('image','image','',array('width' => '600', 'height' => '600', 'manual_crop' => true));
                $gps->pass_var('order_id',$txn_id);
                $gps->pass_var('createdBy', $login_id,'create');
    			$gps->pass_var('modifiedBy', $login_id,'edit');
    			$gps->before_insert('created_date');
    			$gps->before_update('modify_date');
                $gps->where('order_id',$txn_id);
                $data['output'] = $gps->render();
				$this->load->view('single-order',$data);
			}
			else
				$this->load->view('nodata',$data);
			$this->load_footer();
		}
		else
			redirect(base_url('orders'));
	}	
	public function accept()
	{
        $this->load_header();
	    $data['title'] = "Accepted Orders";
		if(isset($_GET['from']) && $_GET['from'] != '')
        {
			$from = date('Y-m-d 00:00:00', strtotime($_GET['from']));
            $to = date('Y-m-d 23:59:59', strtotime($_GET['from']));
        }
		else
        {
			$from = date('Y-m-d 00:00:00');
            $to = date('Y-m-d 23:59:59');
        }
		$data['branches'] = $this->get->table('restaurants');
		$userdata = $this->auth_user->checkLogin();
		if($userdata[0]->role == 'vendor')
		{
			if($userdata[0]->branch && is_numeric($userdata[0]->branch))
				$where = array('rest_id' => $userdata[0]->branch);
			else
				$where = array('rest_id' => $userdata[0]->branch);
		}
		else{
			if(isset($_GET['branch']) && $_GET['branch'] != '' && is_numeric($_GET['branch']))
				$where = array('rest_id' => $_GET['branch']);
			else
				$where = NULL;
		}
		$branch = $this->get->table('restaurants', $where);
		if($branch != false)
		{
			$branch_id = ($userdata[0]->role != 'vendor')?((isset($_GET['branch']) && $_GET['branch'] != '' && is_numeric($_GET['branch']))?$_GET['branch']:'all'):$branch[0]->rest_id;
			$data['vendor_id'] = $branch_id;
			$data['branch_name'] = $branch[0]->rest_name;
			$data['items'] = array(); 
			$topItems = $this->ordersModel->itemWiseReport($branch_id,'2', $from, $to);
			if($topItems != false){ 
				$itemTotal = 0; $itemtotalCompletedCount = 0; $itemdcc = 0;
				foreach($topItems as $topSeller){ 
					$itemdiscount = (($topSeller['price']*$topSeller['quantity'])*$topSeller['discount'])/100;
					$itemtotalCompletedCount = ((($topSeller['price']*$topSeller['quantity'])-$itemdiscount+$topSeller['gst']))+$itemtotalCompletedCount;
					//$itemdcc = $topSeller['delivery_charges'];
					if(array_key_exists($topSeller['product_id'], $data['items']))
					{
						$data['items'][$topSeller['product_id']] = array(
							'name' => $topSeller['name'],
							'branch' => $topSeller['rest_name'],
							'quantity' => $data['items'][$topSeller['product_id']]['quantity']+$topSeller['quantity'],
							'type' => $topSeller['item_type'],
                            'price' => $topSeller['price'],
                            'item_details' => $topSeller['item_details'],
							'total' => $data['items'][$topSeller['product_id']]['total']+((($topSeller['price']*$topSeller['quantity'])-$itemdiscount+$topSeller['gst'])),
                            'date' => $topSeller['created_at']
						);
					}
					else
					{
						$data['items'][$topSeller['product_id']] = array(
							'name' => $topSeller['name'],
							'branch' => $topSeller['rest_name'],
							'quantity' => $topSeller['quantity'],
							'type' => $topSeller['item_type'],
                            'price' => $topSeller['price'],
                            'item_details' => $topSeller['item_details'],
							'total' => ((($topSeller['price']*$topSeller['quantity'])-$itemdiscount+$topSeller['gst'])),
                            'date' => $topSeller['created_at']
						);
					}
				} 
				$data['itemTotal'] = $itemtotalCompletedCount;
			}
            $this->load->view('accept-orders',$data);
		}
		else
			$this->load->view('nodata',$data);
		$this->load_footer();
	}
	public function addItem()
	{
	    if(isset($_POST['id']) && isset($_POST['item']) && isset($_POST['qty'])){
			$order_id = $_POST['id'];
			$item_id = $_POST['item'];
			$qty = $_POST['qty'];
			$required_fields = array('item','qty');
			
			foreach($_POST as $key=>$value){
				if(empty($value) && in_array($key, $required_fields) === true){
					$errors[] = 'Fields marked with * are required';
					break 1;
				}
			}
			if($this->session->userdata('logged_in')['role'] == 'vendor')
				$check_product= $this->db->query("select product_id,quantity,order_active from user_cart where product_id=$item_id and order_id='$order_id' and vendor_id = '".$this->session->userdata('logged_in')['branch']."'");
			else
				$check_product= $this->db->query("select product_id,quantity,order_active from user_cart where product_id=$item_id and order_id='$order_id'");
			if($check_product->num_rows() > 0)
			{
				$quant = $check_product->result_array()[0];
				if($quant['order_active'] == 1){
					if($this->session->userdata('logged_in')['role'] == 'vendor')
						$upd_quant = $this->db->query("update user_cart set quantity=$qty where product_id=$item_id and order_id='$order_id' and vendor_id = '".$this->session->userdata('logged_in')['branch']."'");
					else
						$upd_quant = $this->db->query("update user_cart set quantity=$qty where product_id=$item_id and order_id='$order_id'"); 
				}
				else {
					if($this->session->userdata('logged_in')['role'] == 'vendor')
						$upd_quant = $this->db->query("update user_cart set quantity=$qty,order_active=1 where product_id=$item_id and order_id='$order_id' and vendor_id = '".$this->session->userdata('logged_in')['branch']."'");
					else
						$upd_quant = $this->db->query("update user_cart set quantity=$qty,order_active=1 where product_id=$item_id and order_id='$order_id'"); 
				}
				$message = array(
					"title" => "Successfully Added",
					"message" => "",
					"status" => "success",
				);
				$this->session->set_flashdata('alertMessage', $message);
			}
			else {
				$items = $this->ordersModel->fetchitemDetails($item_id);
				$item_name = $items['item_name'];
				$item_details =$items['item_details'];
				$item_img = $items['item_img'];
				$item_price = $items['item_price'];
				$discount = $items['discount'];
				$details = $this->ordersModel->fetchorderDetails($order_id);
				//$del_type=$details['delivery_type'];
				$add_id = $details['address_id'];
				$user_id = $details['user_id'];
				$order_type =$details['order_type'];
				$delivery_charges = $details['delivery_charges'];
				 if(empty($_POST) === false && empty($errors) === true){
					$sql = "INSERT INTO `user_cart`(`order_id`, `order_type`, `user_id`, `address_id`, `vendor_id`, `product_id`, `name`, `item_details`, `thumbnail`, `quantity`, `price`, `discount`, `online_order`, `delivery_charges`, `order_status`, `order_active`, `created_at`) 
							VALUES ('$order_id',$order_type,$user_id,$add_id,1,$item_id,'$item_name','$item_details','$item_img',$qty,$item_price,$discount,1,$delivery_charges,2,1,now())";
					if($this->db->query($sql)){
						$message = array(
							"title" => "Successfully Added",
							"message" => "",
							"status" => "success",
						);
						$this->session->set_flashdata('alertMessage', $message);
						return true;
					}else{  
						$message = array(
							"title" => '',
							"message" => "Please try again",
							"status" => "error",
						);
						$this->session->set_flashdata('alertMessage', $message);
					}
				}else if(empty($errors)=== false){
					$message = array(
						"title" => "Fill all fields",
						"message" => "",
						"status" => "error",
					);
					$this->session->set_flashdata('alertMessage', $message);
				}
			}				
		}
		else{
			echo 'data not sent';
		}
	}
	public function assign()
	{
		if(isset($_POST['orderid']) && isset($_POST['del_boy'])){
            $map_address = "";
			$orderid = $_POST['orderid'];
			$user_id = $_POST['del_boy'];
			$exe_details = $this->ordersModel->getExecutiveDetails($user_id);
			$address_id = $this->ordersModel->getAddressID($orderid);
			$customerDetails = $this->ordersModel->getDeliveryDetails($address_id);
            $price_details = $this->ordersModel->getOrderItems($orderid);
			//$address = $customerDetails['customer_name'].','.$customerDetails['mobile'].','.$customerDetails['hno'].','. $customerDetails['city'];
            $address = $customerDetails['customer_name'].' '.$customerDetails['mobile'].' Amount:'.$price_details['total'];
            $hno = str_replace(" ","+",$customerDetails['hno']);
            $street = str_replace(" ","+",$customerDetails['street']);
            $city = str_replace(" ","+",$customerDetails['city']);
            $state = str_replace(" ","+",$customerDetails['state']);
            $zip = str_replace(" ","+",$customerDetails['zip']);
            $map = $hno.",".$street.",".$city.",".$state.",".$zip;
            $map_address = $address.' http://maps.google.com/?q='.$map;
			$required_fields = array('del_boy');
			foreach($_POST as $key => $value){
				if(empty($value) && in_array($key, $required_fields) === true){
						echo'Executive is required';
						break 1;
					}
			}
			$sql = $this->db->query("select * from del_orders where order_id='$orderid'");
			if($sql->num_rows() > 0)
			{
				$res = $sql->result_array()[0];
				$exe_mbl =  $this->ordersModel->getExecutiveDetails($res['user_id']);
				$phone = $exe_mbl['mobile'];
				$message = "Delivery request for orderid : $orderid has been cancelled.";
				$this->site->bulksms($phone,$message);
				$upd = $this->db->query("update del_orders set user_id=$user_id,modified_at=now() where order_id='$orderid'");
				if($upd){
					$phone = $exe_details['mobile'];
					$message = "You have a new delivery request orderid : $orderid to address $map_address";
					$this->site->bulksms($phone,$message);
				}
				$message = array(
					"title" => "Successfully assigned",
					"message" => "",
					"status" => "success",
				);
				$this->session->set_flashdata('alertMessage', $message);
			}
			else {
				$ins = $this->db->query("INSERT INTO `del_orders`(`order_id`, `user_id`, `status`, `created_at`, `modified_at`) VALUES ('$orderid',$user_id,1,now(),now())");
				if($ins){
					$phone = $exe_details['mobile'];
					$message = "You have a new delivery request orderid : $orderid to address $map_address";
					$this->site->bulksms($phone,$message);
					$message = array(
						"title" => "Successfully assigned",
						"message" => "",
						"status" => "success",
					);
					$this->session->set_flashdata('alertMessage', $message);
					
				}
				else{  
					$message = array(
						"title" => "Error Assigning Executive",
						"message" => "",
						"status" => "error",
					);
					$this->session->set_flashdata('alertMessage', $message);	 
				} 
			}
			echo $response;
		}
	}
	public function edit()
	{
		if(isset($_GET['order_id']) && $_GET['order_id'] != '' && isset($_GET['action'])){
			$order_id = $_GET['order_id'];
			$action = $_GET['action'];
			$redirect = $_GET['redirect'];
			if($action == 1){
				if($this->session->userdata('logged_in')['role'] == 'vendor')
					$sql = "UPDATE `user_cart` SET `order_status` = order_status + 1,`notification_status`=1, `modified_at` = NOW() WHERE `order_id` = '$order_id' and vendor_id = '".$this->session->userdata('logged_in')['branch']."'";
				else
					$sql = "UPDATE `user_cart` SET `order_status` = order_status + 1,`notification_status`=1, `modified_at` = NOW() WHERE `order_id` = '$order_id' ";
				$message = array(
					"title" => "Successfully accepted",
					"message" => "",
					"status" => "success",
				);
			}else if($action == 2){
				if($this->session->userdata('logged_in')['role'] == 'vendor')
					$sql = "UPDATE `user_cart` SET `order_status` = 5,`notification_status`=1, `modified_at` = NOW() WHERE `order_id` = '$order_id' and vendor_id = '".$this->session->userdata('logged_in')['branch']."'";
				else
					$sql = "UPDATE `user_cart` SET `order_status` = 5,`notification_status`=1, `modified_at` = NOW() WHERE `order_id` = '$order_id' ";
				$message = array(
					"title" => "Successfully cancelled",
					"message" => "",
					"status" => "success",
				);
			}
			else if($action == 3){
				if($this->session->userdata('logged_in')['role'] == 'vendor')
					$sql = "UPDATE `user_cart` SET `order_status` = 6,`notification_status`=1, `modified_at` = NOW() WHERE `order_id` = '$order_id' and vendor_id = '".$this->session->userdata('logged_in')['branch']."'";
				else
					$sql = "UPDATE `user_cart` SET `order_status` = 6,`notification_status`=1, `modified_at` = NOW() WHERE `order_id` = '$order_id' ";
				$message = array(
					"title" => "Successfully returned",
					"message" => "",
					"status" => "success",
				);
			}
			if($this->db->query($sql)){
				redirect(base_url('orders?type='.$redirect));
			}
			$this->session->set_flashdata('alertMessage', $message);
		}
	}
	public function reciept()
	{
		if(isset($_GET['order_id']) && $_GET['order_id'] != ''){
			$order_id = $_GET['order_id'];
			$data['title']="Orders";
			if($this->session->userdata('logged_in')['role'] == 'vendor'){
				$data['vendors'] = $this->get->table('admin',array('branch' => $this->session->userdata('logged_in')['branch'], 'role' => 'vendor'));
                $data['branch'] = $this->get->table('restaurants',array('rest_id' => $this->session->userdata('logged_in')['branch']));
				$orders = $this->get->tableArray('user_cart',array('vendor_id' => $this->session->userdata('logged_in')['branch'], 'order_id' => $order_id));
			}
			else{
				$data['vendors'] = $this->get->table('admin',array('role' => 'vendor'));
				$orders = $this->get->tableArray('user_cart',array('order_id' => $order_id));
                $data['branch'] = ($orders != false)?$this->get->table('restaurants',array('rest_id' => $orders[0]['vendor_id'])):false;
			}
			if($orders != false)
			{
				$data['site']=$this->site->settings();
				$data['order_id'] = $order_id;
				$this->load->view('reciept',$data);
			}
			else
				redirect(base_url('orders'));
		}
		else
			redirect(base_url('orders'));
	}
	public function updateStatus()
	{
		if(isset($_POST['id']) && $_POST['id']) 
		{
			$id = $_POST['id'];
			$orderDetails = $this->ordersModel->getOrderStatus($id);
			$orderstatus=$orderDetails['status'];
			if($orderDetails['status'] == 1)
			{
				if($this->session->userdata('logged_in')['role'] == 'vendor')
					$update_status = "UPDATE `user_cart` SET `order_status` = $orderstatus+1,`notification_status`=1, `modified_at` = NOW() WHERE `order_id` = '$id' and vendor_id = '".$this->session->userdata('logged_in')['branch']."'";
				else
					$update_status = "UPDATE `user_cart` SET `order_status` = $orderstatus+1,`notification_status`=1, `modified_at` = NOW() WHERE `order_id` = '$id' ";
				$this->db->query($update_status);
				$message = array(
					"title" => "Successfully accepted",
					"message" => "",
					"status" => "success",
				);
			}
			if($orderDetails['status'] == 2)
			{
				if($this->session->userdata('logged_in')['role'] == 'vendor')
					$update_status = "UPDATE `user_cart` SET `order_status` = $orderstatus+2,`notification_status`=1, `modified_at` = NOW() WHERE `order_id` = '$id' and vendor_id = '".$this->session->userdata('logged_in')['branch']."'";
				else
					$update_status = "UPDATE `user_cart` SET `order_status` = $orderstatus+2,`notification_status`=1, `modified_at` = NOW() WHERE `order_id` = '$id' ";
				$this->db->query($update_status);
				$phone = $_POST['mbl'];
				$message = "Thank you for choosing. Your order has been successfully delivered. Please order again.";
				$this->site->bulksms($phone,$message);				
				$message = array(
					"title" => "Successfully completed",
					"message" => "",
					"status" => "success",
				);
			}
			$this->session->set_flashdata('alertMessage', $message);
		} 
	}
	public function delete()
	{
		if(isset($_POST['sid']) && $_POST['sid'] != '')
		{
			$c_id= $_POST['sid'];
			if($this->session->userdata('logged_in')['role'] == 'vendor')
				$sql = $this->db->query("Update user_cart set order_active=0 where c_id=$c_id and vendor_id = '".$this->session->userdata('logged_in')['branch']."'");
			else
				$sql = $this->db->query("Update user_cart set order_active=0 where c_id=$c_id");
			if($sql){
				$message = array(
					"title" => "Successfully deleted",
					"message" => "",
					"status" => "success",
				);
				$this->session->set_flashdata('alertMessage', $message);
				return true;
			}
		}
	}
    public function time_elapsed_string($datetime, $full = false) {
        $now = new DateTime;
        $ago = new DateTime($datetime);
        $diff = $now->diff($ago);
        $diff->w = floor($diff->d / 7);
        $diff->d -= $diff->w * 7;
        $string = array(
            'y' => 'year',
            'm' => 'month',
            'w' => 'week',
            'd' => 'day',
            'h' => 'hour',
            'i' => 'minute',
            's' => 'second',
        );
        foreach ($string as $k => &$v) {
            if ($diff->$k) {
                $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
            } else {
                unset($string[$k]);
            }
        }

        if (!$full) $string = array_slice($string, 0, 1);
        return $string ? implode(', ', $string) . ' ago' : 'just now';
    }
	public function load_footer()
	{
		$this->load->view('include/footer');
	}
}
