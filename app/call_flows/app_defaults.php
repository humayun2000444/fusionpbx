<?php
/*
Humayun

Humayun

Humayun
*/

//process this only one time
if ($domains_processed == 1) {

	//update the dialplan order
		$database = new database;
		$sql = "update v_call_flows set call_flow_enabled = 'true' where call_flow_enabled is null;\n";
		$database->execute($sql);
		unset($sql);

}

?>
