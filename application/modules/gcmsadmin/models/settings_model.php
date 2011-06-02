<?php

class settings_model extends CI_Model
{


	function _read_global_settings() {
   
    $query = $this->db->get( 'gcms_settings' );

    if( $query->num_rows() > 0 ) {
    	
		$rows = $query->result();
		
        return $rows;
    } else {
        return false;
    }
    } //end read config


}//end of model class