<?php
	$c = 0;
	$deliveryType = $row['order_type'];
	$address_id ='';
	$customerDetails['mobile']='';
?>
		<div id="page-wrapper">
            <div class="container-fluid">
                <div class="row bg-title">
                    <div class="col-lg-3 col-md-4 col-md-4 col-xs-12">
                        <h4 class="page-title"><?=$title;?></h4> </div>
                    <div class="col-lg-9 col-md-8 col-md-8 col-xs-12">
                        <ol class="breadcrumb">
                            <li><a href="<?=base_url();?>">Home</a></li>
                            <li class="active"><?=$title;?></li>
                        </ol>
                    </div>
                    <!-- /.col-lg-12 -->
                </div>
				  <div class="row">
					<div class="col-lg-12">
						<div class="white-box">
							<div class="row">
									<div class="col-md-12">
										<div class="scrollable">
											<div class="row"><div class="col-md-12"><h3> Order Details: <b><?=$row['order_id']?></b> </h3></div></div>
											<?php $orderstatus = $this->ordersModel->getOrderStatus($txn_id); if($orderstatus['status']== 2) {	?>
											<div class="row">
												<div class="col-md-8">
													<form id="addItem" method="post">
														<div class="col-md-5">
															<div class="form-group">
																 <select class="select2 form-control custom-select" required name="item">
																	<option value="">Select Item</option>
																		<?php $que = $this->get->tableArray('restaurant_items', array('vendor_id' => $row['vendor_id'],'status' => 1));
																			if($que != false){ foreach($que as $res){ ?>
																				<option value="<?=$res['item_id'];?>"><?=$res['item_name'].'('.$res['item_details'].')';?></option>         
																			<?php } } ?>
																 </select>
															 </div>
														</div>
														<div class="col-md-2">
															<div class="form-group">
																<input type="number" class="form-control" placeholder="Quantity" name="qty" value="1" min="1" max="999" required>
															</div>
														</div>
														<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash();?>" />
														<div class="col-md-3">
															<div class="form-group">
																<button type="submit" class="btn btn-info form-control text-white"  data-id="<?=$txn_id?>">Add Item</button>
															</div>
														</div>
													</form>
												</div>  
												<?php if($deliveryType == 2){ 
														$exeassigned = $this->ordersModel->getAssigned($txn_id);
														if($exeassigned != ''){ 
															$exe_details = $this->ordersModel->getExecutiveDetails($exeassigned['user_id']);
														}
												?>
												<div class="col-md-4" class="delivery">
													<form id="assign" method="post">
														<div class="col-md-8">
																<div class="form-group">
																   <select class="select2 form-control custom-select" required name="del_boy">
																	   <option value="">Assign Delivery Boy</option>
																	   <?php $del = $this->get->tableArray('del_users', array('vendor_id' => $row['vendor_id'], 'status' => 1));
																			if($del != false){ foreach($del as $val){?>
																				<option value="<?=$val['id']; ?>" <?php if($exeassigned != '' && $exeassigned['user_id']==$val['id'])echo 'selected';?>><?=$val['name'];?></option>   
																			<?php } } ?>
																   </select>
																</div>
														</div>
														<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash();?>" />
														<div class="col-md-4">
															  <div class="form-group">
																<button type="submit" class="btn btn-info form-control text-white"  data-oid="<?=$txn_id?>">Assign</button>
															  </div>
														</div>    
													</form>
													</div>
													<?php } ?>
											</div>
											<?php } ?>
										</div>
										<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash();?>" />
											<div class="table-responsive">
												<table id="demo-foo-addrow" class="table m-t-30 table-hover contact-list" data-page-size="50">
												
													<thead>
														<tr>
															<th>#</th>
															<th>Order ID</th>
															<th>Name</th>
															<th>Quantity</th>
															<th>Price</th>
															<th>Delivery Type</th>
															<th>Order Date</th>
															<th>Order Status</th>
														</tr>
													</thead>
													<?php
															$address_id = $row['address_id'];
															$order_id=$row['order_id'];
															$orderType=$row['order_type'];
															$order_status = $row['order_status'];
															$cancel = "<?=base_url('orders/single?txn_id='.$txn_id);?>";
															$accept = "<?=base_url('orders/processOrder?action=2&txn_id='.$txn_id);?>";
													?>
													<tbody>
														<?php $c = 1; $order = $this->get->tableArray('user_cart', array('order_id' => $txn_id, 'order_active' => 1)); if($order != false){ foreach($order as $row){?>
														<tr>
															<td><?= $c++; ?></td>
															<td><?= $row['order_id']; ?></td>
															<td><?= $row['name']; ?></td>
															<td>
                                                                <?php $weight = explode(' ',$row['item_details']); $in_weight = ((int)$row['item_details']*$row['quantity'] > 999)?(((int)$row['item_details']*$row['quantity'])/1000).' kg':(int)$row['item_details']*$row['quantity'].' g';
                                                                if(stripos($row['item_details'], "kg") !== false)
                                                                    echo  $row['item_details'].' x ' . $row['quantity'] . ' = '.(int)$row['item_details']*$row['quantity'].' kg';
                                                                elseif(isset($weight[1]) && ($weight[1] == 'g' || $weight[1] == 'G'))
                                                                    echo  $row['item_details'].' x ' . $row['quantity'] . ' = '.$in_weight;
                                                                else
                                                                    echo $row['item_details'].' x '.$row['quantity'];?></td>
															<td><?=$row['price'].' x '.$row['quantity'];?> = ₹ <?=$row['price']*$row['quantity'];?></td>
															<td>
																<?php
																	
																	if($deliveryType == 1)
																		echo "Pickup";
																	else
																		echo "Delivery";
																?>
															</td>
															<td><?= $row['created_at']; ?></td>
															 <td>
																<?php
																	$status = $row['order_status'];
																	if($status == 1)
																		echo "Pending";
																	else if($status == 2)
																		echo "Accepted";
																	else if($status == 4)
																		echo "Completed";
																	else if($status == 5)
																		echo "Cancelled";
																	else if($status == 6)
																		echo "Returned";
																?>
															</td>
														<?php	if($orderstatus['status']==2){ ?>
															<td><button class="btn btn-danger row_id"  data-sid="<?=$row['c_id'];?>"><i class="fa fa-trash"></i></button></td>
														<?php } ?>
														</tr>
													
														<?php } } else{
																echo "<tr><td colspan='8' class='text-center'><b>No Pending Orders</h3></b></td></tr>";
														}?>
														
													</tbody>
												</table>
													<div class="col-md-2 col-xs-offset-10">
													    <?php if($order_status == 1 || $order_status == 2) {
																if($order_status == 1)
																	$btnText = 'Accept Order';
																else if($order_status == 2)
																	$btnText = 'Complete Order';
															?>
															<div class="col-xs-12">
																<button onclick="myFunction()" class="btn btn-<?=($btnText == 'Accept Order')?'info':'success';?>"><?=$btnText; ?></button>
															</div>
														<?php } ?>	
											<!--		<div class="col-xs-6">
															<?php echo "<a href='$accept'><button type='button' class='btn btn-success'>Accept Order</button></a>"; ?>
															<?php echo "<a href='$cancel'><button type='button' class='btn btn-danger'>Cancel Order</button></a>"; ?>
														</div> 
											-->
													</div>
											</div>
									</div>
									  
								<hr>		
								<?php	
								if($deliveryType == 2){
								$customerDetails = $this->ordersModel->getDeliveryDetails($address_id);?>

										<div class="col-md-8 m-t-40">
											<h3><b>Customer Details</b></h3>
											<h4><b>Order ID: </b> <?=$order_id?></h4>
											<h4><b>Customer Name:  </b><?=$customerDetails['customer_name'];?></h4>
											<h4><b>Customer Address:  </b><br><?=$customerDetails['hno']?><br><?=$customerDetails['street']?><br><?=$customerDetails['city']?><br><?=$customerDetails['state']?><br><?=$customerDetails['zip']?></h4>
											<h4><b>Customer Number:  </b><?=$customerDetails['mobile'];?></h4>				
										</div>
										
								<?php }?>
										<div class="col-md-4 m-t-40">
											<h3><b> Cart Details </b></h3>
												<?php $details = $this->ordersModel->getOrderItems($order_id);?>
													<h4>Price: Rs. <?=$details['price']; ?></h4>
												<?php if($deliveryType == 2){?>	
													<h4>Delivery Charges: + Rs. <?=$details['delivery_charges'];?></h4>
												<?php } ?>
													<h4>Discount: - Rs. <?= $details['discount'] ?></h4> 
													<h4>Total: Rs. <?=$details['total'];?></h4>
												<?php if(isset($exeassigned) && $exeassigned != '') { ?>	
													<h3><b>Executive Details</b></h3>
													<h4>Executive Name : <?=$exe_details['name'];?></h4>
													<h4>Executive Mobile : <?=$exe_details['mobile'];?></h4>
												<?php } ?>		
												<h4>Payment : <?=($details['payment'] == '')?'<span class="badge badge-danger">COD</span>':'<span class="badge badge-success">Paid</span>';?></h4>
										</div>
							</div>		
								<?php	if($orderstatus['status']!= 5){ ?>
								<center><a href="#"  onclick="window.open('reciept?order_id=<?=$txn_id;?>', '_blank', 'location=yes,height=570,width=520,scrollbars=yes,status=yes');" class='btn btn-warning' >Print Reciept</a></center>
							<?php } ?>
						</div>
					</div>
				  </div>
                  <div class="row">
					<div class="col-lg-12">
						<?=$output;?>
					</div>
				  </div>
            </div>
