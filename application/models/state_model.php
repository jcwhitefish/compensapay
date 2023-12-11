<?php
class State_model extends CI_Model {
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }
    public function get_all_states() {
        $query = $this->db->get('cat_state');
        return $query->result();
    }
    public function get_state($id) { 
        $condiciones = array('stt_id' => $id);
        $query = $this->db->where($condiciones);
        $query = $this->db->get('cat_state');
        return $query->result(); 
    }
    
}
