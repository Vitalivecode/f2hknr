		<div id="page-wrapper">
            <div class="container-fluid">
                <div class="row bg-title">
                    <div class="col-lg-3 col-md-4 col-md-4 col-xs-12">
                        <h4 class="page-title"><?=$title;?></h4> 
                    </div>
                    <?php if($this->uri->segment(2) == 'restaurant-items'){ ?>
                    <div class="col-lg-4 col-md-4 col-md-4 col-xs-12" align="center">
                        <a href="<?=base_url('export/items');?>" id="export" class="btn btn-primary">Export</a>
                        <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#items-import">Import</button>
                    </div>
                    <?php } ?>
                    <div class="col-lg-<?=($this->uri->segment(2) == 'restaurant-items')?5:9;?> col-md-<?=($this->uri->segment(2) == 'restaurant-items')?4:8;?> col-md-<?=($this->uri->segment(2) == 'restaurant-items')?4:8;?> col-xs-12">
                        <ol class="breadcrumb">
                            <li><a href="<?=base_url();?>">Home</a></li>
                            <li class="active"><?=$title;?></li>
                        </ol>
                    </div>
                    <!-- /.col-lg-12 -->
                </div>
				<div class="row">
					<div class="col-lg-12">
						<?=$output;?>
					</div>
				</div>
            </div>
<script type="text/javascript">
jQuery(document).on("gpsafterrequest",function(event,container){
    if(GPS.current_task == 'save')
    {
        var validate = jQuery(container).find('.validation-error').length;
        if(validate == 0)
        {
            jQuery.toast({
        		heading: 'Successfully Saved',
        		text: '',
        		position: 'top-right',
        		loaderBg: '#ff6849',
        		icon: 'success',
        		hideAfter: 3500,
        		stack: 6
        	})
        }
    }
	if(GPS.current_task == 'remove')
    {
		jQuery.toast({
			heading: 'Successfully Deleted',
			text: '',
			position: 'top-right',
			loaderBg: '#ff6849',
			icon: 'success',
			hideAfter: 3500,
			stack: 6
		})
    }
});
jQuery(document).on("ready gpsafterrequest",function(){
    jQuery("#select").select2();
});
<?php if($this->uri->segment(2) == 'promotions'){ ?>
jQuery(document).on('click','#all',function(){
    var multiselect = jQuery('#select2').val();
    if(jQuery("#all").is(':checked') )
    {
        jQuery("#select2 > option").prop("selected",true).trigger("change");
    }
    else
    {
        jQuery("#select2 > option").prop("selected",false).trigger("change");
    }  
});
<?php } ?>
</script>
<script src="<?=base_url();?>plugins/bower_components/toast-master/js/jquery.toast.js"></script>