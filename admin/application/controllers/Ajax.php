<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Ajax extends CI_Controller{
    public function __construct(){
        parent::__construct();
    }
    public function index(){
        include(FCPATH.'/gps/gps.php');
        Gps::import_session($this->session->userdata('logged_in'));
        Gps::get_requested_instance();
        $this->session->set_userdata(array('logged_in'=>Gps::export_session()));
    }
    public function session(){
        $session = $this->session->userdata('logged_in');
		print_r($session);
		return $session;
    }
} 
