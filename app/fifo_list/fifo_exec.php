<?php
/*
Humayun

	Humayun

	The Initial Developer of the Original Code is
	Mark J Crane Humayun
	Copyright (C) 2010 - 2019
	All Rights Reserved.

Humayun
*/

//includes files
	require_once dirname(__DIR__, 2) . "/resources/require.php";
	require_once "resources/check_auth.php";

//check permissions
	if (permission_exists('active_queue_edit')) {
		//access granted
	}
	else {
		echo "access denied";
		exit;
	}

//get variables
	if (is_array($_GET)>0) {
		$switch_cmd = trim($_GET["cmd"]);
		$action = trim($_GET["action"]);
		$direction = trim($_GET["direction"]);
	}

//GET to PHP variables
	if (is_array($_GET)) {
		//fs cmd
		if (!empty($switch_cmd)) {
			/*
			if ($action == "energy") {
				//conference 3001-example.dyndns.org energy 103
				$switch_result = event_socket::api($switch_cmd);
				$result_array = explode("=",$switch_result);
				$tmp_value = $result_array[1];
				if ($direction == "up") { $tmp_value = $tmp_value + 100; }
				if ($direction == "down") { $tmp_value = $tmp_value - 100; }
				//echo "energy $tmp_value<br />\n";
				$switch_result = event_socket::api($switch_cmd.' '.$tmp_value);
			}
			if ($action == "volume_in") {
				$switch_result = event_socket::api($switch_cmd);
				$result_array = explode("=",$switch_result);
				$tmp_value = $result_array[1];
				if ($direction == "up") { $tmp_value = $tmp_value + 1; }
				if ($direction == "down") { $tmp_value = $tmp_value - 1; }
				//echo "volume $tmp_value<br />\n";
				$switch_result = event_socket::api($switch_cmd.' '.$tmp_value);
			}
			if ($action == "volume_out") {
				$switch_result = event_socket::api($switch_cmd);
				$result_array = explode("=",$switch_result);
				$tmp_value = $result_array[1];
				if ($direction == "up") { $tmp_value = $tmp_value + 1; }
				if ($direction == "down") { $tmp_value = $tmp_value - 1; }
				//echo "volume $tmp_value<br />\n";
				$switch_result = event_socket::api($switch_cmd.' '.$tmp_value);
			}
			*/
		//connect to the event socket
			//$esl = event_socket::create();
		//send the command over event socket
			//if ($esl->is_connected()) {
			//	$switch_result = event_socket::api($switch_cmd);
			//}
		}

	}

?>
