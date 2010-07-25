<?php 

/*
Plugin Name: Basic Authentication
Plugin URI: http://www.cuvedev.net
Description: Disable access to wordpress if not logged in
Author: Klaas Cuvelier
Version: 1.2
*/


	/**
	 * WordPress contest which ask authentication to the users before showing the site
	 * 
	 * @copyright 	Klaas Cuvelier
	 * @author 		Klaas Cuvelier, cuvelierklaas@gmail.com (http://www.cuvedev.net)
	 * @version		1.2
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
		list($url, $crap) = explode('?', $_SERVER['REQUEST_URI']);
	
		// check if not login-page or admin-panel
		if ($url !== '/wp-login.php' && substr($url, 0, 9) !== '/wp-admin')
		{
			$authMethod = get_option('basic_authentication_method', ''); 
	
			// check method and result
			if ($authMethod === 'predefined')
			{
				session_start();
				$login = basic_authentication_doLogin();
				
				if (!basic_authentication_predefinedLoggedIn())
				{
					basic_authentication_showLoginForm($login);
					exit;
				}
				
			}
			else if ($authMethod === 'wp-login'	&& !is_user_logged_in())
			{
				header('LOCATION: /wp-login.php?redirect_to=' . urlencode($url) . '&reauth=1');
				exit;				
			}
		}
	}
	
	// add to admin menu
	function basic_auth_admin() 
	{
		add_options_page('Basic Authentication Options', 'Basic Authentication', 'manage_options', 'basic-authentication', function () {;
			include(dirname(__FILE__) . '/basic-auth-options.php');
		});
	}
	
	
	// check if basic_authentication logged in
	function basic_authentication_predefinedLoggedIn()
	{
		return $_SESSION['basic_authentication_loggedin'] === true;	
	}
	
	
	// basic authentication check if try to login
	function basic_authentication_doLogin()
	{
		if (is_numeric($_SESSION['basic_authentication_tries']) && $_SESSION['basic_authentication_tries']++ > 3)
		{
			return 'You have tried to many times. You have been temporaraly blocked.';
		}
		
		if (isset($_POST['pwd']))
		{
			if ($_POST['pwd'] === get_option('basic_authentication_password'))
			{
				$_SESSION['basic_authentication_loggedin'] 	= true;	
				$_SESSION['basic_authentication_tries'] 	= 0;
				return 'OK';		
			}	
			else
			{
				$_SESSION['basic_authentication_tries'] = is_numeric($_SESSION['basic_authentication_tries']) ? $_SESSION['basic_authentication_tries']++ : 1;		
				return 'ERROR';		
			}		
		}
	}
	
	
	// show basic_authentication login form
	function basic_authentication_showLoginForm($login)
	{
		include(dirname(__FILE__) . '/basic-auth-login.php'); 
	}

?>