<html>
	<head>
		<title>Facebook App Token Result</title>
		<link rel="stylesheet" type="text/css" href="style.css"/>
	</head>
	<body>
<?php
	require 'include.php';
	session_start();
	
	if($_SESSION['state'] && ($_SESSION['state'] === $_REQUEST['state']))
	{
		$token_url = "https://graph.facebook.com/oauth/access_token?" .
			"client_id=" . $_SESSION['appID'] .
			"&redirect_uri=" . urlencode(base_url() . $step3) .
			"&client_secret=" . $_SESSION['appSecret'] .
			"&code=" . $_REQUEST["code"]
		;

		$process = curl_init($token_url); 
		curl_setopt($process, CURLOPT_TIMEOUT, 30);
		curl_setopt($process, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($process, CURLOPT_SSL_VERIFYPEER, 0);
		$response = curl_exec($process);
		$responseCode = curl_getinfo($process, CURLINFO_HTTP_CODE);
		
		if ($response && $responseCode == 200)
		{
			$params = null; parse_str($response, $params);
			$token = $params['access_token'];
			$expiresRaw = $params['expires'];
			$expires = date("Y-m-d H:i:s", time() + intval($expiresRaw));

			?>
				<div id="result">
					<span class="highlight">Access token:</span>
					<br/>
					<textarea readonly="readonly"><?php echo $token ?></textarea>
					
					<?php if ($expiresRaw) { ?>
					<br/><br/>
					Expires on <span id="output-expires"><?php echo $expires ?></span>
					<?php } ?>
				</div>
			<?php
		}
		else
		{
			$errno = curl_errno ($process);
			$error = curl_error($process);
			
			?>
				<div id="error">
					Error <?php
						if ($errno)
						{
							echo $errno;
							if ($error) echo ': ' . $error;
						}
						else
							echo 'returned from Facebook API (status ' . $responseCode . '):'
					?>
					<br/><br/>
					<textarea readonly="readonly"><?php echo $response ?></textarea>
				</div>
			<?php
		}
		
		curl_close($process); 
	}
	else {
		echo("The state does not match. Please try again.");
	}
	
?>
	</body>
</html>