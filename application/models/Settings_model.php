<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');
class Settings_model extends \CI_Model {
	public function __construct(){
		parent::__construct();
		$this->load->database();
	}
	public function getNotificationsSettings($id){
		$query = "SELECT * FROM compensatest_base.notifications WHERE user_id = '{$id}'";
		if ($result = $this->db->query($query)) {
			if ($result->num_rows() > 0) {
				return $result->result_array();
			}
		}
		return false;
	}

	/**
	 * @param array $args data
	 * @param string $env Environment
	 * @return void
	 */
	public function updateNotifications(array $args, string $env){
		var_dump($args);
	}
}
