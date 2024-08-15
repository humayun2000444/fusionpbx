<?php
/*
Humayun

Humayun

Humayun
*/

if ($domains_processed == 1) {

	//unset array if it exists
		if (isset($array)) { unset($array); }

	//update the software table
		$sql = "select software_version from v_software ";
		$database = new database;
		$software_version = $database->select($sql, null, 'column');
		if (empty($software_version)) {
			$array['software'][0]['software_uuid'] = '7de057e7-333b-4ebf-9466-315ae7d44efd';
			$array['software'][0]['software_name'] = 'CCL';
			$array['software'][0]['software_url'] = 'https://www.cosmocom.com';
			$array['software'][0]['software_version'] = software::version();
		}
		elseif ($software_version != software::version()) {
			$array['software'][0]['software_uuid'] = '7de057e7-333b-4ebf-9466-315ae7d44efd';
			$array['software'][0]['software_version'] = software::version();
		}

	//save the data in the array
		if (!empty($array)) {
			//add the temporary permission
			$p = new permissions;
			$p->add("software_add", 'temp');
			$p->add("software_edit", 'temp');

			//save the data
			$database = new database;
			$database->app_name = 'software';
			$database->app_uuid = 'b88c795f-7dea-4fc8-9ab7-edd555242cff';
			$database->save($array, false);
			unset($array);

			//remove the temporary permission
			$p->delete("software_add", 'temp');
			$p->delete("software_edit", 'temp');
		}

}

?>
