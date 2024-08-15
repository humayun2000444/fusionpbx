<?php
/*
Humayun

Humayun


*/

//define the feature_event_notify class
	class feature_event_notify {

		public $debug;
		public $domain_name;
		public $extension;
		public $forward_all_destination;
		public $forward_all_enabled;
		public $forward_busy_destination;
		public $forward_busy_enabled;
		public $forward_no_answer_destination;
		public $forward_no_answer_enabled;
		public $do_not_disturb;
		public $ring_count;

	//feature_event method		
		public function send_notify() {
			$esl = event_socket::create();
			if ($esl->is_connected()) {
				// Get the SIP profiles for the extension
				$command = "sofia_contact */{$this->extension}@{$this->domain_name}";
				$contact_string = event_socket::api($command);
				// The first value in the array will be full matching text, the second one will be the array of profile matches
				preg_match_all('/sofia\/([^,]+)\/(?:[^,]+)/', $contact_string, $matches);
				if (sizeof($matches) != 2 || sizeof($matches[1]) < 1) {
					$profiles = array("internal");
				} else {
					// We have at least one profile, get all of the unique profiles
					$profiles = array_unique($matches[1]);
				}

				foreach ($profiles as $profile) {
					//send the event
					$event = "sendevent SWITCH_EVENT_PHONE_FEATURE\n";
					$event .= "profile: " . $profile . "\n";
					$event .= "user: " . $this->extension . "\n";
					$event .= "host: " . $this->domain_name . "\n";
					$event .= "device: \n";
					$event .= "Feature-Event: init\n";
					$event .= "forward_immediate_enabled: " . $this->forward_all_enabled . "\n";
					$event .= "forward_immediate: " . $this->forward_all_destination . "\n";
					$event .= "forward_busy_enabled: " . $this->forward_busy_enabled . "\n";
					$event .= "forward_busy: " . $this->forward_busy_destination . "\n";
					$event .= "forward_no_answer_enabled: " . $this->forward_no_answer_enabled . "\n";
					$event .= "forward_no_answer: " . $this->forward_no_answer_destination . "\n";
					$event .= "doNotDisturbOn: " . $this->do_not_disturb . "\n";
					$event .= "ringCount: " . $this->ring_count . "\n";
					event_socket::command($event);
				}
			}
		} //function

	} //class

?>
