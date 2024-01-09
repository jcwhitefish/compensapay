<?php 
class User_model extends CI_Model {
	private string $dbsandbox = 'appsolve_base';
//	private string $dbprod = 'compensapay';
	private string $dbprod = 'compensatest_base';
	public string $base = '';
	private string $enviroment = 'SANDBOX';
    public function __construct() {
        parent::__construct();
        $this->load->database();
		$this->base = $this->enviroment === 'SANDBOX' ? $this->dbsandbox : $this->dbprod;
    }
    public function insert_user($datos) {
        // Asegurar que solo se insertan las columnas deseadas
        $columnas_permitidas = ['user', 'password', 'id_profile', 'name', 'last_name', 'email', 'telephone', 'id_question', 'answer', 'id_company', 'manager', 'unique_key'];

        // Filtrar solo las columnas permitidas
        $datos_insertar = array_intersect_key($datos, array_flip($columnas_permitidas));

        // Insertar datos en la base de datos
        $this->db->insert('users', $datos_insertar);

        // Devolver el ID del último registro insertado
        return $this->db->insert_id();
    }
    public function get_user($condiciones) {
        // TODO: Asi podemos traer 1 registro en especifico bajo ciertas condiciones
        $query = $this->db->get_where('users', $condiciones);
        return $query->row_array();
    }
	public function get_userById(int $id, string $env = NULL){
		//Se declara el ambiente a utilizar
		$this->enviroment = $env === NULL ? $this->enviroment : $env;
		$this->base = strtoupper($this->enviroment) === 'SANDBOX' ? $this->dbsandbox : $this->dbprod;
        $usuario = array();

		$query = "SELECT * FROM $this->base.users WHERE id = '{$id}'";
		if ($result = $this->db->query($query)) {
			if ($result->num_rows() > 0) {
				$usuario = $result->result_array();
			}
		}

        $query2 = "SELECT * FROM cat_preguntas ORDER BY pg_id ASC";
        if ($result2 = $this->db->query($query2)) {
			if ($result2->num_rows() > 0) {
				$preguntas = $result2->result_array();
			}
		}

        array_push($usuario, $preguntas);
        
        return $usuario;
	}
    public function update_user($id, $nuevos_datos)  {
        $condiciones = array('id' => $id);
        $this->db->where($condiciones);
        $this->db->update('users', $nuevos_datos);
    }
    public function imprimir()  {
        echo 'Hola mundo';
    }
	public function setInitialConf($id, string $env = NULL){
		//Se declara el ambiente a utilizar
		$this->enviroment = $env === NULL ? $this->enviroment : $env;
		$this->base = strtoupper($this->enviroment) === 'SANDBOX' ? $this->dbsandbox : $this->dbprod;
		$query = "INSERT INTO $this->base.notifications (user_id) VALUES ('{$id}')";
		if($this->db->query($query)){
			return true;
		}
		return false;
	}
}
