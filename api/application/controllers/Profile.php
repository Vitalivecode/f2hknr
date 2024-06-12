<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Profile extends CI_Controller {
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
    	    $result = $this->get->users($userid);
    		if($result != false)
    		{
        		$data['status'] = "200";
        		$data['message'] = "success";
        		foreach($result as $user)
        		{
                    $data['data'][] = array(
                        'user_id' => $user->user_id,
                        'name' => $user->name,
                        'mobile' => $user->mobile,
                        'email' => $user->email,
                        'referralcode' => 'FTH'.$user->user_id
                    );
                    //$data['data'][] = $user;
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
	public function edit()
	{
	    $_POST = json_decode(file_get_contents('php://input'), true);
	    if(isset($_POST['user_id']) && $_POST['user_id'] != '')
	    {
	        $userid = $_POST['user_id'];
	        $name = $_POST['name'];
	        $mobile = $_POST['mobile'];
	        $email = $_POST['email'];
	        $referral = isset($_POST['referralcode'])?substr($_POST['referralcode'],3):'';
	        $date = date('Y-m-d H:i:s');
	        $insert = array("user_id" => $userid, "name" => $name, "mobile" => $mobile, "email" => $email, "referral" => $referral, "modified_at" => $date);
    	    $result = $this->insert->profile($insert);
    		if($result == true)
    		{
        		$data['status'] = "200";
        		$data['message'] = "success";
        		$data['data'][] = array("alert" => "Successfully updated");
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
