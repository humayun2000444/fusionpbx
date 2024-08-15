<?php
/*
	Humayun
*/

//process this only one time
	if ($domains_processed == 1) {

		//set domains with enabled status of empty or null to true
			$sql = "update v_domains set domain_enabled = 'true' ";
			$sql .= "where domain_enabled = '' or domain_enabled is null ";
			$database = new database;
			$database->execute($sql, null);
			unset($sql);

	}
 
?>
