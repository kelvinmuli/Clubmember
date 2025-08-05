<?php

class RegisterModel extends CI_Model{

    public function add_user($data){
        //get the data from controller and insert into the table 'users'
        return $this->db->insert('zidii_users', $data);
    }

    public function insertBonds(Array $data) {
        if ($this->db->insert('zidii_bid_bonds', $data)) {
            return $this->db->insert_id();
        } else {
            return false;
        }
    }

     public function insertUserAgent(Array $data) {
        if ($this->db->insert('zidii_users', $data)) {
            return $this->db->insert_id();
        } else {
            return false;
        }
    }


     public function getBonds($where = NULL) {
        $this->db->select('*');
        $this->db->from('zidii_bid_bonds');
        if ($where !== NULL) {
            if (is_array($where)) {
                foreach ($where as $field=>$value) {
                    $this->db->where($field, $value);
                }
            } else {
                $this->db->where('bid_bond_id', $where);
            }
        }
        $result = $this->db->get()->result();
       
       return $result;
    }


     public function getUserAgents($where = NULL) {
        $this->db->select('*');
        $this->db->from('zidii_users');
        if ($where !== NULL) {
            if (is_array($where)) {
                foreach ($where as $field=>$value) {
                    $this->db->where($field, $value);
                }
            } else {
                $this->db->where('id', $where);
            }
        }
        $result = $this->db->get()->result();
       
       return $result;
    }

}
