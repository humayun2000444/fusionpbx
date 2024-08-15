<?php
/*
	Humayun
*/

//process this only one time
	if ($domains_processed == 1) {

		//domain settings - change the type from var to text
			$sql = "update v_domain_settings ";
			$sql .= "set domain_setting_name = 'text' ";
			$sql .= "where domain_setting_name = 'var' ";
			$database = new database;
			$database->execute($sql, null);
			unset($sql, $parameters);

		//update any domains set to legacy languages
			$language = new text;
			foreach ($language->legacy_map as $language_code => $legacy_code) {
				if(strlen($legacy_code) == 5) {
					continue;
				}

				$sql = "update v_domain_settings set domain_setting_value = :language_code ";
				$sql .= "where domain_setting_value = :legacy_code ";
				$sql .= "and domain_setting_name = 'code' ";
				$sql .= "and domain_setting_subcategory = 'language' ";
				$sql .= "and domain_setting_category = 'domain'";
				$parameters['language_code'] = $language_code;
				$parameters['legacy_code'] = $legacy_code;
				$database = new database;
				$database->execute($sql, $parameters);
				unset($sql, $parameters);
			}

		//migrate old domain_settings
			$sql = "update v_domain_settings ";
			$sql .= "set domain_setting_value = '#fafafa' ";
			$sql .= "where domain_setting_subcategory = 'message_default_color' ";
			$sql .= "and domain_setting_value = '#ccffcc' ";
			$database = new database;
			$database->execute($sql, null);
			unset($sql, $parameters);

			$sql = "update v_domain_settings ";
			$sql .= "set domain_setting_value = '#666' ";
			$sql .= "where domain_setting_subcategory = 'message_default_background_color' ";
			$sql .= "and domain_setting_value = '#004200' ";
			$database = new database;
			$database->execute($sql, null);
			unset($sql, $parameters);

	}

?>
