<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Paymentgateway extends CI_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->model('get');
	}
	public function razorpay()
	{
	    $_POST = json_decode(file_get_contents('php://input'), true);
		if(isset($_POST['locationId']) && $_POST['locationId'] != '')
		{
    		$where = array('branchID' => $_POST['locationId'], 'status' => '1');
    		$result = $this->get->table('payment_gateway', $where);
			if ($result != false){
				$data['status'] = "200";
				$data['message'] = "success";
				$data['data'][] = array("name" => $result[0]->title, 'id' => $result[0]->key_id, 'secret' => $result[0]->secret_key);
			}
			else{
				$data['status'] = "500";
        		$data['message'] = "error";
                $data['data'] = array();
			}
		}
		else
		{
		    $data['status'] = "500";
    		$data['message'] = "error";
            $data['data'][] = array("alert" => "Branch required");
		}
    	$encode = json_encode($data);
    	echo $encode;
	}
}
