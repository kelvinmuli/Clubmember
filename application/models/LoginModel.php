<?php

class LoginModel extends CI_Model {


    public function checkLogin($email, $password) {
        //query the table 'users' and get the result count
        $this->db->where('email', $email);
        $this->db->where('password', $password);
        $query = $this->db->get('users');

        return $query->num_rows();
    }


    public function login($email, $password){

        $this->db->select('*');
        $this->db->from('users');
        $this->db->where('email', $email);
        $this->db->where('password', $password);
        $this->db->limit(1);

        $query = $this->db->get();

        if ($query->num_rows() == 1) {
            return $query->result();
        } else {
            return false;
        }
    }



    public function checkUserReset($email){

        $this->db->select('*');
        $this->db->from('users');
        $this->db->where('email', $email);
        $this->db->limit(1);

        $query = $this->db->get();

        if ($query->num_rows() == 1) {
            return $query->result();
        } else {
            return false;
        }
    }


    public function get($where = NULL) {

        $this->db->select('*');
        $this->db->from("users");
        if ($where !== NULL) {
            if (is_array($where)) {
                foreach ($where as $field=>$value) {
                    $this->db->where($field, $value);
                }
            } else {
                $this->db->where("user_id", $where);
            }
        }

        $result = $this->db->get()->result();
       
        return $result;
        
	}
	
	 
	/**
     * Inserts new data into database
     *
     * @param Array $data Associative array with field_name=>value pattern to be inserted into database
     * @return mixed Inserted row ID, or false if error occured
     */
    public function insert(Array $data) {

		if ($this->db->insert('users', $data)) {
			return $this->db->insert_id();
		} else {
			return false;
		}
	}


     public function updateUser(Array $data, $where = array()) {
            if (!is_array($where)) {
                $where = array('user_id' => $where);
            }
        $this->db->update('users', $data, $where);
        return $this->db->affected_rows();
    }


}
