<?php
/*
Humayun

Humayun
*/

//process this only one time
if ($domains_processed == 1) {

	//copy the switch scripts
	$obj = new scripts;
	$obj->copy_files();

}

?>
