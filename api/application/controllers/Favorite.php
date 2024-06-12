<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Favorite extends CI_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->model('get');
		$this->load->model('insert');
	}
	public function index()
	{
	    $_POST = json_decode(file_get_contents('php://input'), true);
		if(isset($_POST['user_id']) && ($_POST['user_id'] != '') && isset($_POST['id']) && ($_POST['id'] != '') && isset($_POST['status']) && ($_POST['status'] != ''))
		{
		    $user_id = $_POST['user_id'];
		    
		        $resultres = $this->get->getstore($user_id);
    			if($resultres != false)
        		    {
        		      $storeId = $resultres[0]->store;
                    }
                $resultven = $this->get->getvendor($storeId);
                if($resultven != false)
            		{
                	  $rest_id = $resultven[0]->rest_id;
            	    }
    		    
		    $item_id = $_POST['id'];
		    $status = $_POST['status'];
    		$favResult = $this->insert->favorite($user_id,$item_id,$status,$rest_id);
        	if($favResult == true)
        	{
            	$data['status'] = "200";
            	$data['message'] = "success";
		        $favorite = ($this->get->favorite($user_id,'all',$rest_id) != false)?count($this->get->favorite($user_id,'all',$rest_id)):0;
            	$data['data'][] = array("alert" => "Successfully Saved", "favoriteCount" => $favorite);
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
            $data['data'][] = array("alert" => "The Userid, Itemid and Status fields are required");
		}
    	$encode = json_encode($data);
    	echo $encode;
	}
	public function get()
	{
	    $_POST = json_decode(file_get_contents('php://input'), true);
		if(isset($_POST['user_id']) && ($_POST['user_id'] != ''))
		{
		    $user_id = $_POST['user_id'];
		    
		        $resultres = $this->get->getstore($user_id);
    			if($resultres != false)
        		    {
        		      $storeId = $resultres[0]->store;
                    }
                $resultven = $this->get->getvendor($storeId);
                if($resultven != false)
            		{
                	  $rest_id = $resultven[0]->rest_id;
            	    }
    		    
		    $specialdiscount = $this->get->specialdiscount($rest_id);
    		$favResult = $this->get->favorite($user_id,'all',$rest_id);
        	if($favResult != false)
        	{
        	    $array_ids = '';
            	$data['status'] = "200";
            	$data['message'] = "success";
            	foreach($favResult as $favorite)
            	{
            	    $array_ids[] = $favorite->item_id;
            	}
                $result = $this->get->product($array_ids);
                if($result != false)
                {
                    foreach($result as $items)
                    {
                        $specialdis = ($specialdiscount != false)?$specialdiscount[0]->discount.'%':$items->discount.'%';
                        $imageUrl = $this->imagecheck->index(base_url('../uploads').'/'.$items->item_img);
                	    $siteUrl = base_url('category').'/'.$items->item_cat_id;
                	    $priceTotal = $items->item_price-($items->item_price*$specialdis)/100;
                	    $availability = ($items->status == '1') ? true : false;
                	    $isFavorite = ($this->get->favorite($user_id,$items->item_id,$rest_id) != false) ? true : false;
                        $data['data'][] = array("id" => $items->item_id, "title" => ucwords(strtolower($items->item_name)), "imageURL" => $imageUrl, "itemType" => $items->item_type, "weight" => $items->item_details, "price_unit" => $items->item_price, "quantity" => "1", "price_total" => $items->item_price, "discount" => $specialdis, "availability" => $availability, "itemTypeURL" => $siteUrl, "isFavorite" => $isFavorite);
                    }
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
}
