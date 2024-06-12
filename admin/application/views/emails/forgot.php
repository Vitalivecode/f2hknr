<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
		<title><?=$site[0]->title;?></title>
		

		<style>	@media only screen and (max-width: 300px){ 
				body {
					width:218px !important;
					margin:auto !important;
				}
				.table {width:195px !important;margin:auto !important;}
				.logo, .titleblock, .linkbelow, .box, .footer, .space_footer{width:auto !important;display: block !important;}		
				span.title{font-size:20px !important;line-height: 23px !important}
				span.subtitle{font-size: 14px !important;line-height: 18px !important;padding-top:10px !important;display:block !important;}		
				td.box p{font-size: 12px !important;font-weight: bold !important;}
				.table-recap table, .table-recap thead, .table-recap tbody, .table-recap th, .table-recap td, .table-recap tr { 
					display: block !important; 
				}
				.table-recap{width: 200px!important;}
				.table-recap tr td, .conf_body td{text-align:center !important;}	
				.address{display: block !important;margin-bottom: 10px !important;}
				.space_address{display: none !important;}	
			}
	@media only screen and (min-width: 301px) and (max-width: 500px) { 
				body {width:308px!important;margin:auto!important;}
				.table {width:285px!important;margin:auto!important;}	
				.logo, .titleblock, .linkbelow, .box, .footer, .space_footer{width:auto!important;display: block!important;}	
				.table-recap table, .table-recap thead, .table-recap tbody, .table-recap th, .table-recap td, .table-recap tr { 
					display: block !important; 
				}
				.table-recap{width: 293px !important;}
				.table-recap tr td, .conf_body td{text-align:center !important;}
				
			}
	@media only screen and (min-width: 501px) and (max-width: 768px) {
				body {width:478px!important;margin:auto!important;}
				.table {width:450px!important;margin:auto!important;}	
				.logo, .titleblock, .linkbelow, .box, .footer, .space_footer{width:auto!important;display: block!important;}			
			}
	@media only screen and (max-device-width: 480px) { 
				body {width:308px!important;margin:auto!important;}
				.table {width:285px;margin:auto!important;}	
				.logo, .titleblock, .linkbelow, .box, .footer, .space_footer{width:auto!important;display: block!important;}
				
				.table-recap{width: 285px!important;}
				.table-recap tr td, .conf_body td{text-align:center!important;}	
				.address{display: block !important;margin-bottom: 10px !important;}
				.space_address{display: none !important;}	
			}
</style>

	</head>
	<body style="-webkit-text-size-adjust:none;background-color:#fff;width:650px;font-family:Open-sans, sans-serif;color:#555454;font-size:13px;line-height:18px;margin:auto">
		<table class="table table-mail" style="width:100%;margin-top:10px;-moz-box-shadow:0 0 5px #afafaf;-webkit-box-shadow:0 0 5px #afafaf;-o-box-shadow:0 0 5px #afafaf;box-shadow:0 0 5px #afafaf;filter:progid:DXImageTransform.Microsoft.Shadow(color=#afafaf,Direction=134,Strength=5)">
			<tr>
				<td class="space" style="width:20px;padding:7px 0">&nbsp;</td>
				<td align="center" style="padding:7px 0">
					<table class="table" bgcolor="#ffffff" style="width:100%">
						<tr bgcolor="#ED3733">
							<td align="center" class="logo" style="border-bottom:4px solid #333333;padding:7px 0">
								<a title="<?=$site[0]->title;?>" href="<?=base_url();?>" style="color:#fff; text-decoration:none;"><h2 style="    margin-top: 13px;">Password reset instructions</h2></a>							</td>
						</tr>

<tr>
	<td align="center" class="titleblock" style="padding:7px 0">
		<font size="2" face="Open-sans, sans-serif" color="#555454">
			<span class="title" style="font-weight:500;font-size:28px;text-transform:uppercase;line-height:33px">Hi <?=ucfirst($data[0]->fullname);?>,</span><br/>
			<span class="subtitle" style="font-weight:500;font-size:16px;text-transform:uppercase;line-height:25px"> </span>		</font>	</td>
</tr>
<tr>
	<td class="space_footer" style="padding:0!important">&nbsp;</td>
</tr>
<tr>
	<td>
		<p>Someone requested that the password be reset for the following account:</p>

		<p>If this was a mistake, just ignore this email and nothing will happen.</p>

		<p>To reset your password, visit the following address:</p>

		<p><a href="<?=base_url().'Forgot/password/'.urlencode($forgot_key).'/'.urlencode($id).'/'.url_title($data[0]->fullname,'-');?>" target="_blank">Click here to reset your password</a></p>
	</td>
</tr>
<tr>
	<td></td>
</tr>

						<tr>
							<td class="space_footer" style="padding:0!important">&nbsp;</td>
						</tr>
						<tr>
							<td class="footer" style="border-top:4px solid #333333;padding:7px 0">
								<div><span style="text-align:left;width:50%;float:left;"><a href="<?=base_url();?>" style="color:#337ff1"> <?=$_SERVER['SERVER_NAME'];?></a></span> <span style="text-align:right;width:50%;"><?=$site[0]->footer_right;?></span></div>							</td>
						</tr>
					</table>
				</td>
				<td class="space" style="width:20px;padding:7px 0">&nbsp;</td>
			</tr>
		</table>
	</body>
</html>