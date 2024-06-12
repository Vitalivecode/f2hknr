
<div id="page-wrapper">
            <div class="container-fluid">
                <div class="row bg-title">
                    <div class="col-lg-3 col-md-4 col-md-4 col-xs-12">
                        <h4 class="page-title"><?=$title;?></h4> </div>
                    <div class="col-lg-9 col-md-8 col-md-8 col-xs-12">
                        <ol class="breadcrumb">
                            <li><a href="<?=base_url();?>">Home</a></li>
							<li><a href="<?=base_url();?>users">Management</a></li>
                            <li class="active"><?=$title;?></li>
                        </ol>
                    </div>
                    <!-- /.col-lg-12 -->
                </div>
				<div class="row">
			  	<div class="col-lg-12">
                    <div class="white-box">
					  <?=isset($_POST['submit']) ? $error : '' ; ?>
					  
                      <form  action="<?=base_url();?>users/add" class="form-material form-horizontal" enctype="multipart/form-data" method="post">
                        <div class="col-md-12">
                            <div class="col-md-5">
                                <div class="form-group">
                                  <label class="form-control-label" for="firstName">First Name*</label>
                                    <input type="text" class="form-control" id="firstName" name="name" value="<?=isset($_POST['name']) ? $_POST['name'] : ''; ?>" placeholder="First Name" required>
                                </div>
                            </div>
                            <div class="offset-md-1 col-md-5">
                                <div class="form-group">
                                  <label class="form-control-label" for="middleName">Middle Name</label>
                                    <input type="text" class="form-control" id="middleName" name="mname" value="<?=isset($_POST['mname']) ? $_POST['mname'] : ''; ?>" placeholder="Middle Name">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="col-md-5">
                                <div class="form-group">
                                  <label class="form-control-label" for="lastName">Last Name</label>
                                    <input type="text" class="form-control" id="lastName" name="lname" value="<?=isset($_POST['lname']) ? $_POST['lname'] : ''; ?>" placeholder="Last Name">
                                </div>
                            </div>
                            <div class="offset-md-1 col-md-5">
        						<div class="form-group">
        						  <label class="form-control-label"  for="phone">Phone No.*</label>
        						  <input type="number" min="1" class="form-control" id="phone" name="phone" value="<?=set_value('phone'); ?>" placeholder="Phone No." required>
        						</div>
        				    </div>
        				</div>
        				<div class="col-md-12">
                            <div class="col-md-5">
        						<div class="form-group">
        						  <label for="email">Email address*</label>
        						  <input type="email" class="form-control" id="email" name="email" value="<?=isset($_POST['email']) ? $_POST['email'] : ''; ?>"  placeholder="Email Id">
        						</div>
        					</div>
        					<div class="offset-md-1 col-md-5">
        					    <div class="form-group">
        						  <label class="form-control-label" for="password">Password*</label>
        						  <input type="password" class="form-control" id="password" name="password" placeholder="Password">
        						</div>
					            <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash();?>" />
        					</div>
        				</div>
        				<div class="col-md-12">
                            <div class="col-md-5">
        						<div class="form-group">
        						  <label class="form-control-label"  for="gender">Gender*</label>
        						  <select name="gender" id="gender" class="form-control" required >
            						  <option value="" selected="selected" disabled>Choose Type</option>
            						  <option value="male"  <?=(set_value('gender') == 'male')?'selected':'' ;?> >Male</option>
            						  <option value="female"  <?=(set_value('gender') == 'female')?'selected':'' ;?> >Female</option>
            						  <option value="other"  <?=(set_value('gender') == 'other')?'selected':'' ;?> >Other</option>
        						  </select>
        						</div>
        					</div>
        					<div class="offset-md-1 col-md-5">
        						<div class="form-group">
        						  <label class="form-control-label"  for="role">Role*</label>
        						    <select name="role" id="role" class="form-control" required >
            						  <option value="" selected="selected" disabled>Choose Type</option>
            						  <option value="admin"  <?=(set_value('role') == 'admin')?'selected':'' ;?> >Admin</option>
            						  <option value="other"  <?=(set_value('role') == 'other')?'selected':'' ;?> >Other</option>
            						</select>
        						</div>
        					</div>
        				</div>
        				<?php if($ctables != false) { ?>
        				<div class="col-md-12">
        				    <div class="offset-md-2 col-md-8">
						        <div class="form-group">
						            <label class="form-control-label">Permissions*</label>
        						    <div class="table-responsive">
        						        <table class="table table-borderless">
        						            <thead class="thead-dark">
        						                <tr>
        						                    <th>
        						                        <div class="form-check-inline">
                                                          <label class="form-check-label">
                                                            <input type="checkbox" name="selectalloptions" id="selectalloptions" class="form-check-input selectalloptions" value="1">  
                                                          </label>
                                                        </div>
        						                    </th>
                						            <th >Modules</th>
                						            <th>View</th>
                						            <th>Add</th>
                						            <th>Edit</th>
                						            <th>Delete</th>
            						            </tr>
        						            </thead>
        						            <tbody>
        						              <?php $ad_permission=''; foreach($ctables as $menu) { $ad_permission = json_decode($menu->permissions); ?>
        						              
        						                <tr>
                						            <td>
                						                <div class="form-check-inline">
                                                          <label class="form-check-label">
                                                            <input type="checkbox" name="master-options" id="<?=$menu->cttitle;?>" class="form-check-input master-options" value="1">  
                                                          </label>
                                                        </div>
                						            </td>
                						            <td ><label class="form-check-label" for="<?=$menu->cttitle;?>"><?=$menu->cttitle;?></label></td>
                						            
                						            <td>
                						                <?php if($ad_permission->view == 'active') { ?>
                        						        <div class="form-check-inline user-controls">
                                                          <label class="form-check-label">
                                                            <input type="checkbox" name="view[][<?=$menu->table_name;?>]" class="form-check-input mview mcheck" value="view" disabled>
                                                          </label>
                                                        </div>
                                                        <?php } ?>
                						            </td>
                						            <td>
                						                <?php if($ad_permission->add == 'active') { ?>
                						                <div class="form-check-inline user-controls">
                                                          <label class="form-check-label">
                                                            <input type="checkbox" name="add[][<?=$menu->table_name;?>]" class="form-check-input madd mcheck" value="add" disabled>
                                                          </label>
                                                        </div>
                                                        <?php } ?>
                						            </td>
                						            
                						            <td>
                						                <?php if($ad_permission->edit == 'active') { ?>
                						                <div class="form-check-inline user-controls">
                                                          <label class="form-check-label">
                                                            <input type="checkbox" name="edit[][<?=$menu->table_name;?>]" class="form-check-input medit mcheck" value="edit" disabled>
                                                          </label>
                                                        </div>
                                                        <?php } ?>
                						            </td>
                						            <td>
                						                <?php if($ad_permission->remove == 'active') { ?>
                        						        <div class="form-check-inline user-controls">
                                                          <label class="form-check-label">
                                                            <input type="checkbox" name="delete[][<?=$menu->table_name;?>]" class="form-check-input mdelete mcheck" value="delete" disabled>
                                                          </label>
                                                        </div>
                                                        <?php } ?>
                						            </td>
            						            </tr>
            						            <?php } ?>
            						            
        						            </tbody>
            						        
        						        </table>
                                    </div>
    						</div>
    						</div>
						</div>
						<?php } ?>
						<div class="form-group">
							<input type="submit" name="submit" value="Submit" class="btn <?=$site[0]->button;?>">
						</div>
                      </form>
                    </div>
                </div>
			  </div>
            </div>
            
   <script>
      $('input[name="master-options"]').click(function(){
          var dis =$(this).closest("tr");
      //    var status = $('.master-options').get(0).checked;
            if($(this).prop("checked") == true){
               dis.find('td .mcheck').removeAttr('disabled');
            }
            else if($(this).prop("checked") == false){
                dis.find('td .mcheck').prop("checked",false);
               dis.find('td .mcheck').attr('disabled','disabled');
            }
        });
        
$('#selectalloptions').click(function(event) {   
    if(this.checked) {
        // Iterate each checkbox
        $(':checkbox').each(function() {
            $('.mcheck').removeAttr('disabled');
            this.checked = true;  
            
        });
    } else {
        $(':checkbox').each(function() {
            $('.mcheck').attr('disabled','disabled');
            this.checked = false;                       
        });
    }
});
   </script>         