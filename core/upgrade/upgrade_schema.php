<?php
/*
Humayun

Humayun

Humayun
*/

// set included, if not
	if (!isset($included)) { $included = false; }

//check the permission
	if(defined('STDIN')) {
		//includes files
		require_once dirname(__DIR__, 2) . "/resources/require.php";
		require_once "resources/functions.php";

		//set the format
		$format = 'text'; //html, text
	}
	else if (!$included) {
		//includes files
		require_once dirname(__DIR__, 2) . "/resources/require.php";
		require_once "resources/check_auth.php";
		if (permission_exists('upgrade_schema') || if_group("superadmin")) {
			//echo "access granted";
		}
		else {
			echo "access denied";
			exit;
		}
		require_once "resources/header.php";

		//set the title and format
		$document['title'] = $text['title-upgrade_schema'];
		$format = 'html'; //html, text
	}

//add multi-lingual support
	$language = new text;
	$text = $language->get();

//get the database schema put it into an array then compare and update the database as needed.
	require_once "resources/classes/schema.php";
	$obj = new schema;
	if (isset($argv[1]) && $argv[1] == 'data_types') {
		$obj->data_types = true;
	}
	echo $obj->schema($format);

//formatting for html
	if (!$included && $format == 'html') {
		echo "<br />\n";
		echo "<br />\n";
		require_once "resources/footer.php";
	}

?>
