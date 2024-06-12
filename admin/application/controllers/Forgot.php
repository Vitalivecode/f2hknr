<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Forgot extends CI_Controller{
	public function __construct()	{
		parent::__construct();
		$this->load->library('Site');
		$this->site->maintenance();
		$this->load->model('forget');
									}
	public function index()			{
		if($this->session->userdata('logged_in'))
				{
					redirect(base_url().'home');
				}
			else
				{
                    $data['site']=$this->site->settings();
					$data['title']="Forgot";
					if($this->session->flashdata('log_error'))
						$data['log_error'] = $this->session->flashdata('log_error');
					else
						$data['log_error'] = '';
					$this->load_header();
					$this->load->view('forgot',$data);
					$this->load_footer();
				}
									}
	public function load_header()
	{
        $data['site']=$this->site->settings();
		$data['title']="Login";
		$this->load->view('include/header',$data);
	}
	public function send()		{
		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');
		$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
			if ($this->form_validation->run() == FALSE)
			{
				$message = validation_errors() ;
				echo json_encode(array('type'=>'error', 'text' => $message));  
			}
			else
			{
				$data = array(
					'email' => $this->input->post('email')
					);
				$result['data'] = $this->forget->forgot($data);
				if ($result['data'] == TRUE) {
					$result['forgot_key'] = $this->forget->updateForgotkey($result['data'][0]->sno);
					$result['id'] = base64_encode($result['data'][0]->sno);
					$result['site']=$this->site->settings();
        			$this->email->from($result['site'][0]->sentmail, $result['site'][0]->title);
					$subject='Password reset for'.$_SERVER['SERVER_NAME'];
					$this->email->to($data['email']);
					$this->email->subject($subject); 
					$body = $this->load->view('emails/forgot.php',$result,TRUE);
					$this->email->message($body);  
					$this->email->send();
					$message = "<div class='alert alert-success'>Your password reset link sent to email</div>";
					echo json_encode(array('type'=>'success', 'text' => $message)); 
									 }
				else{
						$message ="<div class='alert alert-danger'>Please Enter valid Emailid</div>";
						echo json_encode(array('type'=>'error', 'text' => $message));
					}
			}
							}
	public function password()			{
		$userid = urldecode($this->uri->segment(4));
		$forgot_key = urldecode($this->uri->segment(3));
		$id = base64_decode($userid);
		$checkLostPassword = $this->forget->checkLostPassword($id,$forgot_key); 
		if(!empty($userid) && $checkLostPassword == true)
		{ 
			if($this->session->userdata('logged_in'))
				{
						redirect(base_url());
				}
				else
				{
						if(isset($_POST['new_pass']))
						{
							$this->load->library('form_validation');
							$this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');
							$this->form_validation->set_rules('new_pass', 'New Password', 'required');
							$this->form_validation->set_rules('conf_pass', 'Confirm Password', 'required');
							if ($this->form_validation->run() == FALSE)
							{
								$message = validation_errors() ;
								echo json_encode(array('type'=>'error', 'text' => $message));
							}
							else
							{	
								$newpass = $this->input->post('new_pass');
								$conpass = $this->input->post('conf_pass');
								if($newpass == $conpass)
								{
									$data = array(
										'forgot_key' => $forgot_key,
										'new_pass' => $this->input->post('new_pass'),
										'conf_pass' => $this->input->post('conf_pass'),
										'id' => $id
										);
									$result = $this->forget->changepass($data);
									if ($result == TRUE) {
										$message = "<div class='alert alert-success'>Successfully Changed. Please Login!</div>";
										echo json_encode(array('type'=>'success', 'text' => $message));
														 }
									else{
											redirect(base_url());
										}
								}
								else
								{
									$message = "<div class='alert alert-danger'>New Password and Confirm Password didn't match </div>";
									echo json_encode(array('type'=>'error', 'text' => $message));
								}
							}
						}
						else
						{
							$data['site']=$this->site->settings();
							$data['title']="Lost Password";
							$this->load_header();
							$this->load->view('lost_password',$data);
							$this->load_footer();
						}
				}
		}
		else
		{
           	redirect(base_url().'forgot');
		}
									}
	
	public function load_footer()
	{
		$this->load->view('include/footer');
	}
}
