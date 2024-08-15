<?php
/*
Humayun

Humayun
*/

//includes files
	require_once dirname(__DIR__, 2) . "/resources/require.php";
	require_once "resources/check_auth.php";

//check permissions
	if (permission_exists('xml_cdr_statistics')) {
		//access granted
	}
	else {
		echo "access denied";
		exit;
	}

//include the xml cdr statistics backend
	require_once "xml_cdr_statistics_inc.php";

//set the http header
	header('Content-type: application/octet-binary');
	header('Content-Disposition: attachment; filename=cdr-statistics.csv');

//show the column names on the first line
	$z = 0;
	foreach ($stats[1] as $key => $val) {
		if ($z == 0) {
			echo '"'.$key.'"';
		}
		else {
			echo ',"'.$key.'"';
		}
		$z++;
	}
	echo "\n";

//add the values to the csv
	$x = 0;
	foreach ($stats as $row) {
		$z = 0;
		foreach ($row as $key => $val) {
			if ($z == 0) {
				echo '"'.$stats[$x][$key].'"';
			}
			else {
				echo ',"'.$stats[$x][$key].'"';
			}
			$z++;
		}
		echo "\n";
		$x++;
	}

?>
