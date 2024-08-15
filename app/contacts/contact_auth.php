<?php
/*
Humayun

	Humayun

	The Initial Developer of the Original Code is
	Mark J Crane Humayun
	Portions created by the Initial Developer are Copyright (C) 2008-2013
	the Initial Developer. All Rights Reserved.

Humayun
*/
//includes files
require_once dirname(__DIR__, 2) . "/resources/require.php";
require_once "resources/check_auth.php";
if (permission_exists('contact_add')) {
	//access granted
}
else {
	echo "access denied";
	exit;
}

/*
echo "bang!";
exit;
*/

//add multi-lingual support
	$language = new text;
	$text = $language->get();


$_SESSION['contact_auth']['source'] = ($_SESSION['contact_auth']['source'] == '') ? $_REQUEST['source'] : $_SESSION['contact_auth']['source'];
$_SESSION['contact_auth']['target'] = ($_SESSION['contact_auth']['target'] == '') ? $_REQUEST['target'] : $_SESSION['contact_auth']['target'];


//google api authentication
if ($_SESSION['contact_auth']['source'] == 'google') {

	if ($_REQUEST['error']) {
		message::add(($text['message-'.$_REQUEST['error']] != '') ? $text['message-'.$_REQUEST['error']] : $_REQUEST['error'], 'negative');
		header("Location: ".$_SESSION['contact_auth']['referer']);
		unset($_SESSION['contact_auth']);
		exit;
	}

	if (isset($_REQUEST['signout'])) {
		unset($_SESSION['contact_auth']['token']);
		message::add($text['message-google_signed_out']);
		header("Location: https://www.google.com/accounts/Logout?continue=https://appengine.google.com/_ah/logout?continue=".(($_SERVER["HTTPS"] == "on") ? "https" : "http")."://".$_SERVER['HTTP_HOST'].PROJECT_PATH."/app/contacts/".$_SESSION['contact_auth']['referer']);
		exit;
	}

	if ($_GET['code'] == '') {
		header("Location: https://accounts.google.com/o/oauth2/auth?client_id=".$_SESSION['contact']['google_oauth_client_id']['text']."&redirect_uri=".(($_SERVER["HTTPS"] == "on") ? "https" : "http")."://".$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF']."&scope=https://www.google.com/m8/feeds/&response_type=code");
		exit;
	}
	else {
		$auth_code = $_GET["code"];
	}

	/*******************************************************************************************/
	// request access token

	$fields = array(
		'code' => urlencode($auth_code),
		'client_id' => urlencode($_SESSION['contact']['google_oauth_client_id']['text']),
		'client_secret' => urlencode($_SESSION['contact']['google_oauth_client_secret']['text']),
		'redirect_uri' => urlencode((($_SERVER["HTTPS"] == "on") ? "https" : "http")."://".$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF']),
		'grant_type' => urlencode('authorization_code')
		);

	foreach($fields as $key => $value) {
		$post_fields[] = $key.'='.$value;
	}
	$post_fields = implode("&", $post_fields);

	$curl = curl_init();
	curl_setopt($curl, CURLOPT_URL, 'https://accounts.google.com/o/oauth2/token');
	curl_setopt($curl, CURLOPT_POST, 5);
	curl_setopt($curl, CURLOPT_POSTFIELDS, $post_fields);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
	curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
	$result = curl_exec($curl);
	curl_close($curl);

	$response =  json_decode($result);
	$access_token = $response->access_token;

	if ($access_token != '') {
		// redirect to target script
		$_SESSION['contact_auth']['token'] = $access_token;
		header("Location: ".$_SESSION['contact_auth']['target']);
		exit;
	}

}
else {

	message::add($text['message-access_denied'], 'negative');
	header("Location: ".$_SESSION['contact_auth']['referer']);
	unset($_SESSION['contact_auth']);
	exit;

}
?>