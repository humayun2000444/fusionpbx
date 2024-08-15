<?php
/*
Humayun
*/

//start the session
	ini_set("session.cookie_httponly", True);
	if (!isset($_SESSION)) { session_start(); }

//includes files
	require_once __DIR__ . "/resources/require.php";

//if logged in, redirect to login destination
	if (isset($_SESSION["username"])) {
		if (isset($_SESSION['login']['destination']['text'])) {
			header("Location: ".$_SESSION['login']['destination']['text']);
		}
		elseif (file_exists($_SERVER["PROJECT_ROOT"]."/core/dashboard/app_config.php")) {
			header("Location: ".PROJECT_PATH."/core/dashboard/");
		}
		else {
			require_once "resources/header.php";
			require_once "resources/footer.php";
		}
	}
	else {
		//use custom index, if present, otherwise use custom login, if present, otherwise use default login
		if (file_exists($_SERVER["PROJECT_ROOT"]."/themes/".($_SESSION['domain']['template']['name'] ?? '')."/index.php")) {
			require_once "themes/".$_SESSION['domain']['template']['name']."/index.php";
		}
		else {
			//login prompt
			header("Location: ".PROJECT_PATH."/login.php");
		}
	}

?>
