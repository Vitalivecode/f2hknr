    <section id="wrapper" class="login-register" style="background: url(<?=base_url();?>../uploads/<?=$site[0]->loginbg;?>) center center/cover no-repeat!important;">
        <div class="login-box">
            <div class="white-box" style="background: #ffffffeb;-webkit-box-shadow: 1px 2px 3px 4px #504f4f;-moz-box-shadow: 1px 2px 3px 4px #504f4f; box-shadow:1px 2px 3px 4px #504f4f;">
				<form id="loginform" class="form-horizontal form-material" data-action="<?=base_url();?>login/authlogin" method="post">
					<center><a href="<?=base_url();?>">
					<?php if(!empty($site[0]->logo)) { ?><img src="<?=base_url();?>../uploads/<?=$site[0]->logo;?>" width="200px" title="<?=$site[0]->title;?>" ait="<?=$site[0]->title;?>" />
					<?php } else { ?><b><?=$site[0]->title;?></b><?php } ?>
					</a></center>
                    <h3 class="box-title m-b-20">Sign In</h3>
                    <div class="log-error"></div>
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
					<input type="hidden" name="tokenid" id="token" value="" />
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
                            <button class="btn btn-info btn-lg btn-block text-uppercase waves-effect waves-light <?=$site[0]->button;?>" id="login-submit" type="submit">Log In</button>
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
    </section>
