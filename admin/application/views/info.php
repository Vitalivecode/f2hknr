<div class="content-wrapper">
	<?php if($site[0]->menu == 'header') { ?> <div class="container"> <?php } ?>
        <section class="content-header">
          <h1>
            <?=$title;?>
          </h1>
          <ol class="breadcrumb">
            <li><a href="<?=base_url();?>"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active"><?=$title;?></li>
          </ol>
        </section>
        <section class="content">
          <div class="row box-<?=$site[0]->button;?>">
            <div class="col-xs-12">
              <div class="box">
                <div class="box-header">
                 <!-- <h3 class="box-title">Database</h3> -->
                </div>
                <div class="box-body">
                  <table id="pranay" class="table table-bordered table-striped responsive">
                    <thead>
                      <tr>
                        <th>Sr No</th>
                        <th>Name</th>
                        <th>Phone No</th>
                        <th>Email Id</th>
                        <th>Message</th>
						<th> Date&time </th>
						<th>Status</th>
                      </tr>
                    </thead>
                    <tbody>
					<?php $no=1; foreach($info as $inf): ?>
                      <tr>
                        <td><?=$no;?></td>
                        <td><?=$inf->name;?></td>
                        <td><?=$inf->phone;?></td>
                        <td><?=$inf->email;?></td>
                        <td><?=$inf->service;?></td>
						<td><?=$inf->timedate;?></td>
						<td><?=$inf->status;?></td>
                      </tr>
					<?php $no++; endforeach ?>
                    </tbody>
                    <tfoot>
                      <tr>
                        <th>Sr No</th>
                        <th>Name</th>
                        <th>Phone No</th>
                        <th>Email Id</th>
                        <th>Message</th>
						<th>Status</th>
                      </tr>
                    </tfoot>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </section>
      <?php if($site[0]->menu == 'header') { ?> </div> <?php } ?>
</div>