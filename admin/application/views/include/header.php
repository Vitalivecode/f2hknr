 <!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="<?=base_url().'../uploads/'.$site[0]->favicon;?>" />
    <title><?=$title;?> | <?=$site[0]->title;?> </title>
    <!-- Bootstrap Core CSS -->
    <link href="<?=base_url();?>bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?=base_url();?>plugins/bower_components/bootstrap-extension/css/bootstrap-extension.css" rel="stylesheet">
	<link href="<?=base_url();?>plugins/bower_components/bootstrap-switch/bootstrap-switch.min.css" rel="stylesheet">
	<link href="<?=base_url();?>plugins/bower_components/icheck/skins/all.css" rel="stylesheet">
	<link href="<?=base_url();?>plugins/bower_components/switchery/dist/switchery.min.css" rel="stylesheet" />
	<?php if($this->uri->segment(1) != '' && $this->uri->segment(1) != 'login' && $this->uri->segment(1) != 'Login' && $this->uri->segment(1) != 'Forgot' && $this->uri->segment(1) != 'forgot') { ?>
    <!-- Menu CSS -->
    <link href="<?=base_url();?>plugins/bower_components/sidebar-nav/dist/sidebar-nav.min.css" rel="stylesheet">
	<link rel="stylesheet" href="<?=base_url();?>plugins/bower_components/dropify/dist/css/dropify.min.css">
    <!--alerts CSS -->
    <link href="<?=base_url();?>plugins/bower_components/sweetalert/sweetalert.css" rel="stylesheet" type="text/css">
    <!-- toast CSS -->
    <link href="<?=base_url();?>plugins/bower_components/toast-master/css/jquery.toast.css" rel="stylesheet">
    <!-- morris CSS -->
    <link href="<?=base_url();?>plugins/bower_components/morrisjs/morris.css" rel="stylesheet">
	<!-- Calendar CSS -->
    <link href="<?=base_url();?>plugins/bower_components/calendar/dist/fullcalendar.css" rel="stylesheet" />
    <link href="<?=base_url('plugins/bower_components/typeahead.js-master/dist/typehead-min.css');?>" rel="stylesheet">
    <link href="<?=base_url();?>plugins/bower_components/nestable/nestable.css" rel="stylesheet" type="text/css" />
	<?php } ?>
    <!-- animation CSS -->
    <link href="<?=base_url();?>css/animate.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="<?=base_url();?>css/style.css" rel="stylesheet">
    <link href="<?=base_url();?>css/pranay.css" rel="stylesheet">
    <!-- color CSS -->
    <link href="<?=base_url();?>css/colors/<?=$site[0]->theme;?>.css" id="theme" rel="stylesheet">
	<!-- Popup CSS -->
    <link href="<?=base_url();?>plugins/bower_components/Magnific-Popup-master/dist/magnific-popup.css" rel="stylesheet">
	<!-- Custom Multi Select CSS -->
    <link href="<?=base_url();?>plugins/bower_components/custom-select/custom-select.css" rel="stylesheet" type="text/css" />
	<!-- Custom CSS -->
	<?php if($this->uri->segment(1) == 'settings') { ?>
	<link href="<?=base_url();?>plugins/bower_components/bootstrap-tagsinput/dist/bootstrap-tagsinput.css" rel="stylesheet" />
	<?php } ?>
	<?php if($this->uri->segment(1) == 'users' || $this->uri->segment(1) == 'create' || $this->uri->segment(1) == 'tables' || $this->uri->segment(1) == 'reports') { ?>
	<link href="<?=base_url();?>plugins/bower_components/datatables/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
    <link href="https://cdn.datatables.net/buttons/1.2.2/css/buttons.dataTables.min.css" rel="stylesheet" type="text/css" />
	<?php } ?>
	<?=$site[0]->c_links;?>
	<?php if(!empty($site[0]->css)) { ?>
	<style>
		<?=$site[0]->css;?>
	</style>
	<?php } ?>
    <!-- jQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <?php if($this->uri->segment(1) == '' || $this->uri->segment(1) == 'login') { ?>
    <script src="<?=base_url();?>js/firebase.js"></script>
    <?php } ?>
    <script src="<?=base_url();?>js/table2excel.js" type="text/javascript"></script>
    <script type="text/javascript">
        $(function () {
            $("#btnExport").click(function () {
                $("#tblCustomers").table2excel({
                    filename: Date.now() + ".xls"
                });
            });
        });
    </script> 
    <!-- Bootstrap Core JavaScript -->
    <script src="<?=base_url();?>bootstrap/dist/js/tether.min.js"></script>
    <script src="<?=base_url();?>bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- Custom Theme JavaScript -->
    <script src="<?=base_url();?>js/custom.js"></script>
    <!-- Pranay JavaScript -->
    <script src="<?=base_url();?>js/pranay.js"></script>
    
    <script src="<?=base_url();?>plugins/bower_components/toast-master/js/jquery.toast.js"></script>
    <!--slimscroll JavaScript -->
    <script src="<?=base_url();?>js/jquery.slimscroll.js"></script>
    <!-- Menu Plugin JavaScript -->
    <script src="<?=base_url();?>plugins/bower_components/sidebar-nav/dist/sidebar-nav.min.js"></script>
    <?php if($this->uri->segment(1) == 'settings') { ?>
	<script type="text/javascript" src="<?=base_url();?>plugins/bower_components/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js"></script>
	<?php } ?>
    <!--    Font Awesome    -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
