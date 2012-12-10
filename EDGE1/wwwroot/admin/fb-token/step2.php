<?php
	require 'include.php';
	session_start();
	
	$redirect = '/admin/fb-token/step3.php';
	
	$_SESSION['appID'] = $_REQUEST['appID'];
	$_SESSION['appSecret'] = $_REQUEST['appSecret'];
	$_SESSION['permissions'] = $_REQUEST['permissions'];
	$_SESSION['state'] = md5(uniqid(rand(), TRUE)); // CSRF protection
	
    $dialog_url = "https://www.facebook.com/dialog/oauth?" .
		"client_id="  . $_SESSION['appID'] .
		"&redirect_uri=" . urlencode(base_url() . $redirect) .
		"&state=" . $_SESSION['state']
	;
	
	echo("<script> self.location.href='" . $dialog_url . "'</script>");
?>