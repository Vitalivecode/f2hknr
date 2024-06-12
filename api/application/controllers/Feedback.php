<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Feedback extends CI_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->model('get');
		$this->load->model('insert');
	}
	public function index()
	{
	    $_POST = json_decode(file_get_contents('php://input'), true);
		if(isset($_POST['user_id']) && isset($_POST['locationId']) && $_POST['user_id'] != '' && ($_POST['locationId'] != ''))
		{
    		$insert = array(
    			'user_id' => $_POST['user_id'],
    			'vendor_id' => $_POST['locationId'],
    			'type' => $_POST['type'],
    			'title' => $_POST['title'],
    			"message" => $_POST['message'],
    			'created_at' => date('Y-m-d H:i:s')
    		);
    		$result = $this->insert->feedback($insert);
			if ($result === true){
				$data['status'] = "200";
				$data['message'] = "success";
				$data['data'][] = array("alert" => "Successfully submitted!");
			}
			else{
				$data['status'] = "500";
        		$data['message'] = "error";
                $data['data'][] = array("alert" => "Please try again");
			}
		}
		else
		{
		    $data['status'] = "500";
    		$data['message'] = "error";
            $data['data'][] = array("alert" => "Branch and category required");
		}
    	$encode = json_encode($data);
    	echo $encode;
	}
	public function services()
	{
	    $where = array('status' => '1');
    	$results = $this->get->table('feedback_services', $where);
		if ($results != false){
			$data['status'] = "200";
			$data['message'] = "success";
			$complaints = array();
			$suggestions = array();
			foreach($results as $result)
			{
				if($result->type == 'Complaint')
					$complaints[] = $result->title;
				else
					$suggestions[] = $result->title;
			}
			$data['data'][] = array("complaints" => $complaints, "suggestions" => $suggestions);
		}
		else{
			$data['status'] = "500";
        	$data['message'] = "error";
            $data['data'][] = array();
		}
    	$encode = json_encode($data);
    	echo $encode;
	}
}
