<?php echo '<div class="box-header">'.$this->render_table_name().'</div>'; ?>
<?php if ($this->is_create or $this->is_csv or $this->is_print or $this->is_search){?>
        <div class="gps-top-actions">
			<div class="row" style="padding-bottom:10px;">
				<div class="col-md-12 col-sm-12">
					<div class="row">
					    <?php if($this->is_create){ ?>
    						<div class="col-md-1 dataTables_length">
    							<?php echo $this->add_button('btn btn-success','glyphicon glyphicon-plus-sign'); ?>
    						</div>
						<?php } ?>
						<div class="col-md-<?=$this->is_create?3:4;?>">
							<?php echo '<div class="row"><div class="col-md-8 text-right"><label class="form-control-label text-right p-t-10">Show entries</label></div><div class="col-md-4">'.$this->render_limitlist(false).'</div></div>'; ?>
						</div>
						<?php if($this->is_print || $this->is_csv){ ?>
    						<div class="col-md-2">
    							<div class="pull-right">
    								<?php echo $this->print_button('btn btn-default','glyphicon glyphicon-print');
    								echo $this->csv_button('btn btn-default','glyphicon glyphicon-file'); ?>
    							</div>
    						</div>
						<?php } ?>
        				<div class="col-md-<?=($this->is_print || $this->is_csv)?6:8;?> col-sm-12">
        					<div class="btn-group pull-right">
        						<?php echo $this->render_search(); ?>
        					</div>
        				</div>
					</div>
				</div>
				<div class="clearfix"></div>
			</div>
        </div>
<?php } ?>
    <div class="box-body">
        <div class="gps-list-container">
            <table class="gps-list table table-striped table-hover table-bordered responsive  dataTable" id="tblCustomers">
                <thead>
                    <?php echo $this->render_grid_head('tr role="row"', 'th'); ?>
                </thead>
                <tbody>
                    <?php echo $this->render_grid_body('tr', 'td'); ?>
                </tbody>
                <tfoot>
                    <?php echo $this->render_grid_footer('tr', 'td'); /* echo $this->render_grid_head('tr', 'th'); */ ?>
                </tfoot>
            </table>
        </div>
    </div>
        <div class="gps-nav">
            <?php echo $this->render_pagination(); ?>
            <?php echo $this->render_benchmark(); ?>
        </div>