<script language="JavaScript">
function myFunction(){
	var csrf = $('input[name="8i5PtJZ5g8"]').val();
	$.ajax({
		url: "<?=base_url('orders/updateStatus');?>",
		type: 'POST',
		data: {id: "<?=$txn_id;?>", mbl:"<?=$customerDetails['mobile'];?>", '8i5PtJZ5g8':csrf},
		async: false,
		success: function (data) {
			location.reload();
		},
	});
}
$(document).on('click', '.row_id', function(){
    var sid = $(this).data('sid');
	var csrf = $('input[name="8i5PtJZ5g8"]').val();
    var r = confirm("Do you want to remove this item ?");
	if (r == true) 
	{
    	$.ajax({
    		url: "<?=base_url('orders/delete');?>",
    		type: 'POST',
    		data: {sid:sid, '8i5PtJZ5g8':csrf},
    		async: false,
    		success: function (data) {
    			location.reload();
    		
    		},
    	});
	}
});
$(document).on('submit','#addItem', function (event){
	event.preventDefault();
	var formData = new FormData($(this)[0]);
	formData.append('id', '<?=$txn_id;?>');
	$.ajax({
		url: "<?=base_url('orders/addItem');?>",
		type: 'POST',
		data:  formData,
		async: false,
		cache: false,
		contentType: false,
		processData: false,
		success: function (data) {
			window.location.reload(); 
		},
	});
}); 
$(document).on('submit','#assign', function (event){
	event.preventDefault();
	var formData = new FormData($(this)[0]);
	formData.append('orderid', '<?=$txn_id;?>');
	$.ajax({
		url: "<?=base_url('orders/assign');?>",
		type: 'POST',
		data:  formData,
		async: false,
		cache: false,
		contentType: false,
		processData: false,
		success: function (data) {
		   window.location.reload(); 
		},
	});
}); 
</script>
