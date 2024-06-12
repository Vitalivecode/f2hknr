<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?=$title;?> | <?=$site[0]->title;?></title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
	<link rel="shortcut icon" href="<?=base_url().$site[0]->favicon;?>" />
    <link rel="stylesheet" href="<?=base_url();?>Admin/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <link rel="stylesheet" href="<?=base_url();?>Admin/dist/css/gps.min.css">
    <link rel="stylesheet" href="<?=base_url();?>Admin/plugins/iCheck/square/_all.css">
    <script src="<?=base_url();?>Admin/plugins/jQuery/jquery.min.js"></script>
  </head>
  <body class="hold-transition login-page">
    <div class="login-box">
      <div class="login-logo">
        <a href="<?=base_url();?>">
            <?php if(!empty($site[0]->logo)) { ?> 
            <img src="<?=base_url();?>uploads/<?=$site[0]->logo;?>" width="300px" title="<?=$site[0]->title;?>" ait="<?=$site[0]->title;?>" />
            <?php } else { ?>
            <b><?=$site[0]->title;?></b>
            <?php } ?>
        </a>
      </div>
	  <?=$log_error;?>
      <div class="login-box-body">
        <p class="login-box-msg">Lost Password</p>
        <form action="<?=current_url();?>" method="post">
          <div class="form-group has-feedback">
            <input type="password" name="new_pass" class="form-control" placeholder="New Password" autofocus required>
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
          </div>
          <div class="form-group has-feedback">
            <input type="password" name="conf_pass" class="form-control" placeholder="Re-enter New Password" required>
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
          </div>
          <div class="row">
            <div class="col-xs-4 pull-right">
              <button type="submit" name="changepass" class="btn btn-primary btn-block btn-flat">Submit</button>
            </div>
          </div>
        </form>
		<br>
      </div>
    </div>
    <script src="<?=base_url();?>Admin/bootstrap/js/bootstrap.min.js"></script>
    <script src="<?=base_url();?>Admin/plugins/iCheck/icheck.min.js"></script>
    <script>
      $(function () {
        $('input').iCheck({
          checkboxClass: 'icheckbox_square-<?=$site[0]->theme;?>',
          radioClass: 'iradio_square-<?=$site[0]->theme;?>',
          increaseArea: '20%'
        });
      });
    </script>
  </body>
</html>
