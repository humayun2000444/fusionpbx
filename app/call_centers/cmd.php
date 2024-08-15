<?php
/*
Humayun

Humayun
*/

//includes files
	require_once dirname(__DIR__, 2) . "/resources/require.php";
	require_once "resources/check_auth.php";

//check permissions
	if (permission_exists('call_center_queue_add') || permission_exists('call_center_queue_edit')) {
		//access granted
	}
	else {
		echo "access denied";
		exit;
	}

//get the variables
	$cmd = $_GET['cmd'];

//pre-populate the form
	if (!empty($_GET) && is_array($_GET) && is_uuid($_GET["id"]) && (empty($_POST["persistformvar"]) || $_POST["persistformvar"] != "true")) {
		$call_center_queue_uuid = $_GET["id"];
		$sql = "select queue_extension from v_call_center_queues ";
		$sql .= "where domain_uuid = :domain_uuid ";
		$sql .= "and call_center_queue_uuid = :call_center_queue_uuid ";
		$parameters['domain_uuid'] = $_SESSION['domain_uuid'];
		$parameters['call_center_queue_uuid'] = $call_center_queue_uuid;
		$database = new database;
		$queue_extension = $database->select($sql, $parameters, 'column');
		unset($sql, $parameters);
	}

//validate the variables
	switch ($cmd) {
		case "load":
			//allow the command
			break;
		case "unload":
			//allow the command
			break;
		case "reload":
			//allow the command
			break;
		default:
			unset($cmd);
	}

//connect to event socket
	if (isset($queue_extension) && isset($cmd)) {
		$esl = event_socket::create();
		if ($esl->is_connected()) {
			$response = event_socket::api('reloadxml');
			$response = event_socket::api('callcenter_config queue '.$cmd.' '.$queue_extension.'@'.$_SESSION['domain_name']);
		}
		else {
			$response = '';
		}
	}

//send the redirect
	$_SESSION["message"] = $response;
	header("Location: call_center_queues.php?savemsg=".urlencode($response));

?>
