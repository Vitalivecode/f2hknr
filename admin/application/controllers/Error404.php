<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Error404 extends CI_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->library('Site');
		$this->site->maintenance();
		$this->load->library('Auth_user');
		$this->auth_user->checkLogin();
        $this->load->model('adminpanel');
        $this->load->model('alert');
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
		$data['title']="Page Not Found";
		$this->load->view('include/header',$data);
	}
	public function load_body()
	{
		$data['title']="Page Not Found";
		$this->load->view('error404',$data);
	}
	public function load_footer()
	{
		$this->load->view('include/footer');
	}
}
