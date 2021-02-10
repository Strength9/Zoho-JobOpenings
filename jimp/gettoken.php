<?php

/*

Once you have processed the refresh token you do not need the page again.
Generate the below information from 

https://api-console.zoho.com/

You will Need 

"Client Name" - API Name 
"Homepage URL" - Homepage of your APP
"Authorized Redirect URIs" - The URL of this page i.e { https://youraddress.com/jimp/gettoken.php } - > You will need this on the jimp_process.php script

*/

$JimpClientID='YOUR API CLIENT ID';
$JimpClientSecret='YOUR API CLIENT SECRET';
$JimpRedirectURL='https://XXXX.XXX/jimp/gettoken.php';

?>

<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Get Refresh Token</title>
</head>
	
<body>
	<h2>STEP 1 of 2 -  submit this form to go to step 2</h2>
	<form action="https://accounts.zoho.com/oauth/v2/auth" method="get">
		<table>
			<tr>
				<td>Scope</td>
				<td><input type="text" name="scope" size = "32" value="ZohoRecruit.modules.all"></td>
			</tr>
			<tr>
				<td>Client ID</td>
				<td><input type="text" name="client_id" size = "64" value="<?php echo $JimpClientID;?>"></td>
			</tr>
			<tr>
				<td>Response Type</td>
				<td><input type="text" name="response_type" size = "16" value="code"></td>
			</tr>
			<tr>
				<td>Access Type</td>
				<td><input type="text" name="access_type" size = "16" value="offline"></td>
			</tr>
			<tr>
				<td>Redirect URI</td>
				<td><input type="text" name="redirect_uri" size = "80" value="<?php echo $JimpRedirectURL;?>"></td>
			</tr>
			<tr>
				<td colspan="2"><input type="submit" value="Get Auth Code"><input type="reset" value="Cancel"></td>
			</tr>
		</table>
	</form>
	
	<?php if ($_GET["code"]) {
	?>
	<hr>
	<h2>STEP 2 of 2 - submit this form and you will get a JSON response containing the access token and the refresh token. - you NEED to copy the refresh token to use in Jimp Process Script</h2>
	<form action="https://accounts.zoho.com/oauth/v2/token" method="post">
		<table>
			<tr>
				<td>grant_type</td>
				<td><input type="text" name="grant_type" size="32" value="authorization_code"></td>
			</tr>
			<tr>
				<td>Client ID</td>
				<td><input type="text" name="client_id" size="64" value="<?php echo $JimpClientID;?>"></td>
			</tr>
			<tr>
				<td>client_secret</td>
				<td><input type="text" name="client_secret" size="80" value="<?php echo $JimpClientSecret;?>"></td>
			</tr>
			<tr>
				<td>Redirect URI</td>
				<td><input type="text" name="redirect_uri" size="80" value="<?php echo $JimpRedirectURL;?>"></td>
			</tr>
			<tr>
				<td>Code</td>
				<td><input type="text" name="code" size="80" value="<?php echo $_GET["code"]; ?>"></td>
			</tr>
			<tr>
				<td colspan="2"><input type="submit" value="Get Access Token"><input type="reset" value="Cancel"></td>
			</tr>
		</table>
	</form>
	
	
	<?php }
	?>
</body>
</html>