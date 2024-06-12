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
					<?=isset($_POST['update']) ? $error : '' ; ?>
                       <form  action="<?=base_url();?>users/edit/<?=$this->uri->segment(3);?>" enctype="multipart/form-data" class="form-material form-horizontal" autocomplete="off" method="post">
                        <div class="col-md-12">
                            <div class="col-md-5">
                                <div class="form-group">
        						  <label class="form-control-label"  for="fullName">Full Name*</label>
        						  <input type="text" class="form-control" id="fullName" name="name" value="<?php if(!empty(set_value('name'))) { echo set_value('name'); } elseif(!empty($getAdmin[0]->fullname)) { echo $getAdmin[0]->fullname; } ?>" placeholder="Full Name">
        						</div>
        					</div>
        					<div class="offset-md-1 col-md-5">
        						<div class="form-group">
        						  <label class="form-control-label"  for="phone">Phone No.</label>
        						  <input type="number" min="1" class="form-control" id="phone" name="phone" value="<?php if(!empty(set_value('phone'))) { echo set_value('phone'); } elseif(!empty($getAdmin[0]->phone)) { echo $getAdmin[0]->phone; } ?>" placeholder="Phone No.">
        						</div>
        					</div>
        				</div>
        				<div class="col-md-12">
        				    <div class="col-md-5">
        						<div class="form-group">
        						  <label class="form-control-label"  for="email">Email address*</label>
        						  <input type="email" class="form-control" id="email" name="email" value="<?php if(!empty(set_value('email'))) { echo set_value('email'); } elseif(!empty($getAdmin[0]->email)) { echo $getAdmin[0]->email; } ?>" autocomplete="off"  placeholder="Email Id">
        						</div>
        					</div>
        					<div class="offset-md-1 col-md-5">
        						<div class="form-group">
        						  <label class="form-control-label"  for="password">Password*</label>
        						  <input type="password" class="form-control" id="password" name="password" value="<?php if(!empty(set_value('password'))) { echo set_value('password'); } elseif(!empty($password)) { echo $password; } ?>" autocomplete="off" placeholder="Password">
        						</div>
        					</div>
        				</div>
        				<div class="col-md-12">
                            <div class="col-md-5">
        						<div class="form-group">
        						  <label class="form-control-label"  for="gender">Gender*</label>
        						  <select name="gender" id="gender" class="form-control" required >
            						  <option value="" selected="selected" disabled>Choose Type</option>
            						  <option value="male" <?=(set_value('gender') == 'male')?'selected':($getAdmin[0]->gender == 'male') ? 'selected' : '' ;?> >Male</option>
            						  <option value="female" <?=(set_value('gender') == 'female')?'selected':($getAdmin[0]->gender == 'female') ? 'selected' : '' ;?> >Female</option>
            						  <option value="other" <?=(set_value('gender') == 'other')?'selected':($getAdmin[0]->gender == 'other') ? 'selected' : '' ;?> >Other</option>
        						  </select>
        						</div>
        					</div>
        					<div class="offset-md-1 col-md-5">
        						<div class="form-group">
        						  <label class="form-control-label"  for="role">Role*</label>
        						 <select name="role" id="role" class="form-control" required >
            						  <option value="" selected="selected" disabled>Choose Type</option>
            						  <option value="admin" <?=(set_value('role') == 'admin')?'selected':($getAdmin[0]->role == 'admin') ? 'selected' : '' ;?> >Admin</option>
            						  <option value="vendor"  <?=(set_value('role') == 'vendor')?'selected':($getAdmin[0]->role == 'vendor') ? 'selected' : '' ;?> >Vendor</option>
        						  </select>
        						</div>
        					</div>
        				</div>
        				<?php if($ctables != false && $this->session->userdata('logged_in')['role'] == 'superadmin') { ?>
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
        						              <?php 
        						              $ad_permission=''; 
        						              $permissions = json_decode($getAdmin[0]->permissions);
        						              foreach($ctables as $menu) { 
        						                $ad_permission=json_decode($menu->permissions);
        						                $table = $menu->table_name;
        						                $perm = '';
        						                $p = array();
        						                $view = 0;
            						            $add = 0;
            						            $edit = 0;
            						            $delete = 0;
        						                foreach($permissions as $permsn ) {  
        						                    $perm = isset($permsn->$table)?$permsn->$table:'';
        						                    if(!empty($perm))
        						                    {
        						                        $p[$table][] = $perm;
        						                    }
        						                }
        						                if(!empty($p))
        						                {
            						                $view = in_array('view', $p[$table])?1:0;
            						                $add = in_array('add', $p[$table])?1:0;
            						                $edit = in_array('edit', $p[$table])?1:0;
            						                $delete = in_array('delete', $p[$table])?1:0;
        						                }
        						              ?>
        						              
        						                <tr>
                						            <td>
                						                <div class="form-check-inline">
                                                          <label class="form-check-label" >
                                                            <input type="checkbox" name="master-options" id="<?=$menu->cttitle;?>" class="form-check-input master-options" <?=(!empty($view) || !empty($add) || !empty($edit) || !empty($delete) )?'checked':'';?> value="1">
                                                          </label>
                                                        </div>
                						            </td>
                						            <td ><label class="form-check-label" for="<?=$menu->cttitle;?>"><?=$menu->cttitle;?></label></td>
                						            
                						            <td>
                						                <?php if($ad_permission->view == 'active') { ?>
                        						        <div class="form-check-inline user-controls">
                                                          <label class="form-check-label">
                                                            <input type="checkbox" name="view[][<?=$menu->table_name;?>]" class="form-check-input mview mcheck" value="view"  <?=(isset($view) && $view == 1)?'checked':'';?> <?=(!empty($view) || !empty($add) || !empty($edit) || !empty($delete) )?'':'disabled';?> >
                                                          </label>
                                                        </div>
                                                        <?php } ?>
                						            </td>
                						            <td>
                						                <?php if($ad_permission->add == 'active') { ?>
                						                <div class="form-check-inline user-controls">
                                                          <label class="form-check-label">
                                                            <input type="checkbox" name="add[][<?=$menu->table_name;?>]" class="form-check-input madd mcheck" value="add" <?=(isset($add) && $add == 1)?'checked':'';?>  <?=(!empty($view) || !empty($add) || !empty($edit) || !empty($delete) )?'':'disabled';?> >
                                                          </label>
                                                        </div>
                                                        <?php } ?>
                						            </td>
                						            
                						            <td>
                						                <?php if($ad_permission->edit == 'active') { ?>
                						                <div class="form-check-inline user-controls">
                                                          <label class="form-check-label">
                                                            <input type="checkbox" name="edit[][<?=$menu->table_name;?>]" class="form-check-input medit mcheck" value="edit" <?=(isset($edit) && $edit == 1)?'checked':'';?>  <?=(!empty($view) || !empty($add) || !empty($edit) || !empty($delete) )?'':'disabled';?> >
                                                          </label>
                                                        </div>
                                                        <?php } ?>
                						            </td>
                						            <td>
                						                <?php if($ad_permission->remove == 'active') { ?>
                        						        <div class="form-check-inline user-controls">
                                                          <label class="form-check-label">
                                                            <input type="checkbox" name="delete[][<?=$menu->table_name;?>]" class="form-check-input mdelete mcheck" value="delete" <?=(isset($delete) && $delete == 1)?'checked':'';?>  <?=(!empty($view) || !empty($add) || !empty($edit) || !empty($delete) )?'':'disabled';?> >
                                                          </label>
                                                        </div>
                                                        <?php } ?>
                						            </td>
            						            </tr>
            						            <?php  } ?>
            						            
        						            </tbody>
            						        
        						        </table>
                                    </div>
    						</div>
    						</div>
						</div>
						<?php } ?>
					  <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash();?>" />
                        <div class="form-group">       
                          <input type="submit" name="update" value="Update" class="btn <?=$site[0]->button;?>">
                        </div>
                      </form>
                    </div>
                </div>
			  </div>
            </div>     