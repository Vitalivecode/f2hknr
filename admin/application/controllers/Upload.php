<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Upload extends CI_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->library('Site');
		$this->site->maintenance();
		$this->load->library('Auth_user');
		$this->auth_user->checkLogin();
		$this->load->library('encrypt');
		$this->load->model('change_pass');
		$this->load->model('account');
		$this->load->library('upload');
        $this->load->model('adminpanel');
        $this->load->model('alert');
        $this->load->model('uploads');
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
		$data['title']="Admin";
		$this->load->view('include/header',$data);
	}
	public function load_body()
	{
		$data['title']="Upload";
		$this->load->view('upload',$data);
	}
	public function upload()
	{
		if(isset($_POST['fullname']))
		{
			$this->load->library('form_validation');
			$this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');
			$this->form_validation->set_rules('fullname', 'Full Name', 'required');
			$this->form_validation->set_rules('userfile[]', 'Document', 'callback_file_selected_test');
			if ($this->form_validation->run() == FALSE)
			{	
				echo '<div class="alert alert-danger">Required all fields</div>';
			}
			else
			{
			    $base64_image = array();
			   // $config['upload_path'] = '../test/';
				$config['allowed_types'] = 'gif|jpg|png|zip|rar|mp4';
				$config['overwrite'] = 1;
				$this->load->library('upload', $config);
				foreach($_FILES['userfile']['name'] as $key => $image)
				{
			        $alert = false;
			        $check = getimagesize($_FILES['userfile']['tmp_name'][$key]);
        			if($check !== false) {
        			    $login = $this->session->userdata('logged_in')['id'];
        				$img = base64_encode(file_get_contents( $_FILES['userfile']['tmp_name'][$key] ));
        				$dataArray = array(
        				    'userid' => $login,
        				    'title' => $this->input->post('fullname'),
        				    'image' => 'data:'.$check["mime"].';base64,'.$img,
        				    );
        				$results = $this->uploads->imageInsert($dataArray);
        				if($results == true)
        				{
        				    
        				}
        			    $alert = '1';
        				//$base64_image[] =  '<img src="data:'.$check["mime"].';base64,'.$data.'" width="100%" />';
        			} else {
        				$alert = $this->upload->display_errors();
        			}
			        /*
					$_FILES['userfile[]']['name'] = $_FILES['userfile']['name'][$key];
					$_FILES['userfile[]']['type'] = $_FILES['userfile']['type'][$key];
					$_FILES['userfile[]']['tmp_name'] = $_FILES['userfile']['tmp_name'][$key];
					$_FILES['userfile[]']['error'] = $_FILES['userfile']['error'][$key];
					$_FILES['userfile[]']['size'] = $_FILES['userfile']['size'][$key];
					$this->upload->initialize($config);
    				if($this->upload->do_upload('userfile[]'))
    				{
					    $fileData[] = $this->upload->data()['file_name'];
					    $login = $this->session->userdata('logged_in');
					    $alert = '1';
				    }
    				else
    				{
    				    $alert = $this->upload->display_errors();   
    				} */
				}
				if($alert == '1')
				{
				    //print_r($base64_image);
				    echo $alert;
				}
				else
				{
				    echo '<div class="alert alert-danger">'.$alert.'</div>';
				}
			}
		}
		else
		{
			echo '<div class="alert alert-danger">Error</div>';
		}
	}
	function file_selected_test(){
        $this->form_validation->set_message('file_selected_test', 'Please select file.');
        if (empty($_FILES['userfile']['name'][0])) {
            return false;
        }else{
            return true;
        }
    }
	public function get()
	{
	    $this->load_header();
	    $data['title']="Upload";
	    $login = $this->session->userdata('logged_in')['id'];
	    $data['images'] = $this->uploads->imageGet($login);
		$this->load->view('upload',$data);
	    $this->load_footer();
	}
	public function load_footer()
	{
		$this->load->view('include/footer');
	}
}
