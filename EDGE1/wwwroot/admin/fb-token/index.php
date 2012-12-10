<?php
	require 'include.php';	
	$redirect = '/admin/fb-token/step2.php';
?>

<html>
	<head>
		<title>Facebook App Token Generator</title>
		<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
		
		<style type="text/css">
			body {
				height: 100%;
			}
			#form {
				margin-bottom: 10px;
			}
				#form .field {
					margin-bottom: 5px;
				}

				.clear {
					clear: both;
				}

				#form .field .field-name {
					width: 200px;
					float: left;
				}

				#form .field input[type=text] {
					width: 300px;
				}

				#form input[type=button] {
					margin-left: 200px;
					display: block;
				}
			
			#dialog {
				display: none;
				position: absolute;
				width: 480px;
				height: 360px;
				border: 1px solid #999;
				box-shadow: -3px -3px 10px 5px rgba(0,0,0,0.3);
				background-color: #fff;
			}
			
				#dialog #iframe{
					border: 0;
					width: 100%;
					height: 100%;
				}
			
			#result {
				display: none
			}
			
			.comment {
				font-size: 10px;
			}
		</style>
	</head>
	
	<body>
		<h1>Facebook App Token Generator</h1>
		<p>Make sure to login as a Facebook user with access to the required ad accounts.</p>
		<div>
			<div id="form">
				<div class="field">
					<div class="field-name">App ID</div>
					<input type="text" id="field-appID"/>
					<div class="clear"></div>
				</div>
				<div class="field">
					<div class="field-name">App Secret</div>
					<input type="text" id="field-appSecret"/>
					<div class="clear"></div>
				</div>
				<div class="field">
					<div class="field-name">Permissions<br/><span class="comment">(comma separated)</span></div>
					<input type="text" id="field-permissions" value="ads_management"/>
					<div class="clear"></div>
				</div>
				<input type="button" value="Submit" id="form-submit"/>
			</div>
		</div>
		<script type="text/javascript">
			$(window).load(function() {
				$('#form-submit').click(function(){
					var $dialog = $('#dialog')
					$dialog
						.css({
							left: $(window).width()/2 - $dialog.width()/2,
							top: $(window).height()/2 - $dialog.height()/2
						})
						.show();
					$('#iframe').attr('src', '<?php echo base_url() . $redirect ?>');
				});
				
				window.accessTokenReceived = function(token, expires) {
					$('#dialog').hide();
					$('#result').show();
					$('output-token').attr('value', token);
					$('output-expires').html(expires);
				};
			});

		</script>
		<div id="dialog">
			<iframe id="iframe">
			</iframe>
		</div>
		
		<div id="result">
			Access token <input type="text" readonly="readonly" id="output-token"/>
			expires on <span id="output-expires"></span>
		</div>
	</body>
	
</html>