<?php
/*
	Humayun
*/


if ($domains_processed == 1) {

	//update the notifications table
	//if (is_array($_SESSION['switch']['scripts'])) {
	//	$sql = "select count(*) from v_notifications ";
	//	$database = new database;
	//	$num_rows = $database->select($sql, null, 'column');
	//	if ($num_rows == 0) {
	//		//build insert array
	//			$array['notifications'][0]['notification_uuid'] = uuid();
	//			$array['notifications'][0]['project_notifications'] = 'false';
	//		//grant temporary permissions
	//			$p = new permissions;
	//			$p->add('notification_add', 'temp');
	//		//execute insert
	//			$database = new database;
	//			$database->app_name = 'notifications';
	//			$database->app_uuid = 'e746fbcb-f67f-4e0e-ab64-c414c01fac11';
	//			$database->save($array, false);
	//			unset($array);
	//		//revoke temporary permissions
	//			$p->delete('notification_add', 'temp');
	//	}
	//	unset($sql, $num_rows);
	//}

}

?>
