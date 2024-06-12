			<div class="scrollable">
				<div class="table-responsive">
				<?php if($orders != false){ ?>
					<table id="tables-export" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
					<thead>
						<tr>
							<th>#</th>
							<th>Order ID</th>
							<th>Type</th>
							<th>Status</th>
							<th>Payment</th>
							<th>Item Name</th>
							<th>Item Details</th>
							<th>Mobile No.</th>
							<th>Total Order Details</th>
							<th>Order Placed On</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
							<?php $no = 1;
							foreach($orders as $row){ 
							    $type = $row['order_status'];
									$accept = base_url("orders/edit?action=1&order_id=".$row['order_id']."&redirect=".$type);
									$cancel = base_url("orders/edit?action=2&order_id=".$row['order_id']."&redirect=".$type);
									$return = base_url("orders/edit?action=3&order_id=".$row['order_id']."&redirect=".$type);
									$view = base_url("orders/single?txn_id=".$row['order_id']);
									
							?>
						<tr>
							<td><?=$no++; ?></td>
							<td><?=$row['order_id'];?></td>
							<td><?=($row['order_type'] == 1)?'<span class="badge badge-success">Pickup</span>':'<span class="badge badge-info">Delivery</span><br>';?></td>
							<td><?php
								$status = $row['order_status'];
								$txn_id = $row['order_id'];
								if($status == 1)
									echo '<span class="badge badge-warning">Pending</span>';
								else if($status == 2)
									echo '<span class="badge badge-info">Accepted</span>';
								else if($status == 4)
									echo '<span class="badge badge-success">Delivered</span>';
								else if($status == 5)
									echo '<span class="badge badge-danger">Cancelled</span>';
								else if($status == 6)
									echo '<span class="badge badge-success">Returned</span>';
								?>
							</td>
							<td><?=($row['payment'] == '')?'<span class="badge badge-danger">COD</span>':'<span class="badge badge-success">Paid</span>';?></td>
							<td>
								<?php 
									$details = $this->ordersModel->getOrderItems($row['order_id']);
									foreach($details['items'] as $d){ $weight = explode(' ',$d['item_details']); $in_weight = ((int)$d['item_details']*$d['individual_quantity'] > 999)?(((int)$d['item_details']*$d['individual_quantity'])/1000).' kg':(int)$d['item_details']*$d['individual_quantity'].' g';
                                        if(stripos($d['item_details'], "kg") !== false)
                                            echo  $d['name'] . ' <b>('.$d['item_details'].' x ' . $d['individual_quantity'] . ' = '.(int)$d['item_details']*$d['individual_quantity'].' kg)</b><br/>';
                                        elseif(isset($weight[1]) && ($weight[1] == 'g' || $weight[1] == 'G'))
                                            echo  $d['name'] . ' <b>('.$d['item_details'].' x ' . $d['individual_quantity'] . ' = '.$in_weight.')</b><br/>';
                                        else
										  echo  $d['name'] . ' <b>('.$d['item_details'].' x ' . $d['individual_quantity'] . ')</b><br/>';
                                    }
								?> 
							</td>
							<td>
								<?php
									echo 'Num Items: ' . $row['count'] . '<br/>' . "Price: Rs. " . $details['price']; 
									if($row['order_type'] == 2){ echo '<br/>Delivery Charges: Rs. ' . $details['delivery_charges']; }
									echo '<br/> Discount: Rs. ' . $details['discount']  . '<br/> Total: <b>Rs. ' .$details['total'].'</b>' ;
								?>
							</td> 
							<td width="100px"> 
								<?php $address = $this->get->table('app_users',array('user_id' => $row['user_id'])); echo ($address != false)?$address[0]->mobile:''; echo ($address != false && $address[0]->name != '')?'</br>('.$address[0]->name.')':'';  ?>	
							</td>
                            <td> <?php $received = 0; $price = 0; $discount = 0; $delivery_charges = 0; $order_date = ""; $where = array('user_id' => $row['user_id'],'order_active' => '1', 'vendor_id' => $row['vendor_id']); $user_total_order_details = $this->get->tableGroup('user_cart', $where, 'order_id'); $where = array('user_id' => $row['user_id'],'order_active' => '1', 'vendor_id' => $row['vendor_id'], 'order_status' => '4'); $user_order_details = $this->get->tableGroup('user_cart', $where, 'order_id'); if($user_order_details != false){ foreach($user_order_details as $user_order_detail){ $delivery_charges = $delivery_charges+(($user_order_detail->order_type == 2)?$user_order_detail->delivery_charges:0); $order_date = $user_order_detail->created_at; }} $user_paid_amount = $this->get->table('user_cart', $where, 'order_id'); if($user_paid_amount != false){ foreach($user_paid_amount as $user_paid){ 
                                    $price = $price + ($user_paid->price * $user_paid->quantity);
                                    $discount = $discount + (($user_paid->price*$user_paid->quantity)*$user_paid->discount/100);
                                    $received = $price-$discount; }} 
                                ?>
                                Total Orders: <b><?=count($user_total_order_details);?></b><br>
                                Delivered Orders: <b><?=($user_order_details != false)?count($user_order_details):0;?></b><br>
                                Cancel Orders: <b><?=($this->get->table('user_cart',array('user_id' => $row['user_id'],'order_active' => '1', 'vendor_id' => $row['vendor_id'], 'order_status' => '5'), 'order_id') != false)?count($this->get->tableGroup('user_cart',array('user_id' => $row['user_id'],'order_active' => '1', 'vendor_id' => $row['vendor_id'], 'order_status' => '5'), 'order_id')):0;?></b><br>
                                Received Amount: <b>Rs. <?=number_format($received+$delivery_charges,2);?></b><br><?=($order_date != '')?'Last Order: <b>'.$controller->time_elapsed_string($order_date).'</b>':'';?>
                            </td>
							<td><?=date('d-M-Y',strtotime($row['created_at'])).'</br>'.date('h:i:s A',strtotime($row['created_at']));?></td>
							<td>
								<a href="<?=$view;?>" class="btn btn-warning">View</a><br>
								<?php if($status == 1 || $status == 2) {
									if($status == 1)
										$btnText = 'Accept';
									else if($status == 2)
										$btnText = 'Complete';
								?>
								<?php echo "<a href='$cancel'  class='btn btn-danger m-t-10'>Cancel</a></br>"; ?>
										<button class="btn btn-<?=($btnText == 'Accept')?'info':'success';?> m-t-10 accept" data-id="<?=$txn_id?>" data-mbl="<?=($address != false)?$address[0]->mobile:'';?>" ><?=$btnText;?></button>
								<?php }  ?>
                            </td> 
					</tr>
					<?php } ?>
					</tbody>
				</table>
                <?php } else{ echo '<h4 align=center>No orders found</h4>'; } ?>
			</div>
		</div>