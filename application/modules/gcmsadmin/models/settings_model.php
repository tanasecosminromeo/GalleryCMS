<?php

class settings_model extends CI_Model
{


	function _read_global_settings() {
   
    $query = $this->db->get( 'gcms_settings' );

    if( $query->num_rows() > 0 ) {
    	return $query->result();
    } else {
        return false;
    }
    } //end read config


function _read_setting( $string ) {
   			$this->db->where('option_name', $string);
			$this->db->limit( 1 );
    $query = $this->db->get( 'gcms_settings' );
	

    if( $query->num_rows() > 0 ) {
    		$row = $query->row();
            return $row->option_value;
        } else {
            return false;
        }
    } //end read config




}//end of model class