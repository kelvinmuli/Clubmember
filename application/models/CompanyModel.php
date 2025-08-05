<?php defined('BASEPATH') OR exit('No direct script access allowed');

class CompanyModel extends CI_Model {

	  /**
     * @name string TABLE_NAME Holds the name of the table in use by this model
     */
	const TABLE_NAME = 'zidii_clubs';
	const USER_COMPANIES = 'user_companies';

	
    /**
     * @name string PRI_INDEX Holds the name of the tables' primary index used in this model
     */
	const company_docs = 'company_docs';
   
    /**
     * Retrieves record(s) from the database
     *
     * @param mixed $where Optional. Retrieves only the records matching given criteria, or all records if not given.
     *                      If associative array is given, it should fit field_name=>value pattern.
     *                      If string, value will be used to match against PRI_INDEX
     * @return mixed Single record if ID is given, or array of results
     */

    public function get($where = NULL) {
		$this->db->select('*');
        $this->db->from(self::TABLE_NAME);
        if ($where !== NULL) {
            if (is_array($where)) {
                foreach ($where as $field=>$value) {
                    $this->db->where($field, $value);
                }
            } else {
                $this->db->where('club_id', $where);
            }
        }
		$result = $this->db->get()->result();
		
       return $result;
          
	}

    public function getusers($where = NULL) {
        $this->db->select('*');
        $this->db->from('users');
        if ($where !== NULL) {
            if (is_array($where)) {
                foreach ($where as $field=>$value) {
                    $this->db->where($field, $value);
                }
            } else {
                $this->db->where('user_id', $where);
            }
        }
        $result = $this->db->get()->result();
        
       return $result;
          
    }



     public function getCompanyDocs($where = NULL) {

        $this->db->select('*');
        $this->db->from("company_docs");
        if ($where !== NULL) {
            if (is_array($where)) {
                foreach ($where as $field=>$value) {
                    $this->db->where($field, $value);
                }
            } else {
                $this->db->where('club_id', $where);
            }
        }
        $result = $this->db->get()->result();
        
       return $result;
          
    }


	public function getUserCompanies($where = NULL) {
		$this->db->select('*');
        $this->db->from(self::USER_COMPANIES);
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

    public function getCompaniesFromUserId($user_id)
    {
        $companyArr = [];
        $userCompanies = $this->getUserCompanies(array('user_id'=>$user_id));
        foreach ($userCompanies as $value) { array_push($companyArr,$value->company_id); }

        if(!empty($companyArr)){
        $this->db->select('*');
        $this->db->from('zidii_clubs');
        $this->db->order_by('club_name', 'ASC');
        $this->db->where_in('club_id',$companyArr);
        $result = $this->db->get()->result();
        }

        return $result;
    }



    /**
     * Inserts new data into database
     *
     * @param Array $data Associative array with field_name=>value pattern to be inserted into database
     * @return mixed Inserted row ID, or false if error occured
     */
    public function insert(Array $data) {

		if ($this->db->insert(self::TABLE_NAME, $data)) {
			return $this->db->insert_id();
		} else {
			return false;
		}
	}


	public function insertUserCompanies(Array $data) {

		if ($this->db->insert(self::USER_COMPANIES, $data)) {
			return $this->db->insert_id();
		} else {
			return false;
		}
	}

	
    /**
     * Updates selected record in the database
     *
     * @param Array $data Associative array field_name=>value to be updated
     * @param Array $where Optional. Associative array field_name=>value, for where condition. If specified, $id is not used
     * @return int Number of affected rows by the update query
     */
    public function update(Array $data, $where = array()) {
            if (!is_array($where)) {
                $where = array('club_id' => $where);
            }
        $this->db->update(self::TABLE_NAME, $data, $where);
        return $this->db->affected_rows();
	}

     public function updateuser(Array $data, $where = array()) {
            if (!is_array($where)) {
                $where = array('user_id' => $where);
            }
        $this->db->update('users', $data, $where);
        return $this->db->affected_rows();
    }


    /**
     * Deletes specified record from the database
     *
     * @param Array $where Optional. Associative array field_name=>value, for where condition. If specified, $id is not used
     * @return int Number of rows affected by the delete query
     */
    public function delete($where = array()) {
        if (!is_array($where)) {
            $where = array(self::PRI_INDEX => $where);
        }
        $this->db->delete(self::TABLE_NAME, $where);
        return $this->db->affected_rows();
	}
	


}

/* End of file ModelName.php */


?>
