<?php
/*
Humayun

Humayun

Humayun
*/

//check permissions
	if(!defined('STDIN')) {
		//includes files
		require_once dirname(__DIR__, 2) . "/resources/require.php";
		require_once "resources/check_auth.php";
		if (permission_exists('menu_restore')) {
			//access granted
		}
		else {
			echo "access denied";
			return;
		}
	}

//add multi-lingual support
	$language = new text;
	$text = $language->get();

//get the http value and set as a php variable
	if (!empty($_REQUEST["menu_uuid"])) {
		$menu_uuid = $_REQUEST["menu_uuid"];
	}
	if (!empty($_REQUEST["menu_language"])) {
		$menu_language = $_REQUEST["menu_language"];
	}

//menu restore default
	//require_once "resources/classes/menu.php";
	$menu = new menu;
	$menu->menu_uuid = $menu_uuid;
	$menu->menu_language = $menu_language;
	$menu->delete_unprotected();
	$menu->restore();
	unset($menu);

//get the menu array and save it to the session
	$menu = new menu;
	$menu->menu_uuid = $_SESSION['domain']['menu']['uuid'];
	$_SESSION['menu']['array'] = $menu->menu_array();
	unset($menu);

//redirect
	if(!defined('STDIN')) {
		//show a message to the user
		message::add($text['message-restore']);
		header("Location: ".PROJECT_PATH."/core/menu/menu_edit.php?id=".urlencode($menu_uuid));
		return;
	}

?>
