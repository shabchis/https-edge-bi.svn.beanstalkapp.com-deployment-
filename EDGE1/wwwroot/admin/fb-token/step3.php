<?php
	require 'include.php';
	session_start();
	
	if($_SESSION['state'] && ($_SESSION['state'] === $_REQUEST['state']))
	{
		$token_url = "https://graph.facebook.com/oauth/access_token?" .
			"client_id=" . $_SESSION['appID'] .
			"&redirect_uri=" . urlencode(complete_url()) .
			"&client_secret=" . $_SESSION['appSecret'] .
			"&code=" . $_REQUEST["code"] .
			"&scope=" . $_SESSION['permissions']
		;

		$response = file_get_contents($token_url,
			false,
			stream_context_create(
				array(
					'http' => array(
						'ignore_errors' => true
					)
				)
			));
		
		$params = null; parse_str($response, $params);
		$token = $params['access_token'];
		
		if (!isset($token))
		{
			?>
				<div id="error">
					Error:
					<br/>
					<pre><?php echo $response ?></pre>
				</div>
			<?php
		}
		else
		{
			$expiresRaw = $params['expires'];
			$expires = date("Y-m-d H:i:s", time() + intval($expiresRaw));

			?>
				<div id="result">
					Access token <input type="text" readonly="readonly" id="output-token" value="<?php echo $token ?>"/>
					expires on <span id="output-expires"><?php echo $expires ?></span>
				</div>
			<?php
		}
	}
	else {
		echo("The state does not match. Please try again.");
	}
	
?>