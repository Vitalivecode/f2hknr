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
                            <form action="<?=base_url('orders/accept');?>" method="get" class="form-horizontal">
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
				<div class="row">
					<?php if(!empty($items)){ ?>
					<div class="col-lg-12">
                        <div class="card">
                            <div class="card-body bg-light">
                                <div class="row">
                                    <div class="col-md-6 col-xs-12">
                                        <h4><?=(isset($_GET['from']) && $_GET['from'] != '')?date('d M Y',strtotime($_GET['from'])):date('d M Y');?></h4>
                                        <h5 class="font-light m-t-0">Accepted Orders</h5></div>
                                    <div class="col-md-6 col-xs-12 align-self-center display-6 text-right">
                                        <h2 class="text-info">₹<?=number_format($itemTotal,2);?></h2>
										<h6>(Exclude delivery charges)</h6>
									</div>
                                </div>
                            </div>
                            <div class="table-responsive col-md-12" style="max-height: 570px;overflow-y: auto;">
                                <table id="tables-accepted" class="table table-hover no-wrap">
                                    <thead>
                                        <tr>
                                            <th class="text-center">#</th>
											<th>BRANCH</th>
                                            <th>NAME</th>
                                            <th>QUANTITY</th>
                                            <th>PRICE</th>
                                            <th>TOTAL</th>
                                            <th>ORDER DATE</th>
                                        </tr>
                                    </thead>
                                    <tbody>
										<?php $no=1; array_multisort(array_column($items, 'quantity'), SORT_DESC, $items); foreach($items as $item){ 
								        $weight = explode(' ',$item['item_details']); $in_weight = ((int)$item['item_details']*$item['quantity'] > 999)?(((int)$item['item_details']*$item['quantity'])/1000).' kg':(int)$item['item_details']*$item['quantity'].' g';
                                        if(stripos($item['item_details'], "kg") !== false)
                                            $details = $item['item_details'].' x ' . $item['quantity'] . ' = '.(int)$item['item_details']*$item['quantity'].' kg';
                                        elseif(isset($weight[1]) && ($weight[1] == 'g' || $weight[1] == 'G'))
                                            $details = $item['item_details'].' x ' . $item['quantity'] . ' = '.$in_weight;
                                        else
										  $details = $item['item_details'].' x ' . $item['quantity'];
										?>
                                        <tr>
                                            <td class="text-center"><?=$no++;?></td>
                                            <td class="txt-oflo"><?=$item['branch'];?></td>
                                            <td class="txt-oflo"><?=$item['name'];?></td><!--
                                            <td class="txt-oflo"><?=$item['quantity'].' ('.$item['type'].')';?></td> -->
                                            <td class="txt-oflo"><?=$details;?></td>
                                            <td><span class="text-info">₹<?=number_format($item['price'],2);?></span></td>
                                            <td><span class="text-info">₹<?=number_format($item['total'],2);?></span></td>
                                            <td class="txt-oflo"><?=date('d-m-Y',strtotime($item['date']));?></td>
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
<link href="<?=base_url('plugins/bower_components/datatables/jquery.dataTables.min.css');?>" rel="stylesheet" type="text/css" />
<link href="https://cdn.datatables.net/buttons/1.2.2/css/buttons.dataTables.min.css" rel="stylesheet" type="text/css" />
<script src="<?=base_url('plugins/bower_components/datatables/jquery.dataTables.min.js');?>"></script>
<script src="https://cdn.datatables.net/buttons/1.2.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.2.2/js/buttons.flash.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js"></script>
    <script src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/pdfmake.min.js"></script>
    <script src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.2.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.2.2/js/buttons.print.min.js"></script>
	<script src="https://cdn.datatables.net/plug-ins/1.10.21/sorting/currency.js"></script>
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
$('#tables-accepted').DataTable({
    dom: 'Bfrtip',
    "pageLength": 50,
    buttons: [
        'copy', 'csv', 'excel', 'pdf', 'print'
    ]
});
</script>