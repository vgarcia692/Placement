<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Schools_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function get_all_schools() {
        $this->db->distinct();
        $this->db->select('high_school');
        $query = $this->db->get('exams');
        return $query->result_array();
    }

}