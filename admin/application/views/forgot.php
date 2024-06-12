    <section id="wrapper" class="login-register">
        <div class="login-box">
            <div class="white-box">
                <form class="form-material form-horizontal" id="recoverform" name="forgot" action="<?=base_url();?>forgot/send" style="display:block;">
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
                            <a href="<?=base_url();?>login" id="to-login" class="text-dark pull-left"><i class="fa fa-lock m-r-5"></i> Login</a> 
						</div>
                    </div>
                </form>
            </div>
        </div>
    </section>
