    <section id="wrapper" class="login-register" style="background: url(<?=base_url();?>../uploads/<?=$site[0]->loginbg;?>) center center/cover no-repeat !important; background-color: rgba(255,255,255,0.9);">
        <div>
            <a href="<?=base_url();?>">
    			<img src="<?=base_url();?>uploads/vshoot-logo.png" width="300px" title="Vshoot" ait="Vshoot"></a>
    		<a href="<?=base_url();?>../logins" style="float: right; padding: 25px;">
    		    <i class="fa fa-user fa-4x"></i>
			</a>		
		</div>

    <div class="row">
    <div class="col-md-4">
    </div>
    <div class="col-md-4">
        <div class="" style="background: #9152f8; background: -webkit-linear-gradient(top, #7579ff, #b224ef); background: -o-linear-gradient(top, #7579ff, #b224ef); background: -moz-linear-gradient(top, #7579ff, #b224ef); background: linear-gradient(top, #7579ff, #b224ef); padding: 55px 55px 37px 55px; border-radius: 10px;">
            <div class="">
				<form id="loginform" class="form-horizontal form-material" action="<?=base_url();?>login/authlogin" method="post">
					<!--
					<center><a href="<?=base_url();?>">
					<?php if(!empty($site[0]->logo)) { ?><img src="<?=base_url();?>../uploads/<?=$site[0]->logo;?>" width="300px" title="<?=$site[0]->title;?>" ait="<?=$site[0]->title;?>" />
					<?php } else { ?><b><?=$site[0]->title;?></b><?php } ?>
					</a></center>
					-->
                    <h3 class="box-title m-b-20">Sign In</h3>
					<?=$log_error;?>
                    <div class="form-group ">
                        <div class="col-xs-12">
                            <input class="form-control" type="email" name="email" value="<?=!empty(get_cookie("user_email")) ? get_cookie("user_email") : '' ;?>" <?=!empty(get_cookie("user_email")) ?  'autocomplete="on"' : ' autocomplete="on" autofocus' ;?>  placeholder="Email Id" autofocus required >
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-xs-12">
                            <input class="form-control" type="password" name="password" value="<?=!empty(get_cookie("user_password")) ? get_cookie("user_password") : '' ;?>" <?=!empty(get_cookie("user_password")) ? 'autofocus' : '' ;?> placeholder="Password" required >
                        </div>
                    </div>
					<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash();?>" />
                    <div class="form-group">
                        <div class="col-md-12">
                            <div class="checkbox checkbox-primary pull-left p-t-0">
                                <input type="checkbox" name="signin_rem" id="remember">
                                <label for="remember"> Remember me </label>
                            </div>
                            <a href="javascript:void(0)" id="to-recover" class="text-dark pull-right"><i class="fa fa-lock m-r-5"></i> Forgot pwd?</a> 
						</div>
                    </div>
                    <div class="form-group text-center m-t-20">
                        <div class="col-xs-12">
                            <button class="btn btn-info btn-lg btn-block text-uppercase waves-effect waves-light <?=$site[0]->button;?>" type="submit">Log In</button>
                        </div>
                    </div>
                </form>
                <form class="form-material form-horizontal" id="recoverform" name="forgot" action="<?=base_url();?>forgot/send">
                    <div class="form-group ">
                        <div class="col-xs-12">
                            <h3>Recover Password</h3>
                            <p class="text-muted">Enter your Email and instructions will be sent to you! </p>
                        </div>
                    </div>
					<div id="results"></div>
                    <div class="form-group">
                        <div class="col-xs-12">
                            <input class="form-control" type="email" name="email" id="email" required="" placeholder="Emailid">
                        </div>
                    </div>
					<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash();?>" />
                    <div class="form-group text-center m-t-20">
                        <div class="col-xs-12">
                            <button class="btn btn-primary btn-lg btn-block text-uppercase waves-effect waves-light <?=$site[0]->button;?>" id="reset" type="submit">Reset</button>
                        </div>
                    </div>
					<div class="form-group">
                        <div class="col-md-12">
                            <a href="javascript:void(0)" id="to-login" class="text-dark pull-left"><i class="fa fa-lock m-r-5"></i> Login</a> 
						</div>
                    </div>
                </form>
            </div>
        </div>
        </div>
    <div class="col-md-4">
    </div>
    </div>
    </section>
