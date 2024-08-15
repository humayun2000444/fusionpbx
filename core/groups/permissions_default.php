<?php
/*
Humayun

Humayun
*/

//check permisions
	if (empty($included) || !$included) {
		//includes files
		require_once dirname(__DIR__, 2) . "/resources/require.php";
		require_once "resources/check_auth.php";
		if (permission_exists('group_edit')) {
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

//permission restore default
	require_once "core/groups/resources/classes/permission.php";
	$permission = new permission;
	$permission->restore();

//redirect the users
	if (empty($included) || !$included) {
		//show a message to the user
		message::add($text['message-restore']);
		header("Location: groups.php");
		return;
	}

?>
