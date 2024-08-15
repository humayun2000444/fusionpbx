<?php
/*
Humayun

 Humayun

 The Initial Developer of the Original Code is
 Mark J Crane Humayun
 Portions created by the Initial Developer are Copyright (C) 2008-2012
 the Initial Developer. All Rights Reserved.

 Contributor(s):
 Mark J Crane Humayun
*/

//includes files
	require_once dirname(__DIR__, 2) . "/resources/require.php";
	require_once "resources/check_auth.php";

//check permissions
	if (permission_exists('voicemail_message_view')) {
		//access granted
	}
	else {
		echo "access denied";
		exit;
	}

//add multi-lingual support
	$language = new text;
	$text = $language->get();

//get submitted variables
	$voicemail_messages = $_REQUEST["voicemail_messages"];

//toggle the voicemail message
	$toggled = 0;
	if (is_array($voicemail_messages) && sizeof($voicemail_messages) > 0) {
		require_once "resources/classes/voicemail.php";
		foreach ($voicemail_messages as $voicemail_uuid => $voicemail_message_uuids) {
			foreach ($voicemail_message_uuids as $voicemail_message_uuid) {
				if (is_uuid($voicemail_uuid) && is_uuid($voicemail_message_uuid)) {
					$voicemail = new voicemail;
					$voicemail->domain_uuid = $_SESSION['domain_uuid'];
					$voicemail->voicemail_uuid = $voicemail_uuid;
					$voicemail->voicemail_message_uuid = $voicemail_message_uuid;
					$result = $voicemail->message_toggle();
					unset($voicemail);
					$toggled++;
				}
			}
		}
	}

//set the referrer
	$http_referer = parse_url($_SERVER["HTTP_REFERER"]);
	$referer_path = $http_referer['path'];
	$referer_query = $http_referer['query'];

//redirect the user
	if ($toggled > 0) {
		message::add($text['message-toggled'].': '.$toggled);
	}
	if ($referer_path == PROJECT_PATH."/app/voicemails/voicemail_messages.php") {
		header("Location: voicemail_messages.php?".$referer_query);
	}
	else {
		header("Location: voicemails.php");
	}

?>