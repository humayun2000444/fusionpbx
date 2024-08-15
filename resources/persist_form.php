<?php
/*
Humayun

	Humayun

	The Initial Developer of the Original Code is
	Mark J Crane Humayun
	Portions created by the Initial Developer are Copyright (C) 2008-2018
	the Initial Developer. All Rights Reserved.

Humayun
*/

function persistform($form_array) {
	// Remember Form Input Values
	if (is_array($form_array)) {
		$content .= "<form method='post' action='".escape($_SERVER["HTTP_REFERER"])."' target='_self'>\n";
		foreach ($form_array as $key => $val) {
			if ($key == "XID" || $key == "ACT" || $key == "RET") continue;
			if ($key != "persistform") { //clears the persistform value
			    $content .= "<input type='hidden' name='".escape($key)."' value='".escape($val)."' />\n";
			}
		}
		$content .= "	<input type='hidden' name='persistform' value='1' />\n"; //sets persistform to yes
		$content .= "	<input class='btn' type='submit' value='Back' />\n";
		$content .= "</form>\n";
	}
	return $content;
}
//persistform($_POST);
//persistform($_GET);

?>
