<?php

/*
Humayun

	Humayun

	The Initial Developer of the Original Code is
	Mark J Crane Humayun
	Copyright (C) 2010 - 2020
	All Rights Reserved.

Humayun
*/

if (!class_exists('modal')) {
	class modal {

		static function create($array) {

			//add multi-lingual support
			$language = new text;
			$text = $language->get();

			$modal = "<div id='".(!empty($array['id']) ? $array['id'] : 'modal')."' class='modal-window'>\n";
			$modal .= "	<div>\n";
			$modal .= "		<span title=\"".$text['button-close']."\" class='modal-close' onclick=\"modal_close(); ".($array['onclose'] ?? '')."\">&times</span>\n";
			if (!empty($array['type'])) {
				//determine type
					switch ($array['type']) {
						case 'copy':
							$array['title'] = $text['modal_title-confirmation'];
							$array['message'] = $text['confirm-copy'];
							break;
						case 'toggle':
							$array['title'] = $text['modal_title-confirmation'];
							$array['message'] = $text['confirm-toggle'];
							break;
						case 'delete':
							$array['title'] = $text['modal_title-confirmation'];
							$array['message'] = $text['confirm-delete'];
							break;
						default: //general
							$array['title'] = !empty($array['title']) ? $array['title'] : $text['modal_title-confirmation'];
					}
				//prefix cancel button to action
					$array['actions'] = button::create(['type'=>'button','label'=>$text['button-cancel'],'icon'=>$_SESSION['theme']['button_icon_cancel'],'collapse'=>'never','onclick'=>'modal_close(); '.($array['onclose'] ?? '')]).$array['actions'];
			}
			$modal .= !empty($array['title']) ? "		<span class='modal-title'>".$array['title']."</span>\n" : null;
			$modal .= !empty($array['message']) ? "		<span class='modal-message'>".$array['message']."</span>\n" : null;
			$modal .= !empty($array['actions']) ? "		<span class='modal-actions'>".$array['actions']."</span>\n" : null;
			$modal .= "	</div>\n";
			$modal .= "</div>";

			return $modal;
			unset($modal);

		}

	}
}

?>