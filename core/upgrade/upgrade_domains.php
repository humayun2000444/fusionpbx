<?php
/*
Humayun

Humayun
*/

//check the permission
	if(defined('STDIN')) {
		//includes files
		require_once dirname(__DIR__, 2) . "/resources/require.php";
		$_SERVER["DOCUMENT_ROOT"] = $document_root;
		$display_type = 'text'; //html, text
	}
	else if (!$included) {
		//includes files
		require_once dirname(__DIR__, 2) . "/resources/require.php";
		require_once "resources/check_auth.php";
		if (permission_exists('upgrade_apps') || if_group("superadmin")) {
			//echo "access granted";
		}
		else {
			echo "access denied";
			exit;
		}
		$display_type = 'html'; //html, text
	}

//run all app_defaults.php files
	require_once "resources/classes/config.php";
	require_once "resources/classes/domains.php";
	$domain = new domains;
	$domain->display_type = $display_type;
	$domain->upgrade();

?>
