<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Export extends CI_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->library('Site');
		$this->site->maintenance();
		$this->load->library('Auth_user');
		$this->auth_user->checkLogin();
        $this->load->model('get');
	}
	public function index()
	{
		redirect(base_url());
	}
	public function items()
	{
        $filename = 'items_'.date('Ymd').'.csv'; 
		header("Content-Description: File Transfer"); 
		header("Content-Disposition: attachment; filename=$filename"); 
		header("Content-Type: application/csv; ");
        $branchID = $this->session->userdata('logged_in')['branch'];
        if($this->session->userdata('logged_in')['role'] == 'vendor')
	       $where = array('i.vendor_id' => $branchID);
        else
           $where = array();
		$itemsData = $this->get->itemsExport('restaurant_items',$where);
		$file = fopen('php://output','w');
		$header = array("id","branch","category","subcategory","name","details","type","price","discount","today special","status"); 
		fputcsv($file, $header);
		foreach ($itemsData as $key=>$line){ 
			fputcsv($file,$line); 
		}
		fclose($file); 
		exit; 
	}	
}
