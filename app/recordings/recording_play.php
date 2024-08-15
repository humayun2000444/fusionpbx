<?php
/*
	Humayun
*/

//includes files
	require_once dirname(__DIR__, 2) . "/resources/require.php";
	require_once "resources/check_auth.php";

//check permissions
	if (permission_exists('recording_play')) {
		//access granted
	}
	else {
		echo "access denied";
		exit;
	}

//get the variables
	$filename = $_GET['filename'];
	$type = $_GET['type']; //moh //rec

//show the content
?>
<html>
<head>
</head>
<body link="#0000CC" vlink="#0000CC" alink="#0000CC">

<table width="100%" border="0" cellpadding="0" cellspacing="0">
	<tr>
		<td align='center'>
			<b><?php echo escape($filename) ?></b>
		</td>
	</tr>
	<tr>
		<td align='center'>
		<?php
		// detect browser
		$user_agent = http_user_agent();
		$browser_name = $user_agent['name'];

		$file_ext = substr($filename, -3);
		if ($file_ext == "wav") {
			//HTML5 method
			if ($browser_name == "Google Chrome" || $browser_name == "Mozilla Firefox") {
				echo "<audio src=\"recordings.php?a=download&type=".urlencode($type)."&filename=".urlencode($filename)."\" autoplay=\"true\" ></audio>";
			}
			else {
				echo "<audio src=\"http://localhost:8000/mod/recordings/recordings.php?a=download&type=".urlencode($type)."&filename=".urlencode($filename)."\" autoplay=\"autoplay\"></audio>";
				echo "<embed src=\"recordings.php?a=download&type=".urlencode($type)."&filename=".urlencode($filename)."\" autostart=\"true\" width=\"300\" height=\"90\" name=\"sound_".escape($filename)."\" enablejavascript=\"true\">\n";
			}
		}
		if ($file_ext == "mp3") {
			echo "<object type=\"application/x-shockwave-flash\" width=\"400\" height=\"17\" data=\"slim.swf?autoplay=true&song_title=".urlencode($filename)."&song_url=recordings.php?a=download&type=".urlencode($type)."&filename=".urlencode($filename)."\">\n";
			echo "<param name=\"movie\" value=\"slim.swf?autoplay=true&song_url=recordings.php?a=download&type=".urlencode($type)."&filename=".urlencode($filename)."\" />\n";
			echo "<param name=\"quality\" value=\"high\"/>\n";
			echo "<param name=\"bgcolor\" value=\"#E6E6E6\"/>\n";
			echo "</object>\n";
		}
		?>
		</td>
	</tr>
</table>

</body>
</html>
