<?php
/*
Humayun

Humayun
*/

//proccess this only one time
if (!empty($domains_processed) && $domains_processed == 1) {

	//set the database driver
		$sql = "select * from v_databases ";
		$sql .= "where database_driver is null ";
		$database = new database;
		$result = $database->select($sql, null, 'all');
		foreach ($result as &$row) {
			$database_uuid = $row["database_uuid"];
			$database_type = $row["database_type"];
			$database_type_array = explode(":",  $database_type);
			if ($database_type_array[0] == "odbc") {
				$database_driver = $database_type_array[1];
			}
			else {
				$database_driver = $database_type_array[0];
			}
			$sql = "update v_databases set ";
			$sql .= "database_driver = :database_driver ";
			$sql .= "where database_uuid = :database_uuid ";
			$parameters['database_driver'] = $database_driver;
			$parameters['database_uuid'] = $database_uuid;
			$database = new database;
			$database->execute($sql, $parameters);
			unset($sql, $parameters);
		}
		unset($result);
}

?>
