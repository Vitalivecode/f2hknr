<?php defined('BASEPATH') OR exit('No direct script access allowed');
class PushNotifications extends CI_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->model('get');
								}
	public function index()
	{	
	    if(isset($_GET['anmid']))
	    {
	        $anmid = $_GET['anmid'];
	        $results = $this->get->pushnotifications($anmid);
	        if($results == true)
	        {
	            //print_r($results);
	            foreach($results as $push)
	            {
        	        $data[] = array('page_no' => $push->page_no,'notificationid' => $push->id,'daycounts' => $push->days, 'schoolname' => $push->schoolname);	
	            }
        		$result = array('status' => '200', 'message' => 'success', 'data' => $data);
        		$encode = json_encode($result);
        		echo $encode;
	        }
	        else
	        {
        		$result = array('status' => '400', 'message' => 'No data found', 'data' => array());
        		$encode = json_encode($result);
        		echo $encode;
	        }
	    }
	    else
	    {		
    		$result = array('status' => '400', 'message' => 'No data found', 'data' => array());
    		$encode = json_encode($result);
    		echo $encode;
	    }
	}
	public function send()
	{			
	    
	    $anmresults = $this->get->anm();
	    if($anmresults == true)
	    {
	       foreach($anmresults as $anm)
	       {
	           $anaemiapushresults = $this->get->anaemiapush($anm->sno);
	           if($anaemiapushresults == true)
	           {
	               foreach($anaemiapushresults as $anaemiapushresult)
	               {
	                   if($anaemiapushresult->daycounts <= '5')
	                   {
	                        if($anaemiapushresult->daycounts == '1')
	                        {
                    	        $pageno = '4';   
	                        }
	                        else
	                        {
	                            if(date('h:i A') == '08:30 AM')
                    	            $pageno = '1';
	                            if(date('h:i A') == '12:00 PM')
                    	            $pageno = '2';
	                            if(date('h:i A') == '08:30 PM')
                    	            $pageno = '3';
	                        }
	                        if($anaemiapushresult->daycounts != '1' && (date('h:i A') == '08:30 AM' || date('h:i A') == '12:00 PM' || date('h:i A') == '08:30 PM'))
	                        {
    		                    $this->load->model('insert');
    		                    $insert = array(
    		                        'anmid' => $anm->sno,
    		                        'page_no' => $pageno,
    		                        'days' => $anaemiapushresult->daycounts,
    		                        'schoolname' => $anaemiapushresult->sname,
    		                        'date_time' => date('Y-m-d h:i:s')
    		                        );
    		                    $insertpush = $this->insert->insertpush($insert);
    	                        //print_r($insert);
                        	    $notificationid = "$insertpush";
                        	    $daycounts = $anaemiapushresult->daycounts;
                        	    $schoolname = $anaemiapushresult->sname;
                        	    $data = array(array(
                        	       'page_no' => $pageno,
                        		   'notificationid' => $notificationid,
                        		   'daycounts' => $daycounts, 
                        		   'schoolname' => $schoolname
                        		));
                        		$registrationId = array();
                        		$description = 'Notifications';
                        		$title = 'SAMATHA';
                        		$registrationId = [$anm->device_token];
                        		define('API_ACCESS_KEY', 'AAAA0SsIS4U:APA91bFmMMsRxSe79OptmuxmCC_dnwPEmx8EoGXW5fn-jLHgeXy4TgcYbSWTQwOng705ktie2SnicryzGYosATNkhseS-aB6CQzprYnMdU_jYHM7jnIA_GFAD7nndMbx4R_xqI3NcD0L');
                        		$final_msg = array(
                        			'body'      => $description,
                        			'title'	    => $title,
                        		    'icon'      => "",
                        			'sound'     => 'default',
                        			'color'     => "#203E78",
                        		    //'page_no'   =>'1',
                        		    'data' => $data
                        		);
                        		$fields = array(
                        			'registration_ids' => $registrationId,
                        			'notification' => $final_msg
                        		);
                        		$headers = array(
                        			'Authorization: key='.API_ACCESS_KEY,
                        			'Content-Type: application/json'
                        		);
                        		$ch = curl_init();
                        		curl_setopt( $ch,CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send' );
                        		curl_setopt( $ch,CURLOPT_POST, true );
                        		curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
                        		curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
                        		curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
                        		curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode($fields));
                        		$result = curl_exec($ch);
                        		//print_r($result);
                        		//print_r(json_encode($fields));
                        		curl_close( $ch );
	                       }
    	                   else
    	                   {
    		                    $this->load->model('insert');
    		                    $insert = array(
    		                        'anmid' => $anm->sno,
    		                        'page_no' => $pageno,
    		                        'days' => $anaemiapushresult->daycounts,
    		                        'schoolname' => $anaemiapushresult->sname,
    		                        'date_time' => date('Y-m-d h:i:s')
    		                        );
    		                    $insertpush = $this->insert->insertpush($insert);
    	                        //print_r($insert);
                        	    $notificationid = "$insertpush";
                        	    $daycounts = $anaemiapushresult->daycounts;
                        	    $schoolname = $anaemiapushresult->sname;
                        	    $data = array(array(
                        	       'page_no' => $pageno,
                        		   'notificationid' => $notificationid,
                        		   'daycounts' => $daycounts, 
                        		   'schoolname' => $schoolname
                        		));
                        		$registrationId = array();
                        		$description = 'Notifications';
                        		$title = 'SAMATHA';
                        		$registrationId = [$anm->device_token];
                        		define('API_ACCESS_KEY', 'AAAA0SsIS4U:APA91bFmMMsRxSe79OptmuxmCC_dnwPEmx8EoGXW5fn-jLHgeXy4TgcYbSWTQwOng705ktie2SnicryzGYosATNkhseS-aB6CQzprYnMdU_jYHM7jnIA_GFAD7nndMbx4R_xqI3NcD0L');
                        		$final_msg = array(
                        			'body'      => $description,
                        			'title'	    => $title,
                        		    'icon'      => "",
                        			'sound'     => 'default',
                        			'color'     => "#203E78",
                        		    //'page_no'   =>'1',
                        		    'data' => $data
                        		);
                        		$fields = array(
                        			'registration_ids' => $registrationId,
                        			'notification' => $final_msg
                        		);
                        		$headers = array(
                        			'Authorization: key='.API_ACCESS_KEY,
                        			'Content-Type: application/json'
                        		);
                        		$ch = curl_init();
                        		curl_setopt( $ch,CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send' );
                        		curl_setopt( $ch,CURLOPT_POST, true );
                        		curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
                        		curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
                        		curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
                        		curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode($fields));
                        		$result = curl_exec($ch);
                        		//print_r($result);
                        		//print_r(json_encode($fields));
                        		curl_close( $ch );
	                        }
	                   }
	               }
	           }
	       }
	    }
	}
}
