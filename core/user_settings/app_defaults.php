<?php
/*
	Humayun
*/

//process this only one time
	if ($domains_processed == 1) {
		//update any users set to legacy languages
			$language = new text;
			foreach ($language->legacy_map as $language_code => $legacy_code) {
				if (strlen($legacy_code) == 5) {
					continue;
				}
				$sql = "update v_user_settings set user_setting_value = :language_code ";
				$sql .= "where user_setting_value = :legacy_code ";
				$sql .= "and user_setting_name = 'code' ";
				$sql .= "and user_setting_subcategory = 'language' ";
				$sql .= "and user_setting_category = 'domain'";
				$parameters['language_code'] = $language_code;
				$parameters['legacy_code'] = $legacy_code;
				$database = new database;
				$database->execute($sql, $parameters);
				unset($sql, $parameters);
			}
		//migrate old user_settings
			$sql = "update v_user_settings ";
			$sql .= "set user_setting_value = '#fafafa' ";
			$sql .= "where user_setting_subcategory = 'message_default_color' ";
			$sql .= "and user_setting_value = '#ccffcc' ";
			$database = new database;
			$database->execute($sql, null);
			unset($sql);

			$sql = "update v_user_settings ";
			$sql .= "set user_setting_value = '#666' ";
			$sql .= "where user_setting_subcategory = 'message_default_background_color' ";
			$sql .= "and user_setting_value = '#004200' ";
			$database = new database;
			$database->execute($sql, null);
			unset($sql);
	}

?>
