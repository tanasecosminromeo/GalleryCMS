<?php

class users_model extends CI_Model
{


public function is_valid_user($data) {
			
		$this->db->where( 'email', $data->username );
		$this->db->where( 'password', $data->password );
		$this->db->limit( 1 );
       	$query = $this->db->get( 'gcms_users' );
			
        if( $query->num_rows() > 0 ) {
            return $query->row();
        } else {
            return false;
        }
    }


public function admin_email_exist($email) {
			
		$this->db->where( 'email', $email );
		$this->db->where('usertype <', 2); 
		$this->db->limit( 1 );
       	$query = $this->db->get( 'gcms_users' );
			
        if( $query->num_rows() > 0 ) {
            return true;
        } else {
            return false;
        }
    }


}//end of model class