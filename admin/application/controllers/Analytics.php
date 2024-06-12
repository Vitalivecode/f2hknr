<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Analytics extends CI_Controller {
	public function __construct(){
		parent::__construct();
        $this->load->library('Site');
		$this->site->maintenance();
		$this->load->library('Auth_user');
		$this->auth_user->checkLogin();
        $this->load->model('adminpanel');
        $this->load->library("pagination");
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
		$data['title']="Analytics";
		$this->load->view('include/header',$data);
	}
	public function load_body()
	{
		$config = array();
		$config["base_url"] = base_url() . "Analytics/Index/";
		$result['total_count']=count($this->adminpanel->visit_count());
        $config["total_rows"] = $result['total_count'];
        $config["per_page"] = 10;
		$result["start_page"] = $config["per_page"];
		$config['num_links'] = $result['total_count'];
		$config['next_link'] = 'Next &gt;';
		$config['prev_link'] = '&lt; Previous';
        $this->pagination->initialize($config);
        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
		$data['visit'] = $this->adminpanel->visit($config["per_page"], $page);
		$data["links"] = $this->pagination->create_links();
			if($data["links"]!= '') {
				$data['pagermessage'] = 'Showing '.((($this->pagination->cur_page-1)*$this->pagination->per_page)+1).' to '.($this->pagination->cur_page*$this->pagination->per_page).' of '.$this->pagination->total_rows;
    		}
			if($data['visit'] == TRUE)
			{
				$this->load->view('analytics',$data);
			}
			else
			{
				$this->load->view('analytics',$data);
			}
	}
	public function Offline() {
		$id = $this->uri->segment(3);
		if(!empty($id)){
			$online = $this->adminpanel->online($id);
			if($online == true)
			{
				redirect(base_url().'analytics');
			}
		}
		else {
		redirect(base_url().'analytics');
		}
	}
	public function Block() {
		$id = $this->uri->segment(3);
		if(!empty($id)){
			$block = $this->adminpanel->block($id);
			if($block == true)
			{
				redirect(base_url().'analytics');
			}
		}
		else {
		redirect(base_url().'analytics');
		}
	}
	public function Inblock() {
		$id = $this->uri->segment(3);
		if(!empty($id)){
			$block = $this->adminpanel->inblock($id);
			if($block == true)
			{
				redirect(base_url().'analytics');
			}
		}
		else {
		redirect(base_url().'analytics');
		}
	}
	public function load_footer()
	{
		$this->load->view('include/footer');
	}
}
