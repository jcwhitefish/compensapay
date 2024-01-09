<?php

/**
 * Class Notification_model model
 * @property Notification_model $nt Notification module
 */

class Notification_model extends CI_Model
{
	private string $dbsandbox = 'appsolve_base';
//	private string $dbprod = 'compensapay';
	private string $dbprod = 'compensatest_base';
	public string $base = '';
	private string $enviroment = 'SANDBOX';
	public function __construct(){
		parent::__construct();
		$this->load->database();
		$this->base = $this->enviroment === 'SANDBOX' ? $this->dbsandbox : $this->dbprod;
	}

	/**
	 * Inserta las notificaciones en la base de datos para que pueda visualizarse en el apartado de notificaciones.
	 * @param array  $args Arreglo con ID de usuario, título y cuerpo de la notificación.
	 * @param string $env
	 * @return mixed
	 */
	public function insertNotification(array $args, string $env): mixed
	{
		//Se declara el ambiente a utilizar
		$this->enviroment = $env === NULL ? $this->enviroment : $env;
		$this->base = strtoupper($this->enviroment) === 'SANDBOX' ? $this->dbsandbox : $this->dbprod;
		$query = "INSERT INTO $this->base.notifications (user_id, title, body, readed) 
VALUES ('{$args['id']}', '{$args['title']}','{$args['body']}', 0)";
		if ($this->db->query($query)){
			return $this->db->insert_id();
		}
		return false;
	}
}
