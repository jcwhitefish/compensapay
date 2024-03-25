<?php 
class Company_model extends CI_Model {
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }
    // Funcion para registrar las companias
    public function insert_company($datos) {
        // Asegurar que solo se insertan las columnas deseadas
        $columnas_permitidas = ['legal_name', 'short_name', 'id_type', 'rfc', 'id_fiscal', 'id_postal_code', 'id_country', 'address', 'telephone', 'account_clabe', 'id_broadcast_bank', 'dias_pago', 'unique_key'];

        // Filtrar solo las columnas permitidas
        $datos_insertar = array_intersect_key($datos, array_flip($columnas_permitidas));

        // Insertar datos en la base de datos
        $this->db->insert('companies', $datos_insertar);

        // Devolver el ID del último registro insertado
        return $this->db->insert_id();
    }
    public function get_company($condiciones) {
        // TODO: Asi podemos traer 1 registro en especifico bajo ciertas condiciones
        //$this->db->select('rec_supplier.rec_id, companies.*, COUNT(accionistas.id) AS accionistas');
        $this->db->select('stp_kyc.kyc_id, stp_perfiltransaccional.pt_id, stp_propietarioreal.Id AS propietarioReal, companies.*, COUNT(stp_usuarios.id) AS StpUsuarios, COUNT(stp_contactos.id) AS StpContactos', 'fintech.arteria_clabe AS finclabe');
        $this->db->from('companies');
        //$this->db->join('rec_supplier', 'rec_supplier.id_com = companies.id', 'left');
        $this->db->join('stp_kyc', 'stp_kyc.idCompanie = companies.id', 'left');
        $this->db->join('stp_perfiltransaccional', 'stp_perfiltransaccional.idCompanie = companies.id', 'left');
        $this->db->join('stp_propietarioreal', 'stp_propietarioreal.idCompanie = companies.id', 'left');
        $this->db->join('stp_usuarios', 'stp_usuarios.idCompanie = companies.id', 'left');
        $this->db->join('stp_contactos', 'stp_contactos.idCompanie = companies.id', 'left');
        $this->db->join('fintech', 'fintech.companie_id = companies.id', 'left');
        $this->db->where('companies.id', $condiciones['id']);
        $query = $this->db->get();
        //$query = $this->db->get_where('companies', $condiciones);
        return $query->row_array();
    }

    public function get_company_by_rfc($rfc) {
        $this->db->select('c.*');
		$this->db->from('companies as c');
		$this->db->where('c.rfc', $rfc);
        $query = $this->db->get();
        return $query->result();
    }
}
