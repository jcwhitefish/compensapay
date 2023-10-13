<?php 
class User_model extends CI_Model {
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }
    public function insert_user($datos) {
        // Asegurar que solo se insertan las columnas deseadas
        $columnas_permitidas = ['user', 'password', 'id_profile', 'name', 'last_name', 'email', 'telephone', 'id_question', 'answer', 'id_companie', 'manager', 'unique_key'];

        // Filtrar solo las columnas permitidas
        $datos_insertar = array_intersect_key($datos, array_flip($columnas_permitidas));

        // Insertar datos en la base de datos
        $this->db->insert('usuarios', $datos_insertar);

        // Devolver el ID del último registro insertado
        return $this->db->insert_id();
    }
}
