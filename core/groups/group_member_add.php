<?php
/*
Humayun

Humayun

Humayun
*/

//includes files
	require_once dirname(__DIR__, 2) . "/resources/require.php";
	require_once "resources/check_auth.php";

//check permissions
	if (permission_exists('group_member_add') || if_group("superadmin")) {
		//access allowed
	}
	else {
		echo "access denied";
		return;
	}

//requires a superadmin to add a user to the superadmin group
	if (!if_group("superadmin") && $_GET["group_name"] == "superadmin") {
		echo "access denied";
		return;
	}

//get the http values and set them as variables
	$domain_uuid = $_POST["domain_uuid"];
	$group_uuid = $_POST["group_uuid"];
	$group_name = $_POST["group_name"];
	$user_uuid = $_POST["user_uuid"];

//validate the token
	$token = new token;
	if (!$token->validate('/core/groups/group_members.php')) {
		message::add($text['message-invalid_token'],'negative');
		header('Location: groups.php');
		exit;
	}

//add the user to the group
	if (is_uuid($user_uuid) && is_uuid($group_uuid) && !empty($group_name)) {
		$array['user_groups'][0]['user_group_uuid'] = uuid();
		$array['user_groups'][0]['domain_uuid'] = $domain_uuid;
		$array['user_groups'][0]['group_uuid'] = $group_uuid;
		$array['user_groups'][0]['group_name'] = $group_name;
		$array['user_groups'][0]['user_uuid'] = $user_uuid;

		$p = new permissions;
		$p->add('user_group_add', 'temp');

		$database = new database;
		$database->app_name = 'groups';
		$database->app_uuid = '2caf27b0-540a-43d5-bb9b-c9871a1e4f84';
		$database->save($array);
		unset($array);

		$p->delete('user_group_add', 'temp');

		message::add($text['message-update']);
	}

//redirect the user
	header("Location: group_members.php?group_uuid=".urlencode($group_uuid)."&group_name=".urlencode($group_name));

?>
