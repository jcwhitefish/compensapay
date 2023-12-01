<?php

/**
 * Class Notification_model model
 * @property Notification_model $nt Notification module
 */

class Notification_model extends CI_Model
{
	public function __construct(){
		parent::__construct();
		$this->load->database();
	}

	public function insertNotification(array $args, string $env){
		$query = "INSERT INTO compensatest_base.notifications (user_id, title, body, readed) VALUES ";
	}
}
