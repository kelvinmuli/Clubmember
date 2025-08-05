<?php
class Property_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function insert_property($data) {
        return $this->db->insert('properties', $data);
    }
}
