<?php 

/*
Plugin Name: Basic Authentication
Plugin URI: http://www.cuvedev.net/2010/07/wordpress-plugin-authentication/
Description: Disable access to wordpress if not logged in
Author: Klaas Cuvelier
Author URI: http://www.cuvedev.net
Version: 1.9
*/


	/**
	 * WordPress contest which ask authentication to the users before showing the site
	 * 
	 * @copyright 	Klaas Cuvelier
	 * @author 		Klaas Cuvelier, cuvelierklaas@gmail.com (http://www.cuvedev.net)
	 * @version		1.9
	 * @license		GPL v2.0
	 * 
	 */

	add_action('init', 'basic_auth_init');
	add_action('admin_menu', 'basic_auth_admin');
	
	// do the checking
	function basic_auth_init() 
	{	
		// check if plugin is enabled
		if (get_option('basic_authentication_enabled', '') !== 'on')
		{
			return;
		}
		
		// get current page
		$url = str_replace(site_url(), '', 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);		
		list($url, $crap) = explode('?', $url);

        // extra check when WP isn't installed in root dir - thx @ Rob Record
        $wp_dir = str_replace('http://' . $_SERVER['HTTP_HOST'], '', site_url());
        $redirect_url = $wp_dir . $url;
		

		// check if not login-page or admin-panel
		if ($url !== '/wp-login.php' && substr($url, 0, 9) !== '/wp-admin' && substr($url, 0, 11) !== '/xmlrpc.php')
		{
			$authMethod = get_option('basic_authentication_method', ''); 
	
			// check method and result
			if ($authMethod === 'predefined')
			{
				session_start();
				$login = basic_authentication_doLogin();
				
				if (!basic_authentication_predefinedLoggedIn())
				{
					basic_authentication_showLoginForm($login, implode('?', array($url, $crap)));
					exit;
				}
				
			}
			else if ($authMethod === 'wp-login'	&& !is_user_logged_in())
			{
				header('LOCATION: ' . site_url('wp-login.php?redirect_to=' . urlencode($redirect_url) . '&reauth=1'));
				exit;				
			}
		}
	}
	
	// add to admin menu
	function basic_auth_admin() 
	{
		add_options_page('Basic Authentication Options', 'Basic Authentication', 'manage_options', 'basic-authentication', 'basic_auth_options');
	}
	
	
	// check if basic_authentication logged in
	function basic_authentication_predefinedLoggedIn()
	{
		return $_SESSION['basic_authentication_loggedin'] === true && $_SESSION['basic_authentication_pwd'] === md5(get_option('basic_authentication_password'));	
	}
	
	
	// basic authentication check if try to login
	function basic_authentication_doLogin()
	{
		// time to deny logging in when tried to much (in minutes)
		$timeBlocked = 15;
		
		if (is_numeric($_SESSION['basic_authentication_tries']) && 	$_SESSION['basic_authentication_tries'] >= 3) 
		{
			$_SESSION['basic_authentication_tries'] = 0;
			$_SESSION['basic_authentication_block'] = time();
		}

		if (is_numeric($_SESSION['basic_authentication_block']))
		{
			if (time() - $_SESSION['basic_authentication_block'] > ($timeBlocked * 60))
			{
				$_SESSION['basic_authentication_block'] = 'NO';
				unset($_SESSION['basic_authentication_block']);
			}
			else
			{
				return 'Too many login attempts, your account has been blocked temporarily.';
			}
		}
		
		
		if (isset($_POST['pwd']))
		{
			if ($_POST['pwd'] === get_option('basic_authentication_password'))
			{
				$_SESSION['basic_authentication_loggedin'] 	= true;					
				$_SESSION['basic_authentication_tries'] 	= 0;
				$_SESSION['basic_authentication_pwd'] 		= md5(get_option('basic_authentication_password'));
				return 'OK';		
			}	
			else
			{
				$_SESSION['basic_authentication_tries'] = is_numeric($_SESSION['basic_authentication_tries']) ? $_SESSION['basic_authentication_tries'] + 1: 1;
				return 'ERROR';		
			}		
		}
	}
	
	
	// show basic_authentication login form
	function basic_authentication_showLoginForm($login, $url)
	{
		include(dirname(__FILE__) . '/basic-auth-login.php'); 
	}
	
	// basic auth options
	function basic_auth_options () 
	{
		include(dirname(__FILE__) . '/basic-auth-options.php');
	}

?>