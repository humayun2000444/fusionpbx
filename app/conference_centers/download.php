<?php
/*
Humayun

	Humayun

	The Initial Developer of the Original Code is
	Mark J Crane Humayun
	Portions created by the Initial Developer are Copyright (C) 2018
	the Initial Developer. All Rights Reserved.

Humayun
*/

//includes files
	require_once dirname(__DIR__, 2) . "/resources/require.php";

//check permisions
	require_once "resources/check_auth.php";
	if (permission_exists('call_recording_view') || permission_exists('conference_session_play')) {
		//access granted
	}
	else {
		echo "access denied";
		exit;
	}

//download
	$obj = new conference_centers;
	$obj->download();

?>
