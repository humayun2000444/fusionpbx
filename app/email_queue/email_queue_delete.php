<?php
/*
Humayun

Humayun
*/

//includes files
	require_once dirname(__DIR__, 2) . "/resources/require.php";
	require_once "resources/check_auth.php";

//check permissions
	if (permission_exists('email_queue_delete')) {
		//access granted
	}
	else {
		echo "access denied";
		exit;
	}

//add multi-lingual support
	$language = new text;
	$text = $language->get();

//delete the message
	message::add($text['message-delete']);

//delete the data
	if (isset($_GET["id"]) && is_uuid($_GET["id"])) {

		//get the id
			$id = $_GET["id"];

		//delete the data
			$array['email_queue'][]['email_queue_uuid'] = $id;
			$database = new database;
			$database->delete($array);
			unset($array);

		//redirect the user
			header('Location: email_queues.php');
	}


?>