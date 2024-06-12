<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Profile extends CI_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->library('Site');
		$this->site->maintenance();
		$this->load->library('Auth_user');
		$this->auth_user->checkLogin();
		$this->load->model('change_pass');
		$this->load->model('account');
		$this->load->library('upload');
        $this->load->model('adminpanel');
        $this->load->model('alert');
								}
	public function index()
	{
		$this->load_header();
		$this->load_body();
		$this->load_footer();
	}
	public function Update()
	{
		$this->load_header();
		$this->updateprofile();
		$this->load_footer();
	}
	public function Password()
	{
		$this->load_header();
		$this->changepass();
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
		$data['tab']="active";
		$data['title']="Profile";
		$this->load->view('profile',$data);
	}
	public function updateprofile()
	{
		if(isset($_POST['updateprofile']))
		{
			$this->load->library('form_validation');
			$this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');
			$this->form_validation->set_rules('fullname', 'Full Name', 'required');
			$this->form_validation->set_rules('preimg', 'Profile Picture', 'required');
			if ($this->form_validation->run() == FALSE)
				{	
					$data['succ'] = '';
					$data['tab']="active";
					$data['title']="Profile";
					$this->load->view('profile',$data);
				}
			else{
					$config['upload_path'] = '../uploads/';
					$config['allowed_types'] = 'gif|jpg|png';
					$this->load->library('upload', $config);
					$this->upload->initialize($config);
						if($this->upload->do_upload())
						{
							$data = $this->upload->data();
							$login = $this->session->userdata('logged_in');
							$data['email'] = $login['email'];
							$data['id'] = $login['id'];
							$updatedata = array(
									'fullname' => $this->input->post('fullname'),
									'img' => $data['file_name']
												);
							$result = $this->account->detailsupdate($data,$updatedata);
							if ($result == TRUE) {
								$message = array(
									"title" => "Your Profile",
									"message" => "Successfully updated.",
									"status" => "success",
								);
								$this->session->set_flashdata('alertMessage', $message);
								redirect(base_url().'profile');
												 }
							else{
								$data['succ']="<script>$(document).ready(function() { $.toast({heading: 'Required all fields',text: '',position: 'top-right',loaderBg: '#ff6849',icon: 'error',hideAfter: 3500,stack: 6 })})</script>";
								$data['tab']="active";
								$data['title']="Profile";
								$this->load->view('profile',$data);
								}
						}
						else
						{
							$login = $this->session->userdata('logged_in');
							$data['email'] = $login['email'];
							$data['id'] = $login['id'];
							$updatedata = array(
									'fullname' => $this->input->post('fullname'),
									'img' => $this->input->post('preimg')
												);
							$result = $this->account->detailsupdate($data,$updatedata);
							if ($result == TRUE) {
								$message = array(
									"title" => "Your Profile",
									"message" => "Successfully updated.",
									"status" => "success",
								);
								$this->session->set_flashdata('alertMessage', $message);
								redirect(base_url().'profile');
												 }
							else{
								$data['succ']="<script>$(document).ready(function() { $.toast({heading: 'Required all fields',text: '',position: 'top-right',loaderBg: '#ff6849',icon: 'error',hideAfter: 3500,stack: 6 })})</script>";
								$data['tab']="active";
								$data['title']="Profile";
								$this->load->view('profile',$data);
								}
						}
				}
		}
		else
		{
			$data['title']="Profile";
			$data['tab']="active";
			$this->load->view('profile',$data);
		}
	}
	public function changepass()
	{
		if(isset($_POST['changepass']))
		{
			$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');
		$this->form_validation->set_rules('old_pass', 'Current Password', 'required');
		$this->form_validation->set_rules('new_pass', 'New Password', 'required');
		$this->form_validation->set_rules('conf_pass', 'Confirm Password', 'required');
			if ($this->form_validation->run() == FALSE)
			{
				$data['error']="";
				$data['tab']="active";
				$data['title']="Profile";
				$this->load->view('profile',$data);
			}
			else
			{	
				$newpass = $this->input->post('new_pass');
				$conpass = $this->input->post('conf_pass');
				if($newpass == $conpass)
				{
					$login = $this->session->userdata('logged_in');
					$id = $login['id'];
					$data = array(
						'old_pass' => $this->input->post('old_pass'),
						'new_pass' => $this->input->post('new_pass'),
						'conf_pass' => $this->input->post('conf_pass'),
						'id' => $id
						);
					$result = $this->change_pass->changepass($data);
					if ($result == TRUE) {
						$data['error']="<script>$(document).ready(function() { $.toast({heading: 'Your Password',text: 'Successfully Changed',position: 'top-right',loaderBg: '#ff6849',icon: 'success',hideAfter: 3500,stack: 6 })})</script>";
						$data['tab']="active";
						$data['title']="Profile";
						$this->load->view('profile',$data);
										 }
					else{
							$data['error']="<script>$(document).ready(function() { $.toast({heading: 'Current Password didn`t match ',text: '',position: 'top-right',loaderBg: '#ff6849',icon: 'error',hideAfter: 3500,stack: 6 })})</script>";
							$data['tab']="active";
							$data['title']="Profile";
							$this->load->view('profile',$data);
						}
				}
				else
				{
					$data['error']="<script>$(document).ready(function() { $.toast({heading: 'New Password and Confirm Password didn`t match ',text: '',position: 'top-right',loaderBg: '#ff6849',icon: 'warning',hideAfter: 3500,stack: 6 })})</script>";
					$data['tab']="active";
					$data['title']="Profile";
					$this->load->view('profile',$data);
				}
			}
	}
		else
		{
			$data['title']="Profile";
			$data['tab']="active";
			$this->load->view('profile',$data);
		}
	}
	public function load_footer()
	{
		$this->load->view('include/footer');
	}
	public function do_upload(){
	$config['upload_path'] = '../uploads/';
			$config['allowed_types'] = 'gif|jpg|png';
			$this->load->library('upload', $config);
			$this->upload->initialize($config);
	if($this->upload->do_upload())
	{
	$this->load->view('profile',$data);
	}

}
	
	
	
	
	
	
	
	
}
