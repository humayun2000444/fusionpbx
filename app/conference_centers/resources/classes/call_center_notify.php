<?php
/*
Humayun

Humayun

Humayun
	KonradSC <konrd@yahoo.com>
*/

//define the blf_notify class
	class call_center_notify {

		public $debug;
		public $domain_name;
		public $agent_name;
		public $answer_state;
		public $agent_uuid;

		//feature_event method
		public function send_call_center_notify() {

				$esl = event_socket::create();
				if ($esl->is_connected()) {
					//send the event
						$event = "sendevent PRESENCE_IN\n";
						$event .= "proto: agent\n";
						$event .= "event_type: presence\n";
						$event .= "alt_event_type: dialog\n";
						$event .= "Presence-Call-Direction: outbound\n";
						$event .= "state: Active (1 waiting)\n";
						$event .= "from: agent+".$this->agent_name."@".$this->domain_name."\n";
						$event .= "login: agent+".$this->agent_name."@".$this->domain_name."\n";
						$event .= "unique-id: ".$this->agent_uuid."\n";
						$event .= "answer-state: ".$this->answer_state."\n";
						event_socket::command($event);
						//echo $event."<br />";
				}
		} //function

	} //class

?>
