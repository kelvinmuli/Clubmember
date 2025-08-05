<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Corporate_member_model extends CI_Model {

    public function insert($data) {
        return $this->db->insert('corporate_members', $data);
    }

    // Get all records
    public function get_all() {
        $query = $this->db->get('corporate_members');
        return $query->result(); // Use result_array() if you want an array instead of objects
    }

    // Optional: Get a single record by ID
    public function get_by_id($user_id) {
        $this->db->where('user_id', $user_id);
        $query = $this->db->get('corporate_members');
        return $query->row(); // Use row_array() if you want an array instead of an object
    }
}
?>