</head>
<?php 
    function permissions($userper,$tablename){
        $permissions = json_decode($userper); 
    	$table = $tablename;
    	$perm = '';
        $p = array();
        $view = 0;
        $add = 0;
        $edit = 0;
        $delete = 0;
        foreach($permissions as $permsn ) {  
            $perm = isset($permsn->$table)?$permsn->$table:'';
            if(!empty($perm))
            {
            	$p[$table][] = $perm;
            }
        }
        if(!empty($p))
        {
            $view = in_array('view', $p[$table])?1:0;
            $add = in_array('add', $p[$table])?1:0;
            $edit = in_array('edit', $p[$table])?1:0;
            $delete = in_array('delete', $p[$table])?1:0;
        }
        if(!empty($view) || !empty($add) || !empty($edit) || !empty($delete) )
            return true;
        else
            return false;
    }
    function childpermissions($userper,$tablenames)
    {
        $i[] = array();
        $permissions = json_decode($userper);
        foreach($tablenames as $tablename)
        {
    		$table = $tablename;
            $perm = '';
            $p = array();
            $view = 0;
            $add = 0;
            $edit = 0;
            $delete = 0;
            if(!empty($permissions))
            {
                foreach($permissions as $permsn ) {  
                	$perm = isset($permsn->$table)?$permsn->$table:'';
                	if(!empty($perm))
                	{
                		$p[$table][] = $perm;
                	}
                }
                if(!empty($p))
                {
                    $view = in_array('view', $p[$table])?1:0;
                    $add = in_array('add', $p[$table])?1:0;
                    $edit = in_array('edit', $p[$table])?1:0;
                    $delete = in_array('delete', $p[$table])?1:0;
                }
                if(!empty($view) || !empty($add) || !empty($edit) || !empty($delete) )
                {
                    $i[] = '1';
                }
                else
                {
                    $i[] = '0';
                }
            }
            else
            {
                $i[] = '0';
            }
        }
        return $i;
    }
