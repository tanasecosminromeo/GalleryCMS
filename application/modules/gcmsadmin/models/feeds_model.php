<?php

class feeds_model extends CI_Model
{

	public function countAll()
	    {
	            return $this->db->count_all('gcms_feeds');
	    }
		
	public function countByID($uid)
	    {
	            $this->db->where('fowner', $uid);	
	            return $this->db->count_all_results('gcms_feeds');
	    }	
		
	public function countStatusByID($uid, $p)
	    {
	            $this->db->where('fowner', $uid);
				$this->db->where('fpublished', $p);	
				//not marked deleted
				$this->db->where('fdeleted', 0);	
				
	            return $this->db->count_all_results('gcms_feeds');
	    }		
		
		
		
		
		
		
		
}//end of class