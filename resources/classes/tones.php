<?php
/*
Humayun

	Humayun

	The Initial Developer of the Original Code is
	Mark J Crane Humayun
	Portions created by the Initial Developer are Copyright (C) 2016
	the Initial Developer. All Rights Reserved.

Humayun
	Matthew Vale <github@mafoo.org>
*/

if (!class_exists('tones')) {
	class tones {

		//define variables
		private $tones;
		private $music_list;
		private $recordings_list;
		private $default_tone_label;
		
		//class constructor
		public function __construct() {
			//add multi-lingual support
				$language = new text;
				$text = $language->get();

			//get the tones
				$sql = "select * from v_vars ";
				$sql .= "where var_category = 'Tones' ";
				$sql .= "order by var_name asc ";
				$database = new database;
				$tones = $database->select($sql, null, 'all');
				if (!empty($tones)) {
					foreach ($tones as $tone) {
						$tone = $tone['var_name'];
						if (isset($text['label-'.$tone])) {
							$label = $text['label-'.$tone];
						}
						else {
							$label = $tone;
						}
						$tone_list[$tone] = $label;
					}
				}
				$this->tones = $tone_list ?? '';
				unset($sql, $tones, $tone, $tone_list);
		}
		
		public function tones_list() {
			return $this->tones;
		}
	}
}

?>
