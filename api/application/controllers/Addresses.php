<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Addresses extends CI_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->model('get');
		$this->load->model('insert');
	}
	public function index()
	{
	    if(isset($_GET['user_id']) && $_GET['user_id'] != '')
	    {
	        $userid = $_GET['user_id'];
    	    $result = $this->get->address($userid,'all');
    		if($result != false)
    		{
        		$data['status'] = "200";
        		$data['message'] = "success";
        		foreach($result as $addresses)
        		{
                    $data['data'][] = $addresses;
        		}
    		}
    		else
    		{
    		    $data['status'] = "200";
        		$data['message'] = "success";
                $data['data'][] = array();
    		}
	    }
	    else
	    {
	        $data['status'] = "500";
        	$data['message'] = "error";
            $data['data'][] = array("alert" => "Userid required");
	    }
    	$encode = json_encode($data);
    	echo $encode;
	}
	public function add()
	{
	    $_POST = json_decode(file_get_contents('php://input'), true);
	    if(isset($_POST['user_id']) && $_POST['user_id'] != '')
	    {
	        $userid = $_POST['user_id'];
	        $name = $_POST['name'];
	        $mobile = $_POST['mobile'];
	        $street = $_POST['street'];
	        $hno = $_POST['hno'];
	        $city = $_POST['city'];
	        $state = $_POST['state'];
	        $zip = $_POST['pincode'];
	        $latitude = isset($_POST['latitude'])?$_POST['latitude']:'';
	        $longitude = isset($_POST['longitude'])?$_POST['longitude']:'';
	        $isValidLocation = isset($_POST['isValidLocation'])?'1':'0';
	        $date = date('Y-m-d H:i:s');
	        $insert = array("user_id" => $userid, "name" => $name, "mobile" => $mobile, "street" => $street, "hno" => $hno, "city" => $city, "state" => $state, "zip" => $zip, "type" => "1", "latitude" => $latitude, "longitude" => $longitude, "isValidLocation" => $isValidLocation, "datetime" => $date);
    	    $result = $this->insert->address($insert);
    		if($result == true)
    		{
        		$data['status'] = "200";
        		$data['message'] = "success";
        		$data['data'][] = array("addressId" => $result);
    		}
    		else
    		{
    		    $data['status'] = "500";
        		$data['message'] = "error";
                $data['data'][] = array("alert" => "Please try again");
    		}
	    }
	    else
	    {
	        $data['status'] = "500";
        	$data['message'] = "error";
            $data['data'][] = array("alert" => "Userid required");
	    }
    	$encode = json_encode($data);
    	echo $encode;
	}
}
