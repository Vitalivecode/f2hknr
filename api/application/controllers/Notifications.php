<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Notifications extends CI_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->model('get');
								}
	public function index()
	{
    	$result['status'] = '200';
    	$result['message'] = 'success';
    	$limit = '4';
    	$achieved = '';
    	$message = '';
    	$welcome = '';
    	if(isset($_GET['anmid']))
	    {
	        $anmid = $_GET['anmid'];
	        $user = $this->get->user($anmid);
    		if($user == true)
        	{
    	        $achieved = ($this->get->anmstudents($anmid) != false) ? (number_format(((count($this->get->anmstudents($anmid)))/2000)*100,2,'.','')).'%' : '0%';
    	        $message = 'You have achieved '.$achieved.' of your goal. Keep it up and quickly complete 100%';
    	        if($this->get->user($_GET['anmid']) == true)
    	        {
    	            $welcome = 'WELCOME '.strtoupper($this->get->user($_GET['anmid'])[0]->fullname);
    	        }
    	        else
    	             $welcome = '';
    	        $resultseverely = $this->get->activeseverely($_GET['anmid'],1);
    	        $resultmildly = $this->get->activemildly($_GET['anmid'],1);
    	        if($resultseverely == false && $resultmildly == false)
    	        {
    	            $actlimit = 4;
    	        }
    	        elseif($resultseverely == false || $resultmildly == false)
    	        {
    	            $actlimit = 3;
    	        }
    	        else
    	        {
    	            $actlimit = 2;
    	        }
        		$activejobs = $this->get->activejobs($_GET['anmid'],$actlimit);
        		//print_r($activejobs);
        		if($activejobs != false)
        		{
        		    $result['status'] = '200';
        		    $result['message'] = 'success';
        		    foreach($activejobs as $jobs)
        		    {
        		        $acjobs[] = array(
        		            "sno" => $jobs->sno,
        		            "sname" => $jobs->sname,
        		            "scode" => $jobs->scode,
        		            "msno" => $jobs->msno,
        		            "mandal" => $jobs->mandal,
        		            "vsno" => $jobs->vsno,
        		            "village" => $jobs->village,
        		            "jobtype" => 'activejobs',
        		            "type" => '',
        		            ); 
        		    }
        		    $followup = $this->get->followup($_GET['anmid'],$limit);
            		if($followup != false)
            		{
            		    $resultseverely = $this->get->activeseverely($_GET['anmid'],1);
            		    if($resultseverely != false)
            		    {
                		    foreach($resultseverely as $followjobs)
                		    {
                		        $fljobs[] = array(
                		            "sno" => $followjobs->sno,
                		            "sname" => $followjobs->sname,
                		            "scode" => $followjobs->scode,
                		            "msno" => $followjobs->msno,
                		            "mandal" => $followjobs->mandal,
                		            "vsno" => $followjobs->vsno,
                		            "village" => $followjobs->village,
                		            "days" => $followjobs->count_of_severely,
                		            "student_count" => $followjobs->severely,
                		            "jobtype" => 'followupjobs',
                		            "type" => 'severely'
                		            ); 
                		    }
            		        $severely = $fljobs;
            		    }
            		    else
            		        $severely = array();
            		    $resultmildly = $this->get->activemildly($_GET['anmid'],1);
            		    if($resultmildly != false)
            		    {
                		    foreach($resultmildly as $followmildlyjobs)
                		    {
                		        $flmildlyjobs[] = array(
                		            "sno" => $followmildlyjobs->sno,
                		            "sname" => $followmildlyjobs->sname,
                		            "scode" => $followmildlyjobs->scode,
                		            "msno" => $followmildlyjobs->msno,
                		            "mandal" => $followmildlyjobs->mandal,
                		            "vsno" => $followmildlyjobs->vsno,
                		            "village" => $followmildlyjobs->village,
                		            "days" => $followmildlyjobs->count_of_mildly,
                		            "student_count" => $followmildlyjobs->mildly,
                		            "jobtype" => 'followupjobs',
                		            "type" => 'mildly'
                		            ); 
                		    }
            		        $mildly = $flmildlyjobs;
            		    }
            		    else
            		        $mildly = array();
                		if($resultseverely != false || $resultmildly != false)
                		{
            		        $activefollowups = array_merge($acjobs,$severely,$mildly);
                		}
                		else
                		{
                		    $activefollowups = $acjobs;
                		}
            		} 
            		else
            		{
            		    $activefollowups = $acjobs;
            		}
        		    $result['data']['activejobs'] = $activefollowups;
        		    //$result['data']['activejobs']['jobtype'] = 'activejob';
        		}
        		else
        		{
        		    $result['status'] = '400';
        		    $result['message'] = 'No data found';
        		    $result['data']['activejobs'] = array();
        		}
        		$followup = $this->get->followup($_GET['anmid'],$limit);
        		if($followup != false)
        		{
        		    if(count($this->get->followupmildly($_GET['anmid'],2)) == 1)
        		        $followupseverlimit = 4;
        		    else
        		        $followupseverlimit = 2;
        		    if($this->get->followupseverely($_GET['anmid'],$followupseverlimit) == true)
        		    {
        		        $severelyfollowup = $this->get->followupseverely($_GET['anmid'],$followupseverlimit);
        		    }
        		    else
        		    {
        		        $severelyfollowup = array();
        		    }
        		    if(count($this->get->followupseverely($_GET['anmid'],2)) == 1)
        		        $followupmildlimit = 4;
        		    else
        		        $followupmildlimit = 2;
        		    if($this->get->followupmildly($_GET['anmid'],$followupmildlimit) == true)
        		    {
        		        $mildlyfollowup = $this->get->followupmildly($_GET['anmid'],$followupmildlimit);
        		    }
        		    else
        		    {
        		        $mildlyfollowup = array();
        		    }
        		    $arrayfollowups = array_merge($severelyfollowup,$mildlyfollowup);
        		    $result['status'] = '200';
        		    $result['message'] = 'success';
        		    $result['data']['followup'] = $arrayfollowups;
        		}
        		else
        		{
        		    $result['status'] = '400';
        		    $result['message'] = 'No data found';
        		    $result['data']['followup'] = array();
        		}
        		$schoolreports = $this->get->activejobs($_GET['anmid'],$limit);
        		if($schoolreports != false)
        		{
        		    $result['status'] = '200';
        		    $result['message'] = 'success';
        		    $result['data']['schoolreports'] = $schoolreports;
        		}
        		else
        		{
        		    $result['status'] = '400';
        		    $result['message'] = 'No data found';
        		    $result['data']['schoolreports'] = array();
        		}
        		$mandalreports = $this->get->mandalreports($_GET['anmid'],$limit);
        		if($mandalreports != false)
        		{
        		    $result['status'] = '200';
        		    $result['message'] = 'success';
        		    $result['data']['mandalreports'] = $mandalreports;
        		}
        		else
        		{
        		    $result['status'] = '400';
        		    $result['message'] = 'No data found';
        		    $result['data']['mandalreports'] = array();
        		}
        	}
			else
			{
				$result = array('status' => '400', 'message' => 'ANM is Blocked', 'data' => array());
			}
	    }
	    else
	    {
    		$result['status'] = '400';
    		$result['message'] = 'No data found';
    		$result['data'] = array();
	    }
	    $result['data']['welcome'] = $welcome;
	    $result['data']['message'] = $message;
	    $result['data']['achieved'] = $achieved;
		$encode = json_encode($result);
		echo $encode;
		
	}
	public function single()
	{
	    if($this->uri->segment(3))
	    {
    		$notifications = $this->get->notifications($this->uri->segment(3));
    		if($notifications != false)
    		{
    		    $result['status'] = '200';
    		    $result['message'] = 'success';
    		    $result['data'] = $notifications;
    		    $encode = json_encode($result);
    		}
    		else
    		{
    		    $result['status'] = '400';
    		    $result['message'] = 'No data found';
    		    $result['data'] = array();
    		}
	    }
	    else
	    {
    		$result['status'] = '400';
    		$result['message'] = 'No data found';
    		$result['data'] = array();
	    }
		$encode = json_encode($result);
		echo $encode;
		
	}
	public function activejobs()
	{
	    if(isset($_GET['anmid']))
	    {
	        $anmid = $_GET['anmid'];
	        $user = $this->get->user($anmid);
		    if($user == true)
		    {
    	        $limit = '10000';
        		$activejobs = $this->get->activejobs($_GET['anmid'],$limit);
        		if($activejobs != false)
        		{
        		    $result['status'] = '200';
        		    $result['message'] = 'success';
        		    
        		    foreach($activejobs as $jobs)
        		    {
        		        $acjobs[] = array(
        		            "sno" => $jobs->sno,
        		            "sname" => $jobs->sname,
        		            "scode" => $jobs->scode,
        		            "msno" => $jobs->msno,
        		            "mandal" => $jobs->mandal,
        		            "vsno" => $jobs->vsno,
        		            "village" => $jobs->village,
        		            "jobtype" => 'activejobs',
        		            "type" => '',
        		            ); 
        		    }
        		    $followup = $this->get->followup($_GET['anmid'],$limit);
            		if($followup != false)
            		{
            		    $resultseverely = $this->get->activeseverely($_GET['anmid'],$limit);
            		    if($resultseverely != false)
            		    {
                		    foreach($resultseverely as $followjobs)
                		    {
                		        $fljobs[] = array(
                		            "sno" => $followjobs->sno,
                		            "sname" => $followjobs->sname,
                		            "scode" => $followjobs->scode,
                		            "msno" => $followjobs->msno,
                		            "mandal" => $followjobs->mandal,
                		            "vsno" => $followjobs->vsno,
                		            "village" => $followjobs->village,
                		            "days" => $followjobs->count_of_severely,
                		            "student_count" => $followjobs->severely,
                		            "jobtype" => 'followupjobs',
                		            "type" => 'severely'
                		            ); 
                		    }
            		        $severely = $fljobs;
            		    }
            		    else
            		        $severely = array();
            		    $resultmildly = $this->get->activemildly($_GET['anmid'],$limit);
            		    if($resultmildly != false)
            		    {
                		    foreach($resultmildly as $followmildlyjobs)
                		    {
                		        $flmildlyjobs[] = array(
                		            "sno" => $followmildlyjobs->sno,
                		            "sname" => $followmildlyjobs->sname,
                		            "scode" => $followmildlyjobs->scode,
                		            "msno" => $followmildlyjobs->msno,
                		            "mandal" => $followmildlyjobs->mandal,
                		            "vsno" => $followmildlyjobs->vsno,
                		            "village" => $followmildlyjobs->village,
                		            "days" => $followmildlyjobs->count_of_mildly,
                		            "student_count" => $followmildlyjobs->mildly,
                		            "jobtype" => 'followupjobs',
                		            "type" => 'mildly'
                		            ); 
                		    }
            		        $mildly = $flmildlyjobs;
            		    }
            		    else
            		        $mildly = array();
                		if($resultseverely != false || $resultmildly != false)
                		{
            		        $activefollowups = array_merge($acjobs,$severely,$mildly);
                		}
                		else
                		{
                		    $activefollowups = $acjobs;
                		}
            		} 
            		else
            		{
            		    $activefollowups = $acjobs;
            		}
        		    $result['data'] = $activefollowups;
        		}
        		else
        		{
        		    $result['status'] = '400';
        		    $result['message'] = 'No data found';
        		    $result['data'] = array();
        		}
        		$encode = json_encode($result);
        		echo $encode;
		    }
			else
			{
				$result = array('status' => '400', 'message' => 'ANM is Blocked', 'data' => array());
				$encode = json_encode($result);
				echo $encode;
			}
	    }
	    elseif(isset($_GET['schoolid']))
	    {
	        $schoolid = $_GET['schoolid'];
    		$schoolmandal = $this->get->schoolmandal($schoolid);
    		$array = '';
    		if($schoolmandal != false)
    		{
    		    $result['status'] = '200';
    		    $result['message'] = 'success';
    		    $array['mandal_school'] = $schoolmandal;
    		    $villages = $this->get->mandalvillages($schoolmandal[0]->msno);
    		    if($villages != false)
    		    {
    		        $array['villages'] = $villages;
    		    }
    		    $result['data'] = array($array);
        		$encode = json_encode($result);
        		echo $encode;
    		}
    		else
    		{
    		    $result['status'] = '400';
    		    $result['message'] = 'No data found';
    		    $result['data'] = array();
        		$encode = json_encode($result);
        		echo $encode;
    		}
	    }
	    elseif(!isset($_GET['anmid']))
	    {
    		$result['status'] = '400';
    		$result['message'] = 'No data found';
    		$result['data'] = array();
    		$encode = json_encode($result);
    		echo $encode;
	    }
		
	}
	public function followups()
	{
	    if(isset($_GET['anmid']))
	    {
	        $anmid = $_GET['anmid'];
		    $user = $this->get->user($anmid);
		    if($user == true)
    		{
    	        $limit = '10000';
        		$followup = $this->get->followup($_GET['anmid'],$limit);
        		if($followup != false)
        		{
        		    
        		    $resultseverely = $this->get->followupseverely($_GET['anmid'],$limit);
        		    if($resultseverely != false)
        		        $severely = $resultseverely;
        		    else
        		        $severely = array();
        		    $resultmildly = $this->get->followupmildly($_GET['anmid'],$limit);
        		    if($resultmildly != false)
        		        $mildly = $resultmildly;
        		    else
        		        $mildly = array();
        		    $arrayfollowups = array_merge($severely,$mildly);
        		    $result['status'] = '200';
        		    $result['message'] = 'success';
        		    $result['data'] = $arrayfollowups;
        		}
        		else
        		{
        		    $result['status'] = '400';
        		    $result['message'] = 'No data found';
        		    $result['data'] = array();
        		}
        		$encode = json_encode($result);
        		echo $encode;
    		}
			else
			{
				$result = array('status' => '400', 'message' => 'ANM is Blocked', 'data' => array());
				$encode = json_encode($result);
				echo $encode;
			}
	    }
	    else
	    {
    		$result['status'] = '400';
    		$result['message'] = 'No data found';
    		$result['data'] = array();
    		$encode = json_encode($result);
    		echo $encode;
	    }
		
	}
	public function schoolreports()
	{
	    if(isset($_GET['anmid']))
	    {
	        $anmid = $_GET['anmid'];
		    $user = $this->get->user($anmid);
		    if($user == true)
    		{
    	        $limit = '10000';
        		$schoolreports = $this->get->activejobs($_GET['anmid'],$limit);
        		if($schoolreports != false)
        		{
        		    $result['status'] = '200';
        		    $result['message'] = 'success';
        		    $result['data'] = $schoolreports;
        		}
        		else
        		{
        		    $result['status'] = '400';
        		    $result['message'] = 'No data found';
        		    $result['data'] = array();
        		}
    		}
			else
			{
				$result = array('status' => '400', 'message' => 'ANM is Blocked', 'data' => array());
			}
	    }
	    else
	    {
    		$result['status'] = '400';
    		$result['message'] = 'No data found';
    		$result['data'] = array();
	    }
		$encode = json_encode($result);
		echo $encode;
		
	}
	public function mandalreports()
	{
	    if(isset($_GET['anmid']))
	    {
	        $anmid = $_GET['anmid'];
		    $user = $this->get->user($anmid);
		    if($user == true)
    		{
	        
    	        $limit = '10000';
        		$mandalreports = $this->get->mandalreports($_GET['anmid'],$limit);
        		if($mandalreports != false)
        		{
        		    $result['status'] = '200';
        		    $result['message'] = 'success';
        		    $result['data'] = $mandalreports;
        		}
        		else
        		{
        		    $result['status'] = '400';
        		    $result['message'] = 'No data found';
        		    $result['data'] = array();
        		}
	        }
			else
			{
				$result = array('status' => '400', 'message' => 'ANM is Blocked', 'data' => array());
			}
	    }
	    else
	    {
    		$result['status'] = '400';
    		$result['message'] = 'No data found';
    		$result['data'] = array();
	    }
		$encode = json_encode($result);
		echo $encode;
		
	}
	public function activefollowups()
	{
	    if(isset($_GET['anmid']))
	    {
	        $anmid = $_GET['anmid'];
		    $user = $this->get->user($anmid);
		    if($user == true)
    		{
    	        $limit = '10000';
        		$followup = $this->get->followup($_GET['anmid'],$limit);
        		if($followup != false)
        		{
        		    $resultseverely = $this->get->activeseverely($_GET['anmid'],$limit);
        		    if($resultseverely != false)
        		    {
            		    foreach($resultseverely as $followjobs)
            		    {
            		        $fljobs[] = array(
            		            "sno" => $followjobs->sno,
            		            "sname" => $followjobs->sname,
            		            "days" => $followjobs->count_of_severely,
            		            "student_count" => $followjobs->severely,
            		            "jobtype" => 'followupjobs',
            		            "type" => 'severely'
            		            ); 
            		    }
        		        $severely = $fljobs;
        		    }
        		    else
        		        $severely = array();
        		    $resultmildly = $this->get->activemildly($_GET['anmid'],$limit);
        		    if($resultmildly != false)
        		    {
            		    foreach($resultmildly as $followmildlyjobs)
            		    {
            		        $flmildlyjobs[] = array(
            		            "sno" => $followmildlyjobs->sno,
            		            "sname" => $followmildlyjobs->sname,
            		            "days" => $followmildlyjobs->count_of_mildly,
            		            "student_count" => $followmildlyjobs->mildly,
            		            "jobtype" => 'followupjobs',
            		            "type" => 'mildly'
            		            ); 
            		    }
        		        $mildly = $flmildlyjobs;
        		    }
        		    else
        		        $mildly = array();
        		    $arrayfollowups = array_merge($severely,$mildly);
        		    $result['status'] = '200';
        		    $result['message'] = 'success';
        		    $result['data'] = $arrayfollowups;
        		}
        		else
        		{
        		    $result['status'] = '400';
        		    $result['message'] = 'No data found';
        		    $result['data'] = array();
        		}
	        }
			else
			{
				$result = array('status' => '400', 'message' => 'ANM is Blocked', 'data' => array());
			}
	    }
	    else
	    {
    		$result['status'] = '400';
    		$result['message'] = 'No data found';
    		$result['data'] = array();
	    }
		$encode = json_encode($result);
		echo $encode;
		
	}
	public function followupstudents()
	{
	    if(isset($_GET['anmid']) && isset($_GET['schoolid']) && isset($_GET['type']))
	    {
	        $anmid = $_GET['anmid'];
		    $user = $this->get->user($anmid);
		    if($user == true)
    		{
    	        $anmid = $_GET['anmid'];
    	        $schoolid = $_GET['schoolid'];
    	        $type = $_GET['type'];
    			$students = $this->get->anmfollowupstudents($anmid,$schoolid,$type);
    			if($students == true)
    			{
    			    foreach($students as $student)
        			{
        			    $json[] = array(
        			        'sno' => $student->sno,
        			        'mandal' => $student->mandal,
        			        'schools' => $student->schools,
        			        'village' => $student->village,
        			        's_name' => $student->s_name,
        			        'aadhar_no' => $student->aadhar_no,
        			        'f_name' => $student->f_name,
        			        'img' => $url.'uploads/'.$student->img,
        			        'mobile' => $student->mobile,
        			        'dob' => $student->dob,
        			        'age' => $student->age,
        			        'class' => $student->class,
        			        'exam_date' => $student->exam_date,
        			        'height' => $student->height,
        			        'weight' => $student->weight,
        			        'hb_level' => $student->hb_level,
        			        'address' => $student->address,
        			        'community' => $student->community,
        			        's_village' => $student->s_village,
        			        'house_no' => $student->house_no,
        			        );
        			}
        			$result['status'] = '200';
        		    $result['message'] = 'success';
        			$result['data'] = $json;
    			}
        	    else
        	    {
            		$result['status'] = '400';
            		$result['message'] = 'No data found';
            		$result['data'] = array();
        	    }
	        }
			else
			{
				$result = array('status' => '400', 'message' => 'ANM is Blocked', 'data' => array());
			}
	    }
	    else
	    {
    		$result['status'] = '400';
    		$result['message'] = 'No data found';
    		$result['data'] = array();
	    }
		$encode = json_encode($result);
		echo $encode;
		
	}
}