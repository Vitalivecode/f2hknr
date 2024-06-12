<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Download extends CI_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->library('Site');
		$this->site->maintenance();
		$this->load->library('Auth_user');
		$this->auth_user->checkLogin();
		$this->load->model('get');
		$this->load->library('zip');
								}
	public function index()
	{
	    $files = $this->get->management();
	    $today = date('d-M-Y h:i:s A');
	    $this->zip->add_dir($today);
        foreach ($files as $file) {
            $paths = '../uploads/'.$file->img;
            $this->zip->add_data($today.'/'.$file->img,file_get_contents($paths));    
        }
        $this->zip->download('example_backup.zip');
	}
}