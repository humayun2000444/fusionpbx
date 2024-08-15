<?php
/*
 Humayun
*/

//includes files
	require_once dirname(__DIR__, 2) . "/resources/require.php";
	require_once "resources/check_auth.php";

//check permissions
	if (permission_exists('access_control_view')) {
		//access granted
	}
	else {
		echo "access denied";
		exit;
	}

//set the variables
	$search = $_REQUEST['search'] ?? '';

//run the command
	$result = rtrim(event_socket::api('reloadacl'));

//add message
	message::add($result, 'alert');

//redirect
	$search = preg_replace('#[^a-zA-Z0-9_\-\.]# ', '', $search);
	$location = 'access_controls.php'.($search != '' ? "?search=".urlencode($search) : null);

	header("Location: ".$location);

?>
