<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Import extends CI_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->library('Site');
		$this->site->maintenance();
		$this->load->library('Auth_user');
		$this->auth_user->checkLogin();
        $this->load->model('get');
	}
	public function index()
	{
		redirect(base_url());
	}
	public function items()
	{
        if(!empty($_FILES['items']['name']))
		{
			$file = $_FILES['items']['tmp_name'];
			$handle = fopen($file, "r");
			$c = 0;
            $branchID = $this->session->userdata('logged_in')['branch'];
			while(($filesop = fgetcsv($handle, 10000, ",")) !== false)
			{
				$item_id = $filesop[0];
                $details = $filesop[5];
				$item_price = $filesop[7];
				$discount = $filesop[8];
				$today_special = $filesop[9];
				$status = $filesop[10];
                if($this->session->userdata('logged_in')['role'] == 'vendor')
                   $where = array('item_id' => $item_id, 'vendor_id' => $branchID);
                else
                   $where = array('item_id' => $item_id);
                $data = array(
                    'item_details' => $details,
                    'item_price' => $item_price,
                    'discount' => $discount,
                    'today_special' => $today_special,
                    'status' => $status,
                    'modified_at' => date('Y-m-d H:i:s'),
                    'modifiedBy' => $this->session->userdata('logged_in')['id']
                );
				if($c<>0){	//SKIP THE FIRST ROW
					$this->get->update('restaurant_items', $data, $where);
				}
				$c = $c + 1;
			}
            $message = array(
				"title" => 'Import',
				"message" => "Sucessfully import data !",
				"status" => "success",
			);
			$this->session->set_flashdata('alertMessage', $message);
			redirect(base_url('cms/restaurant-items'));
				
		}
        else
        {
            $message = array(
				"title" => 'Import',
				"message" => "Please try again",
				"status" => "error",
			);
			$this->session->set_flashdata('alertMessage', $message);
			redirect(base_url('cms/restaurant-items'));
        }
            
	}	
}
