<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Products extends CI_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->model('get');
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
    		    $imageUrl = base_url('../uploads').'/'.$category->item_img;
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
	public function single()
	{
		if(isset($_GET['user_id']) && ($_GET['user_id'] != '') && isset($_GET['pid']) && ($_GET['pid'] != ''))
		{
		    $pid = $_GET['pid'];
    	    $user_id = $_GET['user_id'];
    	    $specialdiscount = $this->get->specialdiscount();
    	    $result = $this->get->product($pid);
    		if($result != false)
    		{
        		$data['status'] = "200";
        		$data['message'] = "success";
        		foreach($result as $products)
        		{
        		    $specialdis = ($specialdiscount != false)?$specialdiscount[0]->discount.'%':$products->discount.'%';
        		    $imageUrl = $this->imagecheck->index(base_url('../uploads').'/'.$products->item_img);
        		    $siteUrl = base_url('category').'/'.$products->item_cat_id;
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
