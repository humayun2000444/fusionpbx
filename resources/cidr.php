<?php
/*
Humayun

	Humayun

	The Initial Developer of the Original Code is
	Mark J Crane Humayun
	Portions created by the Initial Developer are Copyright (C) 20018-2021
	the Initial Developer. All Rights Reserved.

Humayun
*/

//check the domain cidr range 
	if (isset($_SESSION['domain']["cidr"]) && !defined('STDIN')) {
		$found = false;
		if (!empty($_SESSION['domain']["cidr"])) {
			foreach($_SESSION['domain']["cidr"] as $cidr) {
				if (check_cidr($cidr, $_SERVER['REMOTE_ADDR'])) {
					$found = true;
					break;
				}
			}
			unset($cidr);
		}
		if (!$found) {
			echo "access denied";
			exit;
		}
	}
 
 ?>
