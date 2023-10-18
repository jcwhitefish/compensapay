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
    public function update_user($id, $nuevos_datos)  {
        $condiciones = array('id' => $id);
        $this->db->where($condiciones);
        $this->db->update('users', $nuevos_datos);
    }
    public function imprimir()  {
        echo 'Hola mundo';
    }
}
