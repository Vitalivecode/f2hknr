<?php
function publish_action($gps)
{
    if ($gps->get('primary'))
    {
        $db = GPS_db::get_instance();
        $query = 'UPDATE base_fields SET `bool` = b\'1\' WHERE id = ' . (int)$gps->get('primary');
        $db->query($query);
    }
}
function unpublish_action($gps)
{
    if ($gps->get('primary'))
    {
        $db = GPS_db::get_instance();
        $query = 'UPDATE base_fields SET `bool` = b\'0\' WHERE id = ' . (int)$gps->get('primary');
        $db->query($query);
    }
}

function exception_example($postdata, $primary, $gps)
{
    // get random field from $postdata
    $postdata_prepared = array_keys($postdata->to_array());
    shuffle($postdata_prepared);
    $random_field = array_shift($postdata_prepared);
    // set error message
    $gps->set_exception($random_field, 'This is a test error', 'error');
}

function test_column_callback($value, $fieldname, $primary, $row, $gps)
{
    return $value . ' - nice!';
}

function after_upload_example($field, $file_name, $file_path, $params, $gps)
{
    $ext = trim(strtolower(strrchr($file_name, '.')), '.');
    if ($ext != 'pdf' && $field == 'uploads.simple_upload')
    {
        unlink($file_path);
        $gps->set_exception('simple_upload', 'This is not PDF', 'error');
    }
}

function movetop($gps)
{
    if ($gps->get('primary') !== false)
    {
        $primary = (int)$gps->get('primary');
        $db = GPS_db::get_instance();
        $query = 'SELECT '.$gps->get('primarykey').' FROM '.$gps->get('table').' ORDER BY `sequence`,'.$gps->get('primarykey');
        $db->query($query);
        $result = $db->result();
        $count = count($result);

        $sort = array();
        foreach ($result as $key => $item)
        {
            if ($item[$gps->get('primarykey')] == $primary && $key != 0)
            {
                array_splice($result, $key - 1, 0, array($item));
                unset($result[$key + 1]);
                break;
            }
        }

        foreach ($result as $key => $item)
        {
            $query = 'UPDATE '.$gps->get('table').' SET `sequence` = ' . $key . ' WHERE '.$gps->get('primarykey').' = ' . $item[$gps->get('primarykey')];
            $db->query($query);
        }
    }
}
function movebottom($gps)
{
    if ($gps->get('primary') !== false)
    {
        $primary = (int)$gps->get('primary');
        $db = GPS_db::get_instance();
        $query = 'SELECT '.$gps->get('primarykey').' FROM '.$gps->get('table').' ORDER BY `sequence`,'.$gps->get('primarykey');
        $db->query($query);
        $result = $db->result();
        $count = count($result);

        $sort = array();
        foreach ($result as $key => $item)
        {
            if ($item[$gps->get('primarykey')] == $primary && $key != $count - 1)
            {
                unset($result[$key]);
                array_splice($result, $key + 1, 0, array($item));
                break;
            }
        }

        foreach ($result as $key => $item)
        {
            $query = 'UPDATE '.$gps->get('table').' SET `sequence` = ' . $key . ' WHERE '.$gps->get('primarykey').' = ' . $item[$gps->get('primarykey')];
            $db->query($query);
        }
    }
}

function show_description($value, $fieldname, $primary_key, $row, $gps)
{
    $result = '';
    if ($value == '1')
    {
        $result = '<i class="fa fa-check" />' . 'OK';
    }
    elseif ($value == '2')
    {
        $result = '<i class="fa fa-circle-o" />' . 'Pending';
    }
    return $result;
}

function custom_field($value, $fieldname, $primary_key, $row, $gps)
{
    return '<input type="text" readonly class="gps-input" name="' . $gps->fieldname_encode($fieldname) . '" value="' . $value .
        '" />';
}
function unset_val($postdata)
{
    $postdata->del('Paid');
}

function format_phone($new_phone)
{
    $new_phone = preg_replace("/[^0-9]/", "", $new_phone);

    if (strlen($new_phone) == 7)
        return preg_replace("/([0-9]{3})([0-9]{4})/", "$1-$2", $new_phone);
    elseif (strlen($new_phone) == 10)
        return preg_replace("/([0-9]{3})([0-9]{3})([0-9]{4})/", "($1) $2-$3", $new_phone);
    else
        return $new_phone;
}

function before_list_example($list, $gps)
{
    var_dump($list);
}

function after_update_test($pd, $pm, $xc)
{
    $xc->search = 0;
}

