<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Orders extends CI_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->model('get');
		$this->load->model('insert');
	}
	public function index()
	{
		if(isset($_GET['user_id']) && ($_GET['user_id'] != ''))
		{
		    $userid = $_GET['user_id'];
		    
		    $resultres = $this->get->getstore($userid);
        	if($resultres != false)
    		    {
    		      $storeId = $resultres[0]->store;
                }
            $resultven = $this->get->getvendor($storeId);
            if($resultven != false)
        		{
            	  $rest_id = $resultven[0]->rest_id;
        	    }		   
    		    
			$result = $this->get->getOrders($userid,'all',$rest_id);
			if($result != false) 
			{
				$data['status'] = "200";
        		$data['message'] = "success";
        		foreach($result as $products)
        		{
        		    $siteUrl = base_url('orders/status').'?oid='.$products->order_id.'&user_id='.$userid;
        		    $deliveryCharges = $products->delivery_charges;
        		    $orderType = ($products->order_type == 1) ? 'Pickup' : 'Delivery';
					$paymentStatus = $products->payment_status;
					$txtId = $products->txt_id;
					$paymentType = ($products->payment == '') ? 'COD' : 'Online';
        		    switch ($products->order_status)
        		    {
        		        case "1":
                            $orderStatus = "Pending";
                            break;
                        case "2":
                            $orderStatus = "Accepted";
                            break;
                        case "4":
                            $orderStatus = "Completed";
                            break;
                        case "5":
                            $orderStatus = "Cancelled";
                            break;
                        case "6":
                            $orderStatus = "Returned";
                            break;
                        default:
                            $orderStatus = "Pending";
        		    }
        		    $priceTotal = 0;
        		    $orderItems = $this->get->orders($userid,$products->order_id);
        		    $orderItems = ($this->get->orders($userid,$products->order_id) != false)?$this->get->orders($userid,$products->order_id):array();
        		    if($orderItems != '')
        		    {
        		        foreach($orderItems as $items)
        		        {
                		    $quanPrice = $items->cartCount*$items->price_total;
                		    $priceTotal = ($quanPrice-($quanPrice*$items->discount)/100)+$priceTotal;
        		        }
        		    }
                    $orderImages = ($this->get->table('order_images', array('order_id' => $products->order_id, 'status' => '1'), 'image') != false)?$this->get->table('order_images', array('order_id' => $products->order_id, 'status' => '1'), 'CONCAT("'.base_url().'","../uploads/",`image`) as image'):array();
					$orderCancel = base_url('orders/cancel?orderId='.$products->order_id.'&user_id='.$_GET['user_id']);
					$orderFeedback = base_url('orders/status').'?oid='.$products->order_id.'&user_id='.$userid;
                    $feedback = ($this->get->table('order_feedback',array("order_id" =>$products->order_id, "user_id" => $userid)) != false)?1:0;
        		    $data['data'][] = array("orderId" => $products->order_id, "order_total" => $priceTotal+$deliveryCharges, "orderDate" => $products->created_at, "orderType" => $orderType, "orderStatus" => $orderStatus, "orderItems" => $orderItems, "orderImages" => $orderImages, "paymentStatus" => $paymentStatus, "txtId" => $txtId, "paymentType" => $paymentType, "orderCancel" => $orderCancel, "orderFeedback" => $orderFeedback, "feedback" => $feedback);
        		}
			}
			else
			{
    		    $data['status'] = "200";
        		$data['message'] = "success";
                $data['data'][] = array();
			}
		}
		else
		{
		    $data['status'] = "500";
        	$data['message'] = "error";
            $data['data'][] = array("alert" => "Userid required");
		}
    	$encode = json_encode($data);
    	echo $encode;
	}
	public function status()
	{
		if(isset($_GET['user_id']) && ($_GET['user_id'] != '') && isset($_GET['oid']) && ($_GET['oid'] != ''))
		{
		    $userid = $_GET['user_id'];
		    	
		    $resultres = $this->get->getstore($userid);
        	if($resultres != false)
    		    {
    		      $storeId = $resultres[0]->store;
                }
            $resultven = $this->get->getvendor($storeId);
            if($resultven != false)
        		{
            	  $rest_id = $resultven[0]->rest_id;
        	    }	    
    		    
		    $oid = $_GET['oid'];
		    $result = $this->get->getOrders($userid,$oid,$rest_id);
			if($result != false) 
			{
				$data['status'] = "200";
        		$data['message'] = "success";
        		foreach($result as $products)
        		{
        		    $siteUrl = base_url('orders/status').'?oid='.$products->order_id.'&user_id='.$userid;
        		    $deliveryCharges = $products->delivery_charges;
        		    $orderType = ($products->order_type == 1) ? 'Pickup' : 'Delivery';
        		    switch ($products->order_status)
        		    {
        		        case "1":
                            $orderStatus = "Pending";
                            break;
                        case "2":
                            $orderStatus = "Accepted";
                            break;
                        case "4":
                            $orderStatus = "Completed";
                            break;
                        case "5":
                            $orderStatus = "Cancelled";
                            break;
                        case "6":
                            $orderStatus = "Returned";
                            break;
                        default:
                            $orderStatus = "Pending";
        		    }
        		    $priceTotal = 0;
        		    $address = ($this->get->address($userid,$products->address_id) != false)?$this->get->address($userid,$products->address_id):array();
        		    $orderItems = ($this->get->orders($userid,$products->order_id) != false)?$this->get->orders($userid,$products->order_id):array();
        		    if($orderItems != '')
        		    {
        		        foreach($orderItems as $items)
        		        {
                		    $quanPrice = $items->cartCount*$items->price_total;
                		    $priceTotal = ($quanPrice-($quanPrice*$items->discount)/100)+$priceTotal;
        		        }
        		    }
        		    $data['data'][] = array("orderDetails" => array(array("orderId" => $products->order_id, "order_total" => $priceTotal+$deliveryCharges, "orderDate" => $products->created_at, "orderType" => $orderType, "orderStatus" => $orderStatus, "orderItems" => $orderItems)), "address" => $address);
        		}
			}
			else
			{
    		    $data['status'] = "200";
        		$data['message'] = "success";
                $data['data'][] = array();
			}
		}
		else
		{
		    $data['status'] = "500";
        	$data['message'] = "error";
            $data['data'][] = array("alert" => "Userid required");
		}
    	$encode = json_encode($data);
    	echo $encode;
	}
	public function place()
	{
		$_POST = json_decode(file_get_contents('php://input'), true);
	    //print_r($_POST);
	    $storeId;
	    
		if(isset($_POST['user_id']) && ($_POST['user_id'] != ''))
		{
	        $date = date('Y-m-d H:i:s');
	        $number = count($this->get->orders('all','all'))+1;
	        $orderid = 'F2H'.sprintf('%06d',$number);
    		$ordertype = $_POST['orderType'];
    		$userid = $_POST['user_id'];
    		
    		
        	$resultres = $this->get->getstore($userid);
        	if($resultres != false)
    		    {
    		      $storeId = $resultres[0]->store;
                }
            $resultven = $this->get->getvendor($storeId);
            if($resultven != false)
        		{
            	  $rest_id = $resultven[0]->rest_id;
        	    }
    		
    		$addressid = $_POST['addressId'];
    		$tprice = '0';
	        foreach($_POST['Items'] as $orders)
	        {
    	        $name = $orders['title'];
    	        $itemid = $orders['id'];
    	        $weight = $orders['weight'];
    	        $quantity = $orders['cartCount'];
    	        $image = $orders['imageURL'];
    	        $price = $orders['price_unit'];
    	        $discount = $orders['discount'];
    	        $deliveryCharges = ($ordertype == 1)?'0':$orders['deliveryCharges'];
    			$insert = array(
    				'order_id' => $orderid,
    				'order_type' => $ordertype,
    				'user_id' => $userid,
    				'address_id' => $addressid,
    				"vendor_id" => $rest_id,
    				'product_id' => $itemid,
    				'name' => $name,
    				'item_details' => $weight,
    				'thumbnail' => $image,
    				'quantity' => $quantity,
    				'price' => $price,
    				'gst' => '0',
    				'discount' => $discount,
    				'delivery_charges' => $deliveryCharges,
    				'order_status' => '1',
    				'created_at' => $date
    			);
    			$result = $this->insert->orders($insert);
    			$tprice = $tprice + ($price-($price*$discount/100))*$quantity;
    			if($result == true)
    			    $status = true;
	        } 
			if ($status === true) 
			{
                $coupon_data = array(
    				'order_id' => $orderid,
    				'user_id' => $userid,
    				"vendor_id" => $rest_id,
					'coupon' => (isset($_POST['coupon']) && !empty($_POST['coupon']))?json_encode($_POST['coupon']):'',
					'coupon_code' => (isset($_POST['coupon_code']) && !empty($_POST['coupon_code']))?$_POST['coupon_code']:'',
					'coupon_amount' => (isset($_POST['coupon_amount']) && !empty($_POST['coupon_amount']))?$_POST['coupon_amount']:'0',
    				'created_at' => $date
    			);
                if(isset($_POST['coupon_code']) && !empty($_POST['coupon_code']))
                    $coupon = $this->insert->table('order_coupons',$coupon_data);
			    $totaldiscount = $tprice;
			    $totalprice = $totaldiscount+$deliveryCharges;
                //$address = $this->get->address($userid,$addressid);
                $user = $this->get->users($userid);
                // Customer Message
                $phone = $user[0]->mobile;
                $adminphone = '8340891732';
                $adminphone2 = '7013345316';
            	if($ordertype == 2)
            	{
                $message = "Thanks for your order. Your order will be delivered in 24 hours. Your order ID: ".$orderid.". Your Total Amount: ".$totalprice.". call@ 8340891732, 9030662999."; 
                  /*        $message = "Hello Foodly Users, We are closed today due to Technical Issue. Call us for more details: 8008460888, 8008470888."; */  
                }
                else
                {
                    $message = "";
                //  $message = "Thanks for your order. Please collect your order in 24 hours from F2H store. Your order ID: ".$orderid.". Your Total Amount: ".$totalprice.". call@8340891732, 9030662999."; 
            		   /*    $message = "Hello Foodly Users, We are closed today due to Technical Issue. Call us for more details: 8008460888, 8008470888.";  */
                }  
				$this->bulksms->index($phone,$message);
            	// Admin Message
				$message = "New order received. Order ID: ".$orderid.". Customer Mobile No: ".$phone;
				$this->bulksms->index($adminphone,$message);
                $this->bulksms->index($adminphone2,$message);
    		    $data['status'] = "200";
        		$data['message'] = "success";
        		
                // $data['data'][] = array("alert" => "Sorry for your inconvenience, We are closed today due to Technical Issue");
                $data['data'][] = array("alert" => "Success! Your order has been placed successfully");
			}
			else
			{
    		    $data['status'] = "500";
        		$data['message'] = "error";
                $data['data'][] = array("alert" => "Please try again");
			} 
		}
		else
		{
		    $data['status'] = "500";
        	$data['message'] = "error";
            $data['data'][] = array("alert" => "Userid required");
		}
    	$encode = json_encode($data);
    	echo $encode;
	}
	public function confirm()
	{
		$_POST = json_decode(file_get_contents('php://input'), true);
	    //print_r($_POST);
		$storeId;
	    
		if(isset($_POST['user_id']) && ($_POST['user_id'] != ''))
		{
	        $date = date('Y-m-d H:i:s');
	        $number = count($this->get->orders('all','all'))+1;
	        $orderid = 'F2H'.sprintf('%06d',$number);
    		$ordertype = $_POST['orderType'];
    		$userid = $_POST['user_id'];
    		
    		
        	$resultres = $this->get->getstore($userid);
        	if($resultres != false)
    		    {
    		      $storeId = $resultres[0]->store;
                }
            $resultven = $this->get->getvendor($storeId);
            if($resultven != false)
        		{
            	  $rest_id = $resultven[0]->rest_id;
        	    }
    		
    		$addressid = $_POST['addressId'];
    		$tprice = '0';
	        foreach($_POST['Items'] as $orders)
	        {
    	        $name = $orders['title'];
    	        $itemid = $orders['id'];
    	        $weight = $orders['weight'];
    	        $quantity = $orders['cartCount'];
    	        $image = $orders['imageURL'];
    	        $price = $orders['price_unit'];
    	        $discount = $orders['discount'];
    	        $deliveryCharges = ($ordertype == 1)?'0':$orders['deliveryCharges'];
    			$insert = array(
    				'order_id' => $orderid,
    				'order_type' => $ordertype,
    				'user_id' => $userid,
    				'address_id' => $addressid,
    				"vendor_id" => $rest_id,
    				'product_id' => $itemid,
    				'name' => $name,
    				'item_details' => $weight,
    				'thumbnail' => $image,
    				'quantity' => $quantity,
    				'price' => $price,
    				'gst' => '0',
    				'discount' => $discount,
    				'delivery_charges' => $deliveryCharges,
    				'order_status' => '1',
					'payment' => json_encode($_POST['payment']),
					'payment_status' => (isset($_POST['payment']) && !empty($_POST['payment'][0]['paymentId']))?'Success':'Cancelled',
					'txt_id' => (isset($_POST['payment']) && !empty($_POST['payment'][0]['paymentId']))?$_POST['payment'][0]['paymentId']:'',
    				'created_at' => $date
    			);
    			$result = $this->insert->orders($insert);
    			$tprice = $tprice + ($price-($price*$discount/100))*$quantity;
    			if($result == true)
    			    $status = true;
	        } 
			if ($status === true) 
			{
                $coupon_data = array(
    				'order_id' => $orderid,
    				'user_id' => $userid,
    				"vendor_id" => $rest_id,
					'coupon' => (isset($_POST['coupon']) && !empty($_POST['coupon']))?json_encode($_POST['coupon']):'',
					'coupon_code' => (isset($_POST['coupon_code']) && !empty($_POST['coupon_code']))?$_POST['coupon_code']:'',
					'coupon_amount' => (isset($_POST['coupon_amount']) && !empty($_POST['coupon_amount']))?$_POST['coupon_amount']:'0',
    				'created_at' => $date
    			);
                if(isset($_POST['coupon_code']) && !empty($_POST['coupon_code']))
                    $coupon = $this->insert->table('order_coupons',$coupon_data);
			    $totaldiscount = $tprice;
			    $totalprice = $totaldiscount+$deliveryCharges;
                //$address = $this->get->address($userid,$addressid);
                $user = $this->get->users($userid);
                // Customer Message
                $phone = $user[0]->mobile;
                $adminphone = '8340891732';
            	if($ordertype == 2)
            	{
                $message = "Thanks for your order. Your order will be delivered in 24 hours. Your order ID: ".$orderid.". Your Total Amount: ".$totalprice.". call@ 8340891732, 9030662999."; 
                  /*        $message = "Hello Foodly Users, We are closed today due to Technical Issue. Call us for more details: 8008460888, 8008470888."; */  
                }
                else
                {
                    $message = "";
                //  $message = "Thanks for your order. Please collect your order in 24 hours from F2H store. Your order ID: ".$orderid.". Your Total Amount: ".$totalprice.". call@8340891732, 9030662999."; 
            		   /*    $message = "Hello Foodly Users, We are closed today due to Technical Issue. Call us for more details: 8008460888, 8008470888.";  */
                }    
				$this->bulksms->index($phone,$message);
            	// Admin Message
				//$message = "New order received. Order ID: ".$orderid.". Customer Mobile No: ".$phone;
				//$this->bulksms->index($adminphone,$message);
    		    $data['status'] = "200";
        		$data['message'] = "success";
        		
                // $data['data'][] = array("alert" => "Sorry for your inconvenience, We are closed today due to Technical Issue");
                $data['data'][] = array("alert" => "Success! Your order has been placed successfully");
			}
			else
			{
    		    $data['status'] = "500";
        		$data['message'] = "error";
                $data['data'][] = array("alert" => "Please try again");
			} 
		}
		else
		{
		    $data['status'] = "500";
        	$data['message'] = "error";
            $data['data'][] = array("alert" => "Userid required");
		}
    	$encode = json_encode($data);
    	echo $encode;
	} 
	public function cancel(){
		if(isset($_GET['user_id']) && $_GET['user_id'] != '' && isset($_GET['orderId']) && $_GET['orderId'] != ''){
			$update = $this->get->updateTable('user_cart',array('user_id' => $_GET['user_id'], 'order_id' => $_GET['orderId']),array('order_status' => '5'));
			if($update == true){
				$data['status'] = "200";
				$data['message'] = "success";
				$data['data'][] = array("alert" => "Successfully deleted!");
			}
			else{
				$data['status'] = "500";
				$data['message'] = "error";
				$data['data'][] = array("alert" => "Please try again");
			}
		}
		else{
		    $data['status'] = "500";
        	$data['message'] = "error";
            $data['data'][] = array("alert" => "Userid required");
		}
    	$encode = json_encode($data);
    	echo $encode;
	}
	public function feedback()
	{
		$_POST = json_decode(file_get_contents('php://input'), true);
	    if(isset($_POST['user_id']) && $_POST['user_id'] != '')
		{
	        $date = date('Y-m-d H:i:s');
			$userid = $_POST['user_id'];
			$p = [];
			$items = $this->get->table_in('user_cart','name','c_id',explode(',',$_POST['cart_ids']));
			foreach($items as $item):$p[] = $item['name'];endforeach;
    		$insert = array(
    			'order_id' => $_POST['order_id'],
    			'user_id' => $userid,
    			'vendor_id' => $_POST['locationId'],
    			'cart_ids' => $_POST['cart_ids'],
				'items' => implode(',',$p),
    			'rating' => $_POST['rating'],
    			'note' => $_POST['note'],
    			'created_at' => $date
    		);
    		$result = $this->insert->order_feedback($insert);
			if ($result === true) 
			{
                $user = $this->get->users($userid);
                // Customer Message
				//$message = "New order received. Order ID: ".$orderid.". Customer Mobile No: ".$phone;
                $phone = $user[0]->mobile;   
				//$this->bulksms->index($phone,$message);
    		    $data['status'] = "200";
        		$data['message'] = "success";
                $data['data'][] = array("alert" => "Successfully submitted!");
			}
			else
			{
    		    $data['status'] = "500";
        		$data['message'] = "error";
                $data['data'][] = array("alert" => "Please try again");
			} 
		}
		else
		{
		    $data['status'] = "500";
        	$data['message'] = "error";
            $data['data'][] = array("alert" => "Userid required");
		}
    	$encode = json_encode($data);
		echo $encode; 
	} 
}