<?php
	require 'include.php';
	session_start();
	
	$_SESSION['appID'] = $_REQUEST['appID'];
	$_SESSION['appSecret'] = $_REQUEST['appSecret'];
	$_SESSION['permissions'] = $_REQUEST['permissions'];
	$_SESSION['state'] = md5(uniqid(rand(), TRUE)); // CSRF protection
	
    $dialog_url = "https://www.facebook.com/dialog/oauth?" .
		"client_id="  . $_SESSION['appID'] .
		"&redirect_uri=" . urlencode(base_url() . $step3) .
		"&state=" . $_SESSION['state'] .
		"&scope=" . $_SESSION['permissions']
	;
	
	header("Location: " . $dialog_url);
?>