<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Banner extends CI_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->model('get');
	}
	public function index()
	{
	    $result = $this->get->banner();
		if($result != false)
		{
    		$data['status'] = "200";
    		$data['message'] = "success";
    		foreach($result as $banners)
    		{
    		    $imageUrl = $this->imagecheck->index(base_url('../uploads').'/'.$banners->banner_image);
    		    $siteUrl = $banners->banner_url;
                $data['data'][] = array("imageUrl" => $imageUrl, "title_main" => $banners->banner_name, "title_sub" => $banners->banner_des, "category" => $banners->category, "siteUrl" => $siteUrl);
    		}
		}
		else
		{
		    $data['status'] = "500";
    		$data['message'] = "error";
            $data['data'][] = array("alert" => "");
		}
    	$encode = json_encode($data);
    	echo $encode;
	}
}
