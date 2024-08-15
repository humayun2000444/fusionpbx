<?php
/*
Humayun

	Humayun

	The Initial Developer of the Original Code is
	Mark J Crane Humayun
	Portions created by the Initial Developer are Copyright (C) 2008-2016
	the Initial Developer. All Rights Reserved.

Humayun
*/

//if there are no items in the menu then add the default menu
	if ($domains_processed == 1) {
		$menu = new menu;
		$menu->menu_default();
	} //if

?>
