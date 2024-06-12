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
                  <div class="card">
                    <div class="card-body  table-responsive">
                      <table class="table table-striped table-hover">
                        <thead>
                          <tr>
							<th>Email Id</th>
							<th>Ip Address</th>
							<th>Last Access</th>
							<th>Device</th>
							<th>Status</th>
                          </tr>
                        </thead>
                        <tbody>
							<?php foreach($visit as $vis) : $userdata = unserialize($vis->user_data); ?>
							<tr>
								<td>
								<?php if(!empty($vis->user_data)) { echo $userdata['logged_in']['email'];} ?>
								</td>
								<td><?=$vis->ip_address;?></td>
								<td><?=date('d-m-Y h:i:s A',$vis->last_activity);?></td>
								<?php
								$browser=$vis->user_agent;
								if (strpos(strtolower($browser), "safari/") and strpos(strtolower($browser), "opr/")) {
									$browsername='<img src="'.base_url().'img/session/opera-browser.png" width="16" data-toggle="tooltip" data-placement="bottom" alt="Opera" title="Opera" />';
								} elseIf (strpos(strtolower($browser), "safari/") and strpos(strtolower($browser), "chrome/")) {
									$browsername='<img src="'.base_url().'img/session/Google_Chrome.png" width="16" data-toggle="tooltip" data-placement="bottom" alt="Chrome" title="Chrome" />';
								} elseIf (strpos(strtolower($browser), "chrome/")) {
									$browsername='<img src="'.base_url().'img/session/Google_Chrome.png" width="16" data-toggle="tooltip" data-placement="bottom" alt="Chrome" title="Chrome" />';
								} elseIf (strpos(strtolower($browser), "edge/")) {
									$browsername='<img src="'.base_url().'img/session/explorer.png" width="16" data-toggle="tooltip" data-placement="bottom" alt="Microsoft Edge" title="Microsoft Edge" />';
								} elseIf (strpos(strtolower($browser), "msie")) {
									$browsername='<img src="'.base_url().'img/session/explorer.png" width="16" data-toggle="tooltip" data-placement="bottom" alt="Internet Explorer" title="Internet Explorer" />';
								} elseIf (strpos(strtolower($browser), "ucbr")) {
									$browsername='<img src="'.base_url().'img/session/uc.png" width="16" data-toggle="tooltip" data-placement="bottom" alt="UC" title="UC" />'; 
								} elseIf (strpos(strtolower($browser), "firefox/")) {
									$browsername='<img src="'.base_url().'img/session/firefox.png" width="16" data-toggle="tooltip" data-placement="bottom" alt="Firefox" title="Firefox" />';
								} elseIf (strpos(strtolower($browser), "safari/") and strpos(strtolower($browser), "opr/")==false and strpos(strtolower($ExactBrowserNameUA), "chrome/")==false) {
									$browsername='<img src="'.base_url().'img/session/Safari.png" width="16" data-toggle="tooltip" data-placement="bottom" alt="Safari" title="Safari" />';
								} else {
									$browsername="OUT OF DATA";
								};
								 	if (preg_match('/linux/i', $browser)) {
										$platform ='<img src="'.base_url().'img/session/linux.png" width="16" data-toggle="tooltip" data-placement="bottom" alt="Linux" title="Linux" />';
									}
									elseif (preg_match('/macintosh|mac os x/i', $browser)) {
										$platform ='<img src="'.base_url().'img/session/mac.png" width="16" data-toggle="tooltip" data-placement="bottom"  alt="Mac" title="Mac" />';
									}
									elseif (preg_match('/windows|win32/i', $browser)) {
										$platform ='<img src="'.base_url().'img/session/win.png" width="16" data-toggle="tooltip" data-placement="bottom"  alt="Windows" title="Windows" />';
									}
									else {
										$platform="OUT OF DATA";
									}
									$devicesTypes = array(
										"computer" => array("msie 10", "msie 9", "msie 8", "windows.*firefox", "windows.*chrome", "x11.*chrome", "x11.*firefox", "macintosh.*chrome", "macintosh.*firefox", "opera"),
										"mobile"   => array("mobile", "android", "android.*mobile", "iphone", "ipod", "opera mobi", "opera mini"),
										"bot"      => array("googlebot", "mediapartners-google", "adsbot-google", "duckduckbot", "msnbot", "bingbot", "ask", "facebook", "yahoo", "addthis")
									);
									$deviceName = '';
									foreach($devicesTypes as $deviceType => $devices) {         
										foreach($devices as $device) {
											if(preg_match("/" . $device . "/i", $browser)) {
												$deviceName = $deviceType;
											}
										}
    								}
									if($deviceName == 'computer') {
										$device = '<img src="'.base_url().'img/session/desktop-computer.png" width="16" data-toggle="tooltip" data-placement="bottom" alt="Computer" title="'.$browser.'" />';
									}
									else if($deviceName == 'mobile') {
										$device = '<img src="'.base_url().'img/session/cell.png" width="16" height="16" data-toggle="tooltip" data-placement="bottom" alt="Mobile" title="'.$browser.'" />';
									}
									else if($deviceName == 'bot') {
										$device = '<img src="'.base_url().'img/session/bot.png" width="16" data-toggle="tooltip" data-placement="bottom"  alt="Bot" title="'.$browser.'" />';
									}
									else
										$device = '<img src="'.base_url().'img/session/Unknown-device.png" data-toggle="tooltip" data-placement="bottom" width="16"  alt="Unknown Device" title="Unknown Device" />';
								?>
								<td><?=$platform;?>&nbsp;<strong>|</strong>&nbsp;<?=$device;?>&nbsp;<strong>|</strong>&nbsp;<?=$browsername;?></td>
								<td><?php if(!empty($vis->user_data)) { ?><a href="<?=base_url().'Analytics/Offline/'.$vis->id;?>" ><img src="<?=base_url().'img/session/online.png';?>" data-toggle="tooltip" data-placement="bottom" width="16"  alt="Online"  title="Online" /></a><?php } else { ?><img src="<?=base_url().'img/session/offline.png';?>" width="16"  alt="Offline" title="Offline" /><?php } ?></td>
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