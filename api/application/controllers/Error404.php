<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Error404 extends CI_Controller {
	public function __construct(){
		parent::__construct();
								}
	public function index()
	{
	    $data['status'] = "500";
    	$data['message'] = "error";
        $data['data'][] = array("alert" => "Page Not Found");
		$encode = json_encode($data);
		echo $encode;
	}
}
