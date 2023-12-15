<?php 
class User_model extends CI_Model {
    public function __construct() {
        parent::__construct();
        $this->load->database();
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
	public function setInitialConf($id){
		$query = "INSERT INTO compensatest_base.notifications (user_id) VALUES ('{$id}')";
		if($this->db->query($query)){
			return true;
		}
		return false;
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
}
