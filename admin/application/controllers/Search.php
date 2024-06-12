<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Search extends CI_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->library('Site');
		$this->site->maintenance();
		$this->load->library('Auth_user');
		$this->auth_user->checkLogin();
        $this->load->model('get');
        $this->load->library("pagination");
        $this->load->model('adminpanel');
        $this->load->model('alert');
		if($this->session->userdata('logged_in')['role'] == 'superadmin' || $this->session->userdata('logged_in')['role'] == 'admin')
			return true;
		else
			redirect(base_url());
	}
	public function load_header()
	{
        $data['site']=$this->site->settings();
		$data['userdata']=$this->auth_user->checkLogin();
		$data['tables']=$this->adminpanel->tables();
        $data['ct']=$this->adminpanel->createtable();
		$data['title']="Search Jobs";
		$this->load->view('include/header',$data);
	}
	public function index()
	{
	    $this->load_header();
	    $data['title']="Search Jobs";
	    $table = 'orders';
	    $gps = gps_get_instance(); 
        $gps->table($table);
        $gps->unset_title();
        $gps->unset_add();
        $gps->unset_edit();
        $gps->unset_remove();
        $gps->unset_view();
        $gps->unset_csv();
        $gps->unset_print();
        //$gps->where('status_id >','10');
        $gps->where('isActive','1');
        $gps->where('quoteid','');
        $type = array('isActive' => '1');
        $gps->order_by('id','desc');
		$gps->relation('customerid','customers','id','companyname',$type);
		$gps->relation('driverid','drivers','id','username',$type);
		//$statusType = array('id >' => '3', 'isActive' => '1');
		//$gps->relation('status_id','status','id',array('name'),$statusType);
		$gps->change_type('status_id','select','',array('values' => array('1' => 'Booked','2' => 'Approved','3' => 'Assigned','4' => 'Accepted','5' => 'At Pick Up','6' => 'InTransit','7' => 'At Drop','8' => 'Delivered','9' => 'Closed')));
		$gps->subselect("Job Id","SELECT LPAD({id}, 6, 'ST0000')");
		$gps->subselect('Pick Up','CONCAT_WS(", ",source, suburbSourceId)');
		$gps->subselect('Delivery','CONCAT_WS(", ",receivingCompany, destination, suburbDestinationId)');
        $gps->before_update('driver_pickup_datetime');
        $gps->label(array('customerid' => 'Company Name', 'customerRefNo' => 'Ref', 'pickupDate' => 'Date', 'description' => 'Goods Description', 'servicetype' => 'Service Type', 'servicelevel' => 'Lvl', 'orderValue' => 'Charge $', 'driverid' => 'Driver', 'status_id' => 'Status'));
        $gps->columns(array('Job Id','pickupDate','customerid','customerRefNo','Pick Up','Delivery','description','servicetype','servicelevel','orderValue','driverid','status_id'),false);
        $gps->fields(array('customerid','source','suburbSourceId','destination','suburbDestinationId','description','servicetype','driverid','driver_pickup_datetime','driver_intransit_datetime','driver_drop_datetime','driver_delivery_datetime','status_id'),false);
        $gps->change_type('suburbSourceId','text');
        $gps->change_type('suburbDestinationId','text');
        $gps->change_type('description','text');
        $gps->change_type('pickupDate','date');
        $gps->readonly(array('customerid','source','suburbSourceId','destination','suburbDestinationId','description','servicetype','driverid'));
        $gps->disabled(array('customerid','source','suburbSourceId','destination','suburbDestinationId','description','servicetype','driverid'));
        $gps->button(base_url('jobs/create/{id}?action=edit'),'Edit Job','glyphicon glyphicon-pencil',' btn-warning',array('target'=>'_self','data-toggle'=>'tooltip'),array('status_id','=','1'));
        //$gps->button('javascript:;','Move to outsource','fas fa-truck-monster',' btn-primary outsource',array('target'=>'_self','data-id' => '{id}','data-jobid' => '{Job Id}','data-custid' => '{Company Name}','data-toggle'=>'tooltip'),array('status_id','=','1'));
        $gps->button(base_url('jobs/pod/{id}'),'POD','fa fa-file-alt','btn btn-success',array('data-id' => '{id}','data-toggle'=>'tooltip','target'=>'_self'),array('status_id','>','7'));
        $gps->button('javascript:void(0);','Navigation','fa fa-map','btn btn-info navigation',array('data-id' => '{id}','data-toggle'=>'tooltip'),array('status_id','>','3'));
        $gps->button(base_url('jobs/create/{id}?action=view'),'View','fa fa-eye','btn btn-primary',array('data-id' => '{id}','data-toggle'=>'tooltip','target'=>'_self'),array('status_id','=','9'));
        $gps->button(base_url('invoices/edit/{id}?customerid={customerid}&return=delivered'),'Edit','glyphicon glyphicon-pencil ','btn btn-warning',array('data-id' => '{id}','data-toggle'=>'tooltip','target'=>'_self'),array('status_id','=','8'));
        $gps->create_action('approved', 'approved_action');
        $gps->button('javascript:;', 'Click to approve', 'fa fa-check', 'gps-action btn-success', 
            array(
                'data-task' => 'action',
                'data-action' => 'approved',
                'data-toggle' => 'tooltip',
                'data-placement' => 'bottom',
                'data-table' => 'orders',
                'data-primary' => '{id}'),
            array(
                'status_id',
                '=',
                '1'));
        $data['output'] = $gps->render();
        $this->load->view('edit',$data);
		$this->load_footer();
	}
	public function load_footer()
	{
		$this->load->view('include/footer');
	}
}
