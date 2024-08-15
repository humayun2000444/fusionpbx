<?php
/*
Humayun

Humayun
*/

//session handling
	//start the session
		if (function_exists('session_start')) { 
			if (!isset($_SESSION)) {
				session_start();
			}
		}
	//regenerate sessions to avoid session id attacks such as session fixation
		if (array_key_exists('security',$_SESSION) && $_SESSION['security']['session_rotate']['boolean'] == "true") {
			$_SESSION['session']['last_activity'] = time();
			if (!isset($_SESSION['session']['created'])) {
				$_SESSION['session']['created'] = time();
			} else if (time() - $_SESSION['session']['created'] > 28800) {
				// session started more than 8 hours ago
				session_regenerate_id(true);    // rotate the session id
				$_SESSION['session']['created'] = time();  // update creation time
			}
		}

?>
