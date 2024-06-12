<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Sms extends CI_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->model('get');
	}
	public function index()
	{
            	$apiKey = urlencode('uEM5xniqsLk-UBmgD0mxweCKzdILVvsaWDOsXXKH8Z');
            	$numbers = '9030894779';
            	$sender = urlencode('SAMATA');
            	$message = rawurlencode('1. రెడ్డిగారు.

మీ కూతురు శ్రీలత తెలంగాణ ప్రభుత్వ అనిమీషియా నిర్మూలన వారిచే అనిమియోబి ( రక్తహీనత ) ఉంది అని నిర్ధారించారు.

2. అనీమియా ద్వారా వచ్చే రక్త బలహీనతతో మీ బిడ్డ అలసిపోయి, ఎదుగుదల మరియు కాన్సెన్ట్రేషన్ దేనిపైనా కూడా చేయలేదు.

3. శ్రీలత బాగుండటానికి మీరు ఆమెకు ఇవ్వవల్సినవి పాలకూర, మేతికూర, బీట్ రూట్, అరటిపండ్లు, మొలకెత్తిన పెసర్లు, కర్జూరము, నట్స్, చేపలు, మాంసము, లివర్ మరియు నువ్వుల, లడ్డు');
             
            	//$numbers = implode(',', $numbers);
            	$sms = array('apikey' => $apiKey, 'numbers' => $numbers, "sender" => $sender, "message" => $message, "unicode" => 1);
            	$ch = curl_init('https://api.textlocal.in/send/');
            	curl_setopt($ch, CURLOPT_POST, true);
            	curl_setopt($ch, CURLOPT_POSTFIELDS, $sms);
            	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            	$response = curl_exec($ch);
            	curl_close($ch);
            	echo $response;
	}
}