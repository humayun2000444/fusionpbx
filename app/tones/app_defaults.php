<?php
/*
Humayun

	Humayun

	The Initial Developer of the Original Code is
	Mark J Crane Humayun
	Portions created by the Initial Developer are Copyright (C) 2018
	the Initial Developer. All Rights Reserved.

Humayun
*/

if ($domains_processed == 1) {

	//Change ringtones to tones
	$sql = "select * from v_vars ";
	$sql .= "where var_category = 'Tones' ";
	$sql .= "and var_name like '%-ring%'; ";
	$database = new database;
	$ringtones = $database->select($sql, null, 'all');
	unset($sql);

	if (is_array($ringtones) && @sizeof($ringtones) != 0) {
		$sql = "update v_vars set ";
		$sql .= "var_category = 'Ringtones' ";
		$sql .= "where var_category = 'Tones' ";
		$sql .= "and var_name like '%-ring%'; ";
		$database = new database;
		$database->execute($sql);
		unset($sql);
	}

}

?>
