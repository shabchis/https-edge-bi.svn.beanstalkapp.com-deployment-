<?php
	require 'include.php';
	session_start();
	
	if($_SESSION['state'] && ($_SESSION['state'] === $_REQUEST['state']))
	{
		$token_url = "https://graph.facebook.com/oauth/access_token?" .
			"client_id=" . $_SESSION['appID'] .
			"&redirect_uri=" . urlencode(base_url()) .
			"&client_secret=" . $_SESSION['appSecret'] .
			"&code=" . $_REQUEST["code"] .
			"&scope=" . $_SESSION['permissions']
		;

		$response = file_get_contents($token_url);
		$params = null; parse_str($response, $params);
		
		$token = $params['access_token'];
		$expiresRaw = $params['expires'];
		$expires = date('D M H:i:s Y', time() + intval($expiresRaw));
		
		?>
			<div id="result">
				Access token <input type="text" readonly="readonly" id="output-token" value="<?php echo $token ?>"/>
				expires on <span id="output-expires"><?php echo $expires ?></span>
			</div>
		<?php
	}
	else {
		echo("The state does not match. Please try again.");
	}
	
?>