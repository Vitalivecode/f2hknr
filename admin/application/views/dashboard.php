<?php 
	if(isset($_GET['from']) && $_GET['from'] != '')
		$from = date('Y-m-d 00:00:00', strtotime($_GET['from']));
	else
		$from = date('Y-m-d 00:00:00');
	if(isset($_GET['to']) && $_GET['to'] != '')
		$to = date('Y-m-d 00:00:00', strtotime($_GET['to']));
	else
		$to = date('Y-m-d 23:59:00');
?>
<div id="page-wrapper">
    <div class="container-fluid" id="dashboard">
        <div class="row bg-title">
            <div class="col-lg-<?=($userdata[0]->role != 'vendor')?'4':'6';?> col-md-<?=($userdata[0]->role != 'vendor')?'4':'6';?> col-sm-<?=($userdata[0]->role != 'vendor')?'3':'5';?> col-xs-12">
                <h4 class="page-title">Hello <?=($this->ordersModel->getVendorName($vendor_id) != '')?$this->ordersModel->getVendorName($vendor_id):'Admin';?>,</h4> 
			</div>
			<?php if($userdata[0]->role != 'vendor'){ ?>
			<div class="col-lg-3 col-sm-2 col-md-4 col-xs-12">
				<div class="">
					<select id="branch" class="select2-container form-control select2" onchange="if (this.value) window.location.href=this.value"> 
					<?php if($branches != false){ ?> 
						<option value="<?=base_url('home');?>" <?=(isset($vendor_id) && $vendor_id == 'all')?'selected':'';?>>All</option>
					<?php foreach($branches as $branch){ ?>
						<option value="<?=base_url('home/index/'.$branch->rest_id);?>" <?=(isset($vendor_id) && $vendor_id == $branch->rest_id)?'selected':'';?>><?=$branch->rest_name;?></option>
					<?php } } ?>
					</select>
				</div>
			</div>
			<?php } ?>
            <div class="col-lg-<?=($userdata[0]->role != 'vendor')?'5':'6';?> col-sm-<?=($userdata[0]->role != 'vendor')?'7':'6';?> col-md-<?=($userdata[0]->role != 'vendor')?'4':'7';?> col-xs-12">
                <ol class="breadcrumb">
                    <li><a href="<?=base_url()?>">Home</a></li>
                    <li class="active">Dashboard</li>
                </ol>
            </div>
        </div>
				<div class="row">
					<div class="col-lg-12 col-sm-12 col-xs-12">
						<h4 class="text-center">TODAY'S ORDERS</h4>
					</div>
                    <div class="col-lg-2 col-sm-6 col-xs-12">
                        <a  href="<?=base_url('orders?');?>branch=<?=$vendor_id;?>&type=4&date=today">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title text-uppercase">COMPLETED ORDERS</h5>
                                    <div class="d-flex align-items-center no-block m-t-20 m-b-10">
                                        <h1><i class="fa fa-shopping-cart text-success"></i></h1>
                                        <div class="ml-auto">
                                            <h1 class="text-muted"><?=$tcomplete;?></h1>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-lg-2 col-sm-6 col-xs-12">
                        <a  href="<?=base_url('orders?');?>branch=<?=$vendor_id;?>&type=2&date=today">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title text-uppercase">ACCEPTED ORDERS</h5>
                                    <div class="d-flex align-items-center no-block m-t-20 m-b-10">
                                        <h1><i class="fa fa-cart-plus text-info"></i></h1>
                                        <div class="ml-auto">
                                            <h1 class="text-muted"><?=$taccepted;?></h1>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-lg-2 col-sm-6 col-xs-12">
                        <a  href="<?=base_url('orders?');?>branch=<?=$vendor_id;?>&type=1&date=today">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title text-uppercase">PENDING ORDERS</h5>
                                    <div class="d-flex align-items-center no-block m-t-20 m-b-10">
                                        <h1><i class="fa fa-cart-arrow-down text-warning"></i></h1>
                                        <div class="ml-auto">
                                            <h1 class="text-muted"><?=$tpending;?></h1>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-lg-2 col-sm-6 col-xs-12">
                        <a  href="<?=base_url('orders?');?>branch=<?=$vendor_id;?>&type=5&date=today">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title text-uppercase">CANCELLED ORDERS</h5>
                                    <div class="d-flex align-items-center no-block m-t-20 m-b-10">
                                        <h1><i class="icon-basket text-danger"></i></h1>
                                        <div class="ml-auto">
                                            <h1 class="text-muted"><?=$tcancelled;?></h1>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
					<div class="col-lg-4 col-sm-6 col-xs-12">
                        <a  href="<?=base_url('orders?');?>branch=<?=$vendor_id;?>&type=9&date=today">
                                <div class="card bg-purple m-b-15">
                                    <div class="card-body">
                                        <h5 class="text-white card-title">TODAY'S ORDERS</h5>
                                        <div class="row">
                                            <div class="col-6">
                                                <h1 class="text-white"><?=$ttotal;?></h1>
                                                <p class="text-white"><?=date('D d M Y');?></p> 
											</div>
                                        </div>
                                    </div>
                                </div>
                        </a>
                    </div>
                </div>
				
				<div class="row">
					<div class="col-lg-12 col-sm-12 col-xs-12">
						<h4 class="text-center">ORDERS HISTORY</h4>
					</div>
                    <div class="col-lg-2 col-sm-6 col-xs-12">
                        <a  href="<?=base_url('orders?');?>branch=<?=$vendor_id;?>&type=4">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title text-uppercase">COMPLETED ORDERS</h5>
                                    <div class="d-flex align-items-center no-block m-t-20 m-b-10">
                                        <h1><i class="fa fa-shopping-cart text-success"></i></h1>
                                        <div class="ml-auto">
                                            <h1 class="text-muted"><?=$complete;?></h1>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-lg-2 col-sm-6 col-xs-12">
                        <a  href="<?=base_url('orders?');?>branch=<?=$vendor_id;?>&type=2">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title text-uppercase">ACCEPTED ORDERS</h5>
                                    <div class="d-flex align-items-center no-block m-t-20 m-b-10">
                                        <h1><i class="fa fa-cart-plus text-purple"></i></h1>
                                        <div class="ml-auto">
                                            <h1 class="text-muted"><?=$accepted;?></h1>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-lg-2 col-sm-6 col-xs-12">
                        <a  href="<?=base_url('orders?');?>branch=<?=$vendor_id;?>&type=1">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title text-uppercase">PENDING ORDERS</h5>
                                    <div class="d-flex align-items-center no-block m-t-20 m-b-10">
                                        <h1><i class="fa fa-cart-arrow-down text-warning"></i></h1>
                                        <div class="ml-auto">
                                            <h1 class="text-muted"><?=$pending;?></h1>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-lg-2 col-sm-6 col-xs-12">
                        <a  href="<?=base_url('orders?');?>branch=<?=$vendor_id;?>&type=5">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title text-uppercase">CANCELLED ORDERS</h5>
                                    <div class="d-flex align-items-center no-block m-t-20 m-b-10">
                                        <h1><i class="icon-basket text-danger"></i></h1>
                                        <div class="ml-auto">
                                            <h1 class="text-muted"><?=$cancelled;?></h1>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
					<div class="col-lg-4 col-sm-6 col-xs-12">
                        <a  href="<?=base_url('orders?');?>branch=<?=$vendor_id;?>&type=9">
                                <div class="card bg-info m-b-15">
                                    <div class="card-body">
                                        <h5 class="text-white card-title">TOTAL ORDERS</h5>
                                        <div class="row">
                                            <div class="col-6">
                                                <h1 class="text-white"><?=$total;?></h1>
                                                <p class="text-white"><?='29 Mar - '.date('d M Y');?></p> 
											</div>
                                        </div>
                                    </div>
                                </div>
                        </a>
                    </div>
            </div>
			<div class="row">
				<div class="col-md-12">
					<div class="panel panel-primary">
						<div class="panel-heading text-center">Online Orders</div>
						<div class="panel-body">
							<div class="row">
								<div class="col-lg-8 col-md-12">
									<div class="col-lg-12">
										<div class="white-box card">
											<div class="card-body">
												<h4 class="card-title">Bar Chart</h4>
												<div>
													<canvas id="chart2" height="150"></canvas>
												</div>
											</div>
										</div>
									</div>
								</div>
								<?php $userCartTotalCompleted = $this->ordersModel->userCartCompleted($vendor_id);
									$totalCompletedCount = '0';
									$dcc = 0;
									$totaldelivery_charges = array();
									if($userCartTotalCompleted != false)
									{
										foreach($userCartTotalCompleted as $totalCompleted)
										{
											if($totalCompleted['order_status'] == 4)
											{
												if(array_key_exists($totalCompleted['order_id'], $totaldelivery_charges))
												{
													$totaldelivery_charges[$totalCompleted['order_id']] = array(
														'charges' => $totalCompleted['delivery_charges']
													);
												}
												else
												{
													$totaldelivery_charges[$totalCompleted['order_id']] = array(
														'charges' => $totalCompleted['delivery_charges']
													);
												}
											}
										}
										foreach($userCartTotalCompleted as $totalCompleted)
										{
											$discount = (($totalCompleted['price']*$totalCompleted['quantity'])*$totalCompleted['discount'])/100;
										   //  $totalCompletedCount = ((($totalCompleted['price']*$totalCompleted['quantity'])-$discount+$totalCompleted['gst'])+$totalCompleted['delivery_charges'])+$totalCompletedCount;
											$totalCompletedCount = ((($totalCompleted['price']*$totalCompleted['quantity'])-$discount+$totalCompleted['gst']))+$totalCompletedCount;
											$dcc = $totalCompleted['delivery_charges'];
										}
										$dcc = !empty($totaldelivery_charges)?array_sum(array_column($totaldelivery_charges, 'charges')):0;
										$totalCompletedCount = $totalCompletedCount+$dcc;
									}
									
									$userCartTodayCompleted = $this->ordersModel->userCartTodayCompleted($vendor_id, $from, $to);
									$todayCompletedCount = '0';
									$dc = 0;
									$delivery_charges = array();
									if($userCartTodayCompleted != false)
									{
										foreach($userCartTodayCompleted as $todayCompleted)
										{
											if($todayCompleted['order_status'] == 4)
											{
												if(array_key_exists($todayCompleted['order_id'], $delivery_charges))
												{
													$delivery_charges[$todayCompleted['order_id']] = array(
														'charges' => $todayCompleted['delivery_charges']
													);
												}
												else
												{
													$delivery_charges[$todayCompleted['order_id']] = array(
														'charges' => $todayCompleted['delivery_charges']
													);
												}
											}
										}
										foreach($userCartTodayCompleted as $todayCompleted)
										{
											if($todayCompleted['order_status'] == 4)
											{
												$dc = $todayCompleted['delivery_charges'];
												$discount = (($todayCompleted['price']*$todayCompleted['quantity'])*$todayCompleted['discount'])/100;
											   // $todayCompletedCount = ((($todayCompleted['price']*$todayCompleted['quantity'])-$discount+$todayCompleted['gst'])+$todayCompleted['delivery_charges'])+$todayCompletedCount;
												$todayCompletedCount = ((($todayCompleted['price']*$todayCompleted['quantity'])-$discount+$todayCompleted['gst']))+$todayCompletedCount;
											}    
										}
										$dc = !empty($delivery_charges)?array_sum(array_column($delivery_charges, 'charges')):0;
										$todayCompletedCount = $todayCompletedCount+$dc;
									}
								?>
								<div class="col-lg-4 row">
										<div class="col-md-12">
											<div class="card">
												<div class="card-body">
													<h5 class="card-title">TODAY SALE AMOUNT</h5>
													<div class="row">
														<div class="col-md-6 m-t-10">
															<h1 class="text-primary">₹<?=number_format($todayCompletedCount,2);?></h1>
															<p class="text-muted"><?=date('d M Y');?></p>
															<b>(<?=$tcomplete;?> orders)</b> 
														</div>
														<div class="col-md-6">
															<div id="todaysales" class="text-right"></div>
														</div>
													</div>
												</div>
											</div>
										</div>
										<div class="col-md-12">
											<div class="card">
												<div class="card-body">
													<h5 class="card-title">TOTAL SALE AMOUNT</h5>
													<div class="row">
														<div class="col-md-6 m-t-10">
															<h1 class="text-primary">₹<?=number_format($totalCompletedCount,2);?></h1>
															<p class="text-muted"><?='29 Mar - '.date('d M Y');?></p>
															<b>(<?=$complete;?> orders)</b> 
														</div>
														<div class="col-md-6">
															<div id="totalsales" class="text-right"></div>
														</div>
													</div>
												</div>
											</div>
										</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			
				<div class="row">
					<?php if($site != false){ switch($site[0]->theme){ case 'purple-dark': case 'purple': $bgcolor = '#ab8ce4'; break; case 'default-dark': case 'default': $bgcolor = '#fb9678'; break; case 'green-dark': case 'green': $bgcolor = '#00c292'; break; case 'gray-dark': case 'gray': $bgcolor = '#a0aec4'; break; case 'blue-dark': case 'blue': $bgcolor = '#03a9f3'; break; case 'megna-dark': case 'megna': $bgcolor = '#01c0c8'; break;  default: $bgcolor = ''; break; } } 
				   foreach($tables as $tname ) : $pages = json_decode($tname->permissions); if(!empty($pages->display)) { if($pages->display == 'show') { if((permissions($userdata[0]->permissions,$tname->table_name)) || $this->session->userdata('logged_in')['role'] == 'superadmin'){  ?>
                    <!-- Column -->
                    <div class="col-lg-3 col-md-6">
						<?php $table_type1= $this->adminpanel->getTableType($tname->table_name);if($table_type1[0]->table_type == 'cms') { ?>
                        <a href="<?=base_url()?>cms/<?=str_replace('_','-',$tname->table_name);?>">
						<?php } else { ?>
							<a href="<?=base_url($c->table_name);?>">
						<?php } ?>
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex flex-row">
                                    <div class="round align-self-center" style="background: <?=($tname->bg_color != '')?$tname->bg_color:$bgcolor;?>"><i class="<?=$tname->icon;?>"></i></div>
                                    <div class="m-l-10 align-self-center">
                                        <h3 class="m-b-0"><?php  if($pages->count == 'show') { $where = ($this->session->userdata('logged_in')['role'] == 'superadmin' || $this->session->userdata('logged_in')['role'] == 'admin')?NULL:array('vendor_id' => $this->session->userdata('logged_in')['branch']); if(is_array($this->site->table($tname->table_name,$where))){ echo count($this->site->table($tname->table_name,$where)); } else{ echo 0;} } ?></h3>
                                        <h5 class="text-muted m-b-0"><?=ucfirst($tname->cttitle);?></h5></div>
                                </div>
                            </div>
                        </div></a>
                    </div>
                    <!-- Column -->
					<?php } } }endforeach ?>
                    <?php if($this->session->userdata('logged_in')['role'] == 'superadmin') { ?>
                    <!-- Column -->
                    <div class="col-lg-3 col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex flex-row">
                                    <div class="round align-self-center round-info"><i class="fa fa-users"></i></div>
                                    <div class="m-l-10 align-self-center">
                                        <h3 class="m-b-0"><?php echo $this->db->count_all_results('admin');?></h3>
                                        <h5 class="text-muted m-b-0">Admin(s)</h5></div>
                                </div>
                            </div>
                        </div></a>
                    </div>
                    <!-- Column -->
					<?php } ?>
                </div>
    </div>
