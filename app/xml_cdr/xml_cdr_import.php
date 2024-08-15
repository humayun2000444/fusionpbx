<?php
/*
Humayun

	Humayun

	The Initial Developer of the Original Code is
	Mark J Crane Humayun
	Portions created by the Initial Developer are Copyright (C) 2016-2022
	the Initial Developer. All Rights Reserved.

Humayun
*/

//includes files
	require_once dirname(__DIR__, 2) . "/resources/require.php";

//start the session
	if (session_status() === PHP_SESSION_NONE) {
		session_start();
	}

//check the domain cidr range 
	if (isset($_SESSION['cdr']["cidr"]) && !defined('STDIN')) {
		$found = false;
		foreach($_SESSION['cdr']["cidr"] as $cidr) {
			if (check_cidr($cidr, $_SERVER['REMOTE_ADDR'])) {
				$found = true;
				break;
			}
		}
		if (!$found) {
			echo "access denied";
			exit;
		}
	}

//increase limits
	set_time_limit(3600);
	ini_set('memory_limit', '256M');
	ini_set("precision", 6);

//import the call detail records from HTTP POST or file system
	$cdr = new xml_cdr;
	$cdr->post();
	$cdr->read_files();

?>