function after_upload_test($field, &$filename, $file_path, $upload_config)
{
    $filename = 'bla-bla-bla';
}
function checkEmail($postdata, $gps)
{
    date_default_timezone_set("Asia/Kolkata");
    $db = gps_db::get_instance();
    //$table = $gps->get_var('table');
    $email = $db->escape($postdata->get('email'));
    $query = 'SELECT email FROM `admin` WHERE email = '.$email.' AND status = "active"';
    $db->query($query);
    $result = $db->result();
    $count = count($result);
    if ($count > 0) {
        $gps->set_exception('email', 'This email id is already in use','error');
        echo "<script>jQuery.toast({
    			heading: 'This email id is already in use',
    			text: '',
    			position: 'top-right',
    			loaderBg: '#ff6849',
    			icon: 'error',
    			hideAfter: 3500,
    			stack: 6
    		})</script>";
    }
    $postdata->set('permissions', '[{"special_discounts":"add"},{"del_users":"add"},{"promotions":"add"},{"app_banners":"add"},{"restaurant_items":"add"},{"restaurant_menu":"add"},{"expenses":"add"},{"restaurant_submenu":"add"},{"about_us":"add"},{"contact_us":"add"},{"special_discounts":"edit"},{"del_users":"edit"},{"promotions":"edit"},{"app_banners":"edit"},{"restaurant_items":"edit"},{"restaurant_menu":"edit"},{"expenses":"edit"},{"restaurant_submenu":"edit"},{"about_us":"edit"},{"contact_us":"edit"},{"special_discounts":"delete"},{"del_users":"delete"},{"app_banners":"delete"},{"restaurant_items":"delete"},{"restaurant_menu":"delete"},{"expenses":"delete"},{"restaurant_submenu":"delete"},{"del_users":"view"},{"promotions":"view"},{"app_banners":"view"},{"expenses":"view"},{"restaurant_submenu":"view"},{"about_us":"view"},{"contact_us":"view"},{"order_feedback":"view"}]');
}
function checkUpdateEmail($postdata, $primary, $gps)
{
    date_default_timezone_set("Asia/Kolkata");
    $db = gps_db::get_instance();
    $email = $db->escape($postdata->get('email'));
    $query = 'SELECT email FROM `admin` WHERE email = '.$email.' AND sno != '.$primary.' AND status = "active"';
    $db->query($query);
    $result = $db->result();
    $count = count($result);
    if ($count > 0) {
        $gps->set_exception('email', 'This email id is already in use','error');
        echo "<script>jQuery.toast({
    			heading: 'This email id is already in use',
    			text: '',
    			position: 'top-right',
    			loaderBg: '#ff6849',
    			icon: 'error',
    			hideAfter: 3500,
    			stack: 6
    		})</script>";
    }
    $postdata->set('permissions', '[{"special_discounts":"add"},{"del_users":"add"},{"promotions":"add"},{"app_banners":"add"},{"restaurant_items":"add"},{"restaurant_menu":"add"},{"expenses":"add"},{"restaurant_submenu":"add"},{"about_us":"add"},{"contact_us":"add"},{"special_discounts":"edit"},{"del_users":"edit"},{"promotions":"edit"},{"app_banners":"edit"},{"restaurant_items":"edit"},{"restaurant_menu":"edit"},{"expenses":"edit"},{"restaurant_submenu":"edit"},{"about_us":"edit"},{"contact_us":"edit"},{"special_discounts":"delete"},{"del_users":"delete"},{"app_banners":"delete"},{"restaurant_items":"delete"},{"restaurant_menu":"delete"},{"expenses":"delete"},{"restaurant_submenu":"delete"},{"del_users":"view"},{"promotions":"view"},{"app_banners":"view"},{"expenses":"view"},{"restaurant_submenu":"view"},{"about_us":"view"},{"contact_us":"view"},{"order_feedback":"view"}]');
}
function uniqueId($postdata)
{
    date_default_timezone_set("Asia/Kolkata");
    $sybl = str_split('!@#$%^&*'); 
    $alpha = str_split('ABCDEFGHIJKLMNOPQRSTUVWXYZ'); 
    $num = str_split('0123456789'); 
    shuffle($sybl); 
    $randsybl = '';
    foreach (array_rand($sybl, 2) as $k) $randsybl .= $sybl[$k];
    shuffle($alpha); 
    $randalpha = '';
    foreach (array_rand($alpha, 3) as $k) $randalpha .= $alpha[$k];
    shuffle($num); 
    $randnum = '';
    foreach (array_rand($num, 3) as $k) $randnum .= $num[$k];
    $unique = $randsybl.$randalpha.$randnum;
    $empId = str_shuffle($unique);
    $postdata->set('login_id', $empId);
    $postdata->set('pass', md5($empId));
}
/************ new ****************/
function base_url()
{
	$ark_root  = "http://".$_SERVER['HTTP_HOST'];
	$ark_root .= str_replace(basename($_SERVER['SCRIPT_NAME']),"",$_SERVER['SCRIPT_NAME']);
	return $ark_root;
}
function bulkSMS($numbers,$message)
{
	date_default_timezone_set("Asia/Kolkata");
    $db = gps_db::get_instance();
	$sql = 'select * from sms_credentials  where status = "1" ';
	$db->query($sql);
	$results = $db->result();
	$count = count($results);
	if($count) 
	{
		$phone = $numbers;
		$url = $results[0]['url'];
		$username = $results[0]['user'];
		$password = $results[0]['password'];
		$from = $results[0]['senderID'];
		$route = $results[0]['route'];
		$text = $message;
		$request = $url.'?user='.$username.'&password='.$password.'&senderid='.$from.'&channel=Trans&DCS=0&flashsms=0&number='.urlencode($phone).'&text='.urlencode($text).'&route='.$route;
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $request);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$response = curl_exec($ch);
		curl_close($ch);
	}
	else
		return false;
}
function promotional($postdata, $gps)
{
    date_default_timezone_set("Asia/Kolkata");
    $db = gps_db::get_instance();
    $emails = array();
	$mobiles = array();
	$tokens = array();
    $branch = !empty($postdata->get('branch'))?$postdata->get('branch'):'';
	$type = !empty($postdata->get('type'))?$postdata->get('type'):'';
	$subject = $postdata->get('subject');
	$message = $postdata->get('message');
	$image = ($postdata->get('image') != '')?base_url().'../../uploads/'.$postdata->get('image'):'';
    if((int)$branch && $type != '')
    {
		if($type == 'Mail')
		{
			$sql = 'select email from app_users  where store = "'.$branch.'" and email != "" ';
			$db->query($sql);
			$results = $db->result();
			$count = count($results);
			if($count) 
			{
				foreach($results as $result)
				{
					$emails[] = $result['email'];
				}
			}
			
			$uniqEmails = array_unique($emails);
			$commaEmails = implode(',',$uniqEmails);
			if($commaEmails != '')
			{
				$to = $commaEmails;
				$subject = $subject;
				$message = '<html>
					<head>
						<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
						<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
						<title>iExam</title>	
					</head>
					<body>
						<div class="emailtemp"  style="text-align :center;">
							<div class="head" style="background:#4F5467;">
								<div class="logo" style="text-align :center; v-align:middle; padding:15px;">
									<img src="'.base_url().'../../uploads/logo_(2).png" alt="F2H" style="max-height: 45px;" />
								</div> 
							</div>
							<div class="body">'.$postdata->get('message').'</div>
							<div class="foot" style="background:#4F5467; padding: 2px 0px; color:#fff;">
								<p>&copy; '.date('Y').' <a href="http://'.$_SERVER["HTTP_HOST"].'" target="_blank" style="color:#fff; text-decoration:none;">F2H</a></p>
								
							</div>
						</div>
				</body>
				</html>';
				$setSql = 'select sentmail from settings';
				$db->query($setSql);
				$results = $db->result();
				$headers = "MIME-Version: 1.0" . "\r\n";
				$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
				$headers .= 'From: <'.$results[0]["sentmail"].'>' . "\r\n";
				$headers .= 'Bcc: rudra.pranay@gmail.com' . "\r\n";
				mail($to,$subject,$message,$headers);
			}
		}
		elseif($type == 'SMS')
		{ 
			$sql = 'select mobile from app_users  where store = "'.$branch.'" and mobile != "" ';
			$db->query($sql);
			$results = $db->result();
			$count = count($results);
			if($count) 
			{
				foreach($results as $result)
				{
					$mobiles[] = $result['mobile'];
				}
			}
			$uniqMobiles = array_unique($mobiles);
			$commaMobiles = implode(',',$uniqMobiles);
			if($commaMobiles != '')
			{ 
				$numbers = $commaMobiles;
				$text = $subject.": ".$message;
				bulkSMS($numbers,$text);
			}
		}
		elseif($type == 'Notification')
		{
			$sql = 'select gcm_registration_id from app_users  where store = "'.$branch.'" and gcm_registration_id != "" limit 1000 ';
			$db->query($sql);
			$results = $db->result();
			$count = count($results);
			$link = '';
			$uniqTokens = array();
			define( 'API_ACCESS_KEY', 'AAAA0SsIS4U:APA91bFmMMsRxSe79OptmuxmCC_dnwPEmx8EoGXW5fn-jLHgeXy4TgcYbSWTQwOng705ktie2SnicryzGYosATNkhseS-aB6CQzprYnMdU_jYHM7jnIA_GFAD7nndMbx4R_xqI3NcD0L');
				$msg = array
				(
					'body' 	=> $message,
					'title'	=> $subject,
					'click_action' => $link,
					'sound' => 'default',
					'icon' => $image,
					'color' => '#c41e63',
					'image' => $image
				);
				if($count)
				{
					$tokens = '';
					foreach($results as $result)
					{
						//$tokens = "'".$result['gcm_registration_id']."',".$tokens;
						$tokens[] = $result['gcm_registration_id'];
					}
					$uniqTokens = array_unique($tokens);
					//$uniqTokens = substr($tokens,0,-1);
					//$object = (object)$uniqTokens;
					//print_r(count($uniqTokens));
					if($uniqTokens != '')
					{
						$fields = array
						(
							'registration_ids' => $uniqTokens,
							'notification'	=> $msg
						);
						$headers = array
						(
							'Authorization: key=' . API_ACCESS_KEY,
							'Content-Type: application/json'
						);	
						$ch = curl_init();
						curl_setopt( $ch,CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send' );
						curl_setopt( $ch,CURLOPT_POST, true );
						curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
						curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
						curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
						curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode($fields) );
						$result = curl_exec($ch );
						//echo $result;
						curl_close( $ch );
					}	
				}
		}
		date_default_timezone_set("Asia/Kolkata");
		$postdata->set('created_at', date('Y-m-d H:i:s'));
    }
	else{
		$gps->set_exception('branch', 'Please try again','error');
        echo "<script>jQuery.toast({
    			heading: 'Please try again',
    			text: '',
    			position: 'top-right',
    			loaderBg: '#ff6849',
    			icon: 'error',
    			hideAfter: 3500,
    			stack: 6
    		})</script>";
	}
}

