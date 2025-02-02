<?php
/*
Humayun

	Humayun

	The Initial Developer of the Original Code is
	Mark J Crane Humayun
	Portions created by the Initial Developer are Copyright (C) 2022
	the Initial Developer. All Rights Reserved.

Humayun
*/

//process this only one time
	if ($domains_processed == 1) {

		//if yealink_trust_certificates is true or false then update to 1 or 0
		$sql = "select default_setting_uuid, default_setting_value from v_default_settings ";
		$sql .= "where default_setting_subcategory = 'yealink_trust_certificates' ";
		$sql .= "and (default_setting_value = 'true' or default_setting_value = 'false');";
		$database = new database;
		$row = $database->select($sql, null, 'row');
		if (is_array($row)) {
			if ($row['default_setting_value'] == 'false') {
				$row['default_setting_value'] = '0';
			}
			else {
				$row['default_setting_value'] = '1';
			}
			$sql = "update v_default_settings ";
			$sql .= "set default_setting_value = ".$row['default_setting_value'].",  ";
			$sql .= "default_setting_description = 'Only Accept Trusted Certificates 0-Disabled (default), 1-Enabled.'  ";
			$sql .= "where default_setting_uuid = '".$row['default_setting_uuid']."'; ";
			$database = new database;
			$database->execute($sql, null);
			unset($sql);
		}

		//correct yealink_codec_opus_priority values
		if ($db_type == 'pgsql') {
			$sql = "select pg_typeof(default_setting_enabled) ";
			$sql .= "from v_default_settings limit 1;";
			$database = new database;
			$enabled_type = $database->select($sql, null, 'column');
			if ($enabled_type == 'text') {
				$sql = "update v_default_settings set default_setting_enabled = 'true', default_setting_value = '13'  ";
				$sql .= "where default_setting_uuid = 'a018c028-0f99-4ef8-869d-f5322636ae36' and default_setting_enabled = '13'; ";
				$database = new database;
				$database->execute($sql, null);
				unset($sql);
			}
		}

	}

