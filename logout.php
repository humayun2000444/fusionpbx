<?php
/*
	Humayun
*/

//includes files
	require_once __DIR__ . "/resources/require.php";
	
//use custom logout destination if set otherwise redirect to the index page
	if (isset($_SESSION["login"]["logout_destination"]["text"])){
		$logout_destination = $_SESSION["login"]["logout_destination"]["text"];
	}
	else {
		$logout_destination = PROJECT_PATH."/";
	}

//destroy session
	session_unset();
	session_destroy();

//check for login return preference
	if (!empty($_SESSION["user_uuid"])) {
		if (isset($_SESSION['login']['destination_last']) && ($_SESSION['login']['destination_last']['boolean'] == 'true')) {
			if ($_SERVER['HTTP_REFERER'] != '') {
				//convert to relative path
					$referrer = substr($_SERVER['HTTP_REFERER'], strpos($_SERVER['HTTP_REFERER'], $_SERVER["HTTP_HOST"]) + strlen($_SERVER["HTTP_HOST"]));
				//check if destination url already exists
					$sql = "select count(*) from v_user_settings ";
					$sql .= "where domain_uuid = :domain_uuid ";
					$sql .= "and user_uuid = :user_uuid ";
					$sql .= "and user_setting_category = 'login' ";
					$sql .= "and user_setting_subcategory = 'destination' ";
					$sql .= "and user_setting_name = 'url' ";
					$paramters['domain_uuid'] = $_SESSION['domain_uuid'];
					$paramters['user_uuid'] = $_SESSION['user_uuid'];
					$database = new database;
					$num_rows = $database->select($sql, $parameters, 'column');
					$exists = ($num_rows > 0) ? true : false;
					unset($sql, $parameters, $num_rows);

				//if exists, update
					if ($exists) {
						$sql = "update v_user_settings set ";
						$sql .= "user_setting_value = :user_setting_value ";
						$sql .= "user_setting_enabled = 'true' ";
						$sql .= "where domain_uuid = :domain_uuid ";
						$sql .= "and user_uuid = :user_uuid ";
						$sql .= "and user_setting_category = 'login' ";
						$sql .= "and user_setting_subcategory = 'destination' ";
						$sql .= "and user_setting_name = 'url' ";
						$parameters['user_setting_value'] = $referrer;
						$parameters['domain_uuid'] = $_SESSION['domain_uuid'];
						$parameters['user_uuid'] = $_SESSION["user_uuid"];
						$database = new database;
						$database->execute($sql, $parameters);
						unset($sql, $parameters);
					}
				//otherwise, insert
					else {
						//build insert array
							$user_setting_uuid = uuid();
							$array['user_settings'][0]['user_setting_uuid'] = $user_setting_uuid;
							$array['user_settings'][0]['domain_uuid'] = $_SESSION['domain_uuid'];
							$array['user_settings'][0]['user_uuid'] = $_SESSION["user_uuid"];
							$array['user_settings'][0]['user_setting_category'] = 'login';
							$array['user_settings'][0]['user_setting_subcategory'] = 'destination';
							$array['user_settings'][0]['user_setting_name'] = 'url';
							$array['user_settings'][0]['user_setting_value'] = $referrer;
							$array['user_settings'][0]['user_setting_enabled'] = 'true';
						//grant temporary permissions
							$p = new permissions;
							$p->add('user_setting_add', 'temp');
						//execute insert
							$database = new database;
							$database->app_name = 'logout';
							$database->app_uuid = 'e9f24006-5da2-417f-94fb-7458348bae29';
							$database->save($array);
							unset($array);
						//revoke temporary permissions
							$p->delete('user_setting_add', 'temp');
					}
			}
		}
	}

//redirect the user to the logout page
	header("Location: ".$logout_destination);
	exit;

?>
