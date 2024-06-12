<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Dashboard extends CI_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->model('get');
								}
	public function index()
	{
	    
		$result['status'] = '200';
		$result['message'] = 'success';
		$dashboard = $this->get->dashboard('all');
		if($dashboard != false)
		{
		    $result['data'] = array( array(
		        'total_students' => 'Today You Have Covered '.$this->get->dashboard('all')[0]->total_students.' number of student',
		        'healthy' => $this->get->healthy('all'),
		        'severely' => $this->get->severely('all'),
		        'moderately' => $this->get->moderately('all'),
		        'mildly' => $this->get->mildly('all'))
		        );
		    $encode = json_encode($result);
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
	public function school()
	{
	    if($this->uri->segment(3))
	    {
	        $schoolid = $this->uri->segment(3);
    		$result['status'] = '200';
    		$result['message'] = 'success';
    		$dashboard = $this->get->dashboard($schoolid);
    		if($dashboard != false)
    		{
    		    $school = $this->get->skls($schoolid);
    		    if($school != false)
    		        $schoolname = $school[0]->sname;
    		    else
    		        $schoolname = '';
    		        $total = $this->get->dashboard($schoolid)[0]->total_students;
    		    $result['data'] = array( array(
    		        'total_student_count' => $total,
    		        'total_students' => 'Today You Have Covered '.$total.' number of student in '.$schoolname,
    		        'school_name' => $schoolname,
    		        'healthy' => $this->get->healthy($schoolid,$total),
    		        'severely' => $this->get->severely($schoolid,$total),
    		        'moderately' => $this->get->moderately($schoolid,$total),
    		        'mildly' => $this->get->mildly($schoolid,$total))
    		        );
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
	public function healthy()
	{
	    if($this->uri->segment(3))
	    {
	        $schoolid = $this->uri->segment(3);
    		$result['status'] = '200';
    		$result['message'] = 'success';
    		$hp = 11;
    		$hb_level = 'hb_level >=';
    		$hp2 = '';
    		$hb_level2 = '';
    		$healthystudents = $this->get->school_hp($schoolid,$hb_level,$hp,$hb_level2,$hp2);
    		if($healthystudents != false)
    		{
    		    $school = $this->get->skls($schoolid);
    		    if($school != false)
    		        $schoolname = $school[0]->sname;
    		    else
    		        $schoolname = '';
    		    $studentdata = '';
    		    foreach($healthystudents as $student)
    		    {
    		        $studentdata[] = $student;
    		    }
    		    $result['data'] = array('schoolname' => $schoolname,'studentdata'=>$studentdata);
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
	public function severely()
	{
	    if($this->uri->segment(3))
	    {
	        $schoolid = $this->uri->segment(3);
    		$result['status'] = '200';
    		$result['message'] = 'success';
    		$hp = 7;
    		$hb_level = 'hb_level <';
    		$hp2 = '';
    		$hb_level2 = '';
    		$healthystudents = $this->get->school_hp($schoolid,$hb_level,$hp,$hb_level2,$hp2);
    		if($healthystudents != false)
    		{
    		    $school = $this->get->skls($schoolid);
    		    if($school != false)
    		        $schoolname = $school[0]->sname;
    		    else
    		        $schoolname = '';
    		    $studentdata = '';
    		    foreach($healthystudents as $student)
    		    {
    		        $studentdata[] = $student;
    		    }
    		    $result['data'] = array('schoolname' => $schoolname,'studentdata'=>$studentdata);
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
	public function moderately()
	{
	    if($this->uri->segment(3))
	    {
	        $schoolid = $this->uri->segment(3);
    		$result['status'] = '200';
    		$result['message'] = 'success';
    		$hp = 7;
    		$hb_level = 'hb_level >=';
    		$hp2 = 9;
    		$hb_level2 = 'hb_level <';
    		$healthystudents = $this->get->school_hp($schoolid,$hb_level,$hp,$hb_level2,$hp2);
    		if($healthystudents != false)
    		{
    		    $school = $this->get->skls($schoolid);
    		    if($school != false)
    		        $schoolname = $school[0]->sname;
    		    else
    		        $schoolname = '';
    		    $studentdata = '';
    		    foreach($healthystudents as $student)
    		    {
    		        $studentdata[] = $student;
    		    }
    		    $result['data'] = array('schoolname' => $schoolname,'studentdata'=>$studentdata);
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
	public function mildly()
	{
	    if($this->uri->segment(3))
	    {
	        $schoolid = $this->uri->segment(3);
    		$result['status'] = '200';
    		$result['message'] = 'success';
    		$hp = 9;
    		$hp2 = 11;
    		$hb_level = 'hb_level >=';
    		$hb_level2 = 'hb_level <';
    		$healthystudents = $this->get->school_hp($schoolid,$hb_level,$hp,$hb_level2,$hp2);
    		if($healthystudents != false)
    		{
    		    $school = $this->get->skls($schoolid);
    		    if($school != false)
    		        $schoolname = $school[0]->sname;
    		    else
    		        $schoolname = '';
    		    $studentdata = '';
    		    foreach($healthystudents as $student)
    		    {
    		        $studentdata[] = $student;
    		    }
    		    $result['data'] = array('schoolname' => $schoolname,'studentdata'=>$studentdata);
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
}