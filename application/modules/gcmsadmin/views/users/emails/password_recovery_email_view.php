<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Password Reset</title>
<link href='http://fonts.googleapis.com/css?family=Amaranth:regular,bold' rel='stylesheet' type='text/css'>
<style type="text/css">
body { font-family:Helvetica, Arial, sans-serif; background:#bedae8; color:#617a86; margin:0; padding:0; }
h1, h2, h3 { font-family: 'Amaranth', arial, serif; }
#uclogo {
	background-image: url(<?=base_url()?>com_images/logo.png);
	margin-top: 250px;
	margin-right: auto;
	margin-left: auto;
	background-repeat: no-repeat;
	height: 75px;
	width: 255px;
}
</style>


</head>	
<body>
<div id="header">
	
     <a href="<?=base_url()?>"> <div id="uclogo" class="login-logo"></div></a>
     <div class="clear"></div>
	<h1>Admin Password Recovery Email</h1>
	
	
</div>

hello! <?=$name?>,<br>
you or somebody requested a password reset code on
 <?php
$datestring = "%m/%d/%Y - %h:%i:%a";
		$time = time();
		echo mdate($datestring, $time);
?>
<br>
click on the link bellow to change your password.<br>
<a href="<?=base_url()?>gcmsadmin/login/reset_password/<?=$reset_code?>" target="_blank"><?=base_url()?>gcmsadmin/login/reset_password/<?=$reset_code?></a>

<br>
Thank you.




</body>
</html>