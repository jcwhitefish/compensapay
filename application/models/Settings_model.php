<?php
/**
 * Class Settings model
 * @property Settings_model $conf Settings module
 */
class Settings_model extends \CI_Model {
	private string $dbsandbox = 'appsolve_base';
//	private string $dbprod = 'compensapay';
	private string $dbprod = 'compensatest_base';
	public string $base = '';
	private string $enviroment = 'SANDBOX';
	public function __construct(){
		parent::__construct();
		$this->load->database();
	}

	/**
	 * @param $id
	 * @return mixed
	 */
	public function getNotificationsSettings($id, string $env = NULL): mixed
	{
		//Se declara el ambiente a utilizar
		$this->enviroment = $env === NULL ? $this->enviroment : $env;
		$this->base = strtoupper($this->enviroment) === 'SANDBOX' ? $this->dbsandbox : $this->dbprod;
		$query = "SELECT * FROM $this->base.conf_notifications WHERE user_id = '{$id}'";
		if ($result = $this->db->query($query)) {
			if ($result->num_rows() > 0) {
				return $result->result_array();
			}
		}
		return false;
	}

	/**
	 * Función para actualizar la configuración de las notificaciones
	 * @param array $args array con la configuración de las notificaciones
	 * @param string $id id del usuario que está actualizando la configuración
	 * @param string $env Environment
	 * @return array
	 */
	public function updateNotifications(array $args, string $id, string $env): array
	{
		$this->db->where('user_id', $id);
		$this->db->update('conf_notifications', $args);
		$n = $this->db->affected_rows();
		if ( $n >= 1){
			$update[0] = $n > 1 ? 'actualizaron' : 'actualizó';
			$update[1] = $n > 1 ? 'configuraciones' : 'configuración';
			return ['message' => "Se $update[0] $n $update[1]"];
		}else{
			return ['message' => "No hay cambios en la configuración"];
		}
	}
}
