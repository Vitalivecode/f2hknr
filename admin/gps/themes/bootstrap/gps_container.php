<div class="gps<?php echo $this->is_rtl ? ' gps_rtl' : ''?>">
    <?php echo $this->render_table_name(false, 'div', true)?>
    <div <?php echo ($this->start_minimized) ? ' style="display:none;"' : '' ?>>
        <div class="white-box">
            <div class="gps-ajax">
                <?php echo $this->render_view() ?>
            </div>
        </div>
		<div class="gps-overlay"></div>
    </div>
</div>