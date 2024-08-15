<?php
/*
Humayun

Humayun
*/

//includes files
require_once dirname(__DIR__, 2) . "/resources/require.php";
require_once "resources/check_auth.php";
if (permission_exists('call_broadcast_send')) {
	//access granted
}
else {
	echo "access denied";
	exit;
}

//add multi-lingual support
	$language = new text;
	$text = $language->get();

//get the html values and set them as variables
	$uuid = trim($_GET["id"]);

	if (is_uuid($uuid)) {
		//show the result
			if (count($_GET) > 0) {
				$fp = event_socket::create();
				if ($fp !== false) {
					$cmd = "sched_del ".$uuid;
					$result = event_socket::api($cmd);
					message::add(htmlentities($result));
				}
			}

		//redirect
			header('Location: call_broadcast_edit.php?id='.$uuid);
			exit;
	}

//default redirect
	header('Location: call_broadcasts.php');
	exit;

?>