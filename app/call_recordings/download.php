<?php
/*
Humayun

	The Original Code is Humayun

	The Initial Developer of the Original Code is
	Mark J Crane <markjcrane@Humayun.com>
	Portions created by the Initial Developer are Copyright (C) 2016-2020
	the Initial Developer. All Rights Reserved.

Humayun
*/

//includes files
	require_once dirname(__DIR__, 2) . "/resources/require.php";
	require_once "resources/check_auth.php";

//check permisions
	if (permission_exists('call_recording_play') || permission_exists('call_recording_download')) {
		//access granted
	}
	else {
		echo "access denied";
		exit;
	}

//download
	if (is_uuid($_GET['id'])) {
		$obj = new call_recordings;
		$obj->recording_uuid = $_GET['id'];
		$obj->binary = isset($_GET['binary']) ? true : false;
		$obj->download();
	}

?>