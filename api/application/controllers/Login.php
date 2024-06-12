<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Login extends CI_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->model('loged');
	}
	public function index()
	{
		$_POST = json_decode(file_get_contents('php://input'), true);
		if(isset($_POST['mobileNo']) && ($_POST['mobileNo'] != ''))
		{
    		$array = array(
    			'mobile' => $this->input->post('mobileNo')
    		);
    		$result = $this->loged->login($array);
    		$data['status'] = "200";
    		$data['message'] = "success";
            $data['data'][] = array("otp" => "sent");
		}
		else
		{
		    $data['status'] = "500";
    		$data['message'] = "error";
            $data['data'][] = array("alert" => "The Mobile Number field is required");
		}
    	$encode = json_encode($data);
    	echo $encode;
	}
	public function verify()
	{
		$_POST = json_decode(file_get_contents('php://input'), true);
		if(isset($_POST['mobileNo']) && ($_POST['mobileNo'] != '') && isset($_POST['otp']) && ($_POST['otp'] != '') )
		{
    		$array = array(
    			'mobile' => $this->input->post('mobileNo'),
    			'otp' => $this->input->post('otp')
    		);
    		$result = $this->loged->verify($array);
    		if($result == true)
    		{
        		$data['status'] = "200";
        		$data['message'] = "success";
            	$where = array('rest_id' => $result[0]->store);
        		$branch = $this->loged->getBranches($where);
        		$restaurantPlace = ($branch != false)?$branch[0]->location:'';
        		$latitude = ($branch != false)?$branch[0]->latitude:'';
        		$longitude = ($branch != false)?$branch[0]->longitude:'';
        		$locationId = ($branch != false)?$branch[0]->locationId:'';
        		$radius = ($branch != false)?$branch[0]->radius:'';
        		$address = $this->loged->singleAddress($result[0]->userid);
        		$favorite = ($this->loged->favorite($result[0]->userid,'all') != false)?count($this->loged->favorite($result[0]->userid,'all')):0;
        		if($address != false)
        		{
        		    $isValidLocation = ($address[0]->isValidLocation == 1)?true:false;
        		    $userData = array( array(
        		        'user_id' => $result[0]->userid,
        		        'name' => $result[0]->name,
        		        'email' => $result[0]->email,
        		        'mobile' => $result[0]->mobile,
        		        'addressId' => $address[0]->id,
        		        'addressName' => $address[0]->addressName,
        		        'addressMobile' => $address[0]->addressMobile,
        		        'street' => $address[0]->street,
        		        'hno' => $address[0]->hno,
        		        'city' => $address[0]->city,
        		        'state' => $address[0]->state,
        		        'zip' => $address[0]->zip,
        		        'type' => $address[0]->type,
        		        'favoriteCount' => $favorite,
        		        'isValidLocation' => $isValidLocation,
                		'restaurantPlace' => $restaurantPlace,
                		'latitude' => $latitude,
                		'longitude' => $longitude,
                		'locationId' => $locationId,
                		'radius' => $radius
        		    ));
        		}
        		else
        		{
        		    $userData = array( array(
        		        'user_id' => $result[0]->userid,
        		        'name' => $result[0]->name,
        		        'email' => $result[0]->email,
        		        'mobile' => $result[0]->mobile,
        		        'addressId' => '',
        		        'addressName' => '',
        		        'addressMobile' => '',
        		        'street' => '',
        		        'hno' => '',
        		        'city' => '',
        		        'state' => '',
        		        'zip' => '',
        		        'type' => '',
        		        'favoriteCount' => $favorite,
        		        'isValidLocation' => false,
        		        'restaurantPlace' => '',
        		        'latitude' => '',
        		        'longitude' => '',
        		        'locationId' => '',
        		        'radius' => ''
        		        ));
        		}
                $data['data'] = $userData;
    		}
    		else
    		{
    		    $data['status'] = "500";
        		$data['message'] = "error";
                $data['data'][] = array("alert" => "The OTP did not match!");
    		}
		}
		else
		{
		    $data['status'] = "500";
    		$data['message'] = "error";
            $data['data'][] = array("alert" => "The OTP field is required");
		}
    	$encode = json_encode($data);
    	echo $encode;
	}
}
