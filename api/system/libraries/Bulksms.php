<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class CI_Bulksms {
	var $CI;
    public function __construct()
    {
        $this->CI =&get_instance();
    }
    // public function index($numbers,$message)
    // {
	// 	$this->CI->db->select('site_name, senderID, url, user, password');
	// 	$this->CI->db->from('sms_credentials');
	// 	$this->CI->db->where('status','1');
	// 	$query = $this->CI->db->get();
	// 	if($query->num_rows() > 0){
	// 		$result = $query->row_array();
	// 		$phone = $numbers;
	// 		$url = $result['url'];
	// 		$username = $result['user'];
	// 		$password = $result['password'];
	// 		$from = $result['senderID'];
	// 		$text = $result['site_name']." \n ".$message;
    //     	$request = $url.'?user='.$username.'&password='.$password.'&senderid='.$from.'&channel=Trans&DCS=0&flashsms=0&number='.urlencode($phone).'&text='.urlencode($text).'&route=9';
    //     	$ch = curl_init();
    //     	curl_setopt($ch, CURLOPT_URL, $request);
    //     	curl_setopt($ch, CURLOPT_HEADER, 0);
    //     	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    //     	$response = curl_exec($ch);
    //     	curl_close($ch);
	// 	} 
	// 	else
	// 		return false;
    // }
    public function index($numbers,$otp)
    {
        $cPhone = $numbers;
        $message="Dear Customer, Your OTP is ".$otp." for registration. cell:9966604609 My Gallery Book";

        $username="sct-mybook";
        $password="admin";
        $type="0";
        $dlr="1";
        $entityid="1601100000000017828";
        $tempid="1607100000000297400";
        $senderId = "MGBOOK";
        $url="http://sms1.srichakratech.com/sendsms/bulksms?";
        
        $fields = array(
        'username'      => urlencode($username),
        'password'      => urlencode($password),
        'type'          => urlencode($type),
        'dlr'           => urlencode($dlr),
        'destination'   => urlencode($cPhone),
        'source'        => urlencode($senderId),
        'message'       => urlencode($message),
        'entityid'      => urlencode($entityid),
        'tempid'        => urlencode($tempid)
        );

        $fields_string = '';
        foreach($fields as $key=>$value)
        {
            if($key == 'tempid'){
				$fields_string .= $key.'='.$value;
			}
			else{
				$fields_string .= $key.'='.$value.'&';
			}
        }
        rtrim($fields_string,'&');
        $ch = curl_init();
        curl_setopt($ch,CURLOPT_URL,$url);
        curl_setopt($ch,CURLOPT_POST,count($fields));
        curl_setopt($ch,CURLOPT_POSTFIELDS,$fields_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        $response = curl_exec($ch);
        curl_close($ch);
        return true;
    }
}