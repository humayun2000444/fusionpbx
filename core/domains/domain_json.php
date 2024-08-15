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
	if (permission_exists('domain_view')) {
		//access granted
	}
	else {
		echo "access denied";
		exit;
	}

//get posted data
	if (!empty($_POST['search'])) {
		$search = $_POST['search'];
	}

//add the search term
	if (!empty($_GET["search"])) {
		$search = strtolower($_GET["search"]);
	}

//validate the token	
	//$token = new token;
	//if (!$token->validate($_SERVER['PHP_SELF'])) {
	//	message::add($text['message-invalid_token'],'negative');
	//	header('Location: /');
	//	exit;
	//}

//include css
	//echo "<link rel='stylesheet' type='text/css' href='/resources/fontawesome/css/all.min.css.php'>\n";

//get the list of domains
	if (permission_exists('domain_all') || permission_exists('domain_select')) {
		$sql = "select * ";
		$sql .= "from v_domains ";
		$sql .= "where true ";
		$sql .= "and domain_enabled = 'true' \n";
		if (isset($search)) {
			$sql .= "	and ( ";
			$sql .= "		lower(domain_name) like :search ";
			$sql .= "		or lower(domain_description) like :search ";
			$sql .= "	) ";
			$parameters['search'] = '%'.$search.'%';
		}
		$sql .= "order by domain_name asc ";
		$database = new database;
		$domains = $database->select($sql, $parameters ?? null, 'all');
		unset($sql, $parameters);
	}

//get the domains
	if (file_exists($_SERVER["PROJECT_ROOT"]."/app/domains/app_config.php") && !is_cli()){
		require_once "app/domains/resources/domains.php";
	}

//debug information
	//print_r($domains);

//show the domains as json
	echo json_encode($domains, true);

?>
