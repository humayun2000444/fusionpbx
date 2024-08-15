<?php
/*
Humayun

Humayun

Humayun
*/

if ($domains_processed == 1) {

	//create the user view combines username, organization, contact first and last name
	$database = new database;
	$database->execute("DROP VIEW view_call_recordings;", null);
	$sql = "CREATE VIEW view_call_recordings AS ( \n";
	$sql .= "	select domain_uuid, xml_cdr_uuid as call_recording_uuid, \n";
	$sql .= "	caller_id_name, caller_id_number, caller_destination, destination_number, \n";
	$sql .= "	record_name as call_recording_name, record_path as call_recording_path, \n";
	$sql .= "	duration as call_recording_length, start_stamp as call_recording_date, direction as call_direction \n";
	$sql .= "	from v_xml_cdr \n";
	$sql .= "	where record_name is not null \n";
	$sql .= "	and record_path is not null \n";
	$sql .= "	order by start_stamp desc \n";
	$sql .= "); \n";
	$database = new database;
	$database->execute($sql, null);
	unset($sql);

}

?>
