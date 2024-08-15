<?php
/*
Humayun

Humayun

Humayun
*/

//includes files
	require_once dirname(__DIR__, 2) . "/resources/require.php";
	require_once "resources/check_auth.php";

//check permissions
	if (if_group("superadmin")) {
		//access granted
	}
	else {
		echo "access denied";
		exit;
	}

//set the variables
	$profile = $_GET['profile'] ?? null;
	$action = $_GET['action'];
	$gateway = $_GET['gateway'] ?? null;

//validate the sip profile name
	$sql = "select sip_profile_name from v_sip_profiles ";
	$sql .= "where sip_profile_name = :profile_name ";
	$parameters['profile_name'] = $profile;
	$database = new database;
	$profile_name = $database->select($sql, $parameters, 'column');
	unset($sql, $parameters);

//get the port from sip profile name
	$sql = "select sip_profile_setting_value from v_sip_profile_settings ";
	$sql .= "where sip_profile_uuid = (select sip_profile_uuid from v_sip_profiles where sip_profile_name = :profile_name limit 1) ";
	$sql .= "and sip_profile_setting_name = 'sip-port' ";
	$sql .= "and sip_profile_setting_enabled = 'true' ";
	$sql .= "limit 1";
	$parameters['profile_name'] = $profile;
	$profile_port = $database->select($sql, $parameters, 'column');
	unset($sql, $parameters);

//get the tls port from sip profile name
	$sql = "select sip_profile_setting_value from v_sip_profile_settings ";
	$sql .= "where sip_profile_uuid = (select sip_profile_uuid from v_sip_profiles where sip_profile_name = :profile_name limit 1) ";
	$sql .= "and sip_profile_setting_name = 'tls-sip-port' ";
	$sql .= "and sip_profile_setting_enabled = 'true' ";
	$sql .= "limit 1";
	$parameters['profile_name'] = $profile;
	$profile_tls_port = $database->select($sql, $parameters, 'column');
	unset($sql, $parameters);

//validate the gateway
	if (!empty($_GET['gateway']) && is_uuid($_GET['gateway'])) {
		$gateway_name = $_GET['gateway'];
	}

//build the commands
	switch ($action) {
		case "killgw":
			$command = "sofia profile '".$profile_name."' killgw ".$gateway_name;
			break;
		case "start":
			$command = "sofia profile '".$profile_name."' start";
			//ensure there are no stuck ports before trying to start the profile
			force_close_port($profile_port);
			force_close_port($profile_tls_port);
			break;
		case "stop":
			$command = "sofia profile '".$profile_name."' stop";
			break;
		case "restart":
			$command = "sofia profile '".$profile_name."' restart";
			break;
		case "flush_inbound_reg":
			$command = "sofia profile '".$profile_name."' flush_inbound_reg";
			break;
		case "rescan":
			$command = "sofia profile '".$profile_name."' rescan";
			break;
		case "cache-flush":
			$cache = new cache;
			$response = $cache->flush();
			message::add($response, 'alert');
			break;
		case "reloadxml":
			$command = "reloadxml";
			break;
		case "reloadacl":
			$command = "reloadacl";
			break;
		default:
			unset($action);
	}

//create the event socket connection
	$esl = event_socket::create();
	if ($esl->is_connected()) {
		//if reloadxml then run reloadacl, reloadxml and rescan the external profile for new gateways
			if (isset($command)) {
				//clear the apply settings reminder
					$_SESSION["reload_xml"] = false;

				//run the command
					$result = rtrim(event_socket::api($command));
			}

		//sofia profile
			if (isset($profile) && strlen($profile)) {
				message::add('<strong>'.$profile.'</strong> '.$result, 'alert', 3000);
			}
			else if (!empty($result)) {
				message::add($result, 'alert');
			}
	}

//redirect the user
	header("Location: sip_status.php");

?>