?>
<?php $str=$_SERVER['REQUEST_URI'] ;$r=substr($str, strrpos($str, '/') +1);?>
  <body class="<?=$site[0]->menu;?>">
  	<div class="preloader">
        <div class="cssload-speeding-wheel"></div>
    </div>
  <?php if($this->uri->segment(1) != '' && $this->uri->segment(1) != 'login' && $this->uri->segment(1) != 'Login' && $this->uri->segment(1) != 'Forgot' && $this->uri->segment(1) != 'forgot') { ?>
	<?php $menuoptions = explode(' ',$site[0]->menu);?>
		<div id="wrapper">
        <!-- Navigation -->
        <nav class="navbar navbar-default navbar-static-top m-b-0">
            <div class="navbar-header"> <a class="navbar-toggle hidden-sm hidden-md hidden-lg " href="javascript:void(0)" data-toggle="collapse" data-target=".navbar-collapse"><i class="ti-menu"></i></a>
				<?php if(!empty($site[0]->logo)) { ?>
					<div class="top-left-part"><a class="logo" href="<?=base_url();?>home"><b <?=(in_array("content-wrapper",$menuoptions))?'style="display:block;"':'style="display:none;"'; ?> ><img src="<?=base_url().'../uploads/'.$site[0]->favicon;?>"  width="45px" style="max-height: 45px;" alt="<?=$site[0]->title;?>" /></b><span class="hidden-xs" <?=(in_array("content-wrapper",$menuoptions))?'style="display:none;"':'style="display:block;"'; ?> ><img src="<?=base_url();?>../uploads/<?=$site[0]->logo;?>" class="center-block img-responsive m-t-10" style="max-height: 45px;" alt="<?=$site[0]->title;?>" /></span></a></div>
                <?php } else {?>
					<div class="top-left-part"><a class="logo" href="<?=base_url();?>home"><b><?=$site[0]->title;?></b></a></div>
				<?php } ?>
				<ul class="nav navbar-top-links navbar-left hidden-xs">
                    <li><a href="javascript:void(0)" class="open-close hidden-xs waves-effect waves-light"><i class="icon-arrow-left-circle ti-menu"></i></a></li>
                </ul>
                <ul class="nav navbar-top-links navbar-right pull-right">
                    <?php if($this->session->userdata('logged_in')['role'] == 'vendor') { $availability = $this->branch->status($this->session->userdata('logged_in')['branch']); ?>
						<li><button type="button" id="store" class="btn btn-secondary btn-circle btn-lg m-t-5 btn-<?=(isset($availability) && $availability == true && $availability['availability'] == '1')?'success':'danger';?>" data-toggle="tooltip" data-placement="bottom" data-original-title="<?=(isset($availability) && $availability == true && $availability['availability'] == '1')?'Opened':'Closed';?>" value="<?=(isset($availability) && $availability == true && $availability['availability'] == '1')?'1':'2';?>"><i class="fas fa-door-<?=(isset($availability) && $availability == true && $availability['availability'] == '1')?'open':'closed';?>"></i> </button></li>
					<?php } ?>
						<li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle waves-effect waves-dark" href="" id="2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="fas fa-bell"></i>
                                <div class="notify" style="display:none;"> <span class="heartbit"></span> <span class="point"></span> </div>
                            </a>
                            <div class="dropdown-menu mailbox dropdown-menu-right animated bounceInDown" aria-labelledby="2">
								<ul id="notifications"><div class="text-center p-10"><i class="fa fa-spinner fa-spin"></i></div></ul>
                            </div>
                        </li>
					<?php if($site[0]->display == 'show' && $this->session->userdata('logged_in')['role'] == 'superadmin') { ?>
						<li><a class="waves-effect waves-light" alt="Create Tables" data-toggle="tooltip" data-placement="bottom" title="Create Tables" href="<?=base_url();?>tables"><i data-icon="&#xe001;" class="linea-icon linea-basic"></i></a></li>
						<li><a class="waves-effect waves-light" alt="Manage Tables" data-toggle="tooltip" data-placement="bottom" title="Manage Tables" href="<?=base_url();?>create"><i data-icon="f" class="linea-icon linea-basic"></i></a></li>
						<li><a class="waves-effect waves-light" alt="Management" data-toggle="tooltip" data-placement="bottom" title="Menu Management" href="<?=base_url();?>menu"><i class="icon-menu"></i></a></li>
						<li><a class="waves-effect waves-light" alt="Site Settings" data-toggle="tooltip" data-placement="bottom" title="Site Settings" href="<?=base_url();?>settings"><i class="icon-globe"></i></a></li>
					<?php } ?>
                    <li class="dropdown">
                        <a class="dropdown-toggle profile-pic" data-toggle="dropdown" href="#"> <img src="<?=base_url();?>../uploads/<?=($userdata[0]->img != '')?$userdata[0]->img:'300x300.png';?>" alt="<?=$userdata[0]->fullname;?>" width="36" class="img-circle"><b class="hidden-xs"><?=$userdata[0]->fullname;?></b> </a>
                        <ul class="dropdown-menu dropdown-user animated flipInY">
                            <li><a href="<?=base_url();?>profile"><i class="ti-user"></i> My Profile</a></li>
                            <li role="separator" class="divider"></li>
                            <li><a href="<?=base_url();?>logout"><i class="fa fa-power-off"></i> Logout</a></li>
                        </ul>
                        <!-- /.dropdown-user -->
                    </li>
					<?php if($this->uri->segment(1) == 'settings') { ?>
						<li class="right-side-toggle"> <a class="waves-effect waves-light" href="javascript:void(0)"><i class="ti-settings"></i></a></li>
					<?php } ?>
                    <!-- /.dropdown -->
                </ul>
            </div>
            <!-- /.navbar-header -->
            <!-- /.navbar-top-links -->
            <!-- /.navbar-static-side -->
        </nav>
		<!-- Left navbar-header -->
        <div class="navbar-default sidebar" role="navigation">
            <div class="sidebar-nav navbar-collapse slimscrollsidebar">
                <ul class="nav" id="side-menu">
                    <li class="sidebar-search hidden-sm hidden-md hidden-lg">
                        <!-- input-group -->
                        <div class="input-group custom-search-form">
                            <input type="text" class="form-control" placeholder="Search..."> 
							<span class="input-group-btn">
								<button class="btn btn-default" type="button"> <i class="fa fa-search"></i> </button>
							</span> 
						</div>
                        <!-- /input-group -->
                    </li>
                    <li class="user-pro">
                        <a href="#" class="waves-effect"><img src="<?=base_url();?>../uploads/<?=($userdata[0]->img != '')?$userdata[0]->img:'300x300.png';?>" alt="<?=$userdata[0]->fullname;?>" class="img-circle"> <span class="hide-menu"> <?=$userdata[0]->fullname;?><span class="fa arrow"></span></span>
                        </a>
                        <ul class="nav nav-second-level">
                            <li><a href="<?=base_url();?>profile"><i class="ti-user"></i> My Profile</a></li>
                            <li><a href="<?=base_url();?>logout"><i class="fa fa-power-off"></i> Logout</a></li>
                        </ul>
                    </li>
                    <li class="nav-small-cap m-t-10">--- Main Menu</li>
					<li><a href="<?=base_url()?>home" class="waves-effect <?=($this->uri->segment(1)=='home')?'active' :'';?>"><i class="fa fa-home" data-icon="v"></i> <span class="hide-menu">Home</span></a></li>
					<li><a href="<?=base_url('orders/index')?>" class="waves-effect <?=($this->uri->segment(1) == 'orders' && $this->uri->segment(2) != 'accept')?'active' :'';?>"><i class="fas fa-cart-arrow-down"></i> <span class="hide-menu">Orders</span></a></li>
                    <li><a href="<?=base_url('orders/accept')?>" class="waves-effect <?=($this->uri->segment(1) == 'orders' && $this->uri->segment(2) == 'accept')?'active' :'';?>"><i class="fas fa-cart-plus"></i> <span class="hide-menu">Accepted Orders</span></a></li>
					<?php if($ct != false) { foreach($ct as $c) { if($c->child_id == 0 && $c->table_name != '#') {
        			    if(permissions($userdata[0]->permissions,$c->table_name)){  ?>
        			      <?php $table_type= $this->adminpanel->getTableType($c->table_name);if($table_type[0]->table_type == 'cms') { ?>
        			        <li class="<?=($this->uri->segment(3) == $c->table_name || $this->uri->segment(2) == $c->table_name)?'active' :'';?>"><a href="<?=base_url().'cms/'.str_replace('_','-',$c->table_name);?>" class="waves-effect <?=($this->uri->segment(3) == $c->table_name || $this->uri->segment(2) == $c->table_name)?'active' :'';?>"><i class="<?=$c->icon;?> fa-fw"></i> <span class="hide-menu"><?=ucfirst($c->cttitle);?><?php foreach($tables as $tname ) : if($tname->table_name == $c->table_name) { $pages = json_decode($tname->permissions); if(!empty($pages->count_menu)) { if($pages->count_menu == 'show') { ?> <span class="label label-rouded label-info pull-right"><?php $where = ($this->session->userdata('logged_in')['role'] == 'superadmin' || $this->session->userdata('logged_in')['role'] == 'admin')?NULL:array('vendor_id' => $this->session->userdata('logged_in')['branch']); if(is_array($this->site->table($c->table_name,$where))){ echo count($this->site->table($c->table_name,$where)); } else{ echo 0;} ?></span><?php } } } endforeach ?></span></a></li>
					    <?php } else { ?>
					        <li class="<?=($this->uri->segment(3) == $c->table_name || $this->uri->segment(2) == $c->table_name)?'active' :'';?>"><a href="<?=base_url($c->table_name);?>" class="waves-effect <?=($this->uri->segment(3) == $c->table_name || $this->uri->segment(2) == $c->table_name)?'active' :'';?>"><i class="<?=$c->icon;?> fa-fw"></i> <span class="hide-menu"><?=ucfirst($c->cttitle);?><?php foreach($tables as $tname ) : if($tname->table_name == $c->table_name) { $pages = json_decode($tname->permissions); if(!empty($pages->count_menu)) { if($pages->count_menu == 'show') { ?> <span class="label label-rouded label-info pull-right"><?php $where = ($this->session->userdata('logged_in')['role'] == 'superadmin' || $this->session->userdata('logged_in')['role'] == 'admin')?NULL:array('vendor_id' => $this->session->userdata('logged_in')['branch']); echo count($this->site->table($c->table_name,$where));?></span><?php } } } endforeach ?></span></a></li>
					    <?php } ?>
        			    <?php } ?>
					<?php  }  elseif($c->child_id == 0 && $c->table_name == '#') { $childtable = array(); $childlist = $this->adminpanel->childMenu($c->parent_id); if($childlist != false) { foreach($childlist as $child){ $childtable[] = $child->table_name; } } if((childpermissions($userdata[0]->permissions,$childtable) != '') && in_array('1',childpermissions($userdata[0]->permissions,$childtable))){ ?>
						<li class="<?=($this->uri->segment(3) == '#')?'active' :'';?>"><a href="#" class="waves-effect <?=($this->uri->segment(3) == '#')?'active' :'';?>"><i class="<?=$c->icon;?> fa-fw"></i> <span class="hide-menu"><?=ucfirst($c->cttitle);?><span class="fa arrow"></span></span></a>
							<?php $childlist = $this->adminpanel->childMenu($c->parent_id); if($childlist != false) { ?>
							<ul class="nav nav-second-level">
                                <?php foreach($childlist as $child) { ?>
                                    <?php if(permissions($userdata[0]->permissions,$child->table_name)){  ?>
                                    <?php $table_type1= $this->adminpanel->getTableType($child->table_name);if($table_type1[0]->table_type == 'cms') { ?>
									    <li><a href="<?=($child->table_name != '#') ? base_url().'cms/'.str_replace('_','-',$child->table_name) : '#';?>"><?=ucfirst($child->name);?><?php foreach($tables as $tname ) : if($tname->table_name == $child->table_name) { $pages = json_decode($tname->permissions); if(!empty($pages->count_menu)) { if($pages->count_menu == 'show') { ?> <span class="label label-rouded label-info pull-right"><?php $where = ($this->session->userdata('logged_in')['role'] == 'superadmin' || $this->session->userdata('logged_in')['role'] == 'admin')?NULL:array('vendor_id' => $this->session->userdata('logged_in')['branch']); if(is_array($this->site->table($child->table_name,$where))){ echo count($this->site->table($child->table_name,$where)); } else{ echo 0;} ?></span><?php } } } endforeach ?></a></li>
								    <?php } else { ?>
								        <li><a href="<?=($child->table_name != '#') ? base_url($child->table_name) : '#';?>"><?=ucfirst($child->name);?><?php foreach($tables as $tname ) : if($tname->table_name == $child->table_name) { $pages = json_decode($tname->permissions); if(!empty($pages->count_menu)) { if($pages->count_menu == 'show') { ?> <span class="label label-rouded label-info pull-right"><?php $where = ($this->session->userdata('logged_in')['role'] == 'superadmin' || $this->session->userdata('logged_in')['role'] == 'admin')?NULL:array('vendor_id' => $this->session->userdata('logged_in')['branch']); echo count($this->site->table($child->table_name,$where));?></span><?php } } } endforeach ?></a></li>
								     <?php } ?>
								    <?php } ?>
								<?php } ?>
							</ul>
							<?php } ?>
						</li>
					<?php } } } } ?>
					<li><a href="<?=base_url('reports')?>" class="waves-effect <?=($this->uri->segment(1)=='reports')?'active' :'';?>"><i class="ti-pie-chart"></i> <span class="hide-menu">Reports</span></a></li>
					
					<!-- All tables access for superadmin -->
					<?php if($this->session->userdata('logged_in')['role'] == 'superadmin') { ?>
					   <?php if($ct != false) { foreach($ct as $c) { if($c->child_id == 0 && $c->table_name != '#') { ?>
        			      <?php $table_type= $this->adminpanel->getTableType($c->table_name);if($table_type[0]->table_type == 'cms') { ?>
        			        <li class="<?=($this->uri->segment(3) == $c->table_name || $this->uri->segment(2) == $c->table_name || $this->uri->segment(1) == $c->table_name)?'active' :'';?>"><a href="<?=base_url().'cms/'.str_replace('_','-',$c->table_name);?>" class="waves-effect <?=($this->uri->segment(3) == $c->table_name || $this->uri->segment(2) == $c->table_name || $this->uri->segment(1) == $c->table_name)?'active' :'';?>"><i class="<?=$c->icon;?> fa-fw"></i> <span class="hide-menu"><?=ucfirst($c->cttitle);?><?php foreach($tables as $tname ) : if($tname->table_name == $c->table_name) { $pages = json_decode($tname->permissions); if(!empty($pages->count_menu)) { if($pages->count_menu == 'show') { ?> <span class="label label-rouded label-info pull-right"><?php echo $this->db->count_all_results($c->table_name);?></span><?php } } } endforeach ?></span></a></li>
					    <?php } else { ?>
					        <li class="<?=($this->uri->segment(3) == $c->table_name || $this->uri->segment(2) == $c->table_name || $this->uri->segment(1) == $c->table_name)?'active' :'';?>"><a href="<?=base_url($c->table_name);?>" class="waves-effect <?=($this->uri->segment(3) == $c->table_name || $this->uri->segment(2) == $c->table_name || $this->uri->segment(1) == $c->table_name)?'active' :'';?>"><i class="<?=$c->icon;?> fa-fw"></i> <span class="hide-menu"><?=ucfirst($c->cttitle);?><?php foreach($tables as $tname ) : if($tname->table_name == $c->table_name) { $pages = json_decode($tname->permissions); if(!empty($pages->count_menu)) { if($pages->count_menu == 'show') { ?> <span class="label label-rouded label-info pull-right"><?php echo $this->db->count_all_results($c->table_name);?></span><?php } } } endforeach ?></span></a></li>
					    <?php } ?>
					<?php  }  elseif($c->child_id == 0 && $c->table_name == '#') { $childtable = array(); $childlist = $this->adminpanel->childMenu($c->parent_id); if($this->session->userdata('logged_in')['role'] == 'superadmin' || $childlist != false) { if(is_array($childlist)){ foreach($childlist as $child){ $childtable[] = $child->table_name; } } }  if($this->session->userdata('logged_in')['role'] == 'superadmin' || in_array('1',childpermissions($userdata[0]->permissions,$childtable))){ ?>
						<li class="<?=($this->uri->segment(3) == '#')?'active' :'';?>"><a href="#" class="waves-effect <?=($this->uri->segment(3) == '#')?'active' :'';?>"><i class="<?=$c->icon;?> fa-fw"></i> <span class="hide-menu"><?=ucfirst($c->cttitle);?><span class="fa arrow"></span></span></a>
							<?php $childlist = $this->adminpanel->childMenu($c->parent_id); if($this->session->userdata('logged_in')['role'] == 'superadmin' || $childlist != false) { ?>
							<ul class="nav nav-second-level">
                                <?php if(is_array($childlist)){ foreach($childlist as $child) { ?>
                                    <?php $table_type1= $this->adminpanel->getTableType($child->table_name);if($table_type1[0]->table_type == 'cms') { ?>
									    <li><a href="<?=($child->table_name != '#') ? base_url().'cms/'.str_replace('_','-',$child->table_name) : '#';?>"><?=ucfirst($child->name);?><?php foreach($tables as $tname ) : if($tname->table_name == $child->table_name) { $pages = json_decode($tname->permissions); if(!empty($pages->count_menu)) { if($pages->count_menu == 'show') { ?> <span class="label label-rouded label-info pull-right"><?php echo $this->db->count_all_results($child->table_name);?></span><?php } } } endforeach ?></a></li>
								    <?php } else { ?>
								        <li><a href="<?=($child->table_name != '#') ? base_url($child->table_name) : '#';?>"><?=ucfirst($child->name);?><?php foreach($tables as $tname ) : if($tname->table_name == $child->table_name) { $pages = json_decode($tname->permissions); if(!empty($pages->count_menu)) { if($pages->count_menu == 'show') { ?> <span class="label label-rouded label-info pull-right"><?php echo $this->db->count_all_results($child->table_name);?></span><?php } } } endforeach ?></a></li>
								     <?php } ?>
								<?php } } ?>
							</ul>
							<?php } ?>
						</li>
					<?php } } } } ?>
					    <li class="<?=($this->uri->segment(1)=='users')?'active' :'';?>"><a href="<?=base_url();?>users" class="waves-effect <?=($this->uri->segment(1)=='users')?'active' :'';?>"><i class="fa fa-users-cog fa-fw" data-icon="v"></i> <span class="hide-menu">Management</span></a></li>   
					    <li class="<?=($this->uri->segment(1)=='analytics')?'active' :'';?>"><a href="<?=base_url();?>analytics" class="waves-effect <?=($this->uri->segment(1)=='analytics')?'active' :'';?>"><i class="fa fa-line-chart fa-fw" data-icon="v"></i> <span class="hide-menu">Analytics</span></a></li>
					<?php } ?>
                </ul>
            </div>
        </div>
        <!-- Left navbar-header end -->
		<?php if($this->uri->segment(1) == 'settings') { ?>
		<!-- .right-sidebar -->
                <div class="right-sidebar">
                    <div class="slimscrollright">
                        <div class="rpanel-title"> Service Panel <span><i class="ti-close right-side-toggle"></i></span> </div>
                        <div class="r-panel-body">
						<?php $menuoptions = explode(' ',$site[0]->menu);?>
						<form method="post" id="form-menu" enctype="multipart/form-data" >
                            <ul>
                                <li><b>Layout Options</b></li>
                                <li>
                                    <div class="checkbox checkbox-info">
                                        <input id="checkbox1" name="header" type="checkbox" <?php foreach($menuoptions as $fixedheader) { if($fixedheader == 'fix-header') { echo 'checked'; } } ?> value="fix-header" class="fxhdr">
                                        <label for="checkbox1"> Fix Header </label>
                                    </div>
                                </li>
                                <li>
                                    <div class="checkbox checkbox-warning">
                                        <input id="checkbox2" name="sidebar" type="checkbox" <?php foreach($menuoptions as $fixedsidebar) { if($fixedsidebar == 'fix-sidebar') { echo 'checked'; } } ?> value="fix-sidebar" class="fxsdr">
                                        <label for="checkbox2"> Fix Sidebar </label>
										<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash();?>" />
                                    </div>
                                </li>
                                <li>
                                    <div class="checkbox checkbox-success">
                                        <input id="checkbox4" name="close" type="checkbox" <?php foreach($menuoptions as $contentwrapper) { if($contentwrapper == 'content-wrapper') { echo 'checked'; } } ?> value="content-wrapper" class="open-close">
                                        <label for="checkbox4"> Toggle Sidebar </label>
                                    </div>
                                </li>
                            </ul>
						</form>
                            <ul id="themecolors" class="m-t-20">
                                <li><b>With Light sidebar</b></li>
                                <li><a href="javascript:void(0)" theme="default" class="default-theme <?=($site[0]->theme == 'default')?'working':'';?>">1</a></li>
                                <li><a href="javascript:void(0)" theme="green" class="green-theme <?=($site[0]->theme == 'green')?'working':'';?>">2</a></li>
                                <li><a href="javascript:void(0)" theme="gray" class="yellow-theme <?=($site[0]->theme == 'gray')?'working':'';?>">3</a></li>
                                <li><a href="javascript:void(0)" theme="blue" class="blue-theme <?=($site[0]->theme == 'blue')?'working':'';?>">4</a></li>
                                <li><a href="javascript:void(0)" theme="purple" class="purple-theme <?=($site[0]->theme == 'purple')?'working':'';?>">5</a></li>
                                <li><a href="javascript:void(0)" theme="megna" class="megna-theme <?=($site[0]->theme == 'megna')?'working':'';?>">6</a></li>
                                <li><b>With Dark sidebar</b></li>
                                <br/>
                                <li><a href="javascript:void(0)" theme="default-dark" class="default-dark-theme <?=($site[0]->theme == 'default-dark')?'working':'';?>">7</a></li>
                                <li><a href="javascript:void(0)" theme="green-dark" class="green-dark-theme <?=($site[0]->theme == 'green-dark')?'working':'';?>">8</a></li>
                                <li><a href="javascript:void(0)" theme="gray-dark" class="yellow-dark-theme <?=($site[0]->theme == 'gray-dark')?'working':'';?>">9</a></li>
                                <li><a href="javascript:void(0)" theme="blue-dark" class="blue-dark-theme <?=($site[0]->theme == 'blue-dark')?'working':'';?>">10</a></li>
                                <li><a href="javascript:void(0)" theme="purple-dark" class="purple-dark-theme <?=($site[0]->theme == 'purple-dark')?'working':'';?>">11</a></li>
                                <li><a href="javascript:void(0)" theme="megna-dark" class="megna-dark-theme <?=($site[0]->theme == 'megna-dark')?'working':'';?>">12</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
        <!-- /.right-sidebar -->
		<?php } ?>
  <?php } ?>