<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Cms extends CI_Controller {
	public function __construct(){
		parent::__construct();
        $this->load->library('Site');
		$this->site->maintenance();
		$this->load->library('Auth_user');
		$this->auth_user->checkLogin();
		$this->load->model('adminpanel');
        $this->load->model('alert');
        $this->load->model('get');
								}
	public function index()
	{
		$this->load_header();
		$this->load_body();
		$this->load_footer();
	}
	public function load_header()
	{
    	$data['userdata']=$this->auth_user->checkLogin();
        $table = str_replace('-','_',$this->uri->segment(2));
	    if($data['userdata'][0]->role != 'superadmin')
	    {
    	    $per = $this->auth_user->permissions($data['userdata'][0]->permissions,$table);
    	    if($per)
    	    {
                $data['site']=$this->site->settings();
        		$data['tables']=$this->adminpanel->tables();
                $data['ct']=$this->adminpanel->createtable();
        		if(!empty($table))
        		{
        			$getdata = $this->adminpanel->gettable($table);
        			if($getdata[0]->cttitle != 'empty')
        				$data['title'] = ucfirst($getdata[0]->cttitle);
        			else
        				$data['title']="Page Not Found";
        		}
        		else
        			$data['title']="Page Not Found";
        		$this->load->view('include/header',$data);
    	    }
    	    else
    	    {
    	        redirect(base_url('home'));
    	    }
	    }
	    else
	    {
	        $data['site']=$this->site->settings();
        	$data['tables']=$this->adminpanel->tables();
            $data['ct']=$this->adminpanel->createtable();
        	if(!empty($table))
        	{
        		$getdata = $this->adminpanel->gettable($table);
        		    if($getdata[0]->cttitle != 'empty')
        		$data['title'] = ucfirst($getdata[0]->cttitle);
        		else
        			$data['title']="Page Not Found";
        	}
        	else
        		$data['title']="Page Not Found";
        	$this->load->view('include/header',$data);
	    }
	}
	public function load_body()
	{
        $data['title']="Page Not Found";
        $this->load->view('error404',$data);
	}
	public function page($param)
	{
		$table = strtolower(str_replace('-','_',$param));
        $this->load_header();
        $data['ct'] = $this->adminpanel->perm($table);
        $cid = $data['ct'][0]['cid'];
        $data['manage'] = $this->adminpanel->mnge($cid);
        $requ_fields = json_decode($data['ct'][0]['required_fields']);
        $data['permissions'] = json_decode($data['ct'][0]['permissions']);
        $data['userdata']=$this->auth_user->checkLogin();
		$tablename = lcfirst($table);
        if($data['ct'] == true)
        { 
            $gps = gps_get_instance(); 
            $gps->table($tablename);
            if($data['permissions']->title == 'inactive')
                $gps->unset_title();
            $editPer = $this->permissions($data['userdata'][0]->permissions,$table);
            //print_r($editPer);
            if(!in_array('add',$editPer))
            {
                if($data['permissions']->add == 'inactive' && $data['userdata'][0]->role == 'superadmin')
                {
                    $gps->unset_add();
                }
                elseif($data['userdata'][0]->role != 'superadmin')
                {
                    $gps->unset_add();
                }
            }
            if(!in_array('edit',$editPer))
            {
                if($data['permissions']->edit == 'inactive' && $data['userdata'][0]->role == 'superadmin')
                {
                    $gps->unset_edit();
                }
                elseif($data['userdata'][0]->role != 'superadmin')
                {
                    $gps->unset_edit();
                }
                //if($data['permissions']->edit == 'inactive')
                //    $gps->unset_edit();
            }
            if(!in_array('delete',$editPer))
            {
                if($data['permissions']->remove == 'inactive' && $data['userdata'][0]->role == 'superadmin')
                {
                    $gps->unset_remove();
                }
                elseif($data['userdata'][0]->role != 'superadmin')
                {
                    $gps->unset_remove();
                }
                //if($data['permissions']->remove == 'inactive')
                //    $gps->unset_remove();
            }
            if(!in_array('view',$editPer))
            {
                if($data['permissions']->view == 'inactive' && $data['userdata'][0]->role == 'superadmin')
                {
                    $gps->unset_view();
                }
                elseif($data['userdata'][0]->role != 'superadmin')
                {
                    $gps->unset_view();
                }
                //if($data['permissions']->view == 'inactive')
                //    $gps->unset_view();
            }
            if($data['permissions']->csv == 'inactive')
                $gps->unset_csv();
            if($data['permissions']->print == 'inactive')
                $gps->unset_print();
            if($data['permissions']->search == 'inactive')
                $gps->unset_search();
            if($data['permissions']->numbers == 'inactive')
                $gps->unset_numbers();
            if($data['permissions']->pagination == 'inactive')
                $gps->unset_pagination();
            if($data['permissions']->limitlist == 'inactive')
                $gps->unset_limitlist();
            if($data['permissions']->sortable == 'inactive')
                $gps->unset_sortable();
            if(!empty($data['ct'][0]['rename_column']))
            { 
                $j = json_decode($data['ct'][0]['rename_column']);
                foreach($j  as $key => $p)
                {
                    $gps->label(array($key => $p,));
                }
            }
            if(!empty($data['manage'][0]['changetype']))
            { 
                foreach($data['manage'] as $ctype)
                {
                    $ct = json_decode($ctype['changetype']);
                    if($ct->type == 'image' && $ct->crop != 'ratio_crop')
                        $gps->change_type($ct->col_name,$ct->type,$ct->any,array('width' => $ct->width, 'height' => $ct->height, $ct->crop => true));
					else if($ct->type == 'image' && $ct->crop == 'ratio_crop') {
						$gps->change_type($ct->col_name,$ct->type, $ct->any, array('ratio' => $ct->width/$ct->height, 'manual_crop' => true)); }
					else if($ct->type == 'thumbs')
						$gps->change_type($ct->col_name,'image','',array('thumbs'=>array(array('width'=> $ct->small, 'folder' => 'thumbs/small'),array('width'=> $ct->middle, 'folder' => 'thumbs/middle'),array('width' => $ct->big,'folder' => 'thumbs/big'))));
					else if($ct->type == 'remote_image')
                        $gps->change_type($ct->col_name,$ct->type,$ct->any,array('link' => $ct->links));
                    else if($ct->type == 'file')
                        $gps->change_type($ct->col_name,$ct->type,$ct->any,array($ct->frename => true));
                    else if($ct->type == 'password')
                        $gps->change_type($ct->col_name,$ct->type,$ct->pencrypt);
                    else if($ct->type == 'select')
                        $gps->change_type($ct->col_name,$ct->stype,$ct->s_selected,array('values' => $ct->s_options));
                    else if($ct->type == 'datetime')
                        $gps->change_type($ct->col_name,$ct->dtype,$ct->d_any);
                    else if($ct->type == 'textarea')
                        $gps->change_type($ct->col_name,$ct->type);
                    else if($ct->type == 'int')
                        $gps->change_type($ct->col_name,$ct->type);
                    else if($ct->type == 'text')
                        $gps->change_type($ct->col_name,$ct->type);
                    else if($ct->type == 'timestamp')
                        $gps->change_type($ct->col_name,$ct->type);
					else if($ct->type == 'relation')
					{
						if(!empty($ct->typevalue)){
							$type = array($ct->typename => $ct->typevalue);
							$gps->relation($ct->col_name,$ct->tablename,$ct->valuename,$ct->displayname,$type);}
						else
							$gps->relation($ct->col_name,$ct->tablename,$ct->valuename,$ct->displayname);
					}
					else if($ct->type == 'relation_depend')
					{
						if(!empty($ct->typevalue)){
							$type = array($ct->typename => $ct->typevalue);
							$gps->relation($ct->col_name,$ct->tablename,$ct->valuename,$ct->displayname,$type,'','','','',$ct->dependvaluename,$ct->dependcolname);
						}
						else
							$gps->relation($ct->col_name,$ct->tablename,$ct->valuename,$ct->displayname,'','','','',$ct->dependvaluename,$ct->dependcolname);
						//$gps->relation('region','meta_location','id','local_name','type = \'RE\'','','','','','in_location','country');
					}
					else if($ct->type == 'join')
					{
						$gps->join($ct->col_name,$ct->tablename,$ct->valuename);
					}
					else if($ct->type == 'highlight')
					{
						$gps->highlight($ct->col_name,$ct->condition,$ct->valuename,$ct->color);
					}
					else if($ct->type == 'highlight_row')
					{
						$gps->highlight_row($ct->col_name,$ct->condition,$ct->valuename,$ct->color);
					}
					else if($ct->type == 'map')
					{
						$pin = $ct->latitude.','.$ct->longitude;
						$gps->change_type($ct->col_name,$ct->point,$pin,array('text'=>'Your are here'));
					}
                }
            }
            if(!empty($data['ct'][0]['required_fields']))
            {
                $requ_fields = json_decode($data['ct'][0]['required_fields']);
                foreach($requ_fields as $key => $requ_field)
                {
                    if($requ_field == 'required')
                        $gps->validation_required($key);
                    else if($requ_field == 'readonly')
                        $gps->readonly($key);
                    else if($requ_field == 'disabled')
                        $gps->disabled($key);

                }
            }
            if(!empty($data['ct'][0]['hidden']))
            {
                $hidden_fields = json_decode($data['ct'][0]['hidden']);
                foreach($hidden_fields as $key => $hidden_field)
                {
                    if($hidden_field == 'hidden')
                    {
                        if($tablename != 'orders')
                        {
                            if($tablename != 'customers' && $tablename != 'drivers')
                            {
                                $gps->columns($key,true);
                                $gps->fields($key,true);
                            }
                        }
                    }
                }
            }
            if(!empty($data['ct'][0]['pattern']))
            {
                $pttrn_fields = json_decode($data['ct'][0]['pattern']);
                foreach($pttrn_fields as $key => $pttrn_field)
                {
                    if($pttrn_field != '')
                    {
                        $gps->validation_pattern($key,$pttrn_field);
                    }
                }
            } 
            if(!empty($data['ct'][0]['order_by']))
            {
                $order_by = json_decode($data['ct'][0]['order_by']);
                foreach($order_by as $key => $orderby)
                {
                    if($orderby != '')
                    {
                        $gps->order_by($key,$orderby);
                    }
                }
            } 
			$login_id = $this->session->userdata('logged_in')['id'];
			$role = $this->session->userdata('logged_in')['role'];
			$name = $this->session->userdata('logged_in')['name'];
			$branchID = $this->session->userdata('logged_in')['branch'];
			$vendorsData = array('' => '- none -');
			if($this->session->userdata('logged_in')['role'] == 'vendor')
				$branches = $this->get->table('restaurants',array('rest_id' => $branchID));
			else
				$branches = $this->get->table('restaurants');
			if($branches != false)
			{
				foreach($branches as $branch)
					$vendorsData[$branch->rest_id] = $branch->rest_name;
			}
				
            if($tablename == 'user_cart')
            {
				//$gps->query("SELECT `vendor_id`,`order_id`,`order_type`,`order_status`,`name`,`item_details`,`user_id`,`created_at` FROM `user_cart` WHERE `online_order` = '0' GROUP BY `order_id`");
				$gps->where('online_order','0');
				//$gps->groupBy('order_id');
				$gps->label(array('vendor_id' => 'Vendor', 'order_id' => 'Order Id', 'order_type' => 'Type', 'order_status' => 'Status', 'user_id' => 'Mobile No.', 'created_at' => 'Order Placed On'));
				$gps->columns(array('vendor_id','order_id','order_type','order_status','name','item_details','user_id','created_at'),false);
				$gps->change_type('order_type','select','',array('values' => array('1' => 'Take away', '2' => 'Door delivery')));
				$gps->highlight('order_type','=','1','#ffa50059');
				$gps->highlight('order_type','=','2','#0000ff59');
				$gps->change_type('order_status','select','',array('values' => array('1' => 'Pending', '2' => 'Accepted', '4' => 'Delivered', '5' => 'Cancelled', '6' => 'Returned')));
				$gps->highlight('order_status','=','1','#ffa50059');
				$gps->highlight('order_status','=','2','#0000ff59');
				$gps->highlight('order_status','=','4','#00800061');
				$gps->highlight('order_status','=','5','#ff00005c');
				$gps->highlight('order_status','=','6','#ff00005c');
                //$gps->where('isActive','1');
                //$gps->where('quoteid !=','');
                //$gps->subselect('Pick Up','CONCAT_WS(", ",source, suburbSourceId)');
		        //$gps->subselect('Delivery','CONCAT_WS(", ",receivingCompany, destination, suburbDestinationId)');
                //$gps->columns(array('quoteid','customerid','Pick Up','Delivery','description','servicetype'),false);
                //$gps->button(base_url('jobs/create/{id}?action=quote'),'Edit','glyphicon glyphicon-pencil',' btn-warning',array('target'=>'_self'));
                //$gps->create_action('delete', 'delete_action');
				/*
                $gps->button('javascript:;', 'Delete', 'glyphicon glyphicon-trash', 'gps-action btn-danger', 
                array(
                    'data-task' => 'action',
                    'data-action' => 'delete',
                    'data-toggle' => 'tooltip',
                    'data-placement' => 'bottom',
                    'data-table' => 'orders',
                    'data-confirm' => 'Do you really want remove this entry?',
                    'data-primary' => '{id}'),
                array(
                    'isActive',
                    '=',
                    '1')); */
            }
            if($tablename == 'restaurant_menu')
            { 
				if($this->session->userdata('logged_in')['role'] == 'vendor')
					$gps->where('vendor_id', $branchID);
                $gps->pass_var('createdBy', $login_id,'create');
    			$gps->pass_var('modifiedBy', $login_id,'edit');
    			//$gps->before_insert('created_date');
				$gps->before_insert('add_catsequence');
    			$gps->before_update('modify_date');
				if($this->session->userdata('logged_in')['role'] == 'vendor')
					$gps->change_type('vendor_id', 'select', $branchID, array('values' => $vendorsData));
				else
					$gps->change_type('vendor_id', 'select', '',array('values' => $vendorsData));
				$gps ->change_type('discount', 'price','0', array('suffix'=>' %','decimals'=>'0'));
				$gps->columns(array('vendor_id','res_cat_name','item_img','sequence','status'),false);
                $gps->fields(array('vendor_id','res_cat_name','item_img','status'),false);
				$gps->button('#', "Top", 'glyphicon glyphicon-arrow-up icon-arrow-up', 'btn gps-action', array(
					'data-action' => 'movetop',
					'data-task' => 'action',
					'data-table' => $tablename,
					'data-primarykey' => 'rc_id',
					'data-primary' => '{rc_id}'));
				$gps->button('#', "Bottom", 'glyphicon glyphicon-arrow-down icon-arrow-down', 'btn gps-action', array(
					'data-action' => 'movebottom',
					'data-task' => 'action',
					'data-table' => $tablename,
					'data-primarykey' => 'rc_id',
					'data-primary' => '{rc_id}'));
				$gps->create_action('movetop', 'movetop');
				$gps->create_action('movebottom', 'movebottom');
				$gps->unset_sortable();
				$gps->order_by('sequence');
				$gps->create_action('active', 'active_action');
                $gps->button('javascript:;', 'Active', 'glyphicon glyphicon-check', 'gps-action btn-success', 
                array(
                    'data-task' => 'action',
                    'data-action' => 'active',
                    'data-toggle' => 'tooltip',
                    'data-placement' => 'bottom',
                    'data-table' => $tablename,
					'data-primarykey' => 'rc_id',
                    'data-confirm' => 'Do you really want active this entry?',
                    'data-primary' => '{rc_id}'),
                array(
                    'status',
                    '=',
                    '0'));
				$gps->create_action('deactive', 'deactive_action');
                $gps->button('javascript:;', 'Deactive', 'glyphicon glyphicon-check', 'gps-action btn-danger', 
                array(
                    'data-task' => 'action',
                    'data-action' => 'deactive',
                    'data-toggle' => 'tooltip',
                    'data-placement' => 'bottom',
                    'data-table' => $tablename,
					'data-primarykey' => 'rc_id',
                    'data-confirm' => 'Do you really want deactive this entry?',
                    'data-primary' => '{rc_id}'),
                array(
                    'status',
                    '=',
                    '1'));
            }
			
            if($tablename == 'restaurant_submenu')
            { 
				if($this->session->userdata('logged_in')['role'] == 'vendor')
					$gps->where('vendor_id', $branchID);
                $gps->pass_var('createdBy', $login_id,'create');
    			$gps->pass_var('modifiedBy', $login_id,'edit');
    			//$gps->before_insert('created_date');
				$gps->before_insert('add_subcatsequence');
    			$gps->before_update('modify_date');
				if($this->session->userdata('logged_in')['role'] == 'vendor')
					$gps->change_type('vendor_id', 'select', $branchID, array('values' => $vendorsData));
				else
					$gps->change_type('vendor_id', 'select', '',array('values' => $vendorsData));
				$gps ->change_type('discount', 'price','0', array('suffix'=>' %','decimals'=>'0'));
				$gps->columns(array('vendor_id','cat_id','res_subcat_name','item_img','sequence','status'),false);
                $gps->fields(array('vendor_id','cat_id','res_subcat_name','item_img','status'),false);
				$gps->button('#', "Top", 'glyphicon glyphicon-arrow-up icon-arrow-up', 'btn gps-action', array(
					'data-action' => 'movetop',
					'data-task' => 'action',
					'data-table' => $tablename,
					'data-primarykey' => 'rs_id',
					'data-primary' => '{rs_id}'));
				$gps->button('#', "Bottom", 'glyphicon glyphicon-arrow-down icon-arrow-down', 'btn gps-action', array(
					'data-action' => 'movebottom',
					'data-task' => 'action',
					'data-table' => $tablename,
					'data-primarykey' => 'rs_id',
					'data-primary' => '{rs_id}'));
				$gps->create_action('movetop', 'movetop');
				$gps->create_action('movebottom', 'movebottom');
				$gps->unset_sortable();
				$gps->order_by('sequence');
				$gps->create_action('active', 'active_action');
                $gps->button('javascript:;', 'Active', 'glyphicon glyphicon-check', 'gps-action btn-success', 
                array(
                    'data-task' => 'action',
                    'data-action' => 'active',
                    'data-toggle' => 'tooltip',
                    'data-placement' => 'bottom',
                    'data-table' => $tablename,
					'data-primarykey' => 'rs_id',
                    'data-confirm' => 'Do you really want active this entry?',
                    'data-primary' => '{rs_id}'),
                array(
                    'status',
                    '=',
                    '0'));
				$gps->create_action('deactive', 'deactive_action');
                $gps->button('javascript:;', 'Deactive', 'glyphicon glyphicon-check', 'gps-action btn-danger', 
                array(
                    'data-task' => 'action',
                    'data-action' => 'deactive',
                    'data-toggle' => 'tooltip',
                    'data-placement' => 'bottom',
                    'data-table' => $tablename,
					'data-primarykey' => 'rs_id',
                    'data-confirm' => 'Do you really want deactive this entry?',
                    'data-primary' => '{rs_id}'),
                array(
                    'status',
                    '=',
                    '1'));
            }
            if($tablename == 'restaurant_items')
            { 
				if($this->session->userdata('logged_in')['role'] == 'vendor')
					$gps->where('vendor_id', $branchID);
                $gps->pass_var('createdBy', $login_id,'create');
    			$gps->pass_var('modifiedBy', $login_id,'edit');
    			$gps->before_insert('created_date');
    			$gps->before_update('modify_date');
				if($this->session->userdata('logged_in')['role'] == 'vendor')
					$gps->change_type('vendor_id', 'select', $branchID, array('values' => $vendorsData));
				else
					$gps->change_type('vendor_id', 'select', '',array('values' => $vendorsData));
				$gps ->change_type('discount', 'price','0', array('suffix'=>' %','decimals'=>'0'));
				$gps->columns(array('vendor_id','item_cat_id','item_subcat_id','item_name','item_details','item_type','item_img','item_price','discount','today_special','status'),false);
                $gps->fields(array('vendor_id','item_cat_id','item_subcat_id','item_name','item_details','item_type','item_img','item_price','discount','status'),false);
				$gps->create_action('active', 'active_action');
                $gps->button('javascript:;', 'Active', 'glyphicon glyphicon-check', 'gps-action btn-success', 
                array(
                    'data-task' => 'action',
                    'data-action' => 'active',
                    'data-toggle' => 'tooltip',
                    'data-placement' => 'bottom',
                    'data-table' => $tablename,
					'data-primarykey' => 'item_id',
                    'data-confirm' => 'Do you really want active this entry?',
                    'data-primary' => '{item_id}'),
                array(
                    'status',
                    '=',
                    '0'));
				$gps->create_action('deactive', 'deactive_action');
                $gps->button('javascript:;', 'Deactive', 'glyphicon glyphicon-check', 'gps-action btn-danger', 
                array(
                    'data-task' => 'action',
                    'data-action' => 'deactive',
                    'data-toggle' => 'tooltip',
                    'data-placement' => 'bottom',
                    'data-table' => $tablename,
					'data-primarykey' => 'item_id',
                    'data-confirm' => 'Do you really want deactive this entry?',
                    'data-primary' => '{item_id}'),
                array(
                    'status',
                    '=',
                    '1'));
				$gps->create_action('special', 'special_action');
                $gps->button('javascript:;', 'Make it special', 'fas fa-tag', 'gps-action btn-success', 
                array(
                    'data-task' => 'action',
                    'data-action' => 'special',
                    'data-toggle' => 'tooltip',
                    'data-placement' => 'bottom',
                    'data-table' => $tablename,
                    'data-confirm' => 'Do you really want active today special?',
                    'data-primary' => '{item_id}'),
                array(
                    'today_special',
                    '=',
                    '0'));
				$gps->create_action('undo', 'undo_action');
                $gps->button('javascript:;', 'Undo special', 'fas fa-tag', 'gps-action btn-danger', 
                array(
                    'data-task' => 'action',
                    'data-action' => 'undo',
                    'data-toggle' => 'tooltip',
                    'data-placement' => 'bottom',
                    'data-table' => $tablename,
                    'data-confirm' => 'Do you really want undo special?',
                    'data-primary' => '{item_id}'),
                array(
                    'today_special',
                    '=',
                    '1'));
            }
            if($tablename == 'restaurants')
            { 
				if($this->session->userdata('logged_in')['role'] == 'vendor')
					$gps->where('rest_id', $branchID);
                $gps->pass_var('createdBy', $login_id,'create');
    			$gps->pass_var('modifiedBy', $login_id,'edit');
    			$gps->before_insert('created_date');
    			$gps->before_update('modify_date');
				$gps ->change_type('min_order', 'price','0', array('prefix'=>'₹ ','decimals'=>'2'));
				$gps ->change_type('offerAmount', 'price','0', array('prefix'=>'₹ ','decimals'=>'2'));
				$gps ->change_type('del_charges', 'price','0', array('prefix'=>'₹ ','decimals'=>'2'));
				$gps ->change_type('del_distance', 'price','0', array('suffix'=>' Km','decimals'=>'0'));
				$gps ->change_type('del_time', 'price','0', array('suffix'=>' Min','decimals'=>'0'));
				$gps->columns(array('rest_name','rest_address','min_order','offerAmount','del_distance','del_time','del_charges','start_at','ends_at','availability','status'),false);
                $gps->fields(array('rest_image','created_at','modified_at','createdBy','modifiedBy'),true);
				$gps->create_action('open', 'open_store');
                $gps->button('javascript:;', 'Open Store', 'fas fa-door-open', 'gps-action btn-success', 
                array(
                    'data-task' => 'action',
                    'data-action' => 'open',
                    'data-toggle' => 'tooltip',
                    'data-placement' => 'bottom',
                    'data-table' => $tablename,
                    'data-primary' => '{rest_id}'),
                array(
                    'availability',
                    '=',
                    '0'));
				$gps->create_action('close', 'close_store');
                $gps->button('javascript:;', 'Close Store', 'fas fa-door-closed', 'gps-action btn-danger', 
                array(
                    'data-task' => 'action',
                    'data-action' => 'close',
                    'data-toggle' => 'tooltip',
                    'data-placement' => 'bottom',
                    'data-table' => $tablename,
                    'data-primary' => '{rest_id}'),
                array(
                    'availability',
                    '=',
                    '1'));
            }
			if($tablename == 'expenses')
			{
				if($this->session->userdata('logged_in')['role'] == 'vendor')
					$gps->where('vendor_id', $branchID);
				$gps->pass_var('createdBy', $login_id,'create');
    			$gps->pass_var('modifiedBy', $login_id,'edit');
    			$gps->before_insert('created_date');
    			$gps->before_update('modify_date');
				if($this->session->userdata('logged_in')['role'] == 'vendor')
					$gps->change_type('vendor_id', 'select', $branchID, array('values' => $vendorsData));
				else
					$gps->change_type('vendor_id', 'select', '',array('values' => $vendorsData));
				$gps ->change_type('amount', 'price','0', array('prefix'=>'₹ ','decimals'=>'2'));
				$gps->subselect('Store Amount','SELECT SUM(`amount`) FROM `'.$tablename.'` WHERE `res_name` = {res_name} GROUP BY `res_name`'); 
				$gps ->change_type('Store Amount', 'price','0', array('prefix'=>'₹ ','decimals'=>'2'));
				$gps->columns(array('vendor_id','name','amount','bill','purchase_date','warranty_date'),false);
				$gps->fields(array('vendor_id','name','amount','bill','purchase_date','warranty_date'),false);
				$gps->sum('amount'); 
			}
            if($tablename == 'special_discounts')
            { 
				if($this->session->userdata('logged_in')['role'] == 'vendor')
					$gps->where('vendor_id', $branchID);
				$gps ->change_type('discount', 'price','0', array('suffix'=>' %','decimals'=>'0'));
                $gps->pass_var('createdBy', $login_id,'create');
    			$gps->pass_var('modifiedBy', $login_id,'edit');
    			$gps->before_insert('created_date');
    			$gps->before_update('modify_date');
				if($this->session->userdata('logged_in')['role'] == 'vendor')
					$gps->change_type('vendor_id', 'select', $branchID, array('values' => $vendorsData));
				else
					$gps->change_type('vendor_id', 'select', '',array('values' => $vendorsData));
				$gps->columns(array('from','to','discount','vendor_id','created_at','modified_at','status'),false);
                $gps->fields(array('from','to','discount','vendor_id','status'),false);
            }
            if($tablename == 'app_banners')
            { 
				if($this->session->userdata('logged_in')['role'] == 'vendor')
					$gps->where('vendor_id', $branchID);
                $gps->pass_var('createdBy', $login_id,'create');
    			$gps->pass_var('modifiedBy', $login_id,'edit');
    			$gps->before_insert('created_date');
    			$gps->before_update('modify_date');
				$gps->set_attr('category',array('id' => 'select2'));
				if($this->session->userdata('logged_in')['role'] == 'vendor')
					$gps->change_type('vendor_id', 'select', $branchID, array('values' => $vendorsData));
				else
					$gps->change_type('vendor_id', 'select', '',array('values' => $vendorsData));
				$gps->columns(array('vendor_id','category','subcategory','item','banner_name','banner_image','banner_des','banner_url','created_at','modified_at','status'),false);
                $gps->fields(array('vendor_id','category','subcategory','item','banner_name','banner_image','banner_des','banner_url','status'),false);
            }
            if($tablename == 'promotions')
            { 
				if($this->session->userdata('logged_in')['role'] == 'vendor')
					$gps->where('branch', $branchID);
                $gps->pass_var('createdBy', $login_id,'create');
    			$gps->pass_var('modifiedBy', $login_id,'edit');
				$gps->set_attr('branch',array('id' => 'select2'));
				if($this->session->userdata('logged_in')['role'] == 'vendor')
					$gps->change_type('branch', 'select', $branchID, array('values' => $vendorsData));
				else
					$gps->change_type('branch', 'select', '',array('values' => $vendorsData));
                $gps->fields(array('branch','type','subject','image','message'),false);
				$gps->before_insert('promotional');
                $gps->before_update('promotional');
            }
			if($tablename == 'del_users')
			{
				if($this->session->userdata('logged_in')['role'] == 'vendor')
					$gps->where('vendor_id', $branchID);
				if($this->session->userdata('logged_in')['role'] == 'vendor')
					$gps->change_type('vendor_id', 'select', $branchID, array('values' => $vendorsData));
				else
					$gps->change_type('vendor_id', 'select', '',array('values' => $vendorsData));
			}
			if($tablename == 'app_users')
			{
				if($this->session->userdata('logged_in')['role'] == 'vendor')
					$gps->where('store', $branchID);
				if($this->session->userdata('logged_in')['role'] == 'vendor')
					$gps->change_type('store', 'select', $branchID, array('values' => $vendorsData));
				else
					$gps->change_type('store', 'select', '',array('values' => $vendorsData));
			}
			if($tablename == 'admin')
			{
				if($this->session->userdata('logged_in')['role'] == 'vendor')
					$gps->where('branch', $branchID);
				$gps->where('role','vendor');
				if($this->session->userdata('logged_in')['role'] == 'vendor')
					$gps->change_type('branch', 'select', $branchID, array('values' => $vendorsData));
				else
					$gps->change_type('branch', 'select', '',array('values' => $vendorsData));
				//$gps->pass_var('permissions', '[{"special_discounts":"add"},{"del_users":"add"},{"promotions":"add"},{"app_banners":"add"},{"restaurant_items":"add"},{"restaurant_menu":"add"},{"expenses":"add"},{"restaurant_submenu":"add"},{"about_us":"add"},{"contact_us":"add"},{"special_discounts":"edit"},{"del_users":"edit"},{"promotions":"edit"},{"app_banners":"edit"},{"restaurant_items":"edit"},{"restaurant_menu":"edit"},{"expenses":"edit"},{"restaurant_submenu":"edit"},{"about_us":"edit"},{"contact_us":"edit"},{"special_discounts":"delete"},{"del_users":"delete"},{"app_banners":"delete"},{"restaurant_items":"delete"},{"restaurant_menu":"delete"},{"expenses":"delete"},{"restaurant_submenu":"delete"},{"del_users":"view"},{"promotions":"view"},{"app_banners":"view"},{"expenses":"view"},{"restaurant_submenu":"view"},{"about_us":"view"},{"contact_us":"view"}]');
				$gps->pass_var('role', 'vendor');
    			$gps->before_insert('checkEmail');
    			$gps->before_update('checkUpdateEmail');
			}
            if($tablename == 'sms_credentials' || $tablename == 'about_us' || $tablename == 'contact_us' || $tablename == 'terms_conditions' || $tablename == 'privacy_policy' || $tablename == 'feedback_services' || $tablename == 'payment_gateway' || $tablename == 'farmers' || $tablename == 'referral_coupons' || $tablename == 'order_images')
            { 
                $gps->pass_var('createdBy', $login_id,'create');
    			$gps->pass_var('modifiedBy', $login_id,'edit');
    			$gps->before_insert('created_date');
    			$gps->before_update('modify_date');
            }
			if($tablename == 'about_us' || $tablename == 'contact_us' || $tablename == 'payment_gateway')
			{
				if($this->session->userdata('logged_in')['role'] == 'vendor')
					$gps->where('branchID', $branchID);
				if($this->session->userdata('logged_in')['role'] == 'vendor')
					$gps->change_type('branchID', 'select', $branchID, array('values' => $vendorsData));
				else
					$gps->change_type('branchID', 'select', '',array('values' => $vendorsData));
			}
            if($tablename == 'feedback' || $tablename == 'order_feedback' || $tablename == 'referral_coupons')
            { 
				if($this->session->userdata('logged_in')['role'] == 'vendor')
					$gps->where('vendor_id', $branchID);
				if($this->session->userdata('logged_in')['role'] == 'vendor')
					$gps->change_type('vendor_id', 'select', $branchID, array('values' => $vendorsData));
				else
					$gps->change_type('vendor_id', 'select', '',array('values' => $vendorsData));
    			$gps->before_insert('created_date');
            }
            $data['output'] = $gps->render();
            $this->load->view('edit',$data);
        }
        else
        {
			$data['title']="Page Not Found";
            $this->load->view('error404',$data);
		}
        
        $this->load_footer();
	}
    public function permissions($userper,$tablename){
        $permissions = json_decode($userper);
    	$table = $tablename;
        $perm = '';
        $p = array();
        $view = '';
        $add = '';
        $edit = '';
        $delete = '';
        foreach($permissions as $permsn ) {  
            $perm = isset($permsn->$table)?$permsn->$table:'';
            if(!empty($perm))
            {
            	$p[$table][] = $perm;
            }
        }
        if(!empty($p))
        {
            $view = in_array('view', $p[$table])?'view':'';
            $add = in_array('add', $p[$table])?'add':'';
            $edit = in_array('edit', $p[$table])?'edit':'';
            $delete = in_array('delete', $p[$table])?'delete':'';
        }
        $mergeArray = array($view,$add,$edit,$delete);
        return $mergeArray;
    }
	public function load_footer()
	{
		$this->load->view('include/footer');
	}
}