<?php $topSellers = $this->ordersModel->userCart($vendor_id);
    if($topSellers != false)
    {
        $itemNames = '';
        $itemQuantity = '';
        foreach($topSellers as $topSeller)
        {
            $itemNames .= '"'.$topSeller['item_name'].'",';
            $itemQuantity .= $topSeller['top_quantity'].',';
        }
        $names = substr($itemNames,0,-1);
        $quantity = substr($itemQuantity,0,-1);
?>
<script src="<?=base_url('js/Chart.min.js');?>"></script>
<script>
    $(function() {
        new Chart(document.getElementById("chart2"),
        {
            "type":"bar",
            "data":{"labels":[<?=$names;?>],
            "datasets":[{
                            "label":"Top Product",
                            "data":[<?=$quantity;?>],
                            "fill":false,
                            "backgroundColor":["rgba(255, 99, 132, 0.2)","rgba(255, 159, 64, 0.2)","rgba(255, 205, 86, 0.2)","rgba(75, 192, 192, 0.2)","rgba(54, 162, 235, 0.2)","rgba(153, 102, 255, 0.2)","rgba(201, 203, 207, 0.2)"],
                            "borderColor":["rgb(255, 99, 132)","rgb(255, 159, 64)","rgb(255, 205, 86)","rgb(75, 192, 192)","rgb(54, 162, 235)","rgb(153, 102, 255)","rgb(201, 203, 207)"],
                            "borderWidth":1}
                        ]},
            "options":{
                "scales":{"yAxes":[{"ticks":{"beginAtZero":true}}]}
            }
        });
    });
    var sparklineLogin = function() { 
        $('#todaysales').sparkline([<?=$tcomplete; ?>, <?=$tpending;?>, <?=$tcancelled;?>], {
            type: 'pie',
            height: '80',
            resize: true,
            sliceColors: ['#3ba251', '#ff9800', '#d95b11']
        });
        $('#totalsales').sparkline([<?=$totalCompletedCount;?>], {
            type: 'pie',
            height: '80',
            resize: true,
            sliceColors: ['#3ba251']
        });
    }
    var sparkResize;
    $(window).resize(function(e) {
        clearTimeout(sparkResize);
        sparkResize = setTimeout(sparklineLogin, 500);
    });
    sparklineLogin();
</script>
<?php } ?>