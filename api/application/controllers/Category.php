<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Category extends CI_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->model('get');
		$this->load->model('insert');
	}
	public function index()
	{
	    $cid = 'all';
	    $result = $this->get->category($cid);
		if($result != false)
		{
    		$data['status'] = "200";
    		$data['message'] = "success";
    		foreach($result as $category)
    		{
    		    $imageUrl = $this->imagecheck->index(base_url('../uploads').'/'.$category->item_img);
    		    $siteUrl = base_url('category').'/'.$category->rc_id;
                $data['data'][] = array("imageUrl" => $imageUrl, "title_main" => $category->res_cat_name, "category" => $category->rc_id, "siteUrl" => $siteUrl);
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
	public function sub()
	{
		$_POST = json_decode(file_get_contents('php://input'), true);
		if(isset($_POST['user_id']) && isset($_POST['locationId']) && isset($_POST['category']) && $_POST['user_id'] != '' && ($_POST['locationId'] != '') && ($_POST['category'] != ''))
		{
			$user_id = $_POST['user_id'];
			$cid = $_POST['category'];
			$locationid = $_POST['locationId'];
			$result = $this->get->subcategory($cid,$locationid);
            $specialdiscount = $this->get->specialdiscount($locationid);
			if($result != false)
			{
				$data['status'] = "200";
				$data['message'] = "success";
				foreach($result as $subcategory)
				{
					//$imageUrl = $this->imagecheck->index(base_url('../uploads').'/'.$subcategory->item_img);
					//$siteUrl = base_url('category').'/'.$subcategory->cat_id;
					$items = array();
					$products = $this->get->subproducts($cid,$subcategory->rc_id,$locationid);
					foreach($products as $product)
					{
						$specialdis = ($specialdiscount != false)?$specialdiscount[0]->discount.'%':$product->discount.'%';
						$imageUrl = $this->imagecheck->index(base_url('../uploads').'/'.$product->item_img);
						$siteUrl = base_url('category').'/'.$cid;
						$priceTotal = $product->item_price-($product->item_price*$specialdis)/100;
						$availability = ($product->status == '1') ? true : false;
						$isFavorite = ($this->get->favorite($user_id,$product->item_id) != false) ? true : false;
						$items[] = array("id" => $product->item_id, "title" => ucwords(strtolower($product->item_name)), "imageURL" => $imageUrl, "itemType" => $product->item_type, "weight" => $product->item_details, "price_unit" => $product->item_price, "quantity" => "1", "price_total" => $product->item_price, "discount" => $specialdis, "availability" => $availability, "itemTypeURL" => $siteUrl, "isFavorite" => $isFavorite);
					}
					$data['data'][] = array("title_main" => $subcategory->res_cat_name, "subcategory" => $subcategory->rc_id, "items" => $items);
				}
			}
			else
			{
				$data['status'] = "500";
				$data['message'] = "error";
				$data['data'][] = array("alert" => "");
			}
		}
		else
		{
		    $data['status'] = "500";
    		$data['message'] = "error";
            $data['data'][] = array("alert" => "branch and category required");
		}
    	$encode = json_encode($data);
    	echo $encode;
	}
	public function products($cid)
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
    	    $result = $this->get->products($cid);
    		if($result != false)
    		{
        		$data['status'] = "200";
        		$data['message'] = "success";
        		foreach($result as $products)
        		{
        		    $specialdis = ($specialdiscount != false)?$specialdiscount[0]->discount.'%':$products->discount.'%';
        		    $imageUrl = $this->imagecheck->index(base_url('../uploads').'/'.$products->item_img);
        		    $siteUrl = base_url('category').'/'.$cid;
        		    $priceTotal = $products->item_price-($products->item_price*$specialdis)/100;
        		    $availability = ($products->status == '1') ? true : false;
        		    $isFavorite = ($this->get->favorite($user_id,$products->item_id) != false) ? true : false;
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
