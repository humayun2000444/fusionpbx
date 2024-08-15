<?php
/*
Humayun

Humayun

	Contributor(s):
	Matthew Vale <github@mafoo.org>
*/

//includes files
	require_once dirname(__DIR__, 2) . "/resources/require.php";
	require_once "resources/check_auth.php";

//check permissions
	if (permission_exists('number_translation_add') || permission_exists('number_translation_edit')) {
		//access granted
	}
	else {
		echo "access denied";
		exit;
	}

//set the variables
	$cmd = $_GET['cmd'];
	$rdr = $_GET['rdr'];

//create the event socket connection
	$esl = event_socket::create();
	if ($esl->is_connected()) {
		//reloadxml
			if ($cmd == "api reloadxml") {
				message::add(rtrim(event_socket::command($cmd)), 'alert');
				unset($cmd);
			}

		//reload mod_translate
			if ($cmd == "api reload mod_translate") {
				message::add(rtrim(event_socket::command($cmd)), 'alert');
				unset($cmd);
			}

	}

//redirect the user
	if ($rdr == "false") {
		//redirect false
		echo $response;
	}
	else {
		header("Location: number_translations.php");
	}

?>
