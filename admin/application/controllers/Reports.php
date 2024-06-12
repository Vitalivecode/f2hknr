<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Reports extends CI_Controller {
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
		$data['title']="Reports";
		$this->load->view('include/header',$data);
	}
	public function load_body()
	{
		$data['title'] = "Reports";
		if(isset($_GET['from']) && $_GET['from'] != '')
			$from = date('Y-m-d 00:00:00', strtotime($_GET['from']));
		else
			$from = date('Y-m-d 00:00:00');
		if(isset($_GET['to']) && $_GET['to'] != '')
			$to = date('Y-m-d 23:59:59', strtotime($_GET['to']));
		else
			$to = date('Y-m-d 23:59:59');
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
			$dashboards = $this->ordersModel->getTodayOrdersDashboard($branch_id, $from, $to);
			$data['ttotal'] = $dashboards['total_orders'];
			$data['tpending'] = $dashboards['pending_orders'];
			$data['taccepted'] = $dashboards['processed_orders'];
			$data['tcomplete'] = $dashboards['completed_orders'];
			$data['tcancelled'] = $dashboards['cancelled_orders'];
			$data['items'] = array(); 
			$topItems = $this->ordersModel->itemWiseReport($branch_id,'4', $from, $to);
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
							'price' => $data['items'][$topSeller['product_id']]['price']+((($topSeller['price']*$topSeller['quantity'])-$itemdiscount+$topSeller['gst']))
						);
					}
					else
					{
						$data['items'][$topSeller['product_id']] = array(
							'name' => $topSeller['name'],
							'branch' => $topSeller['rest_name'],
							'quantity' => $topSeller['quantity'],
							'type' => $topSeller['item_type'],
							'price' => ((($topSeller['price']*$topSeller['quantity'])-$itemdiscount+$topSeller['gst']))
						);
					}
				} 
				$data['itemTotal'] = $itemtotalCompletedCount;
			}
			$data['cancelItems'] = array(); 
			$cancelItems = $this->ordersModel->itemWiseReport($branch_id,'5', $from, $to);
			if($cancelItems != false){ 
				$itemTotal = 0; $itemtotalCompletedCount = 0; $itemdcc = 0;
				foreach($cancelItems as $topSeller){ 
					$itemdiscount = (($topSeller['price']*$topSeller['quantity'])*$topSeller['discount'])/100;
					$itemtotalCompletedCount = ((($topSeller['price']*$topSeller['quantity'])-$itemdiscount+$topSeller['gst']))+$itemtotalCompletedCount;
					//$itemdcc = $topSeller['delivery_charges'];
					if(array_key_exists($topSeller['product_id'], $data['cancelItems']))
					{
						$data['cancelItems'][$topSeller['product_id']] = array(
							'name' => $topSeller['name'],
							'branch' => $topSeller['rest_name'],
							'quantity' => $data['cancelItems'][$topSeller['product_id']]['quantity']+$topSeller['quantity'],
							'type' => $topSeller['item_type'],
							'price' => $data['cancelItems'][$topSeller['product_id']]['price']+((($topSeller['price']*$topSeller['quantity'])-$itemdiscount+$topSeller['gst']))
						);
					}
					else
					{
						$data['cancelItems'][$topSeller['product_id']] = array(
							'name' => $topSeller['name'],
							'branch' => $topSeller['rest_name'],
							'quantity' => $topSeller['quantity'],
							'type' => $topSeller['item_type'],
							'price' => ((($topSeller['price']*$topSeller['quantity'])-$itemdiscount+$topSeller['gst']))
						);
					}
				} 
				$data['cancelItemTotal'] = $itemtotalCompletedCount;
			}
			$data['delivery'] = array();
			$deliveryCharges = $this->ordersModel->branchWiseDeliveryCharges($branch_id,'4', $from, $to);
			if($deliveryCharges != false){ 
				$totalDeliveryCharges = 0;
				foreach($deliveryCharges as $charges){ 
					$totalDeliveryCharges = $totalDeliveryCharges+$charges['delivery_charges'];
					if(array_key_exists($charges['vendor_id'], $data['delivery']))
					{
						$data['delivery'][$charges['vendor_id']] = array(
							'branch' => $charges['branch'],
							'orders' => $data['delivery'][$charges['vendor_id']]['orders']+1,
							'charge' => $data['delivery'][$charges['vendor_id']]['charge']+$charges['delivery_charges']
						);
					}
					else
					{
						$data['delivery'][$charges['vendor_id']] = array(
							'branch' => $charges['branch'],
							'orders' => 1,
							'charge' => $charges['delivery_charges']
						);
					}
				}
				$data['totalDeliveryCharges'] = $totalDeliveryCharges;
			}
			$data['users'] = array(); 
			$data['payments'] = array(); 
			$delivery_charges = array(); 
			$charges = array();
			$vendorCharges = array();
			$topUsers = $this->ordersModel->userWiseReport($branch_id,'4', $from, $to);
			if($topUsers != false){ 
				$usertotalCompletedCount = 0; 
				foreach($topUsers as $topSeller){ 
					$itemdiscount = (($topSeller['price']*$topSeller['quantity'])*$topSeller['discount'])/100;
					if(array_key_exists($topSeller['order_id'], $delivery_charges))
					{
						$delivery_charges[$topSeller['order_id']] = array(
							'user' => $topSeller['user_id'],
							'vendor' => $topSeller['vendor_id'],
							'cod_orders' => empty($topSeller['payment'])?1:0,
							'cod' => empty($topSeller['payment'])?$delivery_charges[$topSeller['order_id']]['cod']+((($topSeller['price']*$topSeller['quantity'])-$itemdiscount+$topSeller['gst'])):0,
							'cod_charge' => empty($topSeller['payment'])?$topSeller['delivery_charges']:0,
							'online_orders' => !empty($topSeller['payment'])?1:0,
							'online' => !empty($topSeller['payment'])?$delivery_charges[$topSeller['order_id']]['online']+((($topSeller['price']*$topSeller['quantity'])-$itemdiscount+$topSeller['gst'])):0,
							'online_charge' => !empty($topSeller['payment'])?$topSeller['delivery_charges']:0,
							'orders' => 1,
							'charges' => $topSeller['delivery_charges']
						);
					}
					else
					{
						$delivery_charges[$topSeller['order_id']] = array(
							'user' => $topSeller['user_id'],
							'vendor' => $topSeller['vendor_id'],
							'cod_orders' => empty($topSeller['payment'])?1:0,
							'cod' => empty($topSeller['payment'])?((($topSeller['price']*$topSeller['quantity'])-$itemdiscount+$topSeller['gst'])):0,
							'cod_charge' => empty($topSeller['payment'])?$topSeller['delivery_charges']:0,
							'online_orders' => !empty($topSeller['payment'])?1:0,
							'online' => !empty($topSeller['payment'])?((($topSeller['price']*$topSeller['quantity'])-$itemdiscount+$topSeller['gst'])):0,
							'online_charge' => !empty($topSeller['payment'])?$topSeller['delivery_charges']:0,
							'orders' => 1,
							'charges' => $topSeller['delivery_charges']
						);
					}
				}
				foreach($delivery_charges as $charge)
				{
					if(array_key_exists($charge['user'], $charges))
					{
						$charges[$charge['user']] = array(
							'orders' => $charges[$charge['user']]['orders']+1,
							'cod_orders' => $charges[$charge['user']]['cod_orders']+$charge['cod_orders'],
							'cod' => $charges[$charge['user']]['cod']+$charge['cod'],
							'cod_charge' => $charges[$charge['user']]['cod_charge']+$charge['cod_charge'],
							'online_orders' => $charges[$charge['user']]['online_orders']+$charge['online_orders'],
							'online' => $charges[$charge['user']]['online']+$charge['online'],
							'online_charge' => $charges[$charge['user']]['online_charge']+$charge['online_charge'],
							'del_charges' => $charges[$charge['user']]['del_charges']+$charge['charges'],
						);
					}
					else
					{
						$charges[$charge['user']] = array(
							'orders' => 1,
							'cod_orders' => $charge['cod_orders'],
							'cod' => $charge['cod'],
							'cod_charge' => $charge['cod_charge'],
							'online_orders' => $charge['online_orders'],
							'online' => $charge['online'],
							'online_charge' => $charge['online_charge'],
							'del_charges' => $charge['charges'],
						);
					}
					if(array_key_exists($charge['vendor'], $vendorCharges))
					{
						$vendorCharges[$charge['vendor']] = array(
							'orders' => $vendorCharges[$charge['vendor']]['orders']+1,
							'cod_orders' => $vendorCharges[$charge['vendor']]['cod_orders']+$charge['cod_orders'],
							'cod' => $vendorCharges[$charge['vendor']]['cod']+$charge['cod'],
							'cod_charge' => $vendorCharges[$charge['vendor']]['cod_charge']+$charge['cod_charge'],
							'online_orders' => $vendorCharges[$charge['vendor']]['online_orders']+$charge['online_orders'],
							'online' => $vendorCharges[$charge['vendor']]['online']+$charge['online'],
							'online_charge' => $vendorCharges[$charge['vendor']]['online_charge']+$charge['online_charge'],
							'del_charges' => $vendorCharges[$charge['vendor']]['del_charges']+$charge['charges'],
						);
					}
					else
					{
						$vendorCharges[$charge['vendor']] = array(
							'orders' => 1,
							'cod_orders' => $charge['cod_orders'],
							'cod' => $charge['cod'],
							'cod_charge' => $charge['cod_charge'],
							'online_orders' => $charge['online_orders'],
							'online' => $charge['online'],
							'online_charge' => $charge['online_charge'],
							'del_charges' => $charge['charges'],
						);
					}
				}
				
				foreach($topUsers as $topSeller){ 
					$itemdiscount = (($topSeller['price']*$topSeller['quantity'])*$topSeller['discount'])/100;
					//$itemdcc = $topSeller['delivery_charges'];
					$appUser = $this->ordersModel->appUser($topSeller['user_id']);
					if(array_key_exists($topSeller['user_id'], $data['users']))
					{
						$data['users'][$topSeller['user_id']] = array(
							'name' => ($appUser != false)?$appUser[0]['name']:'',
							'mobile' => ($appUser != false)?$appUser[0]['mobile']:'',
							'branch' => $topSeller['rest_name'],
							'orders' => (array_key_exists($topSeller['user_id'], $charges))?$charges[$topSeller['user_id']]['orders']:'0',
							'cod_orders' => (array_key_exists($topSeller['user_id'], $charges))?$charges[$topSeller['user_id']]['cod_orders']:'0',
							'cod' => (array_key_exists($topSeller['user_id'], $charges))?$charges[$topSeller['user_id']]['cod']:'0',
							'cod_charge' => (array_key_exists($topSeller['user_id'], $charges))?$charges[$topSeller['user_id']]['cod_charge']:'0',
							'online_orders' => (array_key_exists($topSeller['user_id'], $charges))?$charges[$topSeller['user_id']]['online_orders']:'0',
							'online' => (array_key_exists($topSeller['user_id'], $charges))?$charges[$topSeller['user_id']]['online']:'0',
							'online_charge' => (array_key_exists($topSeller['user_id'], $charges))?$charges[$topSeller['user_id']]['online_charge']:'0',
							'charge' => (array_key_exists($topSeller['user_id'], $charges))?$charges[$topSeller['user_id']]['del_charges']:'0',
							'price' => $data['users'][$topSeller['user_id']]['price']+((($topSeller['price']*$topSeller['quantity'])-$itemdiscount+$topSeller['gst']))
						);
					}
					else
					{
						$data['users'][$topSeller['user_id']] = array(
							'name' => ($appUser != false)?$appUser[0]['name']:'',
							'mobile' => ($appUser != false)?$appUser[0]['mobile']:'',
							'branch' => $topSeller['rest_name'],
							'orders' => (array_key_exists($topSeller['user_id'], $charges))?$charges[$topSeller['user_id']]['orders']:'0',
							'cod_orders' =>(array_key_exists($topSeller['user_id'], $charges))?$charges[$topSeller['user_id']]['cod_orders']:'0',
							'cod' =>(array_key_exists($topSeller['user_id'], $charges))?$charges[$topSeller['user_id']]['cod']:'0',
							'cod_charge' => (array_key_exists($topSeller['user_id'], $charges))?$charges[$topSeller['user_id']]['cod_charge']:'0',
							'online_orders' => (array_key_exists($topSeller['user_id'], $charges))?$charges[$topSeller['user_id']]['online_orders']:'0',
							'online' => (array_key_exists($topSeller['user_id'], $charges))?$charges[$topSeller['user_id']]['online']:'0',
							'online_charge' => (array_key_exists($topSeller['user_id'], $charges))?$charges[$topSeller['user_id']]['online_charge']:'0',
							'charge' => (array_key_exists($topSeller['user_id'], $charges))?$charges[$topSeller['user_id']]['del_charges']:'0',
							'price' => ((($topSeller['price']*$topSeller['quantity'])-$itemdiscount+$topSeller['gst']))
						);
					}
					$usertotalCompletedCount = ((($topSeller['price']*$topSeller['quantity'])-$itemdiscount+$topSeller['gst']))+$usertotalCompletedCount;
					if(array_key_exists($topSeller['vendor_id'], $data['payments']))
					{
						$data['payments'][$topSeller['vendor_id']] = array(
							'branch' => $topSeller['rest_name'],
							'orders' => (array_key_exists($topSeller['vendor_id'], $vendorCharges))?$vendorCharges[$topSeller['vendor_id']]['orders']:'0',
							'cod_orders' => (array_key_exists($topSeller['vendor_id'], $vendorCharges))?$vendorCharges[$topSeller['vendor_id']]['cod_orders']:'0',
							'cod' => (array_key_exists($topSeller['vendor_id'], $vendorCharges))?$vendorCharges[$topSeller['vendor_id']]['cod']:'0',
							'cod_charge' => (array_key_exists($topSeller['vendor_id'], $vendorCharges))?$vendorCharges[$topSeller['vendor_id']]['cod_charge']:'0',
							'online_orders' => (array_key_exists($topSeller['vendor_id'], $vendorCharges))?$vendorCharges[$topSeller['vendor_id']]['online_orders']:'0',
							'online' => (array_key_exists($topSeller['vendor_id'], $vendorCharges))?$vendorCharges[$topSeller['vendor_id']]['online']:'0',
							'online_charge' => (array_key_exists($topSeller['vendor_id'], $vendorCharges))?$vendorCharges[$topSeller['vendor_id']]['online_charge']:'0',
							'charge' => (array_key_exists($topSeller['vendor_id'], $vendorCharges))?$vendorCharges[$topSeller['vendor_id']]['del_charges']:'0',
							'price' => $data['payments'][$topSeller['vendor_id']]['price']+((($topSeller['price']*$topSeller['quantity'])-$itemdiscount+$topSeller['gst']))
						);
					}
					else
					{
						$data['payments'][$topSeller['vendor_id']] = array(
							'branch' => $topSeller['rest_name'],
							'orders' => (array_key_exists($topSeller['vendor_id'], $vendorCharges))?$vendorCharges[$topSeller['vendor_id']]['orders']:'0',
							'cod_orders' =>(array_key_exists($topSeller['vendor_id'], $vendorCharges))?$vendorCharges[$topSeller['vendor_id']]['cod_orders']:'0',
							'cod' =>(array_key_exists($topSeller['vendor_id'], $vendorCharges))?$vendorCharges[$topSeller['vendor_id']]['cod']:'0',
							'cod_charge' => (array_key_exists($topSeller['vendor_id'], $vendorCharges))?$vendorCharges[$topSeller['vendor_id']]['cod_charge']:'0',
							'online_orders' => (array_key_exists($topSeller['vendor_id'], $vendorCharges))?$vendorCharges[$topSeller['vendor_id']]['online_orders']:'0',
							'online' => (array_key_exists($topSeller['vendor_id'], $vendorCharges))?$vendorCharges[$topSeller['vendor_id']]['online']:'0',
							'online_charge' => (array_key_exists($topSeller['vendor_id'], $vendorCharges))?$vendorCharges[$topSeller['vendor_id']]['online_charge']:'0',
							'charge' => (array_key_exists($topSeller['vendor_id'], $vendorCharges))?$vendorCharges[$topSeller['vendor_id']]['del_charges']:'0',
							'price' => ((($topSeller['price']*$topSeller['quantity'])-$itemdiscount+$topSeller['gst']))
						);
					}
				} 
				//print_r($vendorCharges);
				$data['usertotalCompletedCount'] = $usertotalCompletedCount;
				$data['vendortotalCompletedCount'] = $usertotalCompletedCount;
			}
			$this->load->view('reports',$data);
		}
		else
			$this->load->view('nodata',$data);
	}	
	function sortByQuantity($a, $b)
	{
		$a = $a['quantity'];
		$b = $b['quantity'];
		if ($a == $b) return 0;
		return ($a < $b) ? -1 : 1;
	}
	public function store()
	{
		$status = '';
		if($this->uri->segment(3) && is_numeric($this->uri->segment(3)))
		{
			$store = $this->ordersModel->store($this->uri->segment(3));
			echo $store;
		}
		else
			echo $status;
	}	
	public function notifications()
	{
		$notifications = $this->ordersModel->notifications();
		if($notifications != false)
		{
			$data['notify'] = $notifications;
			$data['notifications_count'] = $this->ordersModel->notifications_count();
			$this->load->view('header-notifications',$data);
		}
		else
			echo 0;
	}
	public function load_footer()
	{
		$this->load->view('include/footer');
	}
}
