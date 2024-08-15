<?php
/*
Humayun

	Humayun

	The Initial Developer of the Original Code is
	Mark J Crane Humayun
	Portions created by the Initial Developer are Copyright (C) 2008-2015
	the Initial Developer. All Rights Reserved.

Humayun
*/
//includes files
	require_once dirname(__DIR__, 2) . "/resources/require.php";
	require_once "resources/check_auth.php";
	if (!permission_exists('contact_time_add')) { echo "access denied"; exit; }

//get contact and time uuids
	$domain_uuid = $_REQUEST['domain_uuid'];
	$contact_uuid = $_REQUEST['contact_uuid'] ?? '';
	$contact_time_uuid = $_REQUEST['contact_time_uuid'];

//get time quantity
	$sql = "select ";
	$sql .= "time_start ";
	$sql .= "from v_contact_times ";
	$sql .= "where domain_uuid = :domain_uuid ";
	$sql .= "and contact_time_uuid = :contact_time_uuid ";
	$sql .= "and user_uuid = :user_uuid ";
	$sql .= "and contact_uuid = :contact_uuid ";
	$sql .= "and time_start is not null ";
	$sql .= "and time_stop is null ";
	$parameters['domain_uuid'] = $domain_uuid;
	$parameters['contact_uuid'] = $contact_uuid;
	$parameters['user_uuid'] = $_SESSION['user']['user_uuid'];
	$parameters['contact_time_uuid'] = $contact_time_uuid;
	$database = new database;
	$row = $database->select($sql, $parameters, 'row');
	if (!empty($row)) {
		$time_start = strtotime($row["time_start"]);
		$time_now = strtotime(date("Y-m-d H:i:s"));
		$time_diff = gmdate("H:i:s", ($time_now - $time_start));
		echo $time_diff;
		echo "<script id='title_script'>set_title('".$time_diff."');</script>";
	}
	unset ($sql, $parameters, $row);
?>
