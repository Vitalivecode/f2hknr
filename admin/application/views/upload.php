<script src="http://oss.maxcdn.com/jquery.form/3.50/jquery.form.min.js"></script>
<style>
.formarea{
    width:60%;
    margin:0 auto;
    background-color:#fff; 
    text-align:center;
    padding:4%;
    border-radius:5px;
}
#bararea{
    position:relative;
    width:100%;
    height:36px;
    border:2px solid #000;
    margin-bottom: 20px;
}
 
#bar{
    width:0%;
    margin:4px 0;
    height:28px;
    background-color:tomato;
}
 
#status{
    color:#000;
}
#percent{
    position: absolute;
    top: 0;
    margin-left: 50%;
    font-weight: bold;
    color: black;
    margin-top: 5px;
}
</style>
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
						    <?php if(isset($images) && $images != false){ foreach($images as $img){ ?>
						        <div class="col-md-3">
						            <img class="img-thumbnail responsive" src="<?=$img->image;?>" />
						        </div>
						    <?php } } ?>
						    </div>
								  <?php if(isset($_POST['updateprofile'])) {  echo validation_errors(); echo $succ;  }  ?>
								    <div id="status"></div>
									<form class="form-material form-horizontal" name="update_profile" action="<?=base_url();?>upload/upload" enctype="multipart/form-data"  method="post">
									  <div class="form-group">
										<label  class="form-control-label" for="fullname" class="col-md-12 control-label">Full Name</label>
										<div class="col-md-12">
										  <input type="text" class="form-control" name="fullname" id="fullname" placeholder="Full Name" value="<?=$userdata[0]->fullname;?>" required >
										</div>
									  </div>
									  <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash();?>" />
									  <div class="form-group">
										<label  class="form-control-label" for="userfile" class="col-md-12 control-label">Profile Picture</label>
										<div class="col-md-12">
										  <div style="position:relative;">
											<a class='btn <?=$site[0]->button;?>' href='javascript:;'>
												Choose File...
												<input type="file" style='position:absolute;z-index:2;top:0;left:0;filter: alpha(opacity=0);-ms-filter:"progid:DXImageTransform.Microsoft.Alpha(Opacity=0)";opacity:0;background-color:transparent;color:transparent;'  id="userfile" name="userfile[]" required multiple="multiple" size="40"  onchange='$("#upload-file-info").html($(this).val());'>
											</a>
											&nbsp;
											<span class='label label-info' id="upload-file-info"></span>
											</div>
										</div>
									  </div>
    									<div id="bararea" style="display:none">
                                    		<div id="bar"></div>
                                            <div id="percent"></div>
                                    	</div>
									  <div class="form-group">
										<div class="col-sm-offset-2 col-sm-10">
										  <button name="updateprofile" class="btn <?=$site[0]->button;?> upload">Save</button>
										</div>
									  </div>
									</form>
							  </div>
                  		</div>
				  	</div>
			  </div>
		</div>
<script>
$(function() {
	$(document).ready(function(){
		var bar = $('#bar')
		var percent = $('#percent');
		var status = $('#status');
    	$('form').ajaxForm({
    		beforeSend: function() {
    		    $('.upload').attr('disabled','disabled');
    		    $('.upload').html('<i class="fa fa-spinner fa-spin"></i>');
    		    $('#bar').css('background-color','tomato');
    		    $('#bararea').css('display','block');
        		status.empty();
        		var percentVal = '0%';
        		bar.width(percentVal);
        		percent.html(percentVal);
    		},
    	    uploadProgress: function(event, position, total, percentComplete) {
        		var percentVal = percentComplete + '%';
        		percent.html(percentVal);
        		bar.width(percentVal);
    		},
    	    complete: function(xhr) {
    	        if(xhr.responseText == '1')
    	        {
    		        $('#bar').css('background-color','green');
    		        status.html('<div class="alert alert-success">Successfully Uploaded</div>');
    	        }
    	        else
    	        {
    		        status.html(xhr.responseText);
    	        }
    		    $('.upload').removeAttr('disabled','disabled');
    		    $('.upload').html('Save');
    		}
    	});
	});
});
</script>