function open_store($gps)
{
    if ($gps->get('primary'))
    {
        $db = GPS_db::get_instance();
        $query = 'UPDATE '.$gps->get('table').' SET `availability` = b\'1\' WHERE rest_id = ' . (int)$gps->get('primary');
        $db->query($query);
    }
}
function close_store($gps)
{
    if ($gps->get('primary'))
    {
        $db = GPS_db::get_instance();
        $query = 'UPDATE '.$gps->get('table').' SET `availability` = \'0\' WHERE rest_id = ' . (int)$gps->get('primary');
        $db->query($query);
    }
}

function active_action($gps)
{
    if ($gps->get('primary'))
    {
        $db = GPS_db::get_instance();
        $query = 'UPDATE '.$gps->get('table').' SET `status` = b\'1\' WHERE '.$gps->get('primarykey').' = ' . (int)$gps->get('primary');
        $db->query($query);
    }
}
function deactive_action($gps)
{
    if ($gps->get('primary'))
    {
        $db = GPS_db::get_instance();
        $query = 'UPDATE '.$gps->get('table').' SET `status` = \'0\' WHERE '.$gps->get('primarykey').' = ' . (int)$gps->get('primary');
        $db->query($query);
    }
}

function special_action($gps)
{
    if ($gps->get('primary'))
    {
        $db = GPS_db::get_instance();
        $query = 'UPDATE '.$gps->get('table').' SET `today_special` = b\'1\' WHERE item_id = ' . (int)$gps->get('primary');
        $db->query($query);
    }
}
function undo_action($gps)
{
    if ($gps->get('primary'))
    {
        $db = GPS_db::get_instance();
        $query = 'UPDATE '.$gps->get('table').' SET `today_special` = \'0\' WHERE item_id = ' . (int)$gps->get('primary');
        $db->query($query);
    }
}

