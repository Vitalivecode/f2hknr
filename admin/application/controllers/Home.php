<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Home extends CI_Controller {
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
		$data['title']="Dashboard";
		$this->load->view('include/header',$data);
	}
	public function load_body()
	{
		$data['title'] = "Dashboard";
		if(isset($_GET['from']) && $_GET['from'] != '')
			$from = date('Y-m-d 00:00:00', strtotime($_GET['from']));
		else
			$from = date('Y-m-d 00:00:00');
		if(isset($_GET['to']) && $_GET['to'] != '')
			$to = date('Y-m-d 00:00:00', strtotime($_GET['to']));
		else
			$to = date('Y-m-d 23:59:00');
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
			if($this->uri->segment(3) && is_numeric($this->uri->segment(3)))
				$where = array('rest_id' => $this->uri->segment(3));
			else
				$where = NULL;
		}
		$branch = $this->get->table('restaurants', $where);
		if($branch != false)
		{
			$branch_id = ($userdata[0]->role != 'vendor' && !$this->uri->segment(3))?'all':$branch[0]->rest_id;
			$data['vendor_id'] = $branch_id;
			$data['branch_name'] = $branch[0]->rest_name;
			$dashboard = $this->ordersModel->getOrdersDashboard($branch_id);
			$data['total'] = $dashboard['total_orders'];
			$data['pending'] = $dashboard['pending_orders'];
			$data['accepted'] = $dashboard['processed_orders'];
			$data['complete'] = $dashboard['completed_orders'];
			$data['cancelled'] = $dashboard['cancelled_orders'];
			$dashboards = $this->ordersModel->getTodayOrdersDashboard($branch_id, $from, $to);
			$data['ttotal'] = $dashboards['total_orders'];
			$data['tpending'] = $dashboards['pending_orders'];
			$data['taccepted'] = $dashboards['processed_orders'];
			$data['tcomplete'] = $dashboards['completed_orders'];
			$data['tcancelled'] = $dashboards['cancelled_orders'];
			$this->load->view('dashboard',$data);
		}
		else
			$this->load->view('home',$data);
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
