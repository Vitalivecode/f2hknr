<!DOCTYPE html>
<html>
<head>
<style>
table,  td {
  border: 1px solid black;
  border-collapse: collapse;
}
td {
  padding: 4px;
     
}


.tdd td
{
    border:none;
}
.nob
{
    border:none;
}
.hh
{
    border-bottom: dashed;
    border-bottom-width:2px;
}
.tdh
{
    border-top:dashed;
    border-top-width:2px;
    border-bottom:dashed;
    border-bottom-width:2px;
    border-left:none;
    border-right:none;
}
</style>
</head>
<body onLoad=window.print();>

<?php 

if($_GET['order_id']){
$order_id = $_GET['order_id'];
$details = $this->ordersModel->getOrderItems($order_id);
$address = $this->ordersModel->appUser($details['user_id']);

if($details['online_order'] == 1)
{
$address_id = $details['address_id'];
$add  = $this->get->tableArray('user_addresses', array('id' => $address_id));
$mbl = ($add != false)?$add:array();
}
?>
<table style="width:90%" align=center>
    <tr>
      <th colspan="2"><img src="<?=base_url();?>../uploads/<?=$site[0]->logo;?>" width=70 height=70></th>  
    </tr>
  <tr>
    <th colspan="2" >F2H</th>
  </tr>
   <tr>
    <th colspan="2" style="font-size:12px"><?=(isset($branch) && $branch != false)?$branch[0]->rest_name:'';?></th>
  </tr>
   <tr>
    <th colspan="2" style="font-size:12px"><?=(isset($branch) && $branch != false)?$branch[0]->rest_address:'';?></th>
  </tr>
   <tr>
    <th colspan="2" style="font-size:11px"><div style="width:50%;float:left;" align="left">Order Id: <?=isset($_GET['order_id'])?$_GET['order_id']:'';?></div><div style="width:50%;float:right;" align="right"><?=date('d-M-Y h:i:s A',strtotime($details['created_at']));?></div></th>
  </tr>
  
   <tr>
    <th colspan="2" class="hh"></th>
  </tr>
<tr class="tdd">
<td align="center" colspan="2"><b>Items</b><br/><div style="font-size:12px;margin-top: -1px;"><?php if(($details['online_order'] == 1) && ($details['order_type'] == 1)){}else{?> Customer No.(<b> <?php if($details['online_order'] == 1){echo $mbl['mobile'];}else{ echo $address[0]['mobile'];}?></b>)<?php } ?></div></td>
</tr>
<?php $order = $this->get->tableArray('user_cart', array('order_id' => $order_id, 'order_active' => 1)); if($order != false){ foreach($order as $row){ ?>
   <tr class="tdd" style="border-collapse: collapse;">
    <td align="left"><?=$row['quantity'];?> x <?=$row['price'];?> <?= $row['name']; ?></td>
    <td align="right">Rs. <?=($row['price']-($row['price']*$row['discount']/100))*$row['quantity']?>(<?= ($row['price']*$row['discount']/100)*$row['quantity'] ?>)</td>
  <tr>
        <?php }} ?>
    <th colspan="2" class="hh"></th>
  </tr>
  <tr class="tdd">
    <td>Sub Total</td>
    <td align="right">Rs.<?=$details['price']; ?></td>
    
<?php if($details['order_type'] == 2){ ?>	
  <tr class="tdd">
    <td>Delivery Charges</td>
    <td align="right">Rs.<?=$details['delivery_charges'];?></td>
  </tr>
<?php } ?> 
  <tr class="tdd">
    <td>Discount</td>
    <td align="right">Rs. <?= $details['discount'] ?></td>
    
  </tr>
  <tr>
    <td class="nob" >TOTAL<span>(Inc. Taxes)</span></td>
    <td class="tdh" align="right">Rs. <?=$details['total'];?></td>
    
  </tr>
  <tr class="tdd">
      <td> </td>
      <td></td>
    </tr>
  <tr>
    <td colspan="2" align="center"  style="font-size:8px">THANK YOU FOR ORDERING WITH US! PLEASE ORDER AGAIN <br/><span>Developed by vitasoft.in</span></td>
  </tr>
</table>
<div class="both" style="padding:14px 0;clear:both;width:90%;margin: auto;"><div class="hh"></div></div>
<table style="width:90%" align=center>
    <tr>
      <th colspan="2"><img src="<?=base_url();?>../uploads/<?=$site[0]->logo;?>" width=70 height=70></th>  
    </tr>
  <tr>
    <th colspan="2" >F2H</th>
  </tr>
   <tr>
    <th colspan="2" style="font-size:12px"><?=(isset($branch) && $branch != false)?$branch[0]->rest_name:'';?></th>
  </tr>
   <tr>
    <th colspan="2" style="font-size:12px"><?=(isset($branch) && $branch != false)?$branch[0]->rest_address:'';?></th>
  </tr>
   <tr>
    <th colspan="2" style="font-size:11px"><div style="width:50%;float:left;" align="left">Order Id: <?=isset($_GET['order_id'])?$_GET['order_id']:'';?></div><div style="width:50%;float:right;" align="right"><?=date('d-M-Y h:i:s A',strtotime($details['created_at']));?></div></th>
  </tr>
  
   <tr>
    <th colspan="2" class="hh"></th>
  </tr>
<tr class="tdd">
<td align="center" colspan="2"><b>Items</b><br/><div style="font-size:12px;margin-top: -1px;"><?php if(($details['online_order'] == 1) && ($details['order_type'] == 1)){}else{?> Customer No.(<b> <?php if($details['online_order'] == 1){echo $mbl['mobile'];}else{ echo $address[0]['mobile'];}?></b>)<?php } ?> </div></td>
</tr>
<?php $order = $this->get->tableArray('user_cart', array('order_id' => $order_id)); if($order != false){ foreach($order as $row){ ?>
   <tr class="tdd" style="border-collapse: collapse;">
    <td align="left"><?=$row['quantity'];?> x <?=$row['price'];?> <?= $row['name']; ?></td>
    <td align="right">Rs. <?=($row['price']-($row['price']*$row['discount']/100))*$row['quantity']?>(<?= ($row['price']*$row['discount']/100)*$row['quantity'] ?>)</td>
  <tr>
        <?php }} ?>
    <th colspan="2" class="hh"></th>
  </tr>
  <tr class="tdd">
    <td>Sub Total</td>
    <td align="right">Rs.<?=$details['price']; ?></td>
    
<?php if($details['order_type'] == 2){ ?>	
  <tr class="tdd">
    <td>Delivery Charges</td>
    <td align="right">Rs.<?=$details['delivery_charges'];?></td>
  </tr>
<?php } ?> 
  <tr class="tdd">
    <td>Discount</td>
    <td align="right">Rs. <?= $details['discount'] ?></td>
    
  </tr>
  <tr>
    <td class="nob" >TOTAL<span>(Inc. Taxes)</span></td>
    <td class="tdh" align="right">Rs. <?=$details['total'];?></td>
    
  </tr>
  <tr class="tdd">
      <td> </td>
      <td></td>
    </tr>
  <tr>
    <td colspan="2" align="center"  style="font-size:8px">THANK YOU FOR ORDERING WITH US! PLEASE ORDER AGAIN <br/><span>Developed by vitasoft.in</span></td>
  </tr>
</table>
<?php }?>
</body>
</html>