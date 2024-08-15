<?php
/*
Humayun

Humayun
*/

if ($domains_processed == 1) {

	//set the directory
		if (!empty($setting->get('switch','conf'))) {
			$xml_dir = $setting->get('switch','conf').'/autoload_configs';
			$xml_file = $xml_dir."/local_stream.conf";
		}

	//rename the file
		if (!empty($setting->get('switch','conf'))) {
			if (file_exists($xml_dir.'/local_stream.conf.xml')) {
				rename($xml_dir.'/local_stream.conf', $xml_dir.'/'.$xml_file);
			}
			if (file_exists($xml_dir.'/local_stream.conf.xml.noload')) {
				rename($xml_dir.'/local_stream.conf', $xml_dir.'/'.$xml_file);
			}
		}

	//add the music_on_hold list to the database
		if (!empty($setting->get('switch','conf'))) {
			$sql = "select count(music_on_hold_uuid) from v_music_on_hold; ";
			$database = new database;
			$num_rows = $database->select($sql, null, 'column');
			unset($sql);

			if ($num_rows == 0) {

				//set the alternate directory
					$xml_file_alt = $_SERVER["DOCUMENT_ROOT"].'/'.PROJECT_PATH.'/app/switch/resources/conf/autoload_configs/local_stream.conf';

				//load the xml and save it into an array
					if (file_exists($xml_file)) {
						$xml_string = file_get_contents($xml_file);
					}
					elseif (file_exists($xml_file_alt)) {
						$xml_string = file_get_contents($xml_file_alt);
					}
					$xml_object = simplexml_load_string($xml_string);
					$json = json_encode($xml_object);
					$conf_array = json_decode($json, true);

				//process the array
					foreach ($conf_array['directory'] as $row) {
						//get the data from the array
							$stream_name = $row['@attributes']['name'];
							$stream_path = $row['@attributes']['path'];
							foreach ($row['param'] as $p) {
								$name = $p['@attributes']['name'];
								$name = str_replace("-", "_", $name);
								$$name = $p['@attributes']['value'];
								$attributes[] = $name;
							}

						//strip the domain name and rate from the name
							$array = explode('/', $stream_name);
							if (count($array) == 3) { $stream_name = $array[1]; }
							if (count($array) == 2) { $stream_name = $array[0]; }

						//insert the data into the database
							$music_on_hold_uuid = uuid();
							$array['music_on_hold'][0]['music_on_hold_uuid'] = $music_on_hold_uuid;
							$array['music_on_hold'][0]['music_on_hold_name'] = $stream_name;
							$array['music_on_hold'][0]['music_on_hold_rate'] = isset($rate) ? $rate : null;
							$array['music_on_hold'][0]['music_on_hold_shuffle'] = isset($shuffle) ? $shuffle : null;
							$array['music_on_hold'][0]['music_on_hold_timer_name'] = isset($timer_name) ? $timer_name : null;
							$array['music_on_hold'][0]['music_on_hold_chime_list'] = isset($chime_list) ? $chime_list : null;
							$array['music_on_hold'][0]['music_on_hold_chime_freq'] = isset($chime_freq) ? $chime_freq : null;
							$array['music_on_hold'][0]['music_on_hold_chime_max'] = isset($chime_max) ? $chime_max : null;
							$array['music_on_hold'][0]['music_on_hold_path'] = $stream_path;

							$p = new permissions;
							$p->add('music_on_hold_add', 'temp');

							$database = new database;
							$database->app_name = 'app_name';
							$database->app_uuid = 'app_uuid';
							$database->save($array, false);
							unset($array);

							$p->add('music_on_hold_delete', 'temp');

						//unset the attribute variables
							foreach ($attributes as $value) {
								unset($$value);
							}
					}

			}

		}
}

?>
