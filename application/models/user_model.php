<?php
/**
 * Class User_model model
 * @property User_model $dataUsr User module
 */
class User_model extends CI_Model {
	private string $enviroment = 'SANDBOX';
	private string $dbsandbox = 'compensatest_base';
//	private string $dbprod = 'compensapay';
	private string $dbprod = 'compensatest_base';
	public string $base = '';

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
	public function get_userById(int $id) {
		
        $usuario = array();

		$query = "SELECT * FROM compensatest_base.users WHERE id = '{$id}'";
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
    public function reset_password($usuario){
        $query = "SELECT id, email, name, last_name FROM users WHERE user LIKE '".$usuario."' OR email LIKE '".$usuario."' LIMIT 1";

        if($result = $this->db->query($query))
        {
            $usermail = $result->result_array();

            foreach($usermail as $value)
            {
                $id = $value["id"];
            }

            //resetea password en base de datos
            $query2 = "UPDATE users SET password = NULL WHERE Id='".$id."'";
            $this->db->query($query2);
        }
        return $usermail;
    }

	/**
	 * Función para generar la configuración inicial de una empresa
	 * @param int $id ID de la empresa a la que se le añade la información
	 * @return bool
	 */
	public function setInitialConf(int $id): bool
	{
		$query = "INSERT INTO compensatest_base.notifications (user_id) VALUES ('{$id}')";
		if($this->db->query($query)){
			return true;
		}
		return false;
	}
	/**
	 * Función para obtener los datos de la/s fintech de una compañía
	 * @param int         $id Id de compañía a obtener datos
	 * @param string|NULL $env Ambiente en el cúal se va a trabajar
	 * @return array arreglo con los resultados de la consulta
	 */
	public function getFintechInfo(int $id, string $env=NULL): array
	{
		//Se declara el ambiente a utilizar
		$this->enviroment = $env === NULL ? $this->enviroment : $env;
		$this->base = strtoupper($this->enviroment) === 'SANDBOX' ? $this->dbsandbox : $this->dbprod;
		//Se crea el query para obtener las facturas
		$query = "SELECT * FROM compensatest_base.fintech WHERE companie_id = '$id'";
		//Verífica que se ejecute bien el query
		if($res = $this->db->query($query)){
			//Verífica que haya resultados
			if ($res->num_rows() > 0) {
				//se crea un único arreglo con la información de los movimientos y se envía
				return ["code" => 200,"result" => $res->result_array()];
			}
			//Se devuelve una respuesta de que la compañía no cuenta con registro de una FINTECH
			return ["code" => 404, "message" => "No se encontraron resultados", "reason" => "La compañía no se encuentra registrada a una FINTECH"];
		}
		return ["code" => 500, "message" => "Error al extraer la información", "reason" => "Error con la fuente de información"];
	}
}
