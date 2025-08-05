<?php defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model {

    public function insert_user($data) {
        return $this->db->insert('users', $data);
    }

    public function activate_user($token) {
        $this->db->where('activation_token', $token);
        $user = $this->db->get('users')->row();

        if ($user) {
            $this->db->where('id', $user->id);
            return $this->db->update('users', ['is_active' => 1, 'activation_token' => NULL]);
        }
        return false;
    }
}

?>