function created_date($postdata, $gps)
{
    date_default_timezone_set("Asia/Kolkata");
    $postdata->set('created_at', date('Y-m-d H:i:s'));
}
function modify_date($postdata, $gps)
{
    date_default_timezone_set("Asia/Kolkata");
    $postdata->set('modified_at', date('Y-m-d H:i:s'));
}
function add_catsequence($postdata, $gps)
{
	date_default_timezone_set("Asia/Kolkata");
	$db = GPS_db::get_instance();
    $sql = 'select MAX(`sequence`) as `orders` from `restaurant_menu`';
	$db->query($sql);
	$results = $db->result();
	$count = count($results);
	if($count) 
	{
		$sequence = $results[0]['orders']+1;
		$postdata->set('sequence', $sequence);
		$postdata->set('created_at', date('Y-m-d H:i:s'));
	}
}
function add_subcatsequence($postdata, $gps)
{
	date_default_timezone_set("Asia/Kolkata");
	$db = GPS_db::get_instance();
    $sql = 'select MAX(`sequence`) as `orders` from `restaurant_submenu`';
	$db->query($sql);
	$results = $db->result();
	$count = count($results);
	if($count) 
	{
		$sequence = $results[0]['orders']+1;
		$postdata->set('sequence', $sequence);
		$postdata->set('created_at', date('Y-m-d H:i:s'));
	}
}