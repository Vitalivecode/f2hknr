<?php 
	if(isset($_GET['from']) && $_GET['from'] != '')
		$from = date('Y-m-d 00:00:00', strtotime($_GET['from']));
	else
		$from = date('Y-m-d 00:00:00');
	if(isset($_GET['to']) && $_GET['to'] != '')
		$to = date('Y-m-d 23:59:59', strtotime($_GET['to']));
	else
		$to = date('Y-m-d 23:59:59');
?>
<div id="page-wrapper">
    <div class="container-fluid" id="dashboard">
        <div class="row bg-title">
            <div class="col-lg-<?=($userdata[0]->role != 'vendor')?'4':'6';?> col-md-<?=($userdata[0]->role != 'vendor')?'4':'6';?> col-sm-<?=($userdata[0]->role != 'vendor')?'3':'5';?> col-xs-12">
                <h4 class="page-title"><?=$title;?></h4> 
			</div>
			<?php if($userdata[0]->role != 'vendor'){ ?>
			<div class="col-lg-3 col-sm-2 col-md-4 col-xs-12">
			</div>
			<?php } ?>
            <div class="col-lg-<?=($userdata[0]->role != 'vendor')?'5':'6';?> col-sm-<?=($userdata[0]->role != 'vendor')?'7':'6';?> col-md-<?=($userdata[0]->role != 'vendor')?'4':'7';?> col-xs-12">
                <ol class="breadcrumb">
                    <li><a href="<?=base_url()?>">Home</a></li>
                    <li class="active"><?=$title;?></li>
                </ol>
            </div>
        </div>
			<div class="row">
                    <div class="col-md-12">
                        <div class="white-box">
                            <form action="<?=base_url('reports');?>" method="get" class="form-horizontal">
                                <div class="form-group" style="margin-bottom: 0px;">
								<?php if($userdata[0]->role != 'vendor'){ ?>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="col-md-12">Branches</label>
                                            <div class="col-md-12">
                                                <select id="branch" name="branch" class="select2-container form-control select2"> 
												<?php if($branches != false){ ?> 
													<option value="all" <?=(isset($vendor_id) && $vendor_id == 'all')?'selected':'';?>>All</option>
												<?php foreach($branches as $branch){ ?>
													<option value="<?=$branch->rest_id;?>" <?=(isset($vendor_id) && $vendor_id == $branch->rest_id)?'selected':'';?>><?=$branch->rest_name;?></option>
												<?php } } ?>
												</select>
        									</div>
    									</div>
                                    </div>
								<?php } ?>
									<div class="col-md-2">
									    <div class="form-group">
    									    <label class="col-md-12">From Date</label>
    									    <div class="col-md-12">
        										<input class="form-control" name="from" value="<?=(isset($_GET['from']) && $_GET['from'] != '')?$_GET['from']:date('Y-m-d');?>" type="date">
        										<span></span>
        									</div>
    									</div>
									</div>
									<div class="col-md-2">
									    <div class="form-group">
    									    <label class="col-md-12">To Date</label>
    									    <div class="col-md-12">
        										<input class="form-control" name="to" value="<?=(isset($_GET['to']) && $_GET['to'] != '')?$_GET['to']:date('Y-m-d');?>" type="date">
        										<span></span>
        									</div>
    									</div>
									</div>
									<div class="col-md-1">
									    <div class="form-group">
    									    <label class="col-md-12"> &nbsp; </label>
    									    <div class="col-md-12">
    										    <input class="btn btn-info" value="Search" type="submit">
    										</div>
    									</div>
									</div>
								</div>
							</form>
						</div>
					</div>
				</div>
				<div class="row hidden-xs">
					<div class="col-md-12 m-b-15">
						<?php $getBranch = (isset($_GET['branch']) && $_GET['branch'] != '')?$_GET['branch']:'all'; $params = $_SERVER['QUERY_STRING']; $fullURL = base_url('reports').'?'.$params; ?>
						<a href="<?=base_url('reports?branch='.$getBranch.'&from='.date('Y-m-d').'&to='.date('Y-m-d'));?>" class="text-white btn btn-<?=($fullURL == base_url('reports?branch='.$getBranch.'&from='.date('Y-m-d').'&to='.date('Y-m-d')))?'primary':'default';?> btn-sm">Today</a>
						<a href="<?=base_url('reports?branch='.$getBranch.'&from='.date('Y-m-d', strtotime('this Sunday')).'&to='.date('Y-m-d', strtotime('this Saturday')));?>" class="text-white btn btn-<?=($fullURL == base_url('reports?branch='.$getBranch.'&from='.date('Y-m-d', strtotime('this Sunday')).'&to='.date('Y-m-d', strtotime('this Saturday'))))?'primary':'default';?> btn-sm">This Week</a>
						<a href="<?=base_url('reports?branch='.$getBranch.'&from='.date('Y-m-d', strtotime('last Sunday')).'&to='.date('Y-m-d', strtotime('last Saturday')));?>" class="text-white btn btn-<?=($fullURL == base_url('reports?branch='.$getBranch.'&from='.date('Y-m-d', strtotime('last Sunday')).'&to='.date('Y-m-d', strtotime('last Saturday'))))?'primary':'default';?> btn-sm">Last Week</a>
						<a href="<?=base_url('reports?branch='.$getBranch.'&from='.date('Y-m-d', strtotime('first day of this month')).'&to='.date('Y-m-d', strtotime('last day of this month')));?>" class="text-white btn btn-<?=($fullURL == base_url('reports?branch='.$getBranch.'&from='.date('Y-m-d', strtotime('first day of this month')).'&to='.date('Y-m-d', strtotime('last day of this month'))))?'primary':'default';?> btn-sm">This Month</a>
						<a href="<?=base_url('reports?branch='.$getBranch.'&from='.date('Y-m-d', strtotime('first day of previous month')).'&to='.date('Y-m-d', strtotime('last day of previous month')));?>" class="text-white btn btn-<?=($fullURL == base_url('reports?branch='.$getBranch.'&from='.date('Y-m-d', strtotime('first day of previous month')).'&to='.date('Y-m-d', strtotime('last day of previous month'))))?'primary':'default';?> btn-sm">Last Month</a>
						<a href="<?=base_url('reports?branch='.$getBranch.'&from='.date('Y-m-01', strtotime('-4 month')).'&to='.date('Y-m-d', strtotime('last day of previous month')));?>" class="text-white btn btn-<?=($fullURL == base_url('reports?branch='.$getBranch.'&from='.date('Y-m-01', strtotime('-4 month')).'&to='.date('Y-m-d', strtotime('last day of previous month'))))?'primary':'default';?> btn-sm">Last 3 Months</a>
						<a href="<?=base_url('reports?branch='.$getBranch.'&from='.date('Y-m-01', strtotime('-7 month')).'&to='.date('Y-m-d', strtotime('last day of previous month')));?>" class="text-white btn btn-<?=($fullURL == base_url('reports?branch='.$getBranch.'&from='.date('Y-m-01', strtotime('-7 month')).'&to='.date('Y-m-d', strtotime('last day of previous month'))))?'primary':'default';?> btn-sm">Last 6 Months</a>
						<a href="<?=base_url('reports?branch='.$getBranch.'&from='.date('Y-01-01').'&to='.date('Y-m-d'));?>" class="text-white btn btn-<?=($fullURL == base_url('reports?branch='.$getBranch.'&from='.date('Y-01-01').'&to='.date('Y-m-d')))?'primary':'default';?> btn-sm">This Year</a>
						<a href="<?=base_url('reports?branch='.$getBranch.'&from='.date('Y-01-01', strtotime('last Year')).'&to='.date('Y-12-31', strtotime('last Year')));?>" class="text-white btn btn-<?=($fullURL == base_url('reports?branch='.$getBranch.'&from='.date('Y-01-01', strtotime('last Year')).'&to='.date('Y-12-31', strtotime('last Year'))))?'primary':'default';?> btn-sm">Last Year</a>
						<a href="<?=base_url('reports?branch='.$getBranch.'&from='.date('Y-01-01', strtotime('-2 Year')).'&to='.date('Y-12-31', strtotime('-1 Year')));?>" class="text-white btn btn-<?=($fullURL == base_url('reports?branch='.$getBranch.'&from='.date('Y-01-01', strtotime('-2 Year')).'&to='.date('Y-12-31', strtotime('-1 Year'))))?'primary':'default';?> btn-sm">Last 2 Years</a>
						<a href="<?=base_url('reports?branch='.$getBranch.'&from='.date('Y-01-01', strtotime('-3 Year')).'&to='.date('Y-12-31', strtotime('-1 Year')));?>" class="text-white btn btn-<?=($fullURL == base_url('reports?branch='.$getBranch.'&from='.date('Y-01-01', strtotime('-3 Year')).'&to='.date('Y-12-31', strtotime('-1 Year'))))?'primary':'default';?> btn-sm">Last 3 Years</a>
						<a href="<?=base_url('reports?branch='.$getBranch.'&from='.date('Y-01-01', strtotime('-6 Year')).'&to='.date('Y-12-31', strtotime('-1 Year')));?>" class="text-white btn btn-<?=($fullURL == base_url('reports?branch='.$getBranch.'&from='.date('Y-01-01', strtotime('-6 Year')).'&to='.date('Y-12-31', strtotime('-1 Year'))))?'primary':'default';?> btn-sm">Last 6 Years</a>
						<a href="<?=base_url('reports?branch='.$getBranch.'&from='.date('Y-01-01', strtotime('-6 Year')).'&to='.date('Y-m-d'));?>" class="text-white btn btn-<?=($fullURL == base_url('reports?branch='.$getBranch.'&from='.date('Y-01-01', strtotime('-6 Year')).'&to='.date('Y-m-d')))?'primary':'default';?> btn-sm">Last 6 Years - Today</a>
					</div>
				</div>
				<div class="row">
					<div class="col-md-7">
						<div class="row">
							<div class="col-lg-6 col-sm-6 col-xs-12">
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
							</div>
							<div class="col-lg-6 col-sm-6 col-xs-12">
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
							</div>
							<div class="col-lg-6 col-sm-6 col-xs-12">
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
							</div>
							<div class="col-lg-6 col-sm-6 col-xs-12">
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
							</div>
						</div>
					</div>
					<div class="col-md-5">
						<div class="row">
							<?php 
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
											//$dc = $todayCompleted['delivery_charges'];
											$discount = (($todayCompleted['price']*$todayCompleted['quantity'])*$todayCompleted['discount'])/100;
											// $todayCompletedCount = ((($todayCompleted['price']*$todayCompleted['quantity'])-$discount+$todayCompleted['gst'])+$todayCompleted['delivery_charges'])+$todayCompletedCount;
											$todayCompletedCount = ((($todayCompleted['price']*$todayCompleted['quantity'])-$discount+$todayCompleted['gst']))+$todayCompletedCount;
										}    
									}
									$dc = !empty($delivery_charges)?array_sum(array_column($delivery_charges, 'charges')):0;
									$todayCompletedCount = $todayCompletedCount+$dc;
								}
							?>
							<div class="col-md-12">
								<div class="card">
									<div class="card-body">
										<h5 class="card-title">SALE AMOUNT (<?=$tcomplete;?> orders)</h5>
										<div class="row">
											<div class="col-md-6 m-t-10">
												<h1 class="text-primary">₹<?=number_format($todayCompletedCount,2);?></h1>
												<p class="text-muted"><?=(isset($_GET['from']) && $_GET['from'] != '' && isset($_GET['to']) && $_GET['to'] != '')?date('d M Y',strtotime($_GET['from'])).' - '.date('d M Y',strtotime($_GET['to'])):date('d M Y');?></p>
												<b>(<?=$ttotal;?> Total orders)</b> 
											</div>
											<div class="col-md-6">
												<div id="todaysales" class="text-right"></div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			<div class="row">
				<div class="col-md-12">
					<div class="panel panel-primary">
						<div class="panel-body">
							<div class="row">
								<div class="col-lg-12 col-md-12">
									<div class="white-box card">
										<div class="card-body">
											<h4 class="card-title">Bar Chart (Top 10 Sale Products)</h4>
											<div>
												<canvas id="chart2" height="150"></canvas>
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
					<?php if(!empty($items)){ ?>
					<div class="col-lg-6">
                        <div class="card">
                            <div class="card-body bg-light">
                                <div class="row">
                                    <div class="col-md-6 col-xs-12">
                                        <h4><?=(isset($_GET['from']) && $_GET['from'] != '' && isset($_GET['to']) && $_GET['to'] != '')?date('d M Y',strtotime($_GET['from'])).' - '.date('d M Y',strtotime($_GET['to'])):date('d M Y');?></h4>
                                        <h5 class="font-light m-t-0">Delivered Orders</h5></div>
                                    <div class="col-md-6 col-xs-12 align-self-center display-6 text-right">
                                        <h2 class="text-success">₹<?=number_format($itemTotal,2);?></h2>
										<h6>(Exclude delivery charges)</h6>
									</div>
                                </div>
                            </div>
                            <div class="table-responsive" style="max-height: 570px;overflow-y: auto;">
                                <table class="table table-hover no-wrap">
                                    <thead>
                                        <tr>
                                            <th class="text-center">#</th>
											<th>BRANCH</th>
                                            <th>NAME</th>
                                            <th>STATUS</th>
                                            <th>QUANTITY</th>
                                            <th>PRICE</th>
                                        </tr>
                                    </thead>
                                    <tbody>
										<?php $no=1; array_multisort(array_column($items, 'quantity'), SORT_DESC, $items); foreach($items as $item){ 
										
										?>
                                        <tr>
                                            <td class="text-center"><?=$no++;?></td>
                                            <td class="txt-oflo"><?=$item['branch'];?></td>
                                            <td class="txt-oflo"><?=$item['name'];?></td>
                                            <td><span class="badge badge-success badge-pill">Delivered</span> </td>
                                            <td class="txt-oflo"><?=$item['quantity'].' ('.$item['type'].')';?></td>
                                            <td><span class="text-success">₹<?=number_format($item['price'],2);?></span></td>
                                        </tr>
										<?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
					<?php } ?>
					<?php if(!empty($cancelItems)){ ?>
					<div class="col-lg-6">
                        <div class="card">
                            <div class="card-body bg-light">
                                <div class="row">
                                    <div class="col-md-6 col-xs-12">
                                        <h4><?=(isset($_GET['from']) && $_GET['from'] != '' && isset($_GET['to']) && $_GET['to'] != '')?date('d M Y',strtotime($_GET['from'])).' - '.date('d M Y',strtotime($_GET['to'])):date('d M Y');?></h4>
                                        <h5 class="font-light m-t-0">Cancelled Orders</h5></div>
                                    <div class="col-md-6 col-xs-12 align-self-center display-6 text-right">
                                        <h2 class="text-danger">₹<?=number_format($cancelItemTotal,2);?></h2>
										<h6>(Exclude delivery charges)</h6>
									</div>
                                </div>
                            </div>
                            <div class="table-responsive" style="max-height: 570px;overflow-y: auto;">
                                <table class="table table-hover no-wrap">
                                    <thead>
                                        <tr>
                                            <th class="text-center">#</th>
											<th>BRANCH</th>
                                            <th>NAME</th>
                                            <th>STATUS</th>
                                            <th>QUANTITY</th>
                                            <th>PRICE</th>
                                        </tr>
                                    </thead>
                                    <tbody>
										<?php $no=1; array_multisort(array_column($cancelItems, 'quantity'), SORT_DESC, $cancelItems); foreach($cancelItems as $item){ 
										
										?>
                                        <tr>
                                            <td class="text-center"><?=$no++;?></td>
                                            <td class="txt-oflo"><?=$item['branch'];?></td>
                                            <td class="txt-oflo"><?=$item['name'];?></td>
                                            <td><span class="badge badge-danger badge-pill">CANCELLED</span> </td>
                                            <td class="txt-oflo"><?=$item['quantity'].' ('.$item['type'].')';?></td>
                                            <td><span class="text-danger">₹<?=number_format($item['price'],2);?></span></td>
                                        </tr>
										<?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
					<?php } ?>
				</div>
			<?php if($userdata[0]->role != 'vendor'){ ?>
			<div class="row">
				<div class="col-md-12">
					<div class="panel panel-primary">
						<div class="panel-body">
							<div class="row">
								<div class="col-lg-12 col-md-12">
									<div class="white-box card">
										<div class="card-body">
											<h4 class="card-title">Bar Chart (Top 10 Branches)</h4>
											<div>
												<canvas id="chart3" height="150"></canvas>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<?php } ?>
			<div class="row">
				<?php if(!empty($delivery)){ ?>
					<div class="col-lg-6">
                        <div class="card">
                            <div class="card-body bg-light">
                                <div class="row">
                                    <div class="col-md-6 col-xs-12">
                                        <h4><?=(isset($_GET['from']) && $_GET['from'] != '' && isset($_GET['to']) && $_GET['to'] != '')?date('d M Y',strtotime($_GET['from'])).' - '.date('d M Y',strtotime($_GET['to'])):date('d M Y');?></h4>
                                        <h5 class="font-light m-t-0">Delivery Charges</h5></div>
                                    <div class="col-md-6 col-xs-12 align-self-center display-6 text-right">
                                        <h2 class="text-success">₹<?=number_format($totalDeliveryCharges,2);?></h2>
									</div>
                                </div>
                            </div>
                            <div class="table-responsive" style="max-height: 570px;overflow-y: auto;">
                                <table class="table table-hover no-wrap">
                                    <thead>
                                        <tr>
                                            <th class="text-center">#</th>
											<th>BRANCH</th>
                                            <th>CHARGES</th>
                                        </tr>
                                    </thead>
                                    <tbody>
										<?php $no=1; foreach($delivery as $charges){ 
										
										?>
                                        <tr>
                                            <td class="text-center"><?=$no++;?></td>
                                            <td class="txt-oflo"><?=$charges['branch'];?></td>
                                            <td><span class="text-success">₹<?=number_format($charges['charge'],2);?></span></td>
                                        </tr>
										<?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
					<div class="col-lg-6">
                        <div class="card">
                            <div class="card-body bg-light">
                                <div class="row">
                                    <div class="col-md-6 col-xs-12">
                                        <h4><?=(isset($_GET['from']) && $_GET['from'] != '' && isset($_GET['to']) && $_GET['to'] != '')?date('d M Y',strtotime($_GET['from'])).' - '.date('d M Y',strtotime($_GET['to'])):date('d M Y');?></h4>
                                        <h5 class="font-light m-t-0">Delivered Orders</h5></div>
                                    <div class="col-md-6 col-xs-12 align-self-center display-6 text-right">
                                        <h2 class="text-success"><?=number_format($tcomplete,0);?></h2>
									</div>
                                </div>
                            </div>
                            <div class="table-responsive" style="max-height: 570px;overflow-y: auto;">
                                <table class="table table-hover no-wrap">
                                    <thead>
                                        <tr>
                                            <th class="text-center">#</th>
											<th>BRANCH</th>
                                            <th>ORDERS</th>
                                        </tr>
                                    </thead>
                                    <tbody>
										<?php $no=1; foreach($delivery as $charges){ 
										
										?>
                                        <tr>
                                            <td class="text-center"><?=$no++;?></td>
                                            <td class="txt-oflo"><?=$charges['branch'];?></td>
                                            <td><span class="text-success"><?=number_format($charges['orders'],0);?></span></td>
                                        </tr>
										<?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
				<?php } ?>
				<?php if(!empty($payments)){ $vendorOrders = 0; foreach($payments as $payment){ $vendortotalCompletedCount = $vendortotalCompletedCount+$payment['charge']; $vendorOrders = $vendorOrders+$payment['cod_orders']+$payment['online_orders']; } ?>
					<div class="col-lg-6">
                        <div class="card">
                            <div class="card-body bg-light">
                                <div class="row">
                                    <div class="col-md-6 col-xs-12">
                                        <h4><?=(isset($_GET['from']) && $_GET['from'] != '' && isset($_GET['to']) && $_GET['to'] != '')?date('d M Y',strtotime($_GET['from'])).' - '.date('d M Y',strtotime($_GET['to'])):date('d M Y');?></h4>
                                        <h5 class="font-light m-t-0">COD and Online Payment</h5></div>
                                    <div class="col-md-6 col-xs-12 align-self-center display-6 text-right">
                                        <h2 class="text-success">₹<?=number_format($vendortotalCompletedCount,2);?></h2>
										<h6>(Include delivery charges)</h6>
									</div>
                                </div>
                            </div>
                            <div class="table-responsive" style="max-height: 570px;overflow-y: auto;">
                                <table class="table table-hover no-wrap">
                                    <thead>
                                        <tr>
                                            <th class="text-center">#</th>
											<th>BRANCH</th>
                                            <th>COD</th>
                                            <th>ONLINE</th>
                                        </tr>
                                    </thead>
                                    <tbody>
										<?php $no=1; foreach($payments as $payment){ 
										
										?>
                                        <tr>
                                            <td class="text-center"><?=$no++;?></td>
                                            <td class="txt-oflo"><?=$payment['branch'];?></td>
                                            <td><span class="text-danger">₹<?=number_format($payment['cod']+$payment['cod_charge'],2);?></span></td>
                                            <td><span class="text-success">₹<?=number_format($payment['online']+$payment['online_charge'],2);?></span></td>
                                        </tr>
										<?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
					<div class="col-lg-6">
                        <div class="card">
                            <div class="card-body bg-light">
                                <div class="row">
                                    <div class="col-md-6 col-xs-12">
                                        <h4><?=(isset($_GET['from']) && $_GET['from'] != '' && isset($_GET['to']) && $_GET['to'] != '')?date('d M Y',strtotime($_GET['from'])).' - '.date('d M Y',strtotime($_GET['to'])):date('d M Y');?></h4>
                                        <h5 class="font-light m-t-0">Payment wise Orders</h5></div>
                                    <div class="col-md-6 col-xs-12 align-self-center display-6 text-right">
                                        <h2 class="text-success"><?=number_format($vendorOrders,0);?></h2>
									</div>
                                </div>
                            </div>
                            <div class="table-responsive" style="max-height: 570px;overflow-y: auto;">
                                <table class="table table-hover no-wrap">
                                    <thead>
                                        <tr>
                                            <th class="text-center">#</th>
											<th>BRANCH</th>
                                            <th>COD</th>
                                            <th>ONLINE</th>
                                        </tr>
                                    </thead>
                                    <tbody>
										<?php $no=1; foreach($payments as $payment){ ?>
                                        <tr>
                                            <td class="text-center"><?=$no++;?></td>
                                            <td class="txt-oflo"><?=$payment['branch'];?></td>
                                            <td><span class="text-danger"><?=number_format($payment['cod_orders'],0);?></span></td>
                                            <td><span class="text-success"><?=number_format($payment['online_orders'],0);?></span></td>
                                        </tr>
										<?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
				<?php } ?>
			</div>
			<div class="row">
					<?php if(!empty($users)){ foreach($users as $item){ $usertotalCompletedCount = $usertotalCompletedCount+$item['charge']; } ?>
					<div class="col-lg-12">
                        <div class="card">
                            <div class="card-body bg-light">
                                <div class="row">
                                    <div class="col-md-6 col-xs-12">
                                        <h3><?=(isset($_GET['from']) && $_GET['from'] != '' && isset($_GET['to']) && $_GET['to'] != '')?date('d M Y',strtotime($_GET['from'])).' - '.date('d M Y',strtotime($_GET['to'])):date('d M Y');?></h3>
                                        <h5 class="font-light m-t-0">Top Customer Orders</h5></div>
                                    <div class="col-md-6 col-xs-12 align-self-center display-6 text-right">
                                        <h2 class="text-success">₹<?=number_format($usertotalCompletedCount,2);?></h2>
										<h6>(Include delivery charges)</h6>
									</div>
                                </div>
                            </div>
                            <div class="table-responsive" style="max-height: 570px;overflow-y: auto;">
                                <table class="table table-hover no-wrap">
                                    <thead>
                                        <tr>
                                            <th class="text-center">#</th>
											<th>BRANCH</th>
                                            <th>MOBILE NO.</th>
                                            <th>ORDERS</th>
                                            <th>COD ORDERS</th>
                                            <th>ONLINE ORDERS</th>
                                            <th>COD AMOUNT</th>
                                            <th>ONLINE AMOUNT</th>
                                            <th>TOTAL AMOUNT</th>
                                        </tr>
                                    </thead>
                                    <tbody>
										<?php $no=1; array_multisort(array_column($users, 'orders'), SORT_DESC, $users); foreach($users as $item){ 
										
										?>
                                        <tr>
                                            <td class="text-center"><?=$no++;?></td>
                                            <td class="txt-oflo"><?=$item['branch'];?></td>
                                            <td class="txt-oflo"><?=$item['mobile'];?></br><span class="badge badge-success badge-pill"><?=$item['name'];?></span></td>
                                            <td class="txt-oflo"><?=$item['orders'];?></td>
											<td><span class="text-danger"><?=$item['cod_orders'];?></span></td>
											<td><span class="text-success"><?=$item['online_orders'];?></span></td>
											<td><span class="text-danger">₹<?=number_format($item['cod']+$item['cod_charge'],2);?></span></td>
											<td><span class="text-success">₹<?=number_format($item['online']+$item['online_charge'],2);?></span></td>
                                            <td><span class="text-success">₹<?=number_format($item['price']+$item['charge'],2);?></span></td>
                                        </tr>
										<?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
					<?php } ?>
				</div>
			
    </div>
<script src="<?=base_url('js/Chart.min.js');?>"></script>
<?php $topSellers = $this->ordersModel->userCart($vendor_id, $from, $to);
	$names = '';
	$quantity = 0;
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
	}
	$topSales = $this->ordersModel->vendorWiseSaleProduct($vendor_id, '4', $from, $to);
	$product = '';
	$productQuantity = 0;
    if($topSales != false)
    {
        $itemNames = '';
        $itemQuantity = '';
        foreach($topSales as $topSale)
        {
            $itemNames .= '"'.$topSale['item_name'].'",';
            $itemQuantity .= $topSale['top_quantity'].',';
        }
        $product = substr($itemNames,0,-1);
        $productQuantity = substr($itemQuantity,0,-1);
	}
	$topBranches = $this->ordersModel->vendorWiseReport($vendor_id, '4', $from, $to);
	$branch = '';
	$sale = 0;
    if($topBranches != false)
    {
        $branchNames = '';
        $branchSale = '';
        foreach($topBranches as $topBranch)
        {
            $branchNames .= '"'.$topBranch['rest_name'].'",';
            $branchSale .= $topBranch['top'].',';
        }
        $branch = substr($branchNames,0,-1);
        $sale = substr($branchSale,0,-1);
	}
?>
<script>
    $(function() {
        new Chart(document.getElementById("chart"),
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
	$(function() {
        new Chart(document.getElementById("chart2"),
        {
            "type":"bar",
            "data":{"labels":[<?=$product;?>],
            "datasets":[{
                            "label":"Top Sale Product",
                            "data":[<?=$productQuantity;?>],
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
	$(function() {
        new Chart(document.getElementById("chart3"),
        {
            "type":"bar",
            "data":{"labels":[<?=$branch;?>],
            "datasets":[{
                            "label":"Top Branch",
                            "data":[<?=$sale;?>],
                            "fill":false,
                            "backgroundColor":["rgb(60 148 79 / 20%)","rgba(255, 159, 64, 0.2)","rgba(255, 205, 86, 0.2)","rgba(75, 192, 192, 0.2)","rgba(54, 162, 235, 0.2)","rgba(153, 102, 255, 0.2)","rgba(201, 203, 207, 0.2)"],
                            "borderColor":["rgb(61 117 68)","rgb(255, 159, 64)","rgb(255, 205, 86)","rgb(75, 192, 192)","rgb(54, 162, 235)","rgb(153, 102, 255)","rgb(201, 203, 207)"],
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
    }
    var sparkResize;
    $(window).resize(function(e) {
        clearTimeout(sparkResize);
        sparkResize = setTimeout(sparklineLogin, 500);
    });
    sparklineLogin();
</script>