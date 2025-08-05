<?php defined('BASEPATH') OR exit('No direct script access allowed');

class SubjectModel extends CI_Model {

	  /**
     * @name string TABLE_NAME Holds the name of the table in use by this model
     */
	const TABLE_NAME = 'subjects';
	const USER_SUBJECT = 'user_subjects';
	const TOPIC = 'topic';
	const SUBJECTSTOPIC = 'subject_topic';
	

    /**
     * @name string PRI_INDEX Holds the name of the tables' primary index used in this model
     */
	const PRI_INDEX = 'subject_id';
	const TOPIC_INDEX = 'topic_id	';

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
                $this->db->where(self::PRI_INDEX, $where);
            }
        }
		$result = $this->db->get()->result();
		
       return $result;
          
	}


	public function getTopic($where = NULL) {
		$this->db->select('*');
        $this->db->from(self::TOPIC);
        if ($where !== NULL) {
            if (is_array($where)) {
                foreach ($where as $field=>$value) {
                    $this->db->where($field, $value);
                }
            } else {
                $this->db->where(self::TOPIC_INDEX, $where);
            }
        }
		$result = $this->db->get()->result();
		
       return $result;
          
	}


	public function getSubjectTopic($where = NULL) {
		$this->db->select('*');
        $this->db->from(self::SUBJECTSTOPIC);
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


	public function getUserSubject($where = NULL) {
		$this->db->select('*');
        $this->db->from(self::USER_SUBJECT);
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

	public function insertUserSubject(Array $data) {

		if ($this->db->insert(self::USER_SUBJECT, $data)) {
			return $this->db->insert_id();
		} else {
			return false;
		}
	}

	public function insertSubjectTopics(Array $data) {

		if ($this->db->insert(self::SUBJECTSTOPIC, $data)) {
			return $this->db->insert_id();
		} else {
			return false;
		}
	}


	public function insertSubjectsTopics(Array $data)
	{
		if ($this->db->insert(self::TOPIC, $data)) {
			return $this->db->insert_id();
		} else {
			return false;
		}
	}

	public function insertTopic(Array $data) {

		if ($this->db->insert(self::TOPIC, $data)) {
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
                $where = array(self::PRI_INDEX => $where);
            }
        $this->db->update(self::TABLE_NAME, $data, $where);
        return $this->db->affected_rows();
	}
	

	public function updateTopic(Array $data, $where = array()) {
		if (!is_array($where)) {
			$where = array(self::TOPIC_INDEX => $where);
		}
	$this->db->update(self::TOPIC, $data, $where);
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
