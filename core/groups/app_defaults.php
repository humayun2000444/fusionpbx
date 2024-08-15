<?php
/*
	Humayun
*/

if ($domains_processed == 1) {

	//if the default groups do not exist add them
		$group = new groups;
		$group->defaults();

	//find rows that have a null group_uuid and set the correct group_uuid
		$sql = "select * from v_user_groups ";
		$sql .= "where group_uuid is null; ";
		$database = new database;
		$result = $database->select($sql, null, 'all');
		if (is_array($result)) {
			foreach($result as $row) {
				if (!empty($row['group_name'])) {
					//get the group_uuid
						$sql = "select group_uuid from v_groups ";
						$sql .= "where group_name = :group_name ";
						$parameters['group_name'] = $row['group_name'];
						$database = new database;
						$group_uuid = $database->select($sql, $parameters, 'column');
						unset($sql, $parameters);

					//set the group_uuid
						$sql = "update v_user_groups set ";
						$sql .= "group_uuid = :group_uuid ";
						$sql .= "where user_group_uuid = :user_group_uuid; ";
						$parameters['group_uuid'] = $group_uuid;
						$parameters['user_group_uuid'] = $row['user_group_uuid'];
						$database = new database;
						$database->execute($sql, $parameters);
						unset($sql, $parameters);
				}
			}
			unset ($result);
		}

	//set the default group levels
		$sql = "select * from v_groups ";
		$sql .= "where group_level is null; ";
		$database = new database;
		$result = $database->select($sql, null, 'all');
		if (is_array($result) && count($result) > 0) {
			$x = 0;
			foreach($result as $row) {
				$array['groups'][$x]['group_uuid'] = $row['group_uuid'];
				switch ($row['group_name']) {
					case 'superadmin':
						$array['groups'][$x]['group_level'] = 80;
						break;
					case 'admin':
						$array['groups'][$x]['group_level'] = 50;
						break;
					case 'user':
						$array['groups'][$x]['group_level'] = 30;
						break;
					case 'agent':
						$array['groups'][$x]['group_level'] = 20;
						break;
					case 'public':
						$array['groups'][$x]['group_level'] = 10;
						break;
					default:
						$array['groups'][$x]['group_level'] = 10;
				}
				$x++;
			}
			$database = new database;
			$database->app_name = 'groups';
			$database->app_uuid = '2caf27b0-540a-43d5-bb9b-c9871a1e4f84';
			$database->save($array, false);
			unset($array);
		}

	//update the group_uuid
		$sql = "UPDATE v_group_permissions as p ";
		$sql .= "SET group_uuid = ( ";
		$sql .= "	SELECT group_uuid FROM v_groups as g  ";
		$sql .= "	WHERE g.group_name = p.group_name  ";
		$sql .= ") ";
		$sql .= "WHERE group_uuid is null; ";
		$parameters = null;
		$database = new database;
		$database->execute($sql, $parameters);
		unset($sql, $parameters);

	//drop the view_groups
		$database = new database;
		$database->execute("DROP VIEW view_groups;", null);

	//add or update the view
		$sql = "CREATE VIEW view_groups AS (";
		$sql .= "	select domain_uuid, group_uuid, group_name, ";
		$sql .= "	(select domain_name from v_domains where domain_uuid = g.domain_uuid) as domain_name, ";
		$sql .= "	(select count(*) from v_group_permissions where group_uuid = g.group_uuid) as group_permissions, ";
		$sql .= "	(select count(*) from v_user_groups where group_uuid = g.group_uuid) as group_members, ";
		$sql .= "	group_level, group_protected, group_description ";
		$sql .= "	from v_groups as g ";
		$sql .= ");";
		$database = new database;
		$database->execute($sql, null);
		unset($sql);

	//group permissions 
		$database = new database;
		$database->execute("update v_group_permissions set permission_protected = 'false' where permission_protected is null;", null);
		$database->execute("update v_group_permissions set permission_assigned = 'true' where permission_assigned is null;", null);

}

?>
