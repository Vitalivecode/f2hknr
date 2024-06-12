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
					<div class="col-lg-4">
						<div class="white-box" align="center">
						  <img class="profile-user-img img-responsive img-circle" src="<?=base_url();?>../uploads/<?=$userdata[0]->img;?>" alt="<?=$userdata[0]->fullname;?>">
						  <h3 class="profile-username text-center"><?=$userdata[0]->fullname;?></h3>
						  <p class="text-muted text-center"><?=$userdata[0]->email;?></p>
						  <p class="text-muted text-center"><?=$userdata[0]->phone;?></p>
						</div>
					</div>
					<div class="col-lg-8">
						<div class="white-box">
							  <div class="nav-tabs-custom">
								<ul class="nav nav-tabs" role="tablist">
								  <li class="nav-item"><a href="#Update_Profile" class="nav-link <?php if(isset($_POST['updateprofile']))echo $tab; else if(!isset($_POST['changepass'])) echo "active";?>" data-toggle="tab" role="tab">Update Profile</a></li>
								  <li class="nav-item"><a href="#Change_Password" class="<?=(isset($_POST['changepass'])) ? $tab : '';?> nav-link" data-toggle="tab" role="tab">Change Password</a></li>
								</ul>
								<div class="tab-content">
								  <div class="<?php if(isset($_POST['updateprofile']))echo $tab; else if(!isset($_POST['changepass'])) echo "active";?> tab-pane" id="Update_Profile">
								  
								  <?php if(isset($_POST['updateprofile'])) {  echo validation_errors(); echo $succ;  }  ?>
									<form class="form-material form-horizontal" name="update_profile" action="<?=base_url();?>profile/update" enctype="multipart/form-data"  method="post">
									  <div class="form-group">
										<label  class="form-control-label" for="fullname" class="col-md-12 control-label">Full Name</label>
										<div class="col-md-12">
										  <input type="text" class="form-control" name="fullname" id="fullname" placeholder="Full Name" value="<?=$userdata[0]->fullname;?>" required >
										</div>
									  </div>
									  <div class="form-group">
										<label  class="form-control-label" for="email" class="col-md-12 control-label">Email</label>
										<div class="col-md-12">
										  <input type="email" class="form-control" id="email" placeholder="Email" value="<?=$userdata[0]->email;?>"  disabled>
										</div>
									  </div>
									  <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash();?>" />
									  <div class="form-group">
										<label  class="form-control-label" for="userfile" class="col-md-12 control-label">Profile Picture</label>
										<div class="col-md-12">
										  <div style="position:relative;">
											<a class='btn <?=$site[0]->button;?>' href='javascript:;'>
												Choose File...
												<input type="file" style='position:absolute;z-index:2;top:0;left:0;filter: alpha(opacity=0);-ms-filter:"progid:DXImageTransform.Microsoft.Alpha(Opacity=0)";opacity:0;background-color:transparent;color:transparent;'  id="userfile" name="userfile" size="40"  onchange='$("#upload-file-info").html($(this).val());'>
											</a>
											&nbsp;
											<span class='label label-info' id="upload-file-info"></span>
											</div>
										</div>
										<input type="hidden" name="preimg" value="<?=$userdata[0]->img;?>" />
									  </div>
									  <div class="form-group">
										<div class="col-sm-offset-2 col-sm-10">
										  <button type="submit" name="updateprofile" class="btn <?=$site[0]->button;?>">Save</button>
										</div>
									  </div>
									</form>
								  </div><!-- /.tab-pane -->
								  <div class="<?=(isset($_POST['changepass'])) ? $tab : '';?> tab-pane" id="Change_Password">
								  <?php if(isset($_POST['changepass'])) {  echo validation_errors(); echo $error;  }  ?>
									<form class="form-material form-horizontal" action="<?=base_url();?>profile/password" method="post">
									  <div class="form-group">
										<label  class="form-control-label" for="old_pass" class="col-md-12 control-label">Current Password</label>
										<div class="col-md-12">
										  <input type="password" class="form-control" name="old_pass" id="old_pass" placeholder="Current Password" required>
										</div>
									  </div>
									  <div class="form-group">
										<label  class="form-control-label" for="new_pass" class="col-md-12 control-label">New Password</label>
										<div class="col-md-12">
										  <input type="password" class="form-control" name="new_pass" id="new_pass" placeholder="New Password" required>
										</div>
									  </div>
									  <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash();?>" />
									  <div class="form-group">
										<label  class="form-control-label" for="conf_pass" class="col-md-12 control-label">Confirm Password</label>
										<div class="col-md-12">
										  <input type="password" class="form-control" name="conf_pass" id="conf_pass" placeholder="Confirm Password" required>
										</div>
									  </div>
									  <div class="form-group">
										<div class="col-sm-offset-2 col-sm-10">
										  <button type="submit" name="changepass" class="btn <?=$site[0]->button;?>">Save</button>
										</div>
									  </div>
									</form>
								  </div>
								</div>
							  </div>
                  		</div>
				  	</div>
			  </div>
		</div>