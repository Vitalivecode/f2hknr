<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row bg-title">
            <div class="col-lg-<?=($userdata[0]->role != 'vendor')?'4':'6';?> col-md-<?=($userdata[0]->role != 'vendor')?'4':'6';?> col-sm-<?=($userdata[0]->role != 'vendor')?'3':'5';?> col-xs-12">
                <h4 class="page-title">Hello <?=($this->ordersModel->getVendorName($vendor_id) != '')?$this->ordersModel->getVendorName($vendor_id):'Admin';?>,</h4> 
			</div>
			<?php if($userdata[0]->role != 'vendor'){ ?>
			<div class="col-lg-3 col-sm-2 col-md-4 col-xs-12">
				<div class="">
					<select id="branch" class="select2-container form-control select2" onchange="if (this.value) window.location.href=this.value"> 
					<?php if($branches != false){ ?> 
						<option value="<?=base_url('home');?>" <?=(isset($vendor_id) && $vendor_id == 'all')?'selected':'';?>>All</option>
					<?php foreach($branches as $branch){ ?>
						<option value="<?=base_url('home/index/'.$branch->rest_id);?>" <?=(isset($vendor_id) && $vendor_id == $branch->rest_id)?'selected':'';?>><?=$branch->rest_name;?></option>
					<?php } } ?>
					</select>
				</div>
			</div>
			<?php } ?>
            <div class="col-lg-<?=($userdata[0]->role != 'vendor')?'5':'6';?> col-sm-<?=($userdata[0]->role != 'vendor')?'7':'6';?> col-md-<?=($userdata[0]->role != 'vendor')?'4':'7';?> col-xs-12">
                <ol class="breadcrumb">
                    <li><a href="<?=base_url()?>">Home</a></li>
                    <li class="active">Dashboard</li>
                </ol>
            </div>
        </div>
				<div class="row">
					<?php if($site != false){ switch($site[0]->theme){ case 'purple-dark': case 'purple': $bgcolor = '#ab8ce4'; break; case 'default-dark': case 'default': $bgcolor = '#fb9678'; break; case 'green-dark': case 'green': $bgcolor = '#00c292'; break; case 'gray-dark': case 'gray': $bgcolor = '#a0aec4'; break; case 'blue-dark': case 'blue': $bgcolor = '#03a9f3'; break; case 'megna-dark': case 'megna': $bgcolor = '#01c0c8'; break;  default: $bgcolor = ''; break; } } 
				   foreach($tables as $tname ) : $pages = json_decode($tname->permissions); if(!empty($pages->display)) { if($pages->display == 'show') { if((permissions($userdata[0]->permissions,$tname->table_name)) || $this->session->userdata('logged_in')['role'] == 'superadmin'){  ?>
                    <!-- Column -->
                    <div class="col-lg-3 col-md-6">
						<?php $table_type1= $this->adminpanel->getTableType($tname->table_name);if($table_type1[0]->table_type == 'cms') { ?>
                        <a href="<?=base_url()?>cms/<?=str_replace('_','-',$tname->table_name);?>">
						<?php } else { ?>
							<a href="<?=base_url($c->table_name);?>">
						<?php } ?>
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex flex-row">
                                    <div class="round align-self-center" style="background: <?=($tname->bg_color != '')?$tname->bg_color:$bgcolor;?>"><i class="<?=$tname->icon;?>"></i></div>
                                    <div class="m-l-10 align-self-center">
                                        <h3 class="m-b-0"><?php  if($pages->count == 'show') { echo $this->db->count_all_results($tname->table_name); } ?></h3>
                                        <h5 class="text-muted m-b-0"><?=ucfirst($tname->cttitle);?></h5></div>
                                </div>
                            </div>
                        </div></a>
                    </div>
                    <!-- Column -->
					<?php } } }endforeach ?>
                    <?php if($this->session->userdata('logged_in')['role'] == 'superadmin') { ?>
                    <!-- Column -->
                    <div class="col-lg-3 col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex flex-row">
                                    <div class="round align-self-center round-info"><i class="fa fa-users"></i></div>
                                    <div class="m-l-10 align-self-center">
                                        <h3 class="m-b-0"><?php echo $this->db->count_all_results('admin');?></h3>
                                        <h5 class="text-muted m-b-0">Admin(s)</h5></div>
                                </div>
                            </div>
                        </div></a>
                    </div>
                    <!-- Column -->
					<?php } ?>
                </div>
    </div>