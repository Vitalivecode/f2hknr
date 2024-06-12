<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Maintenance extends CI_Controller {
	public function __construct(){
		parent::__construct();
        $this->load->library('Site');
	}
	public function index()
	{
        $data['site'] = $this->site->settings();
		$data['title'] = "Maintenance";
		$checkipaddress = $this->site->checkipaddress();
		if($checkipaddress == true)
		{
		    redirect(base_url('home'),'refresh');
		}
		else
		{
		    $this->load->view('maintenance',$data);
		}
	}
}
