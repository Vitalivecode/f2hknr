<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Location extends CI_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->library('Site');
		$this->site->maintenance();
		$this->load->library('Auth_user');
		$this->auth_user->checkLogin();
        $this->load->model('get');
        $this->load->model('adminpanel');
								}
	public function index()
	{
	    $this->load_header();
		$this->load_body();
		$this->load_footer();
	}
	public function load_header()
	{
        $data['site']=$this->site->settings();
		$data['userdata']=$this->auth_user->checkLogin();
		$data['tables']=$this->adminpanel->tables();
        $data['ct']=$this->adminpanel->createtable();
		$data['title']="Locations";
		$this->load->view('include/header',$data);
	}
	public function load_body()
	{
		$data['title'] = "Locations";
		$where = array('isActive' => '1');
		$data['suburbs'] = $this->get->table('suburbs',$where);
		$this->load->view('job-location',$data);
	}
	function get($addressFrom = NULL, $addressTo = NULL){
        if(isset($_GET['from']) && isset($_GET['to']) && $_GET['from'] != '' && $_GET['to'] != '')
        {
            $addressFrom = isset($_GET['from'])?$_GET['from']:'';
            $addressTo = isset($_GET['to'])?$_GET['to']:'';
            $apiKey = 'AIzaSyB2YDwv8L1zuQizFEk3HBPdQbo6q3-KLE4';
            $formattedAddrFrom    = str_replace(' ', '+', $addressFrom);
            $formattedAddrTo     = str_replace(' ', '+', $addressTo);
            $api = file_get_contents("https://maps.googleapis.com/maps/api/distancematrix/json?units=imperial&origins=".$formattedAddrFrom."&destinations=".$formattedAddrTo."&key=".$apiKey);
            $distance = json_decode($api);
            //print_r($distance);
            echo "<div class='col-md-12'><label><b>Distance: </b></label> <span>".((int)$distance->rows[0]->elements[0]->distance->value / 1000).' Km'."</span> <br>
                <label><b>Travel Time: </b></label> <span>".$distance->rows[0]->elements[0]->duration->text."</span> ";
            echo '<iframe src="https://www.google.com/maps/embed/v1/directions?key=AIzaSyADvgfPSrdO7rxZxkdfuMs8438tmFyhBvk&origin='.$formattedAddrFrom.'&destination='.$formattedAddrTo.'" width="100%" height="450" frameborder="0" style="border:0" allowfullscreen></iframe></div>';
            
        }
        else
            echo '0';
    }
	public function load_footer()
	{
		$this->load->view('include/footer');
	}
}
