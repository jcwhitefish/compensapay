<?php
class Question_model extends CI_Model {
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }
    public function get_all_questions() {
        $query = $this->db->get('cat_preguntas');
        return $query->result();
    }

    
}
