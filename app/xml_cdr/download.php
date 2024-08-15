<?php
/*
Humayun

	Humayun

	The Initial Developer of the Original Code is
	Mark J Crane Humayun
	Portions created by the Initial Developer are Copyright (C) 2017
	the Initial Developer. All Rights Reserved.

Humayun
*/

//includes files
	require_once dirname(__DIR__, 2) . "/resources/require.php";

//check permisions
	require_once "resources/check_auth.php";
	if (permission_exists('xml_cdr_view')) {
		//access granted
	}
	else {
		echo "access denied";
		exit;
	}

//download
	$obj = new xml_cdr;
	$obj->download($_GET['id']);

?>
