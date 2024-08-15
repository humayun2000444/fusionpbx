<?php
/*
Humayun

	Humayun

	The Initial Developer of the Original Code is
	Mark J Crane Humayun
	Portions created by the Initial Developer are Copyright (C) 2023
	the Initial Developer. All Rights Reserved.

Humayun
*/

//includes files
	require_once dirname(__DIR__, 2) . "/resources/require.php";
	require_once "resources/check_auth.php";
	
//check permissions
	if (permission_exists('menu_add') || permission_exists('menu_edit')) {
		//access granted
	}
	else {
		echo "access denied";
		return;
	}

//add multi-lingual support
	$language = new text;
	$text = $language->get();

//get the http value and set as a php variable
	$menu_uuid = $_REQUEST["menu_uuid"];

//unset the sesssion menu array
	unset($_SESSION['menu']['array']);

//get the menu array and save it to the session
	$menu = new menu;
	$menu->menu_uuid = $_SESSION['domain']['menu']['uuid'];
	$_SESSION['menu']['array'] = $menu->menu_array();
	unset($menu);

//redirect the user
	//message::add($text['message-reload']);
	header("Location: ".PROJECT_PATH."/core/menu/menu_edit.php?id=".urlencode($menu_uuid));
	return;

?>
