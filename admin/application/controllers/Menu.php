<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Menu extends CI_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->library('Site');
		$this->site->maintenance();
		$this->load->library('Auth_user');
		$this->auth_user->checkLogin();
        $this->load->model('adminpanel');
        $this->load->model('alert');
        $this->load->model('dashboardModel');
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
		$data['title']="Admin";
		$this->load->view('include/header',$data);
	}
	public function load_body()
	{
		$data['alert'] =  '';
		if(isset($_POST['parent']))
		{
			$this->load->library('form_validation');
			$this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');
			$this->form_validation->set_rules('parent', 'Parent Name', 'required');
			if ($this->form_validation->run() == FALSE)
			{	
				$data['alert'] = validation_errors();
			}
			else
			{
				$menu = $this->adminpanel->insertMenu();
				if($menu == true)
				{
					$message = array(
						"title" => $_POST['parent'],
						"message" => "Successfully Added.",
						"status" => "success",
					);
					$this->session->set_flashdata('alertMessage', $message);
					redirect(base_url().'menu');
				}
				else
					$data['alert'] =  "<script>$(document).ready(function() { $.toast({heading: '".$_POST['parent']."',text: 'Already Existed',position: 'top-right',loaderBg: '#ff6849',icon: 'error',hideAfter: 3500,stack: 6 })})</script>";
			}
		}
		$data['ct']=$this->adminpanel->createtable();
		$data['title']="Menu";
		$this->load->view('menu',$data);
	}  
	public function Edit()
	{
		if($this->uri->segment(3))
		{
			$this->load_header();
			$parent_id = $this->uri->segment(3);
			$data['alert'] =  '';
			$data['editmenu'] = $this->adminpanel->editMenu($parent_id);
			if($data['editmenu'] != false)
			{
				if(isset($_POST['position']))
				{
					$this->load->library('form_validation');
					$this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');
					if(isset($_POST['parent']))
						$this->form_validation->set_rules('parent', 'Parent Name', 'required');
					$this->form_validation->set_rules('position', 'Position', 'required');
					if ($this->form_validation->run() == FALSE)
					{	
						$data['alert'] = validation_errors();
					}
					else
					{
						$menu = $this->adminpanel->updateMenu($parent_id);
						if($menu == true)
						{
							$message = array(
								"title" => $_POST['parent'],
								"message" => "Successfully updated.",
								"status" => "success",
							);
							$this->session->set_flashdata('alertMessage', $message);
							redirect(current_url());
						}
						else
							$data['alert'] =  "<script>$(document).ready(function() { $.toast({heading: '".$_POST['parent']."',text: 'Already Existed',position: 'top-right',loaderBg: '#ff6849',icon: 'error',hideAfter: 3500,stack: 6 })})</script>";
					}
				}
				$data['ct'] = $this->adminpanel->createtable();
				$data['title']="Edit";
				$this->load->view('edit-menu',$data);
			}
			else
			{
				$data['title']="Page Not Found";
				$this->load->view('error404',$data);
			}
			$this->load_footer();
		}
		else
			redirect(base_url().'menu');
	}   
	public function delete()
	{
		$parent_id = $this->uri->segment(3);
		if(!empty($parent_id))
		{
			$delete = $this->adminpanel->menuDelete($parent_id);
			$message = array(
						"title" => "Menu",
						"message" => "Successfully Deleted.",
						"status" => "success",
					);
			$this->session->set_flashdata('alertMessage', $message);
			redirect(base_url().'menu');
		}
		else
			redirect(base_url().'menu');
	}		
	public function load_footer()
	{
		$this->load->view('include/footer');
	}
}
