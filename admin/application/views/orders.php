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
								<form id="addDevice" action="" data-toggle="validator" >
									<div class="row">
										<div class="col-md-12">
											<div class="col-md-2">
												<div class="form-group">
													<select id="limit" name="limit" class="select2-container form-control select2"> 
													<option value="50" <?=(isset($_GET['limit']) && $_GET['limit'] == '50')?'selected':'';?>>50</option>
													<option value="100" <?=(isset($_GET['limit']) && $_GET['limit'] == '100')?'selected':'';?>>100</option>
													<option value="150" <?=(isset($_GET['limit']) && $_GET['limit'] == '150')?'selected':'';?>>150</option>
													<option value="200" <?=(isset($_GET['limit']) && $_GET['limit'] == '200')?'selected':'';?>>200</option>
													<option value="10000" <?=(isset($_GET['limit']) && $_GET['limit'] == '10000')?'selected':'';?>>All</option>
													</select>
												</div>
											</div>
											<?php if($this->session->userdata('logged_in')['role'] == 'vendor'){ ?>
												<input type="hidden" id="restaurants" value="<?=$this->session->userdata('logged_in')['branch'];?>" >
											<?php } else{ ?>
											<div class="col-md-4">
												<div class="form-group">
													<select id="restaurants" class="select2-container form-control select2"> 
													<?php if($branches != false){ foreach($branches as $branch){ ?>
														<option value="<?=$branch->rest_id;?>" <?=(isset($_GET['branch']) && $_GET['branch'] == $branch->rest_id)?'selected':'';?>><?=$branch->rest_name;?></option>
													<?php } } ?>
													</select>
												</div>
											</div>
											<?php } ?>
											<div class="col-md-3">
												<div class="form-group">
													<input type="date" autocomplete="off" class="form-control" name="start" id="start_autoclose" <?=(isset($_GET['date']) && $_GET['date'] == 'today')?'value='.date('Y-m-d'):'';?>  placeholder="Sort by Date">
												</div>
											</div>
											<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash();?>" />
											<div class="col-md-3">
												<div class="form-group">
													<select id="ordertype" class="select2-container form-control select2"> 
														<option value="9" <?=(isset($_GET['type']) && $_GET['type'] == '9')?'selected':'';?>>Total Orders</option>
														<option value="1" <?=(isset($_GET['type']) && $_GET['type'] == '1')?'selected':'';?>>Pending Orders</option>
														<option value="2" <?=(isset($_GET['type']) && $_GET['type'] == '2')?'selected':'';?>>Accepted Orders</option>
														<option value="4" <?=(isset($_GET['type']) && $_GET['type'] == '4')?'selected':'';?>>Delivered Orders</option>
														<option value="5" <?=(isset($_GET['type']) && $_GET['type'] == '5')?'selected':'';?>>Cancelled</option>
													</select>
												</div>
											</div>
										</div>
									</div>
									<div id="ordersList"></div>
									<div class="alert alert-danger" id="error"></div>	
								</form>
						</div>
					</div>
				  </div>
            </div>
<script language="JavaScript">
$(document).ready(function() {
    $('#error').hide();
	getListItems();
});

$("#start_autoclose").on('change',function(ev){
	if(checkStartDate()){
		getListItems();
	}
});

function checkStartDate(){
	if($("#start_autoclose").val() != '')
		return true;
	else
		return false;
}

$('#restaurants').on('change', function(){
	getListItems();
});	
$('#ordertype').on('change', function(){
	getListItems();
});
$('#limit').on('change', function(){
	getListItems();
});
function getListItems(){
	$('#error').hide();
	$('#ordersList').hide();
	var csrf = $('input[name="8i5PtJZ5g8"]').val();
	$.ajax({
        type: "POST",
        url: "<?=base_url('orders/online');?>",
        data: { vendor_id : $("#restaurants").val(), start_date: $("#start_autoclose").val(), type: $("#ordertype").val(), limit: $("#limit").val(), '8i5PtJZ5g8':csrf},
		async: false,
        beforeSend: function() {
            $("#ordersList").attr('align','center');
            $("#ordersList").html('<i class="fa fa-spinner fa-spin"></i>');
        },
        success: function(output)
        {
			$("#ordersList").show();
            $('#ordersList').removeAttr('align');
			$("#ordersList").html(output);
        },
		error:function(e){
			console.log(e.responseText); 
		}
    });	
}
$(document).on("click",".accept",function()
{
    var id= $(this).data('id');
    var mbl =$(this).data('mbl');
    var csrf = $('input[name="8i5PtJZ5g8"]').val();
	$.ajax({
		url: "<?=base_url('orders/updateStatus');?>",
		type: 'POST',
		data: {id: id,mbl: mbl, '8i5PtJZ5g8':csrf},
		async: false,
		success: function (data) {
			location.reload();
		},
	});
});

</script>
