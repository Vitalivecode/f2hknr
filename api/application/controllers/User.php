<?php defined('BASEPATH') OR exit('No direct script access allowed');
class User extends CI_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->model('insert');
		$this->load->library('encrypt');
		$this->load->model('get');
								}
	public function profile()
	{
	    $_POST = json_decode(file_get_contents('php://input'), true);
		if($_POST['id'])
		{
		    $id = $this->input->post('id');
		    $user = $this->get->user($id);
		    if($user == true)
    		{
    		    //$encode = $this->encrypt->encode($this->input->post('password'));
    			if(isset($_POST['old_pass']))
    			{
    				$newpass = $this->input->post('new_pass');
    				$conpass = $this->input->post('conf_pass');
    				if($newpass == $conpass)
    				{
    					$password = array(
    						'old_pass' => $this->input->post('old_pass'),
    						'new_pass' => $this->input->post('new_pass'),
    						'conf_pass' => $this->input->post('conf_pass'),
    						'id' => $id
    					);
    					$result = $this->insert->changepass($password);
    					if ($result == TRUE) 
    					{
    						$message = "Successfully Updated";
    						$result = array('status' => $message);
            				$encode = json_encode($result);
            				echo $encode;
    					}
    					else
    					{
    						$message = "Current Password didn`t match";
    						$result = array('status' => $message);
            				$encode = json_encode($result);
            				echo $encode;
    					}
    				}
    				else
    				{
    					$message = "New Password and Confirm Password didn`t match";
    					$result = array('status' => $message);
            			$encode = json_encode($result);
            			echo $encode;
    				}
			    }
    			else
    			{
    				$result = array('status' => '400', 'message' => 'Please Enter Old Password', 'data' => array());
    				$encode = json_encode($result);
    				echo $encode;
    			}
			}
			else
			{
				$result = array('status' => '400', 'message' => 'ANM is Blocked', 'data' => array());
				$encode = json_encode($result);
				echo $encode;
			}
		}
		else{
			$result = array('status' => '400', 'message' => 'No data found', 'data' => array());
			$encode = json_encode($result);
			echo $encode;
		}
	}
	public function deactive()
	{
		if(isset($_GET['id']))
		{
			$deactiveuser = $this->insert->deactiveuser();
			if($deactiveuser == true)
			{
			    $result = array('status' => '200', 'message' => 'success', 'data' => 'Successfully Closed');
				$encode = json_encode($result);
				echo $encode;
			}
			else
			{
				$result = array('status' => '400', 'message' => 'No data found', 'data' => array());
				$encode = json_encode($result);
				echo $encode;
			}
		}
		else{
			$result = array('status' => '400', 'message' => 'No data found', 'data' => array());
			$encode = json_encode($result);
			echo $encode;
		}
	}
}