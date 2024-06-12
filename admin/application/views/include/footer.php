<?php if($this->uri->segment(1) != '' && $this->uri->segment(1) != 'login' && $this->uri->segment(1) != 'Login' && $this->uri->segment(1) != 'Forgot' && $this->uri->segment(1) != 'forgot') { ?>
           <footer class="footer text-center"><div class="pull-left"><?=$site[0]->footer_left;?></div><div class="pull-right"><?=$site[0]->footer_right;?></div></footer>
        </div>
        <!-- /#page-wrapper -->
    </div>
<?php } ?>
<?php if($this->uri->segment(2) == 'restaurant-items'){ ?>
    <div id="items-import" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <form action="<?=base_url('import/items');?>" method="post" id="volunteer-form" enctype="multipart/form-data" class="form-horizontal">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Upload</h4>
                    </div>
                    <div class="modal-body" style="float:left;">
                        <div class="col-md-12 message"></div>
                        <div class="col-md-12">
							<div class="form-group">
								<label class="col-md-4 text-right">Choose a File: </label>
								<div class="col-md-6">
									<input type="file" id="items" class="form-control" name="items" accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel" />
								</div>
							</div>
						</div>
                    </div>
                    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash();?>" />
                    <div class="modal-footer">
                        <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
                        <button type="submit" name="volunteer" class="btn items-import">Import</button>
                    </div>
                </div>
            </form>
        </div>
</div>
<?php } ?>
	<div id="BaseUri" data-url="<?=base_url();?>"></div>
	<div id="ajaxMessage"></div>
    <!-- /#wrapper -->
    <!-- Bootstrap Core JavaScript -->
    <script src="<?=base_url();?>plugins/bower_components/bootstrap-extension/js/bootstrap-extension.min.js"></script>
	<script src="<?=base_url();?>plugins/bower_components/bootstrap-switch/bootstrap-switch.min.js"></script>
    <!--Wave Effects -->
    <script src="<?=base_url();?>js/waves.js"></script>
	<?php if($this->uri->segment(1) != '' && $this->uri->segment(1) != 'login' && $this->uri->segment(1) != 'Login' && $this->uri->segment(1) != 'Forgot' && $this->uri->segment(1) != 'forgot') { ?>
    <script src="<?=base_url();?>plugins/bower_components/switchery/dist/switchery.min.js"></script>
	<!--Counter js -->
    <script src="<?=base_url();?>plugins/bower_components/waypoints/lib/jquery.waypoints.js"></script>
    <script src="<?=base_url();?>plugins/bower_components/counterup/jquery.counterup.min.js"></script>
    <!--Morris JavaScript -->
    <script src="<?=base_url();?>plugins/bower_components/raphael/raphael-min.js"></script>
    <?php if($this->uri->segment(1) == '' || $this->uri->segment(1) == 'home') { ?>
    <script src="<?=base_url();?>plugins/bower_components/morrisjs/morris.js"></script>
    <script src="<?=base_url();?>js/dashboard1.js"></script>
    <?php } ?>
    <!-- Sparkline chart JavaScript -->
    <script src="<?=base_url();?>plugins/bower_components/jquery-sparkline/jquery.sparkline.min.js"></script>
    <script src="<?=base_url();?>plugins/bower_components/jquery-sparkline/jquery.charts-sparkline.js"></script>
    <!-- Sweet-Alert  -->
    <script src="<?=base_url();?>plugins/bower_components/sweetalert/sweetalert.min.js"></script>
    <script src="<?=base_url();?>plugins/bower_components/sweetalert/jquery.sweet-alert.custom.js"></script>
    <!-- icheck -->
    <script src="<?=base_url();?>plugins/bower_components/icheck/icheck.min.js"></script>
    <script src="<?=base_url();?>plugins/bower_components/icheck/icheck.init.js"></script>
    <!-- Plugin JavaScript -->
    <script src="<?=base_url();?>plugins/bower_components/moment/moment.js"></script>
    <!-- Magnific popup JavaScript -->
    <script src="<?=base_url();?>plugins/bower_components/Magnific-Popup-master/dist/jquery.magnific-popup.min.js"></script>
    <script src="<?=base_url();?>plugins/bower_components/Magnific-Popup-master/dist/jquery.magnific-popup-init.js"></script>
    <!--- Typeheader -->
    <script src="<?=base_url('plugins/bower_components/typeahead.js-master/dist/typeahead.bundle.min.js');?>"></script>
    <script src="<?=base_url('plugins/bower_components/typeahead.js-master/dist/typeahead-init.js');?>"></script>
    <!--- Nestable ----->
    <script src="<?=base_url();?>plugins/bower_components/nestable/jquery.nestable.js"></script>
	<!-- jQuery file upload -->
    <script src="<?=base_url();?>plugins/bower_components/dropify/dist/js/dropify.min.js"></script>
    <script src="<?=base_url();?>plugins/bower_components/custom-select/custom-select.min.js" type="text/javascript"></script>
    <?php if($this->uri->segment(1) == 'users' || $this->uri->segment(1) == 'create' || $this->uri->segment(1) == 'tables' || $this->uri->segment(1) == 'reports') { ?>
	<script src="<?=base_url();?>plugins/bower_components/datatables/jquery.dataTables.min.js"></script>
	<script src="https://cdn.datatables.net/buttons/1.2.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.2.2/js/buttons.flash.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js"></script>
    <script src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/pdfmake.min.js"></script>
    <script src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.2.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.2.2/js/buttons.print.min.js"></script>
	<script src="https://cdn.datatables.net/plug-ins/1.10.21/sorting/currency.js"></script>
	<script>
    $('#tables-export').DataTable({
		<?php if($this->uri->segment(1) != 'reports') { ?>
        dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
		<?php } else{ ?>
		paging: false,
		"bInfo" : false,
		"columnDefs": [
            { "type": "currency", targets: 8 },
			{ "type": "currency", targets: 7 },
			{ "type": "currency", targets: 6 }
        ]
		<?php } ?>
    });
	<?php if($this->uri->segment(1) == 'reports') { ?>
	jQuery.extend( jQuery.fn.dataTableExt.oSort, {
		"formatted-num-pre": function ( a ) {
			a = (a === "-" || a === "") ? 0 : a.replace( /[^\d\-\.]/g, "" );
			return parseFloat( a );
		},
	 
		"formatted-num-asc": function ( a, b ) {
			return a - b;
		},
	 
		"formatted-num-desc": function ( a, b ) {
			return b - a;
		}
	} );
	$('#tables-delivered').DataTable({
		paging: false,
		"bInfo" : false,
		"columnDefs": [
            { "type": "currency", targets: 5 },
			{ type: 'formatted-num', targets: 4 }
        ]
    });
	$('#tables-cancelled').DataTable({
		paging: false,
		"bInfo" : false,
		"columnDefs": [
            { "type": "currency", targets: 5 },
			{ type: 'formatted-num', targets: 4 }
        ]
    });
	<?php } ?>
    </script>
	<?php } ?>
    <!-- Treeview Plugin JavaScript -->
    <script type="text/javascript" charset="utf8" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-treeview/1.2.0/bootstrap-treeview.min.js"></script>
	<script src="<?=base_url();?>plugins/ckeditor/ckeditor.js"></script>
	<!-- Custom JS -->
	<?=$site[0]->j_links;?>
	<?php if(!empty($site[0]->js)) { ?>
	<script type="text/javascript">
		<?=$site[0]->js;?>
	</script>
	<?php } ?>
	<?php if($this->session->flashdata('alertMessage')) { ?>
		<script type="text/javascript">
		$(document).ready(function() {
			$.toast({
				heading: '<?=$this->session->flashdata('alertMessage')['title'];?>',
				text: '<?=$this->session->flashdata('alertMessage')['message'];?>',
				position: 'top-right',
				loaderBg: '#ff6849',
				icon: '<?=$this->session->flashdata('alertMessage')['status'];?>',
				hideAfter: 3500,
				stack: 6
			})
		});
		</script>
	<?php } ?>
	<?php } ?>
    <!--Style Switcher -->
    <script src="<?=base_url();?>plugins/bower_components/styleswitcher/jQuery.style.switcher.js"></script>   
</body>
</html>