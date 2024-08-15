<?php
/*
Humayun

Humayun
*/

//includes files
	require_once dirname(__DIR__, 2) . "/resources/require.php";
	require_once "resources/check_auth.php";

//check permissions
	if (permission_exists('menu_edit')) {
		//access granted
	}
	else {
		echo "access denied";
		return;
	}

//add multi-lingual support
	$language = new text;
	$text = $language->get();

//move down more than one level at a time
//update v_menu_items set menu_item_order = (menu_item_order+1) where menu_item_order > 2 or menu_item_order = 2

if (count($_GET)>0) {
	$menu_item_id = $_GET["menu_item_id"];
	$menu_item_order = $_GET["menu_item_order"];
	$menu_parent_guid = $_GET["menu_parent_guid"];

	$sql = "select menu_item_order from v_menu_items ";
	$sql .= "where domain_uuid = :domain_uuid ";
	$sql .= "order by menu_item_order desc ";
	$sql .= "limit 1 offset 0";
	$parameters['domain_uuid'] = $domain_uuid;
	$database = new database;
	$highestmenu_item_order = $database->select($sql, $parameters, 'column');

	if ($menu_item_order != $highestmenu_item_order) {
		//clear the menu session so it will rebuild with the update
			$_SESSION["menu"] = "";

		//move the current item's order number up
			$sql  = "update v_menu_items set ";
			$sql .= "menu_item_order = (menu_item_order - 1) "; //move down
			$sql .= "where domain_uuid = :domain_uuid ";
			$sql .= "and menu_item_order = :menu_item_order ";
			$parameters['domain_uuid'] = $domain_uuid;
			$parameters['menu_item_order'] = $menu_item_order + 1;
			$database = new database;
			$database->app_name = 'menu';
			$database->app_uuid = 'f4b3b3d2-6287-489c-2a00-64529e46f2d7';
			$database->execute($sql, $parameters);
			unset($sql, $parameters);

		//move the selected item's order number down
			$sql  = "update v_menu_items set ";
			$sql .= "menu_item_order = (menu_item_order + 1) "; //move up
			$sql .= "where domain_uuid = :domain_uuid ";
			$sql .= "and menu_item_id = :menu_item_id ";
			$parameters['domain_uuid'] = $domain_uuid;
			$parameters['menu_item_id'] = $menu_item_id;
			$database = new database;
			$database->app_name = 'menu';
			$database->app_uuid = 'f4b3b3d2-6287-489c-2a00-64529e46f2d7';
			$database->execute($sql, $parameters);
			unset($sql, $parameters);

		//set message
			message::add($text['message-moved_down']);
	}

	//redirect the user
		header("Location: menu_list.php?menu_item_id=".$menu_item_id);
		return;
}

?>