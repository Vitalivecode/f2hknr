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
                    <div class="d-flex align-items-center m-b-20">
                      <a href="<?=base_url();?>users/add" class="btn <?=$site[0]->button;?> mb"><i class="glyphicon glyphicon-plus-sign"></i> Add</a>
                    </div>
					<?php if($usersDetails != false) { ?>
                    <div class="table-responsive">
                      <table id="tables-export" class="display nowrap" cellspacing="0" width="100%">
                        <thead>
                          <tr>
                            <th>S No</th>
							<th>Name</th>
							<th>Email id</th>
							<th>Phone No.</th>
							<th>Photo</th>
							<th>Role</th>
							<th>Actions</th>
                          </tr>
                        </thead>
                        <tbody>
						<?php $no=1; foreach($usersDetails as $users) : ?>
						<tr>
                            <td><?=$no;?></td>
							<td><?=ucfirst($users->fullname);?></td>
							<td><?=$users->email;?></td>
							<td><?=$users->phone;?></td>
							<td><img src="<?=base_url();?>../uploads/<?=$users->img;?>" class="img-responsive img-circle" width="40px" height="40px" /></td>
							<td><?=$users->role;?></td>
							<td><a class="btn btn-warning btn-sm bthmlrn" data-toggle="tooltip" data-placement="bottom" title="Edit"  href="<?=base_url();?>users/edit/<?=$users->sno;?>"  alt="Edit" ><i class="glyphicon glyphicon-pencil "></i></a>
							<?php if($users->sno != $this->session->userdata('logged_in')['id']){ ?>
							    <a class="btn btn-danger btn-sm bthmlrn delete-alert" data-toggle="tooltip" data-placement="bottom" title="Delete"  href="<?=base_url();?>users/delete/<?=$users->sno;?>" alt="Delete"  ><i class="glyphicon glyphicon-trash"></i></a>
							<?php } ?>
							</td>
                        </tr>
						<?php $no++; endforeach; ?>
                        </tbody>
                      </table>
                      <div class="col-md-12"><div class="pull-right"><?=$links;?></div></div>
                    </div>
					<?php } else { ?>
						<div class="row">
							<div class="col-lg-12">
								<section id="wrapper" class="error-page">
									<div class="error-box" style="position: relative;">
										<div class="text-center">
											<h2>No Data</h2>
										</div>
									</div>
								</section>
							</div>
						</div>
					<?php } ?>
                  </div>
                </div>
              </div>
			</div>