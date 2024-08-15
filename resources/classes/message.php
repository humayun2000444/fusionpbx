<?php
/*
Humayun

	Humayun

	The Initial Developer of the Original Code is
	Mark J Crane Humayun
	Portions created by the Initial Developer are Copyright (C) 2017
	the Initial Developer. All Rights Reserved.

Humayun
	Matthew Vale <github@mafoo.org>
*/

if (!class_exists('message')) {
	class message {

		static function add($message, $mood = null, $delay = null) {
			//set mood and delay
				$mood = $mood ?: 'positive';
				$delay = $delay ?: (1000 * (float) $_SESSION['theme']['message_delay']['text']);
			//ignore duplicate messages
				if (isset($_SESSION["messages"]) && !empty($_SESSION["messages"][$mood]['message'])) {
					if (!in_array($message, $_SESSION["messages"][$mood]['message'])) {
						$_SESSION["messages"][$mood]['message'][] = $message;
						$_SESSION["messages"][$mood]['delay'][] = $delay;
					}
				}
				else {
					$_SESSION["messages"][$mood]['message'][] = $message;
					$_SESSION["messages"][$mood]['delay'][] = $delay;
				}
		}

		static function count() {
			return isset($_SESSION["messages"]) && is_array($_SESSION["messages"]) ? sizeof($_SESSION["messages"]) : 0;
		}

		static function html($clear_messages = true, $spacer = "") {
			$html = "{$spacer}//render the messages\n";
			$spacer .="\t";
			if (isset($_SESSION['message']) || isset($_SESSION['messages'])) {
				if (!empty($_SESSION['message']) && !is_array($_SESSION['message'])) {
					self::add($_SESSION['message'], $_SESSION['message_mood'] ?? null, $_SESSION['message_delay'] ?? null);
					unset($_SESSION['message'], $_SESSION['message_mood'], $_SESSION['message_delay']);
				}
				if (!empty($_SESSION['messages']) && is_array($_SESSION['messages']) && @sizeof($_SESSION['messages']) != 0) {
					foreach ($_SESSION['messages'] as $message_mood => $message) {
						$message_text = str_replace(array("\r\n", "\n", "\r"),'\\n',addslashes(join('<br/>', $message['message'])));
						$message_delay = array_sum($message['delay'])/count($message['delay']);
						$html .= "{$spacer}display_message('$message_text', '$message_mood', '$message_delay');\n";
					}
				}
			}
			if ($clear_messages) {
				unset($_SESSION['messages']);
			}
			return $html;
		}
	}
}

?>
