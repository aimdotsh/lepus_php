<?php 
class Backup_model extends CI_Model{

	protected $table='backup';
    
    function get_total_rows(){
		$this->db->from($this->table);
        return $this->db->count_all_results();
	}
    
    function get_total_record(){
        $query = $this->db->get($this->table);
		if ($query->num_rows() > 0)
		{
			return $query->result_array();
		}
	}
    
    function get_total_record_paging($limit,$offset){
        $this->db->limit($limit,$offset);
        $query = $this->db->get($this->table);
		if ($query->num_rows() > 0)
		{
			return $query->result_array();
		}
	}
    
	
    
}

/* End of file Backup_model.php */
/* Location: ./application/models/Backup_model.php */
