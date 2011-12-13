<?php
	/**
	 * WordPress contest which ask authentication to the users before showing the site
	 * 
	 * @copyright 	Klaas Cuvelier
	 * @author 		Klaas Cuvelier, cuvelierklaas@gmail.com (http://www.cuvedev.net)
	 * @version		1.9
	 * @license		GPL v2.0
	 * 
	 */
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="en-US">
	<head>
		<title><?php echo get_option('blogname'); ?> &rsaquo; Log In</title>
	
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<meta name='robots' content='noindex,nofollow' />
	
<?php if ((float)get_bloginfo('version') >= 3.3) { ?>
        <link rel='stylesheet' id='login-css'  href='<?php echo get_option('siteurl'); ?>/wp-admin/css/wp-admin.css' type='text/css' media='all' />
<?php } else { ?>
        <link rel='stylesheet' id='login-css'  href='<?php echo get_option('siteurl'); ?>/wp-admin/css/login.css' type='text/css' media='all' />
<?php } ?>
		<link rel='stylesheet' id='colors-fresh-css'  href='<?php echo get_option('siteurl'); ?>/wp-admin/css/colors-fresh.css' type='text/css' media='all' />
</head>
<body class="login">
<div id="login"><h1><a href="http://wordpress.org/" title="Powered by WordPress"><?php echo get_option('blogname'); ?></a></h1>

<form name="loginform" id="loginform" action="<?php echo site_url($url); ?>" method="post">
	<?php if ($login === 'ERROR') { ?>
	<div id="login_error">Wrong password. Try again</div>
	<?php } else if ($login !== 'OK' && !empty($login)) { ?>
	<div class="message"><?php echo $login; ?></div>
	<?php } 
	
	if (empty($login) || $login === 'ERROR') {?>	
	<p>
		<label>Password<br />
		<input type="password" name="pwd" id="user_pass" class="input" value="" size="20" tabindex="20" /></label>
	</p>
	<p class="submit">
		<input type="submit" name="wp-submit" id="wp-submit" class="button-primary" value="Log In" tabindex="100" />
	</p>
	<?php } ?>
</form>
</html>