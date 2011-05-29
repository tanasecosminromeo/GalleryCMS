<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 *
 * @access public
 */

class installer_model extends CI_Model {
		
	
	function insert_data( $table, $data)
		{
			$insert = $this->db->insert($table, $data);
			return $insert;
		}	
	
	
	
		
		
}//end of class
	