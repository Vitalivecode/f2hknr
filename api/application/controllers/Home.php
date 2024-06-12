<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Home extends CI_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->model('get');
	}
	public function index()
	{
        $date = date('Y-m-d H:i:s');
		$cid = 'all';
		$_POST = json_decode(file_get_contents('php://input'), true);
		$available = '1';
		
		if(isset($_POST['locationId']) && $_POST['locationId'] != '' && isset($_POST['user_id']) && $_POST['user_id'] != '')
		{
		    $userid = $_POST['user_id'];
		    $branchid = $_POST['locationId'];
		    $update = array(
		        "user_id" => $userid,
		        "store" => $branchid
		    );
		    $this->get->updateStore($userid,$update);
		    $resAvailble = $this->get->getRestaurants(array('rest_id' => $branchid));
		    if($resAvailble != false)
		    {
		        $available = $resAvailble[0]->availability;
		    }
		}
		if(isset($_POST['locationId']) && $_POST['locationId'] != '')
		{
		    $branchid = $_POST['locationId'];
		    $where = array(
		        "rest_id" => $branchid,
				"status" => 1
		    );
		    $resbranch = $this->get->getBranches($where);
		    if($resbranch != false)
		    {
		        $branch[] = $resbranch[0];
		    }
			else
				$branch = array();
		}
		else
		{
            $branch = array("alert" => "locationId required");
		}
		$resultres = $this->get->getstore($userid);
    	if($resultres != false)
		    {
		      $storeId = $resultres[0]->store;
            }
        $resultven = $this->get->getvendor($storeId);
        if($resultven != false)
    		{
        	  $rest_id = $resultven[0]->rest_id;
    	    }
          
		
	    $bannerResult = $this->get->banner($rest_id);
	    $specialdiscount = $this->get->specialdiscount($rest_id);
		if($bannerResult != false)
		{
    		$data['status'] = "200";
    		$data['message'] = "success";
    		foreach($bannerResult as $banners)
    		{
    		    $imageUrl = $this->imagecheck->index(base_url('../uploads').'/'.$banners->banner_image);
    		    $siteUrl = $banners->banner_url;
                $banner[] = array("imageUrl" => $imageUrl, "title_main" => $banners->banner_name, "title_sub" => $banners->banner_des, "category" => $banners->category, "subcategory" => $banners->subcategory, "product" => $banners->item, "siteUrl" => $siteUrl);
    		}
		}
		else
		{
		    $data['status'] = "200";
    		$data['message'] = "success";
            $banner = array();
		}
	    $categoryResult = $this->get->category($cid,$rest_id);
		if($categoryResult != false)
		{
    		$data['status'] = "200";
    		$data['message'] = "success";
    		foreach($categoryResult as $category)
    		{
    		    $imageUrl = $this->imagecheck->index(base_url('../uploads').'/'.$category->item_img);
    		    $siteUrl = base_url('category').'/'.$category->rc_id;
                $categories[] = array("imageUrl" => $imageUrl, "title_main" => $category->res_cat_name, "category" => $category->rc_id, "siteUrl" => $siteUrl);
    		}
		}
		else
		{
		    $data['status'] = "200";
    		$data['message'] = "success";
            $categories = array();
		}
		if(isset($_POST['user_id']) && ($_POST['user_id'] != ''))
		{
		    $user_id = $_POST['user_id'];
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
            	    $isFavorite = ($this->get->favorite($user_id,$products->item_id) != false) ? true : false;
                    $todaySpecial[] = array("id" => $products->item_id, "title" => ucwords(strtolower($products->item_name)), "imageURL" => $imageUrl, "itemType" => $products->item_type, "weight" => $products->item_details, "price_unit" => $products->item_price, "quantity" => "1", "price_total" => $products->item_price, "discount" => $specialdis, "availability" => $availability, "itemTypeURL" => $siteUrl, "isFavorite" => $isFavorite);
            	}
        	}
        	else
        	{
        	    $data['status'] = "200";
            	$data['message'] = "success";
                $todaySpecial = array();
        	}
		}
		else
		{
		    $data['status'] = "500";
            $data['message'] = "error";
            $todaySpecial = array("alert" => "Userid required");
		}
        $select = 'vendor_id as locationId,type,code,amount_type,value,min_amount,max_amount,count,terms_conditions,expired_at,status';
        $where = array('vendor_id' => $_POST['locationId'], 'expired_at >=' => $date, 'status' => 1);
	    $couponResult = $this->get->table('referral_coupons', $where, $select);
		if($couponResult != false)
		{
    		$data['status'] = "200";
    		$data['message'] = "success";
            $coupons = $couponResult;
		}
		else
		{
		    $data['status'] = "200";
    		$data['message'] = "success";
            $coupons = array();
		}
		if(isset($_POST['user_id']) && ($_POST['user_id'] != ''))
		{
    	    $user_id = $_POST['user_id'];
    	    $topResult = $this->get->topOrders();
		    if($topResult != false)
		    {
        	    $array_ids = '';
		        $commaSepIds = '';
            	foreach($topResult as $topSeller)
            	{
            	    $array_ids[] = $topSeller->product_id;
            	    $commaSepIds .= $topSeller->product_id.',';
            	}
            	$commaIds = substr($commaSepIds,0,-1);
        		$result = $this->get->topProduct($array_ids,$commaIds);
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
                        $topSellers[] = array("id" => $products->item_id, "title" => ucwords(strtolower($products->item_name)), "imageURL" => $imageUrl, "itemType" => $products->item_type, "weight" => $products->item_details, "price_unit" => $products->item_price, "quantity" => "1", "price_total" => $products->item_price, "discount" => $specialdis, "availability" => $availability, "itemTypeURL" => $siteUrl, "isFavorite" => $isFavorite);
            		}
        		}
        		else
        		{
        		    $data['status'] = "200";
            		$data['message'] = "success";
                    $topSellers = array();
        		}
		    }
    		else
    		{
    		    $data['status'] = "200";
        		$data['message'] = "success";
                $topSellers = array();
    		}
		}
		else
		{
		    $data['status'] = "500";
        	$data['message'] = "error";
            $topSellers = array("alert" => "Userid required");
		}
		$data['data'][] = array('availability' => $available, 'banners' => $banner, 'categories' => $categories, 'branch' => $branch, 'todaySpecial' => $todaySpecial, 'topSellers' => $topSellers, 'coupons' => $coupons);
    	$encode = json_encode($data);
    	echo $encode;
	}
	public function getBranches()
	{
		$result = $this->get->getBranches();
		if($result != false)
		{
			$data['status'] = "200";
        	$data['message'] = "success";
        	$data['data'] = $result;
	    }
		else
		{
		    $data['status'] = "200";
        	$data['message'] = "success";
            $data['data'] = array();
		}
    	$encode = json_encode($data);
    	echo $encode;
	}
	public function selectedBranch()
	{
		$_POST = json_decode(file_get_contents('php://input'), true);
		if(isset($_POST['locationId']) && $_POST['locationId'] != '' && isset($_POST['user_id']) && $_POST['user_id'] != '')
		{
		    $userid = $_POST['user_id'];
		    $update = array(
		        "user_id" => $userid,
		        "store" => $_POST['locationId']
		    );
		    $result = $this->get->updateStore($userid,$update);
    		if($result == true)
    		{
    			$data['status'] = "200";
            	$data['message'] = "success";
            	$where = array('rest_id' => $_POST['locationId']);
            	$branch = $this->get->getBranches($where);
        		if($branch != false)
        		{
                	$data['data'] = $branch;
        	    }
        		else
        		{
                    $data['data'] = array();
        		}
    	    }
    	    else
    		{
    		    $data['status'] = "500";
            	$data['message'] = "error";
                $data['data'] = array();
    		}
		}
		else
		{
		    $data['status'] = "500";
        	$data['message'] = "error";
            $data['data'] = array("alert" => "Userid and locationid required");
		}
    	$encode = json_encode($data);
    	echo $encode;
	}
	public function coupons()
	{
        $date = date('Y-m-d H:i:s');
        $select = 'vendor_id as locationId,type,code,amount_type,value,min_amount,max_amount,count,terms_conditions,expired_at,status';
        if(isset($_GET['locationId']) && $_GET['locationId'] != '')
            $where = array('vendor_id' => $_GET['locationId'], 'expired_at >=' => $date, 'status' => 1);
        else
            $where = array('expired_at >=' => $date, 'status' => 1);
		$result = $this->get->table('referral_coupons', $where, $select);
		if($result != false)
		{
			$data['status'] = "200";
        	$data['message'] = "success";
        	$data['data'] = $result;
	    }
		else
		{
		    $data['status'] = "200";
        	$data['message'] = "success";
            $data['data'] = array();
		}
    	$encode = json_encode($data);
    	echo $encode;
	}
}
