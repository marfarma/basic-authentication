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
	if (!isset($_REQUEST['_folder']) || !in_array($_REQUEST['_folder'], array('uploads', 'themes')))
	{
		exit;
	}

	require_once(dirname(__FILE__) . '/../../../wp-blog-header.php');
	require_once(dirname(__FILE__) . '/basic-authentication.php');
	
	basic_auth_init();

	if ($_REQUEST['_folder'] === 'uploads')
	{
		 $uploadInf = wp_upload_dir();
		chdir($uploadInf['basedir']);
	}
	else 
	{
		chdir(dirname(__FILE__) . '/../../themes');
	}

	$fileName = getcwd() . '/' . $_REQUEST['_protect'];

	if (file_exists($fileName) && substr(realpath($fileName), 0, strlen(realpath('.'))) === realpath('.') && is_file($fileName))
	{
		header("Expires: Mon, 26 Jul 1990 05:00:00 GMT");
		header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); 
		header("Cache-Control: no-store, no-cache, must-revalidate"); 
		header("Cache-Control: post-check=0, pre-check=0", false);
		header("Pragma: no-cache");
		
		print file_get_contents($fileName);
	}
	
?>