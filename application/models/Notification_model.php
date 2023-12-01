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

	/**
	 * Inserta las notificaciones en la base de datos para que pueda visualizarse en el apartado de notificaciones.
	 * @param array  $args Arreglo con ID de usuario, título y cuerpo de la notificación.
	 * @param string $env
	 * @return mixed
	 */
	public function insertNotification(array $args, string $env): mixed
	{
		$query = "INSERT INTO compensatest_base.notifications (user_id, title, body, readed) 
VALUES ('{$args['id']}', '{$args['title']}','{$args['body']}', 0)";
		if ($this->db->query($query)){
			return $this->db->insert_id();
		}
		return false;
	}
}
