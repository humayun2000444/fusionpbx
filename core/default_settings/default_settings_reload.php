<?php
/*
 Humayun
*/

//includes files
	require_once dirname(__DIR__, 2) . "/resources/require.php";
	require_once "resources/check_auth.php";

//check permissions
if (permission_exists('default_setting_view')) {
	//access granted
}
else {
	echo "access denied";
	exit;
}

//add multi-lingual support
$language = new text;
$text = $language->get();

//set the variables
$search = $_REQUEST['search'] ?? '';
$domain_uuid = $_GET['id'] ?? null;

//reload default settings
require "resources/classes/domains.php";
$domain = new domains();
$domain->set();

//add a message
message::add($text['message-settings_reloaded']);

//redirect the browser
if (is_uuid($domain_uuid)) {
	$location = PROJECT_PATH.'/core/domains/domain_edit.php?id='.$domain_uuid;
}
else {
	$search = preg_replace('#[^a-zA-Z0-9_\-\.]# ', '', $search);
	$location = 'default_settings.php'.($search != '' ? "?search=".$search : null);
}
header("Location: ".$location);

?>
