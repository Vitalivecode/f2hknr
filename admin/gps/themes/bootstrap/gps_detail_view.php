<?php echo $this->render_table_name($mode); ?>
<div class="gps-top-actions btn-group">
    <?php 
		if($this->table == 'promotions')
		{
			echo $this->render_button('Send & Back','save','list','btn btn-primary','','create,edit');
			echo $this->render_button('Send & New','save','create','btn btn-default','','create,edit');
			echo $this->render_button('Send & Edit','save','edit','btn btn-default','','create,edit');
			echo $this->render_button('Back','list','','btn btn-warning'); 
		}
		else
		{
			echo $this->render_button('Save & Back','save','list','btn btn-primary','','create,edit');
			echo $this->render_button('save_new','save','create','btn btn-default','','create,edit');
			echo $this->render_button('save_edit','save','edit','btn btn-default','','create,edit');
			echo $this->render_button('Back','list','','btn btn-warning'); 
		}
	?>
</div>
<div class="gps-view">
<?php echo $mode == 'view' ? $this->render_fields_list($mode,array('tag'=>'table','class'=>'table')) : $this->render_fields_list($mode,'div','div','label','div'); ?>
</div>
<div class="gps-nav">
    <?php echo $this->render_benchmark(); ?>
</div>

	<script>
		$(document).ready(function() {
			var elems = Array.prototype.slice.call(document.querySelectorAll('.js-switch'));
			$('.js-switch').each(function() {
				new Switchery($(this)[0], $(this).data());
			});
		});
    </script>
