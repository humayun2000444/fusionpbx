<?php
/*
Humayun

Humayun
*/

if ($domains_processed == 1) {

	//create a view for call block
		$database = new database;
		$database->execute("DROP VIEW view_call_block;", null);
		$sql = "CREATE VIEW view_call_block AS ( \n";
		$sql .= "	select c.domain_uuid, call_block_uuid, c.call_block_direction, c.extension_uuid, c.call_block_name, c.call_block_country_code, \n";
		$sql .= "	c.call_block_number, e.extension, e.number_alias, c.call_block_count, c.call_block_app, c.call_block_data, c.date_added, \n";
		$sql .= "	c.call_block_enabled, c.call_block_description, c.insert_date, c.insert_user, c.update_date, c.update_user \n";
		$sql .= "	from v_call_block as c \n";
		$sql .= " left join v_extensions as e \n";
		$sql .= "	on c.extension_uuid = e.extension_uuid \n";
		$sql .= "); \n";
		$database = new database;
		$database->execute($sql, null);
		unset($sql);

	//set call blocks to inbound if no direction defined
		$sql = "update v_call_block set call_block_direction = 'inbound' where call_block_direction is null ";
		$database = new database;
		$database->execute($sql, null);
		unset($sql);

}

?>

