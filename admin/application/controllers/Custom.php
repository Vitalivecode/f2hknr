<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Custom extends CI_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->library('Site');
		$this->site->maintenance();
		$this->load->library('Auth_user');
		$this->auth_user->checkLogin();
        $this->load->model('usersModel');
        $this->load->library("pagination");
        $this->load->model('adminpanel');
        $this->load->model('alert');
	/*	if($this->session->userdata('logged_in')['role'] == 'superadmin' || $this->session->userdata('logged_in')['role'] == 'admin')
			return true;
		else
			redirect(base_url());*/
								}
	public function index()
	{
		$this->load_header();
		$this->load_body();
		$this->load_footer();
	}
	public function load_header()
	{
	    $data['userdata']=$this->auth_user->checkLogin(); 
	    if($data['userdata'][0]->role != 'superadmin')
	    {
        	$table = $this->uri->segment(1); 
    	    $per = $this->auth_user->permissions($data['userdata'][0]->permissions,$table);
    	    if($per)
    	    {
                $data['site']=$this->site->settings();
        		$data['userdata']=$this->auth_user->checkLogin();
        		$data['tables']=$this->adminpanel->tables();
                $data['ct']=$this->adminpanel->createtable();
        		$data['title']="Custom";
        		$this->load->view('include/header',$data);
    	    }
    	    else
    	    {
    	        redirect(base_url('home'));
    	    }  
	    }
	    else
	    {
	            $data['site']=$this->site->settings();
        		$data['userdata']=$this->auth_user->checkLogin();
        		$data['tables']=$this->adminpanel->tables();
                $data['ct']=$this->adminpanel->createtable();
        		$data['title']="Custom";
        		$this->load->view('include/header',$data);
	    
	   }
	}
	public function load_body()
	{
		$config = array();
		$config["base_url"] = base_url() . "users/index/";
		$result['total_count']=count($this->usersModel->visit_count());
        $config["total_rows"] = $result['total_count'];
        $config["per_page"] = 10000;
		$result["start_page"] = $config["per_page"];
		$config['num_links'] = $result['total_count'];
		$config['next_link'] = 'Next &gt;';
		$config['prev_link'] = '&lt; Previous';
        $this->pagination->initialize($config);
        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
		$data['usersDetails'] = $this->usersModel->usersDetails($config["per_page"], $page);
		$data["links"] = $this->pagination->create_links();
			if($data["links"]!= '') {
				$data['pagermessage'] = 'Showing '.((($this->pagination->cur_page-1)*$this->pagination->per_page)+1).' to '.($this->pagination->cur_page*$this->pagination->per_page).' of '.$this->pagination->total_rows;
    		}
		$this->load->view('custom',$data);
	}
	public function Add()
	{
		$this->load_header(); 
		$data['ctables'] = $this->usersModel->menus();
		if(isset($_POST['submit']))
		{
			$this->load->library('form_validation');
			$this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');
			$this->form_validation->set_rules('name', 'First Name', 'required');
			$this->form_validation->set_rules('email', 'Email Id', 'trim|required|valid_email');
			$this->form_validation->set_rules('phone', 'Phone No.', 'trim|required|regex_match[/^[0-9]{10}$/]|max_length[10]|min_length[10]');
			$this->form_validation->set_rules('role', 'Role', 'trim|required');
			$this->form_validation->set_rules('password', 'Password', 'required');
			//$this->form_validation->set_rules('master-options','Atleast one permission','required');
			if ($this->form_validation->run() == FALSE)
			{	
				$data['error'] = validation_errors();
			}
			else
			{
				$this->load->library('encrypt');
				$password = $this->encrypt->encode($this->input->post('password'));
				$firstname = $this->input->post('name');
				$middlename = ($this->input->post('mname') != "")? ' '.$this->input->post('mname'):'';
				$lastname = ($this->input->post('lname') != "")? ' '.$this->input->post('lname'):'';
				$fullname = $firstname.$middlename.$lastname;
				$add = isset($_POST['add'])?$_POST['add']:[];
				$edit = isset($_POST['edit'])?$_POST['edit']:[];
				$delete = isset($_POST['delete'])?$_POST['delete']:[];
				$view = isset($_POST['view'])?$_POST['view']:[];
				$perm = array_merge($add,$edit,$delete,$view);
				$arrayAdminData = array(
						'fullname' => $fullname,
						'email' => $this->input->post('email'),
						'phone' => $this->input->post('phone'),
						'gender' => $this->input->post('gender'),
						'role' => $this->input->post('role'),
						'pass' => $password,
						'permissions' => json_encode($perm)
						); 	
				$insertUsersDetails = $this->usersModel->insertUsersDetails($arrayAdminData);
				if($insertUsersDetails == true)
				{
					$message = array(
						"title" => $fullname,
						"message" => "Successfully Saved.",
						"status" => "success",
					);
					$this->session->set_flashdata('alertMessage', $message);
					redirect(base_url().'custom/add');
				}
				else
				{
					$data['error'] = "<script>$(document).ready(function() { $.toast({heading: '".$this->input->post('email')."',text: 'User already exist!',position: 'top-right',loaderBg: '#ff6849',icon: 'error',hideAfter: 3500,stack: 6 })})</script>";	
				} 
			}
		}
		$data['title'] = "Add";
		$this->load->view('custom_add',$data);
		$this->load_footer();
	}
	public function Edit()
	{
	    $data['ctables'] = $this->usersModel->menus();
		if(!empty($this->uri->segment(3)))
		{
			$data['getAdmin'] = $this->usersModel->getAdmin($this->uri->segment(3));
			if($data['getAdmin'] != false)
			{
				$this->load->library('encrypt');
				$data['password'] = $this->encrypt->decode($data['getAdmin'][0]->pass);
				if(isset($_POST['update']))
				{
					$this->load->library('form_validation');
					$this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');
					$this->form_validation->set_rules('name', 'Full Name', 'required');
					$this->form_validation->set_rules('email', 'Email Id', 'trim|required|valid_email');
					$this->form_validation->set_rules('phone', 'Phone No.', 'trim|required|regex_match[/^[0-9]{10}$/]|max_length[10]|min_length[10]');
					$this->form_validation->set_rules('role', 'Role', 'trim|required');
					$this->form_validation->set_rules('password', 'Password', 'required');
					if ($this->form_validation->run() == FALSE)
					{	
						$data['error'] = validation_errors();
					}
					else
					{
						$this->load->library('encrypt');
        				$password = $this->encrypt->encode($this->input->post('password'));
        				$firstname = $this->input->post('name');
        				$middlename = ($this->input->post('mname') != "")? ' '.$this->input->post('mname'):'';
        				$lastname = ($this->input->post('lname') != "")? ' '.$this->input->post('lname'):'';
        				$fullname = $firstname.$middlename.$lastname;
        				$add = isset($_POST['add'])?$_POST['add']:[];
        				$edit = isset($_POST['edit'])?$_POST['edit']:[];
        				$delete = isset($_POST['delete'])?$_POST['delete']:[];
        				$view = isset($_POST['view'])?$_POST['view']:[];
        				$perm = array_merge($add,$edit,$delete,$view);
        				$arrayAdminData = array(
        						'fullname' => $fullname,
        						'email' => $this->input->post('email'),
        						'phone' => $this->input->post('phone'),
        						'gender' => $this->input->post('gender'),
        						'role' => $this->input->post('role'),
        						'pass' => $password,
        						'permissions' => json_encode($perm)
        						); 	
						$updateAdminDetails = $this->usersModel->updateAdminDetails($arrayAdminData);
						if($updateAdminDetails == true)
						{
							$message = array(
								"title" => $this->input->post('name'),
								"message" => "Successfully Updated.",
								"status" => "success",
							);
							$this->session->set_flashdata('alertMessage', $message);
							redirect(base_url().'custom/edit/'.$this->uri->segment(3));
						}
						else
						{
							$data['error'] = "<script>$(document).ready(function() { $.toast({heading: '".$this->input->post('email')."',text: 'User already exist!',position: 'top-right',loaderBg: '#ff6849',icon: 'error',hideAfter: 3500,stack: 6 })})</script>";
						}
					}
				}
				$this->load_header();
				$data['title'] = "Edit";
				$this->load->view('custom_edit',$data);
				$this->load_footer();
			}
			else
				redirect(base_url().'custom');
		}
		else
			redirect(base_url().'custom');
	}
	public function Delete()
	{
		if(!empty($this->uri->segment(3)))
		{
			$data['getAdmin'] = $this->usersModel->getAdmin($this->uri->segment(3));
			if($data['getAdmin'] != false)
			{
				$deleteManager = $this->usersModel->deleteAdmin($this->uri->segment(3));
				$message = array(
					"title" => "",
					"message" => "Successfully Deleted.",
					"status" => "success",
				);
				$this->session->set_flashdata('alertMessage', $message);
				redirect(base_url().'custom');
			}
			else
				redirect(base_url().'custom');
		}
		else
			redirect(base_url().'custom');
	}
	public function load_footer()
	{
		$this->load->view('include/footer');
	}
}
