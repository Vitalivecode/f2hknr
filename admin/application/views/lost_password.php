    <section id="wrapper" class="login-register">
        <div class="login-box">
            <div class="white-box">
				<form id="lostpassword" class="form-horizontal form-material" action="<?=current_url();?>" method="post">
					<center><a href="<?=base_url();?>">
					<?php if(!empty($site[0]->logo)) { ?><img src="<?=base_url();?>uploads/<?=$site[0]->logo;?>" width="300px" title="<?=$site[0]->title;?>" ait="<?=$site[0]->title;?>" />
					<?php } else { ?><b><?=$site[0]->title;?></b><?php } ?>
					</a></center>
                    <h3 class="box-title m-b-20">Lost Password</h3>
					<div id="results"></div>
                    <div class="form-group ">
                        <div class="col-xs-12">
                            <input class="form-control" type="password" id="new_pass" name="new_pass" placeholder="New Password" autofocus required >
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-xs-12">
                            <input type="password" name="conf_pass" class="form-control" id="conf_pass" placeholder="Re-enter New Password" required >
                        </div>
                    </div>
					<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash();?>" />
                    <div class="form-group text-center m-t-20">
                        <div class="col-xs-12">
                            <button class="btn btn-info btn-lg btn-block text-uppercase waves-effect waves-light <?=$site[0]->button;?>" id="lost_submit" name="changepass" type="submit">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>

