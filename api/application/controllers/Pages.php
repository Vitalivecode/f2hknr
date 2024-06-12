<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Pages extends CI_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->model('get');
	}
	public function about()
	{
	    $_POST = json_decode(file_get_contents('php://input'), true);
		if(isset($_POST['locationId']) && $_POST['locationId'] != '')
		{
    		$where = array('branchID' => $_POST['locationId'], 'status' => '1');
    		$result = $this->get->table('about_us', $where);
			if ($result != false){
				$data['status'] = "200";
				$data['message'] = "success";
				$data['data'][] = array("title" => $result[0]->name, 'description' => $result[0]->description);
			}
			else{
				$data['status'] = "500";
        		$data['message'] = "error";
                $data['data'][] = array();
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
	public function contact()
	{
	    $_POST = json_decode(file_get_contents('php://input'), true);
		if(isset($_POST['locationId']) && $_POST['locationId'] != '')
		{
    		$where = array('branchID' => $_POST['locationId'], 'status' => '1');
    		$result = $this->get->table('contact_us', $where);
			if ($result != false){
				$data['status'] = "200";
				$data['message'] = "success";
				$data['data'][] = array("title" => $result[0]->name, 'email' => $result[0]->email, 'phone' => $result[0]->phone, 'map' => $result[0]->map, 'address' => $result[0]->address);
			}
			else{
				$data['status'] = "500";
        		$data['message'] = "error";
                $data['data'][] = array();
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
	public function terms()
	{
	    $where = array('status' => '1');
    	$result = $this->get->table('terms_conditions', $where);
		if ($result != false){
			$data['status'] = "200";
			$data['message'] = "success";
			$data['data'][] = array("title" => $result[0]->name, 'description' => $result[0]->description);
		}
		else{
			$data['status'] = "500";
        	$data['message'] = "error";
            $data['data'][] = array();
		}
    	$encode = json_encode($data);
    	echo $encode;
	}
	public function privacy()
	{
	    $where = array('status' => '1');
    	$result = $this->get->table('privacy_policy', $where);
		if ($result != false){
			$data['status'] = "200";
			$data['message'] = "success";
			$data['data'][] = array("title" => $result[0]->name, 'description' => $result[0]->description);
		}
		else{
			$data['status'] = "500";
        	$data['message'] = "error";
            $data['data'][] = array();
		}
    	$encode = json_encode($data);
    	echo $encode;
	}
	public function farmers()
	{
	    $where = array('status' => '1');
    	$results = $this->get->table('farmers', $where);
		if ($results != false){
			$data['status'] = "200";
			$data['message'] = "success";
    		foreach($results as $result)
    		{
    		    $imageUrl = $this->imagecheck->person(base_url('../uploads').'/'.$result->image);
    		    $siteUrl = base_url('category').'/'.$category->rc_id;
                $data['data'][] = array("imageUrl" => $imageUrl, "title" => $result->name, 'description' => $result->description);
    		}
		}
		else{
			$data['status'] = "500";
        	$data['message'] = "error";
            $data['data'][] = array();
		}
    	$encode = json_encode($data);
    	echo $encode;
	}
	public function faqs()
	{
	    $where = array('status' => '1');
    	$result = $this->get->table('faqs', $where);
		if ($result != false){
			$data['status'] = "200";
			$data['message'] = "success";
			$data['data'][] = array("title" => $result[0]->name, 'description' => $result[0]->description);
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
