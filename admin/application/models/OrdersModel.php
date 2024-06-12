<?php class OrdersModel extends CI_Model{
	function __construct() {
		parent::__construct();
	}
	function getData() {
		$limit = isset($_POST['limit'])?$_POST['limit']:50;
		$offset = !empty($_GET['page'])?(($_GET['page']-1)*$limit):0;
		$type = $_POST['type'];
		if($this->session->userdata('logged_in')['role'] == 'vendor')
			$vendor_id = $this->session->userdata('logged_in')['branch'];
		else
			$vendor_id = $_POST['vendor_id'];
		$start_date = $_POST['start_date'];
		if($type == 9){
			if(!empty($vendor_id) && !empty($start_date)){
				$sql = "SELECT count(c.c_id) as count, c.order_type, c.order_id, c.created_at,  c.modified_at, c.address_id, c.user_id, c.vendor_id, c.order_status, c.online_order, c.payment, c.payment_status
							FROM `user_cart` c LEFT JOIN restaurants r ON c.vendor_id = r.rest_id 
							WHERE  c.vendor_id = $vendor_id and DATE_FORMAT(c.created_at, '%Y-%m-%d') = '$start_date' and c.online_order=0 and c.order_active = 1 
							GROUP BY c.order_id ORDER BY c.created_at DESC LIMIT $limit ";
			}else if(!empty($vendor_id)){
				$sql = "SELECT count(c.c_id) as count,  c.order_type, c.order_id,  c.created_at,  c.modified_at, c.address_id, c.user_id,  c.vendor_id, c.order_status,c.online_order, c.payment, c.payment_status 
							FROM `user_cart` c LEFT JOIN restaurants r ON c.vendor_id = r.rest_id 
							WHERE c.vendor_id = $vendor_id and c.online_order=0 and c.order_active = 1 GROUP BY c.order_id ORDER BY c.created_at DESC LIMIT $limit ";
			}else if(!empty($start_date)){
				$sql = "SELECT count(c.c_id) as count, c.order_type,  c.order_id,  c.created_at, c.modified_at, c.address_id, c.user_id,  c.vendor_id, c.order_status,c.online_order, c.payment, c.payment_status 
							FROM `user_cart` c LEFT JOIN restaurants r ON c.vendor_id = r.rest_id 
							WHERE DATE_FORMAT(c.created_at, '%Y-%m-%d') = '$start_date' and c.online_order=0 and c.order_active = 1 
							GROUP BY c.order_id ORDER BY c.created_at DESC LIMIT $limit ";
			}else{
				$sql = "SELECT count(c.c_id) as count,  c.order_type, c.order_id,  c.created_at,  c.modified_at, c.address_id, c.user_id, c.vendor_id, c.order_status,c.online_order, c.payment, c.payment_status 
								FROM `user_cart` c LEFT JOIN restaurants r ON c.vendor_id = r.rest_id where c.online_order=0 and c.order_active = 1 
								GROUP BY c.order_id ORDER BY c.created_at DESC LIMIT $limit ";			
			}

		}else{
			if(!empty($vendor_id) && !empty($start_date)){
				$sql = "SELECT count(c.c_id) as count, c.order_type,  c.order_id,  c.created_at,  c.modified_at, c.address_id, c.user_id,  c.vendor_id, c.order_status,c.online_order, c.payment, c.payment_status 
							FROM `user_cart` c LEFT JOIN restaurants r ON c.vendor_id = r.rest_id 
							WHERE  DATE_FORMAT(c.created_at, '%Y-%m-%d') = '$start_date' and c.online_order=0 and c.order_active = 1 
							AND c.order_status = '$type' GROUP BY c.order_id ORDER BY c.created_at DESC LIMIT $limit ";
			}else if(!empty($vendor_id)){
				$sql = "SELECT count(c.c_id) as count,  c.order_type, c.order_id,  c.created_at,  c.modified_at, c.address_id, c.user_id, c.vendor_id, c.order_status,c.online_order, c.payment, c.payment_status
							FROM `user_cart` c LEFT JOIN restaurants r ON c.vendor_id = r.rest_id 
							WHERE c.vendor_id = $vendor_id and c.order_status = '$type' and c.online_order=0 and c.order_active = 1  GROUP BY c.order_id ORDER BY c.created_at DESC LIMIT $limit ";
			}else if(!empty($start_date)){
				$sql = "SELECT count(c.c_id) as count, c.order_type,  c.order_id,  c.created_at, c.modified_at, c.address_id, c.user_id,  c.vendor_id, c.order_status,c.online_order, c.payment, c.payment_status
							FROM `user_cart` c LEFT JOIN restaurants r ON c.vendor_id = r.rest_id 
							WHERE DATE_FORMAT(c.created_at, '%Y-%m-%d') = '$start_date' AND c.order_status = '$type' and c.online_order=0 and c.order_active = 1 
							GROUP BY c.order_id ORDER BY c.created_at DESC LIMIT $limit ";
			}else{
				$sql = "SELECT count(c.c_id) as count, c.order_type,  c.order_id,  c.created_at, c.modified_at, c.address_id, c.user_id,  c.vendor_id, c.order_status,c.online_order, c.payment, c.payment_status
								FROM `user_cart` c LEFT JOIN restaurants r ON c.vendor_id = r.rest_id  where c.online_order=0 and c.order_active = 1 
								GROUP BY c.order_id ORDER BY c.created_at DESC LIMIT $limit ";			
			}
		}
		$query = $this->db->query($sql);
		if($query->num_rows() > 0){
			$result = $query->result_array();
			return $result;
        }
        else
		{
			return false;
		}
	}
	function getOrderItems($order_id){
		$response['items'] = array();
		$price = 0; $discount = 0; $gst = 0;
		if($this->session->userdata('logged_in')['role'] == 'vendor')
			$q1 = $this->db->query("SELECT name, user_id, order_type, item_details, thumbnail,address_id, quantity, price,online_order, gst,delivery_charges, discount,order_active,created_at,payment,payment_status FROM `user_cart` WHERE order_id = '$order_id' and order_active=1 and vendor_id = '".$this->session->userdata('logged_in')['branch']."'");
		else
			$q1 = $this->db->query("SELECT name, user_id, order_type, item_details, thumbnail,address_id, quantity, price,online_order, gst,delivery_charges, discount,order_active,created_at,payment,payment_status FROM `user_cart` WHERE order_id = '$order_id' and order_active=1");
		if($q1->num_rows() > 0){
			foreach($q1->result_array() as $row){
				$tmp = array();
				$user_id = $row['user_id'];
				$created_at = $row['created_at'];
				$tmp['name'] = $row['name'];
				$tmp['thumbnail'] = $row['thumbnail'];
				$tmp['item_details'] = $row['item_details'];
				$tmp['individual_price'] = $row['price'];
				$tmp['individual_quantity'] = $row['quantity'];
				$quantity = $row['quantity'];
				$price = $price + $row['price'] * $row['quantity'];
			//	$gst = $gst + $row['gst'];
			    $order_type = $row['order_type'];
			    $online_order = $row['online_order'];
			    $payment = $row['payment'];
			    $payment_status = $row['payment_status'];
			    $address_id = $row['address_id'];
			    $delivery_charges = ($row['order_type'] == 2)?$row['delivery_charges']:0;
				$discount = $discount + ($quantity*$row['discount']/100 * $row['price']);
				$total=$price+$delivery_charges-$discount;
				array_push($response['items'], $tmp);
				
				
			}
		}
		    $response['user_id'] = $user_id;
		    $response['online_order'] = $online_order;
		    $response['payment'] = $payment;
		    $response['payment_status'] = $payment_status;
		    $response['address_id'] = $address_id;
		    $response['created_at'] = $created_at;
		    $response['order_type'] = $order_type;
		    $response['quantity'] = $quantity;
			$response['price'] = $price;
			$response['delivery_charges'] = $delivery_charges;
			$response['discount'] = $discount;
			$response['total']=$total;
		return $response;
	}	
	function getOrderStatus($order_id){
		$response = array();
		if($this->session->userdata('logged_in')['role'] == 'vendor')
			$q1 = $this->db->query("SELECT order_status, created_at FROM user_cart WHERE order_id = '$order_id' and order_active = 1 and vendor_id = '".$this->session->userdata('logged_in')['branch']."'");
		else
			$q1 = $this->db->query("SELECT order_status, created_at FROM user_cart WHERE order_id = '$order_id' and order_active = 1");
		if($q1->num_rows() > 0){
			$row = $q1->result_array()[0];
			$response['status'] = $row['order_status'];
			$response['placed_on'] = $this->DateFromDateTime($row['created_at']);
		}
		return $response;
	}	
	function DateFromDateTime($date){
		$date = new DateTime($date);
		return $date->format('d/m/Y');
	}
	function getAssigned($oid){
	    $id='';
		$q1 = $this->db->query("SELECT * FROM `del_orders` where order_id='$oid'");
		if($q1->num_rows() > 0){
			$result = $q1->result_array()[0];
			//$id = $result['user_id'];	
			$id = $result;
		}
		return $id;
	}
	function getExecutiveDetails($id){
		$response = array();
		if($this->session->userdata('logged_in')['role'] == 'vendor')
			$q1 = $this->db->query("SELECT * FROM `del_users` where id = $id and vendor_id = '".$this->session->userdata('logged_in')['branch']."'");
		else
			$q1 = $this->db->query("SELECT * FROM `del_users` where id=$id");
		if($q1->num_rows() > 0){
			$result = $q1->result_array()[0];
			$response['name'] = $result['name'];
			$response['mobile'] = $result['mobile'];
		}
		return $response;
	}
	function getDeliveryDetails($id){
		$response = array();
		$q1 = $this->db->query("SELECT * FROM `user_addresses` WHERE `id` = '$id' ");
		if($q1->num_rows() > 0){
			$result = $q1->result_array()[0];
			$response['customer_name'] = $result['name'];
			$response['mobile'] = $result['mobile'];
			$response['street'] = $result['street'];
			$response['hno'] = $result['hno'];
			$response['city'] = $result['city'];
			$response['state'] = $result['state'];
			$response['zip'] = $result['zip'];
		}
		return $response;
	}
	function appUser($userid)
	{
		if($this->session->userdata('logged_in')['role'] == 'vendor')
			$q1 = $this->db->query("SELECT * FROM app_users WHERE user_id = $userid and store = '".$this->session->userdata('logged_in')['branch']."'");
		else
			$q1 = $this->db->query("SELECT * FROM app_users WHERE user_id = $userid ");
	    if($q1->num_rows() > 0){
            return $q1->result_array();
	    }
	    else
	    {
	        return false;
	    }
	}
	function fetchitemDetails($id){
		$response = array();
		if($this->session->userdata('logged_in')['role'] == 'vendor')
			$q1 = $this->db->query("SELECT * FROM `restaurant_items` WHERE `item_id` = '$id' and vendor_id = '".$this->session->userdata('logged_in')['branch']."'");
		else
			$q1 = $this->db->query("SELECT * FROM `restaurant_items` WHERE `item_id` = '$id' ");
		if($q1->num_rows() > 0){
			$result = $q1->result_array()[0];
			$response['item_name'] = $result['item_name'];
			$response['item_details'] = $result['item_details'];
			$response['item_img'] = $result['item_img'];
			$response['item_price'] = $result['item_price'];
			$response['discount'] = $result['discount'];
		}
		return $response;
	}
	function fetchorderDetails($id){
		$response = array();
		if($this->session->userdata('logged_in')['role'] == 'vendor')
			$q1 = $this->db->query("SELECT * FROM `user_cart` WHERE `order_id` = '$id' and order_active = 1 and vendor_id = '".$this->session->userdata('logged_in')['branch']."'");
		else
			$q1 = $this->db->query("SELECT * FROM `user_cart` WHERE `order_id` = '$id' and order_active = 1 ");
		if($q1->num_rows() > 0){
			$result = $q1->result_array()[0];
			$response['order_type'] = $result['order_type'];
			$response['user_id'] = $result['user_id'];
			$response['address_id'] = $result['address_id'];
			$response['delivery_charges'] = $result['delivery_charges'];
			$response['delivery_type'] = $result['delivery_type'];
		}
		return $response;
	}
	function getAddressID($id){
		if($this->session->userdata('logged_in')['role'] == 'vendor')
			$q1 = $this->db->query("SELECT address_id FROM `user_cart` where order_id ='$id' and order_active = 1 and vendor_id = '".$this->session->userdata('logged_in')['branch']."'");
		else
			$q1 = $this->db->query("SELECT address_id FROM `user_cart` where order_id ='$id' and order_active = 1");
		if($q1->num_rows() > 0){
			$result = $q1->result_array()[0];
			$address_id = $result['address_id'];
		}
		return $address_id;
	}
	function getRestaurantID($vendor_id){
		$id = 0;
		$q1 = $this->db->query("SELECT rest_id FROM `restaurants`");
		if($q1->num_rows() > 0){
			$result = $q1->result_array()[0];
			$id = $result['rest_id'];
		}
		return $id;
	}
	function getOrdersDashboard($vendor_id){
		$response = array();
		$totalOrders = 0;
		$pendingOrders = 0;
		$processedOrders = 0;
		$completedOrders = 0;
		$cancelledOrders = 0;
		$returnedOrders = 0;
		$picked_up = 0;
		if($this->session->userdata('logged_in')['role'] == 'vendor')
			$q1 = $this->db->query("SELECT order_status FROM user_cart WHERE vendor_id = '".$this->session->userdata('logged_in')['branch']."' and order_active = 1 GROUP BY order_id ");
		elseif($vendor_id == 'all')
			$q1 = $this->db->query("SELECT order_status FROM user_cart WHERE order_active = 1 GROUP BY order_id ");
		else
			$q1 = $this->db->query("SELECT order_status FROM user_cart WHERE vendor_id = '$vendor_id' and order_active = 1 GROUP BY order_id ");
		if($q1->num_rows() > 0){
			foreach($q1->result_array() as $result){
				$status = $result['order_status'];
				$totalOrders++;
				if($status == 1)
					$pendingOrders++;
				else if($status == 2)
					$processedOrders++;
				else if($status == 4)
					$completedOrders++;
				else if($status == 5)
					$cancelledOrders++;
				else if($status == 6)
					$returnedOrders++;
				else if($status == 3)
					$picked_up++;
			}
		}
		$response['total_orders'] = $totalOrders;
		$response['pending_orders'] = $pendingOrders;
		$response['processed_orders'] = $processedOrders;
		$response['completed_orders'] = $completedOrders;
		$response['cancelled_orders'] = $cancelledOrders;
		$response['returned_orders'] = $returnedOrders;
		$response['picked_up'] = $picked_up;
		return $response;
	}
	function getTodayOrdersDashboard($vendor_id, $from, $to){
		$response = array();
		$totalOrders = 0;
		$pendingOrders = 0;
		$processedOrders = 0;
		$completedOrders = 0;
		$cancelledOrders = 0;
		$returnedOrders = 0;
		$picked_up = 0;
		if($this->session->userdata('logged_in')['role'] == 'vendor')
			$q1 = $this->db->query("SELECT order_status FROM user_cart WHERE vendor_id = '".$this->session->userdata('logged_in')['branch']."' AND order_active = 1 AND  created_at BETWEEN '$from' AND '$to' GROUP BY order_id ");
		elseif($vendor_id == 'all')
			$q1 = $this->db->query("SELECT order_status FROM user_cart WHERE order_active = 1 AND  created_at BETWEEN '$from' AND '$to' GROUP BY order_id ");
		else
			$q1 = $this->db->query("SELECT order_status FROM user_cart WHERE vendor_id = '$vendor_id' AND order_active = 1 AND  created_at BETWEEN '$from' AND '$to' GROUP BY order_id ");
		if($q1->num_rows() > 0){
			foreach($q1->result_array() as $result){
				$status = $result['order_status'];
				$totalOrders++;
				if($status == 1)
					$pendingOrders++;
				else if($status == 2)
					$processedOrders++;
				else if($status == 4)
					$completedOrders++;
				else if($status == 5)
					$cancelledOrders++;
				else if($status == 6)
					$returnedOrders++;
				else if($status == 3)
					$picked_up++;
			}
		}
		$response['total_orders'] = $totalOrders;
		$response['pending_orders'] = $pendingOrders;
		$response['processed_orders'] = $processedOrders;
		$response['completed_orders'] = $completedOrders;
		$response['cancelled_orders'] = $cancelledOrders;
		$response['returned_orders'] = $returnedOrders;
		$response['picked_up'] = $picked_up;
		return $response;
	}
	function getVendorName($id){
		$name = "";
		if($this->session->userdata('logged_in')['role'] == 'vendor')
			$q1 = $this->db->query("SELECT `fullname` from `admin` where `branch` = '".$this->session->userdata('logged_in')['branch']."'");
		else
			$q1 = $this->db->query("SELECT `fullname` from `admin` where `branch` = '$id' ");
		if($q1->num_rows() > 0){
			$result = $q1->result_array()[0];
			$name = $result['fullname'];
		}
		return $name;
	}
	function userCart($vendor_id, $from = NULL, $to = NULL)
	{
		if($this->session->userdata('logged_in')['role'] == 'vendor'){
			if($from != NULL && $to != NULL)
				$q1 = $this->db->query("SELECT u.product_id, SUM(u.quantity) as top_quantity, r.item_name FROM user_cart as u INNER JOIN restaurant_items as r ON r.item_id = u.product_id WHERE u.vendor_id = '".$this->session->userdata('logged_in')['branch']."' and u.order_active = 1 and u.created_at >= '$from' and u.created_at <= '$to' GROUP BY u.product_id ORDER BY top_quantity DESC LIMIT 20 ");
			else
				$q1 = $this->db->query("SELECT u.product_id, SUM(u.quantity) as top_quantity, r.item_name FROM user_cart as u INNER JOIN restaurant_items as r ON r.item_id = u.product_id WHERE u.vendor_id = '".$this->session->userdata('logged_in')['branch']."' and u.order_active = 1 GROUP BY u.product_id ORDER BY top_quantity DESC LIMIT 20 ");
		}
		elseif($vendor_id == 'all'){
			if($from != NULL && $to != NULL)
				$q1 = $this->db->query("SELECT u.product_id, SUM(u.quantity) as top_quantity, r.item_name FROM user_cart as u INNER JOIN restaurant_items as r ON r.item_id = u.product_id WHERE u.order_active = 1 and u.created_at >= '$from' and u.created_at <= '$to' GROUP BY u.product_id ORDER BY top_quantity DESC LIMIT 20 ");
			else
				$q1 = $this->db->query("SELECT u.product_id, SUM(u.quantity) as top_quantity, r.item_name FROM user_cart as u INNER JOIN restaurant_items as r ON r.item_id = u.product_id WHERE u.order_active = 1 GROUP BY u.product_id ORDER BY top_quantity DESC LIMIT 20 ");
		}
		else{
			if($from != NULL && $to != NULL)
				$q1 = $this->db->query("SELECT u.product_id, SUM(u.quantity) as top_quantity, r.item_name FROM user_cart as u INNER JOIN restaurant_items as r ON r.item_id = u.product_id WHERE u.vendor_id='$vendor_id' and u.order_active = 1 and u.created_at >= '$from' and u.created_at <= '$to' GROUP BY u.product_id ORDER BY top_quantity DESC LIMIT 20 ");
			else
				$q1 = $this->db->query("SELECT u.product_id, SUM(u.quantity) as top_quantity, r.item_name FROM user_cart as u INNER JOIN restaurant_items as r ON r.item_id = u.product_id WHERE u.vendor_id='$vendor_id' and u.order_active = 1 GROUP BY u.product_id ORDER BY top_quantity DESC LIMIT 20 ");
		}
		if($q1->num_rows() > 0)
		{
            return $q1->result_array();
	    }
	    else
	    {
	        return false;
	    }
	}
	function userCartCompleted($vendor_id)
	{
		if($this->session->userdata('logged_in')['role'] == 'vendor')
			$q1 = $this->db->query("SELECT u.price, u.order_id, u.quantity, u.gst, u.discount, u.delivery_charges, u.order_status FROM user_cart as u WHERE u.order_status = '4' and u.vendor_id = '".$this->session->userdata('logged_in')['branch']."' and u.order_active = 1");
		elseif($vendor_id == 'all')
			$q1 = $this->db->query("SELECT u.price, u.order_id, u.quantity, u.gst, u.discount, u.delivery_charges, u.order_status FROM user_cart as u WHERE u.order_status = '4' and u.order_active = 1 ");
		else
			$q1 = $this->db->query("SELECT u.price, u.order_id, u.quantity, u.gst, u.discount, u.delivery_charges, u.order_status FROM user_cart as u WHERE u.order_status = '4' and u.vendor_id='$vendor_id' and u.order_active = 1 ");
		if($q1->num_rows() > 0)
		{
            return $q1->result_array();
	    }
	    else
	    {
	        return false;
	    }
	}
	function userCartTodayCompleted($vendor_id, $from, $to)
	{
		if($this->session->userdata('logged_in')['role'] == 'vendor')
			$q1 = $this->db->query("SELECT u.price, u.order_id, u.quantity, u.gst, u.discount, u.delivery_charges, u.order_status FROM user_cart as u WHERE u.order_status = '4' and u.created_at >= '$from' and u.created_at <= '$to' and u.vendor_id = '".$this->session->userdata('logged_in')['branch']."' and u.order_active = 1");
		elseif($vendor_id == 'all')
			$q1 = $this->db->query("SELECT u.price, u.order_id, u.quantity, u.gst, u.discount, u.delivery_charges, u.order_status FROM user_cart as u WHERE u.order_status = '4' and u.created_at >= '$from' and u.created_at <= '$to' and u.order_active = 1 ");
		else
			$q1 = $this->db->query("SELECT u.price, u.order_id, u.quantity, u.gst, u.discount, u.delivery_charges, u.order_status FROM user_cart as u WHERE u.order_status = '4' and u.created_at >= '$from' and u.created_at <= '$to' and u.vendor_id='$vendor_id' and u.order_active = 1 ");
		if($q1->num_rows() > 0)
		{
            return $q1->result_array();
	    }
	    else
	    {
	        return false;
	    }
	}
	function store($status)
	{
		if($this->session->userdata('logged_in')['role'] == 'vendor')
		{
			if($status == '1')
			{
				$this->db->query("UPDATE `restaurants` SET `availability` = '0' where `rest_id` = '".$this->session->userdata('logged_in')['branch']."'");
				return '2';
			}
			else
			{
				$this->db->query("UPDATE `restaurants` SET `availability` = '1' where `rest_id` = '".$this->session->userdata('logged_in')['branch']."'");
				return '1';
			}
		}
		else
			return '';
	}

    public function notifications()
	{
	    $from = date('Y-m-d 00:00:00');
	    $to = date('Y-m-d 23:59:59');
		if($this->session->userdata('logged_in')['role'] == 'vendor')
			$q1 = $this->db->query("SELECT * FROM `user_cart` WHERE notification_status=0 and order_status=1 and online_order=0 and created_at BETWEEN '$from' AND '$to' AND `vendor_id` = '".$this->session->userdata('logged_in')['branch']."' GROUP BY order_id ORDER BY created_at DESC LIMIT 4");
		else
			$q1 = $this->db->query("SELECT * FROM `user_cart` WHERE notification_status=0 and order_status=1 and online_order=0 and created_at BETWEEN '$from' AND '$to' GROUP BY order_id ORDER BY created_at DESC LIMIT 4");
		if($q1->num_rows() > 0)
		{
            return $q1->result_array();
	    }
	    else
	    {
	        return false;
	    }
	}
	public function notifications_count()
	{
	    $from = date('Y-m-d 00:00:00');
	    $to = date('Y-m-d 23:59:59');
		if($this->session->userdata('logged_in')['role'] == 'vendor')
			$q1 = $this->db->query("SELECT count(order_id) as overall FROM `user_cart` WHERE notification_status=0 and order_status=1 and online_order=0 and created_at BETWEEN '$from' AND '$to' AND `vendor_id` = '".$this->session->userdata('logged_in')['branch']."' GROUP BY order_id ORDER BY created_at DESC");
		else
			$q1 = $this->db->query("SELECT count(order_id) as overall FROM `user_cart` WHERE notification_status=0 and order_status=1 and online_order=0 and created_at BETWEEN '$from' AND '$to' GROUP BY order_id ORDER BY created_at DESC");
		if($q1->num_rows() > 0)
		{
            $res = $q1->result_array();
            $notify_count = count($res);
            return $notify_count;
	    }
	    else
	    {
	        return false;
	    }
	}
	function itemWiseReport($vendor_id, $status = '4', $from, $to)
	{
		if($this->session->userdata('logged_in')['role'] == 'vendor')
			$q1 = $this->db->query("SELECT r.rest_name, u.product_id, u.quantity, u.name, i.item_type, u.price, u.gst, u.discount, u.delivery_charges, u.item_details, u.created_at FROM user_cart as u INNER JOIN restaurants as r ON r.rest_id = u.vendor_id INNER JOIN restaurant_items as i ON i.item_id = u.product_id WHERE u.vendor_id = '".$this->session->userdata('logged_in')['branch']."' and u.order_active = 1 and u.order_status = $status and u.created_at BETWEEN '$from' AND '$to' ORDER BY c_id DESC ");
		elseif($vendor_id == 'all')
			$q1 = $this->db->query("SELECT r.rest_name, u.product_id, u.quantity, u.name, i.item_type, u.price, u.gst, u.discount, u.delivery_charges, u.item_details, u.created_at FROM user_cart as u INNER JOIN restaurants as r ON r.rest_id = u.vendor_id INNER JOIN restaurant_items as i ON i.item_id = u.product_id WHERE u.order_active = 1 and u.order_status = $status and u.created_at BETWEEN '$from' AND '$to' ORDER BY c_id DESC ");
		else
			$q1 = $this->db->query("SELECT r.rest_name, u.product_id, u.quantity, u.name, i.item_type, u.price, u.gst, u.discount, u.delivery_charges, u.item_details, u.created_at FROM user_cart as u INNER JOIN restaurants as r ON r.rest_id = u.vendor_id INNER JOIN restaurant_items as i ON i.item_id = u.product_id WHERE u.vendor_id='$vendor_id' and u.order_active = 1 and u.order_status = $status and u.created_at BETWEEN '$from' AND '$to' ORDER BY c_id DESC ");
		//print_r($this->db->last_query());
		if($q1->num_rows() > 0)
		{
            return $q1->result_array();
	    }
	    else
	    {
	        return false;
	    }
	}
	function vendorWiseReport($vendor_id, $status, $from, $to)
	{
		if($this->session->userdata('logged_in')['role'] == 'vendor')
			$q1 = $this->db->query("SELECT r.rest_name, u.vendor_id, COUNT(*) as top FROM user_cart as u INNER JOIN restaurants as r ON r.rest_id = u.vendor_id WHERE u.vendor_id = '".$this->session->userdata('logged_in')['branch']."' and u.order_active = 1 and u.order_status = $status and u.created_at BETWEEN '$from' AND '$to' GROUP BY vendor_id LIMIT 10 ");
		elseif($vendor_id == 'all')
			$q1 = $this->db->query("SELECT r.rest_name, u.vendor_id, COUNT(*) as top FROM user_cart as u INNER JOIN restaurants as r ON r.rest_id = u.vendor_id WHERE u.order_active = 1 and u.order_status = $status and u.created_at BETWEEN '$from' AND '$to' GROUP BY vendor_id LIMIT 10 ");
		else
			$q1 = $this->db->query("SELECT r.rest_name, u.vendor_id, COUNT(*) as top FROM user_cart as u INNER JOIN restaurants as r ON r.rest_id = u.vendor_id WHERE u.vendor_id='$vendor_id' and u.order_active = 1 and u.order_status = $status and u.created_at BETWEEN '$from' AND '$to' GROUP BY vendor_id LIMIT 10 ");
		//print_r($this->db->last_query());
		if($q1->num_rows() > 0)
		{
            return $q1->result_array();
	    }
	    else
	    {
	        return false;
	    }
	}
	function vendorWiseSaleProduct($vendor_id, $status, $from = NULL, $to = NULL)
	{
		if($this->session->userdata('logged_in')['role'] == 'vendor'){
			if($from != NULL && $to != NULL)
				$q1 = $this->db->query("SELECT u.product_id, SUM(u.quantity) as top_quantity, r.item_name FROM user_cart as u INNER JOIN restaurant_items as r ON r.item_id = u.product_id WHERE u.vendor_id = '".$this->session->userdata('logged_in')['branch']."' and u.order_active = 1 and u.order_status = $status and u.created_at >= '$from' and u.created_at <= '$to' GROUP BY u.product_id ORDER BY top_quantity DESC LIMIT 10 ");
			else
				$q1 = $this->db->query("SELECT u.product_id, SUM(u.quantity) as top_quantity, r.item_name FROM user_cart as u INNER JOIN restaurant_items as r ON r.item_id = u.product_id WHERE u.vendor_id = '".$this->session->userdata('logged_in')['branch']."' and u.order_active = 1 and u.order_status = $status GROUP BY u.product_id ORDER BY top_quantity DESC LIMIT 10 ");
		}
		elseif($vendor_id == 'all'){
			if($from != NULL && $to != NULL)
				$q1 = $this->db->query("SELECT u.product_id, SUM(u.quantity) as top_quantity, r.item_name FROM user_cart as u INNER JOIN restaurant_items as r ON r.item_id = u.product_id WHERE u.order_active = 1 and u.order_status = $status and u.created_at >= '$from' and u.created_at <= '$to' GROUP BY u.product_id ORDER BY top_quantity DESC LIMIT 10 ");
			else
				$q1 = $this->db->query("SELECT u.product_id, SUM(u.quantity) as top_quantity, r.item_name FROM user_cart as u INNER JOIN restaurant_items as r ON r.item_id = u.product_id WHERE u.order_active = 1 and u.order_status = $status GROUP BY u.product_id ORDER BY top_quantity DESC LIMIT 10 ");
		}
		else{
			if($from != NULL && $to != NULL)
				$q1 = $this->db->query("SELECT u.product_id, SUM(u.quantity) as top_quantity, r.item_name FROM user_cart as u INNER JOIN restaurant_items as r ON r.item_id = u.product_id WHERE u.vendor_id='$vendor_id' and u.order_active = 1 and u.order_status = $status and u.created_at >= '$from' and u.created_at <= '$to' GROUP BY u.product_id ORDER BY top_quantity DESC LIMIT 10 ");
			else
				$q1 = $this->db->query("SELECT u.product_id, SUM(u.quantity) as top_quantity, r.item_name FROM user_cart as u INNER JOIN restaurant_items as r ON r.item_id = u.product_id WHERE u.vendor_id='$vendor_id' and u.order_active = 1 and u.order_status = $status GROUP BY u.product_id ORDER BY top_quantity DESC LIMIT 10 ");
		}
		if($q1->num_rows() > 0)
		{
            return $q1->result_array();
	    }
	    else
	    {
	        return false;
	    }
	}
	function branchWiseDeliveryCharges($vendor_id, $status, $from, $to)
	{
		if($this->session->userdata('logged_in')['role'] == 'vendor')
			$q1 = $this->db->query("SELECT r.rest_name as branch, u.vendor_id, u.delivery_charges FROM user_cart as u INNER JOIN restaurants as r ON r.rest_id = u.vendor_id WHERE u.vendor_id = '".$this->session->userdata('logged_in')['branch']."' and u.order_active = 1 and u.order_status = $status and u.created_at BETWEEN '$from' AND '$to' GROUP BY order_id ");
		elseif($vendor_id == 'all')
			$q1 = $this->db->query("SELECT r.rest_name as branch, u.vendor_id, u.delivery_charges FROM user_cart as u INNER JOIN restaurants as r ON r.rest_id = u.vendor_id WHERE u.order_active = 1 and u.order_status = $status and u.created_at BETWEEN '$from' AND '$to' GROUP BY order_id  ");
		else
			$q1 = $this->db->query("SELECT r.rest_name as branch, u.vendor_id, u.delivery_charges FROM user_cart as u INNER JOIN restaurants as r ON r.rest_id = u.vendor_id WHERE u.vendor_id='$vendor_id' and u.order_active = 1 and u.order_status = $status and u.created_at BETWEEN '$from' AND '$to' GROUP BY order_id ");
		//print_r($this->db->last_query());
		if($q1->num_rows() > 0)
		{
            return $q1->result_array();
	    }
	    else
	    {
	        return false;
	    }
	}
	function userWiseReport($vendor_id, $status = '4', $from, $to)
	{
		if($this->session->userdata('logged_in')['role'] == 'vendor')
			$q1 = $this->db->query("SELECT r.rest_name, u.order_id, u.payment, u.vendor_id, u.product_id, u.user_id, u.quantity, u.name, u.price, u.gst, u.discount, u.delivery_charges FROM user_cart as u INNER JOIN restaurants as r ON r.rest_id = u.vendor_id WHERE u.vendor_id = '".$this->session->userdata('logged_in')['branch']."' and u.order_active = 1 and u.order_status = $status and u.created_at BETWEEN '$from' AND '$to' ORDER BY c_id DESC ");
		elseif($vendor_id == 'all')
			$q1 = $this->db->query("SELECT r.rest_name, u.order_id, u.payment, u.vendor_id, u.product_id, u.user_id, u.quantity, u.name, u.price, u.gst, u.discount, u.delivery_charges FROM user_cart as u INNER JOIN restaurants as r ON r.rest_id = u.vendor_id WHERE u.order_active = 1 and u.order_status = $status and u.created_at BETWEEN '$from' AND '$to' ORDER BY c_id DESC ");
		else
			$q1 = $this->db->query("SELECT r.rest_name, u.order_id, u.payment, u.vendor_id, u.product_id, u.user_id, u.quantity, u.name, u.price, u.gst, u.discount, u.delivery_charges FROM user_cart as u INNER JOIN restaurants as r ON r.rest_id = u.vendor_id WHERE u.vendor_id='$vendor_id' and u.order_active = 1 and u.order_status = $status and u.created_at BETWEEN '$from' AND '$to' ORDER BY c_id DESC ");
		//print_r($this->db->last_query());
		if($q1->num_rows() > 0)
		{
            return $q1->result_array();
	    }
	    else
	    {
	        return false;
	    }
	}
}

?>