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
	 * @param string $env Ambiente en el que se va trabajar
	 * @return mixed
	 */
	public function insertNotification(array $args, string $env): mixed
	{
		$query = "INSERT INTO compensatest_base.notifications (user_id, title, body, readed) 
VALUES ('{$args['id']}', '{$args['title']}',  \"".$args['body']."\", 0)";
		if ($res=$this->db->query($query)){
			return($this->db->insert_id());
		}
		return false;
	}

	public function verNotificaciones(){
		$iduser =  $this->session->userdata('datosUsuario')["id"];

		$querynot = "SELECT * FROM notifications WHERE user_id='".$iduser."' ORDER BY create_at DESC";

		if ($result = $this->db->query($querynot)) {
			if ($result->num_rows() > 0){
                $rresult = $result->result_array();
            }
            else {
                $rresult = NULL;
            }
		}

		return $rresult;
	}

	public function updateNoti($idnoti){
		$q_update = "UPDATE notifications SET readed='1' WHERE id='".$idnoti."'";

		if($result = $this->db->query($q_update)) {

			$querynot = "SELECT * FROM notifications WHERE id='".$idnoti."' LIMIT 1";

			if ($result2 = $this->db->query($querynot)) {
				if ($result2->num_rows() > 0){
					$rresult = $result2->result_array();
				}
				else {
					$rresult = NULL;
				}
			}
		}

		return $rresult;
	}
}
