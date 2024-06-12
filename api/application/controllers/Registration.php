<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Registration extends CI_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->library('encrypt');
		$this->load->model('insert');
								}
	public function index()
	{
		$_POST = json_decode(file_get_contents('php://input'), true);
		if($_POST)
		{
			$encode = $this->encrypt->encode($this->input->post('password'));
			$data = array(
				'fullname' => $this->input->post('name'),
				'phone' => $this->input->post('phone'),
				'email' => $this->input->post('email'),
				'password' => $encode,
				'address' => $this->input->post('address'),
				'role' => isset($_POST['role']) ? $this->input->post('role') : 'user',
			);
			$result = $this->insert->reg($data);
			if ($result == TRUE) {
				$result = array('status' => 'Successfully Registered');
				$encode = json_encode($result);
				echo $encode;
			}
			else
			{
				$result = array('status' => 'Already Existed');
				$encode = json_encode($result);
				echo $encode;
			}
		}
		else{
			$result = array('status' => '400');
			$encode = json_encode($result);
			echo $encode;
		}
	}
}