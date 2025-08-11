<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class MaintenanceModel extends GlobalModel 
{
	public function getTable($table, $column_id='', $where = NULL, $order = NULL) 
	{
        $this->db->select('*');
        $this->db->from($table);
		if ($order !== NULL) 
		{
			$this->db->order_by('order', $order);
		}
        if ($where !== NULL) 
		{
            if (is_array($where)) 
			{
                foreach ($where as $field=>$value) 
				{
                    $this->db->where($field, $value);
                }
            } 
			else 
			{
                $this->db->where($column_id, $where);
            }
        }
        return $this->db->get()->result();
    }

	public function getTableRow($table, $column_id, $where, $who = '*') 
	{
        $this->db->select($who);
        $this->db->from($table);
		if (is_array($where)) 
		{
			foreach ($where as $field => $value) 
			{
				$this->db->where($field, $value);
			}
		} 
		else 
		{
			$this->db->where($column_id, $where);
		}
        return $this->db->get()->row();
    }
}
