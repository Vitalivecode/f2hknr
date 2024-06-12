<div class="content-wrapper">
	<?php if($site[0]->menu == 'header') { ?> <div class="container"> <?php } ?>
        <section class="content-header">
          <h1>
            <?=$title;?>
			<small>Admin Panel</small>
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
				<div class="box-body">
                 	<table class="table table-bordered table-hover table-striped responsive">
						<thead>
						  <tr>
							<th>Email Id</th>
							<th>Ip Address</th>
							<th>Last Access</th>
							<th>Device</th>
							<th>Status</th>
							<th>Block</th>
						  </tr>
                    	</thead>
						<tbody>
							<?php foreach($visit as $vis) : $userdata = unserialize($vis->user_data); ?>
							<tr>
								<td>
								<?php if(!empty($vis->user_data)) { foreach($userdata as $key => $details){ }} ?>
								</td>
								<td><a href="#" class="location" data-toggle="modal" data-ip="<?=$vis->ip_address;?>" data-target="#loc"><?=$vis->ip_address;?></a></td>
								<td><?=date('d-m-Y h:i:s A',$vis->last_activity);?></td>
								<?php
								$browser=$vis->user_agent;
								if (strpos(strtolower($browser), "safari/") and strpos(strtolower($browser), "opr/")) {
									$browsername='<img src="'.base_url().'img/session/opera-browser.png" width="16"  alt="Opera" title="Opera" />';
								} elseIf (strpos(strtolower($browser), "safari/") and strpos(strtolower($browser), "chrome/")) {
									$browsername='<img src="'.base_url().'img/session/Google_Chrome.png" width="16"  alt="Chrome" title="Chrome" />';
								} elseIf (strpos(strtolower($browser), "chrome/")) {
									$browsername='<img src="'.base_url().'img/session/Google_Chrome.png" width="16"  alt="Chrome" title="Chrome" />';
								} elseIf (strpos(strtolower($browser), "edge/")) {
									$browsername='<img src="'.base_url().'img/session/explorer.png" width="16"  alt="Microsoft Edge" title="Microsoft Edge" />';
								} elseIf (strpos(strtolower($browser), "msie")) {
									$browsername='<img src="'.base_url().'img/session/explorer.png" width="16"  alt="Internet Explorer" title="Internet Explorer" />';
								} elseIf (strpos(strtolower($browser), "ucbr")) {
									$browsername='<img src="'.base_url().'img/session/uc.png" width="16"  alt="UC" title="UC" />'; 
								} elseIf (strpos(strtolower($browser), "firefox/")) {
									$browsername='<img src="'.base_url().'img/session/firefox.png" width="16"  alt="Firefox" title="Firefox" />';
								} elseIf (strpos(strtolower($browser), "safari/") and strpos(strtolower($browser), "opr/")==false and strpos(strtolower($ExactBrowserNameUA), "chrome/")==false) {
									$browsername='<img src="'.base_url().'img/session/Safari.png" width="16"  alt="Safari" title="Safari" />';
								} else {
									$browsername="OUT OF DATA";
								};
								 	if (preg_match('/linux/i', $browser)) {
										$platform ='<img src="'.base_url().'img/session/linux.png" width="16"  alt="Linux" title="Linux" />';
									}
									elseif (preg_match('/macintosh|mac os x/i', $browser)) {
										$platform ='<img src="'.base_url().'img/session/mac.png" width="16"  alt="Mac" title="Mac" />';
									}
									elseif (preg_match('/windows|win32/i', $browser)) {
										$platform ='<img src="'.base_url().'img/session/win.png" width="16"  alt="Windows" title="Windows" />';
									}
									else {
										$platform="OUT OF DATA";
									}
									$devicesTypes = array(
										"computer" => array("msie 10", "msie 9", "msie 8", "windows.*firefox", "windows.*chrome", "x11.*chrome", "x11.*firefox", "macintosh.*chrome", "macintosh.*firefox", "opera"),
										"mobile"   => array("mobile", "android", "android.*mobile", "iphone", "ipod", "opera mobi", "opera mini"),
										"bot"      => array("googlebot", "mediapartners-google", "adsbot-google", "duckduckbot", "msnbot", "bingbot", "ask", "facebook", "yahoo", "addthis")
									);
									foreach($devicesTypes as $deviceType => $devices) {           
										foreach($devices as $device) {
											if(preg_match("/" . $device . "/i", $browser)) {
												$deviceName = $deviceType;
											}
										}
    								}
									if($deviceName == 'computer') {
										$device = '<img src="'.base_url().'img/session/desktop-computer.png" width="16"  alt="Computer" title="'.$browser.'" />';
									}
									else if($deviceName == 'mobile') {
										$device = '<img src="'.base_url().'img/session/cell.png" width="16" height="16" alt="Mobile" title="'.$browser.'" />';
									}
									else if($deviceName == 'bot') {
										$device = '<img src="'.base_url().'img/session/bot.png" width="16"  alt="Bot" title="'.$browser.'" />';
									}
									else
										$device = '<img src="'.base_url().'img/session/Unknown-device.png" width="16"  alt="Unknown Device" title="Unknown Device" />';
								?>
								<td><?=$platform;?>&nbsp;<strong>|</strong>&nbsp;<?=$device;?>&nbsp;<strong>|</strong>&nbsp;<?=$browsername;?></td>
								<td><?php if(!empty($vis->user_data)) { ?><a href="<?=base_url().'Analytics/Offline/'.$vis->id;?>" ><img src="<?=base_url().'img/session/online.png';?>" width="16"  alt="Online"  title="Online" /></a><?php } else { ?><img src="<?=base_url().'img/session/offline.png';?>" width="16"  alt="Offline" title="Offline" /><?php } ?></td>
								<td><?php if($vis->block == 'active') { ?><a href="<?=base_url().'Analytics/Inblock/'.$vis->id;?>" ><img src="<?=base_url().'img/session/active_block.png';?>" width="16"  alt="Active" title="Active" /></a><?php } else { ?><a href="<?=base_url().'Analytics/Block/'.$vis->id;?>" ><img src="<?=base_url().'img/session/inactive_block.png';?>" width="16"  alt="Inactive" title="Inactive" /></a><?php } ?></td>
							</tr>
							<?php endforeach ?>
						</tbody>
					</table>
					<div class="col-md-3" style="margin-top: 30px !important;"><p class="pull-left"><small><?=(!empty($pagermessage) ? $pagermessage : ''); ?></small></p></div>
					<div class="col-md-9"><div class="pull-right"><?=$links;?></div></div>
				</div>
                </div>
              </div>
            </div>
          </div>
        </section>
      <?php if($site[0]->menu == 'header') { ?> </div> <?php } ?>
</div>
<div class="modal fade" id="loc" role="dialog">
                            <div class="modal-dialog modal-lg"> 
                              <div class="modal-content"> 
                                 <div class="modal-header">
                                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                                  <h4 class="modal-title">Location-<span id="ip"></span></h4>
                                </div>
                                 <div class="modal-body">
                                    <div class="form-horizontal">
                                        <div class="form-group">
                                            <div class="col-md-12">
												 <div class="loading"></div>
												 <div class="data"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                </div>
                             </div> 
                            </div> 
                         </div>