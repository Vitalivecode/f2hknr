<li>
    <div class="drop-title">You have <?=$notifications_count;?> new Orders</div>
</li>
<?php  foreach($notify as $val){ ?>
     <li>
        <div class="message-center ps ps--theme_default">
            <a href="<?=base_url('orders/single?txn_id='.$val['order_id']);?>">
				<div class="user-img"> <img src="<?=$val['thumbnail'];?>"  alt="user" class="img-circle"> </div>
                <div class="mail-contnet">
                    <h5>New order recieved</h5> <span class="mail-desc"><?php if($val['order_type']==2)echo 'Door Delivery';else echo 'Pick Up';?></span> <span class="time"><?=date('d-M-Y h:i A', strtotime($val['created_at']));?></span> 
				</div>
            </a>
        </div>
    </li>
<?php } if($notify != false){ ?>
    <li>
        <a class="nav-link text-center link" href="<?=base_url('orders?type=1');?>"> <strong>See all orders</strong> <i class="fa fa-angle-right"></i> </a>
    </li>
<?php } ?>