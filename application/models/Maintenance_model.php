<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Maintenance_model extends CI_Model {

    /**
     * @name string TABLE_NAME Holds the name of the table in use by this model
     */
    const USER_TYPE_TABLE = 'user_type';
    const TABLE_DEPT = "m_department";
    const USER_RIGHTS_TABLE  = 'user_rights';
    const MODULE_TABLE = 'maintenance_module';
    const TABLE_TITLE = 'm_title';
    const TABLE_GENDER = 'm_gender';
    const TABLE_BRANCH = 'm_branch';
    const TABLE_LEADSOURCE = 'leadssources';
    const TABLE_LEADSTATUS = 'leadsstatus';
    const TABLE_EMPLOYEEMAP = 'employee_map';

    
    public function getEmployeeMap($where = NULL) {
         //get session data

        $this->db->select('*');
        $this->db->from(self::TABLE_EMPLOYEEMAP);
        if ($where !== NULL) {
            if (is_array($where)) {
                foreach ($where as $field=>$value) {
                    $this->db->where($field, $value);
                }
            } else {
                $this->db->where("map_id",$where);
            }
        }
        $result = $this->db->get()->result();
        
        return $result;

    }

    public function getLeadStatus($where = NULL) {
         //get session data
        $session_data = $this->common->loadSession();
        $customer_id = $session_data['customer_id'];

        $this->db->select('*');
        $this->db->from(self::TABLE_LEADSTATUS);

        if ($where !== NULL) {
            if (is_array($where)) {
                foreach ($where as $field=>$value) {
                    $this->db->where($field, $value);
                }
            } else {
                $this->db->where("lead_status_id",$where);
            }
        }
        $result = $this->db->get()->result();
        
        return $result;

    }

    public function getLeadSources($where = NULL) {
         //get session data
        $session_data = $this->common->loadSession();
        $customer_id = $session_data['customer_id'];

        $this->db->select('*');
        $this->db->from(self::TABLE_LEADSOURCE);

        if ($where !== NULL) {
            if (is_array($where)) {
                foreach ($where as $field=>$value) {
                    $this->db->where($field, $value);
                }
            } else {
                $this->db->where("lead_sources_id",$where);
            }
        }
        $result = $this->db->get()->result();
        
        return $result;

    }

    public function getBranch($where = NULL) {
         //get session data
        $session_data = $this->common->loadSession();
        $customer_id = $session_data['customer_id'];

        $this->db->select('*');
        $this->db->from(self::TABLE_BRANCH);

        if ($where !== NULL) {
            if (is_array($where)) {
                foreach ($where as $field=>$value) {
                    $this->db->where($field, $value);
                }
            } else {
                $this->db->where("branch_id",$where);
            }
        }
        $result = $this->db->get()->result();
        
        return $result;
    
    }
    
    public function getGender($where = NULL) {
         //get session data
        $session_data = $this->common->loadSession();
        $customer_id = $session_data['customer_id'];

        $this->db->select('*');
        $this->db->from(self::TABLE_GENDER);

        if ($where !== NULL) {
            if (is_array($where)) {
                foreach ($where as $field=>$value) {
                    $this->db->where($field, $value);
                }
            } else {
                $this->db->where("gender_id",$where);
            }
        }
        $result = $this->db->get()->result();
        
        return $result;
    
    }

    public function getTitle($where = NULL) {
         //get session data
        $session_data = $this->common->loadSession();
        $customer_id = $session_data['customer_id'];

        $this->db->select('*');
        $this->db->from(self::TABLE_TITLE);

        if ($where !== NULL) {
            if (is_array($where)) {
                foreach ($where as $field=>$value) {
                    $this->db->where($field, $value);
                }
            } else {
                $this->db->where("title_id",$where);
            }
        }
        $result = $this->db->get()->result();
        
        return $result;
    
    }

    public function getUserType($where = NULL) {
         //get session data
        $session_data = $this->common->loadSession();
        $customer_id = $session_data['customer_id'];

        $this->db->select('*');
        $this->db->from(self::USER_TYPE_TABLE);

        if ($where !== NULL) {
            if (is_array($where)) {
                foreach ($where as $field=>$value) {
                    $this->db->where($field, $value);
                }
            } else {
                $this->db->where("user_type_id",$where);
            }
        }
        $result = $this->db->get()->result();
        
        return $result;
    
    }

     public function getUserTypeDefault($where = NULL) {
         //get session data

        $this->db->select('*');
        $this->db->from(self::USER_TYPE_TABLE);
        if ($where !== NULL) {
            if (is_array($where)) {
                foreach ($where as $field=>$value) {
                    $this->db->where($field, $value);
                }
            } else {
                $this->db->where("user_type_id",$where);
            }
        }
        $result = $this->db->get()->result();
        
        return $result;
    
    }

     public function getUserRights($where = NULL) {
         //get session data
        $session_data = $this->common->loadSession();

        $this->db->select('*');
        $this->db->from(self::USER_RIGHTS_TABLE);
        if ($where !== NULL) {
            if (is_array($where)) {
                foreach ($where as $field=>$value) {
                    $this->db->where($field, $value);
                }
            } else {
                $this->db->where("id", $where);
            }
        }
        $result = $this->db->get()->result();
       return $result;
    }

     public function getModule($where = NULL) {
       
        $this->db->select('*');
        $this->db->from(self::MODULE_TABLE);
        $this->db->order_by('order', 'asc');
        if ($where !== NULL) {
            if (is_array($where)) {
                foreach ($where as $field=>$value) {
                    $this->db->where($field, $value);
                }
            } else {
                $this->db->where("module_id", $where);
            }
        }

         $result = $this->db->get()->result();
       return $result;
    }


     public function getDept($where = NULL)
    {
          //get session data
        $session_data = $this->common->loadSession();
        $customer_id = $session_data['customer_id'];

        $this->db->select('*');
        $this->db->from(self::TABLE_DEPT);

        if ($where !== NULL) {
            if (is_array($where)) {
                foreach ($where as $field=>$value) {
                    $this->db->where($field, $value);
                }
            } else {
                $this->db->where("department_id", $where);
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
    
    
    public function insertBranch(Array $data) {
        if ($this->db->insert(self::TABLE_BRANCH, $data)) {
            return $this->db->insert_id();
        } else {
            return false;
        }
    }

    public function insertGender(Array $data) {
        if ($this->db->insert(self::TABLE_GENDER, $data)) {
            return $this->db->insert_id();
        } else {
            return false;
        }
    }

    public function insertTitle(Array $data) {
        if ($this->db->insert(self::TABLE_TITLE, $data)) {
            return $this->db->insert_id();
        } else {
            return false;
        }
    }

    public function insertUserType(Array $data) {
        if ($this->db->insert(self::USER_TYPE_TABLE, $data)) {
            return $this->db->insert_id();
        } else {
            return false;
        }
    }

     
    public function insertDepartmentType(Array $data) {
        if ($this->db->insert(self::DEPARTMENT_TYPE, $data)) {
            return $this->db->insert_id();
        } else {
            return false;
        }
    }

    
    public function insertUserRights(Array $data)
    {
        if ($this->db->insert(self::USER_RIGHTS_TABLE, $data)) {
        return $this->db->insert_id();
        } else {
        return false;
        }
    }  

    public function insertDept(Array $data)
    {
        if ($this->db->insert(self::TABLE_DEPT, $data)) {
        return $this->db->insert_id();
        } else {
        return false;
        }
    }

    public function insertLeadSorce(Array $data)
    {
        if ($this->db->insert(self::TABLE_LEADSOURCE, $data)) {
        return $this->db->insert_id();
        } else {
        return false;
        }
    }

    public function insertStatus(Array $data)
    {
        if ($this->db->insert(self::TABLE_LEADSTATUS, $data)) {
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
    

    public function updateBranch(Array $data, $where = array()) {
            if (!is_array($where)) {
                $where = array('branch_id' => $where);
            }
        $this->db->update(self::TABLE_BRANCH, $data, $where);
        return $this->db->affected_rows();
    }

    public function updateGender(Array $data, $where = array()) {
            if (!is_array($where)) {
                $where = array('gender_id' => $where);
            }
        $this->db->update(self::TABLE_GENDER, $data, $where);
        return $this->db->affected_rows();
    }

    public function updateTitle(Array $data, $where = array()) {
            if (!is_array($where)) {
                $where = array('title_id' => $where);
            }
        $this->db->update(self::TABLE_TITLE, $data, $where);
        return $this->db->affected_rows();
    }

    public function updateUserType(Array $data, $where = array()) {
            if (!is_array($where)) {
                $where = array('user_type_id' => $where);
            }
        $this->db->update(self::USER_TYPE_TABLE, $data, $where);
        return $this->db->affected_rows();
    }

    public function updateDept(Array $data, $where = array()) {
            if (!is_array($where)) {
                $where = array('department_id' => $where);
            }
        $this->db->update(self::TABLE_DEPT, $data, $where);
        return $this->db->affected_rows();
    }

    public function updateLeadSources(Array $data, $where = array()) {
            if (!is_array($where)) {
                $where = array('lead_sources_id' => $where);
            }
        $this->db->update(self::TABLE_LEADSOURCE, $data, $where);
        return $this->db->affected_rows();
    }

    public function updateLeadStatus(Array $data, $where = array()) {
            if (!is_array($where)) {
                $where = array('lead_status_id' => $where);
            }
        $this->db->update(self::TABLE_LEADSTATUS, $data, $where);
        return $this->db->affected_rows();
    }
    



    /**
     * Deletes specified record from the database
     *
     * @param Array $where Optional. Associative array field_name=>value, for where condition. If specified, $id is not used
     * @return int Number of rows affected by the delete query
     */
    public function delete($where = array()) {
        if (!is_array()) {
            $where = array(self::PRI_INDEX => $where);
        }
        $this->db->delete(self::TABLE_NAME, $where);
        return $this->db->affected_rows();
    }

        public function deleteUserRight($where = array()) {
        if (!is_array($where)) {
            $where = array('id' => $where);
        }
        $this->db->delete(self::USER_RIGHTS_TABLE, $where);
        return $this->db->affected_rows();
    }
}
        



?>
