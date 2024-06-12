<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Todayspecial extends CI_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->model('get');
	}
	public function index()
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
    		$todayResult = $this->get->todaySpecial($rest_id);
        	if($todayResult != false)
        	{
            	$data['status'] = "200";
            	$data['message'] = "success";
            	foreach($todayResult as $products)
            	{
            	    $specialdis = ($specialdiscount != false)?$specialdiscount[0]->discount.'%':$products->discount.'%';
            	    $imageUrl = $this->imagecheck->index(base_url('../uploads').'/'.$products->item_img);
            	    $siteUrl = base_url('category').'/'.$products->item_cat_id;
            	    $priceTotal = $products->item_price-($products->item_price*$specialdis)/100;
            	    $availability = ($products->status == '1') ? true : false;
            	    $isFavorite = ($this->get->favorite($user_id,$products->item_id,$rest_id) != false) ? true : false;
                    $data['data'][] = array("id" => $products->item_id, "title" => ucwords(strtolower($products->item_name)), "imageURL" => $imageUrl, "itemType" => $products->item_type, "weight" => $products->item_details, "price_unit" => $products->item_price, "quantity" => "1", "price_total" => $products->item_price, "discount" => $specialdis, "availability" => $availability, "itemTypeURL" => $siteUrl, "isFavorite" => $isFavorite);
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
