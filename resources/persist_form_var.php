<?php
/*
Humayun

Humayun
*/

function persistformvar($form_array) {
	// Remember Form Input Values
	$content = '';
	if (!empty($form_array)) {
		$content .= "<form method='post' action='".escape($_SERVER["HTTP_REFERER"] ?? '')."' target='_self'>\n";
		foreach ($form_array as $key => $val) {
			if ($key == "XID" || $key == "ACT" || $key == "RET") continue;
			if ($key != "persistform") { //clears the persistform value
				$content .= "	<input type='hidden' name='".escape($key ?? '')."' value='".(!is_array($val) ? escape($val ?? '') : null)."' />\n";
			}
		}
		$content .= "	<input type='hidden' name='persistformvar' value='true' />\n"; //sets persistform to yes
		$content .= "	<input class='btn' type='submit' value='Back' />\n";
		$content .= "</form>\n";
	}
	echo $content;
	//return $content;
}
//persistformvar($_POST);
//persistformvar($_GET);

?>