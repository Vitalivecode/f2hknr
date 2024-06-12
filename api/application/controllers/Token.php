<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Token extends CI_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->model('get');
	}
	public function index()
	{
		$_POST = json_decode(file_get_contents('php://input'), true);
		if(isset($_POST))
		{
		    $userid = $this->input->post('user_id');
	        $array['gcm_registration_id'] = $this->input->post('token'); 
		    $result = $this->get->updateToken($userid,$array);
			if($result != false) 
			{
				$data['status'] = "200";
        		$data['message'] = "success";
        		//$data['data'][] = array();
			}
	    }
		else
		{
		    $data['status'] = "500";
        	$data['message'] = "error";
            //$data['data'][] = array("alert" => "Userid required");
		}
    	$encode = json_encode($data);
    	echo $encode;
	}
}
