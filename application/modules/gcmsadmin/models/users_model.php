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
            return $query->row();
        } else {
            return false;
        }
    }

public function register_reset_request($data){
	
		$ip_address = $this->session->userdata('ip_address');
		
		$datestring = "%Y:%m:%d - %h:%i:%a";
		$time = time();
		$rightnow = mdate($datestring, $time);

		$admin_forgot_pass_data = array(
			'user_id' => $data->id,
			'email' => $data->email,
			'reqdate' =>  $rightnow,
			'ip' => $this->input->ip_address(),			
			'retrival_code' => $data->reset_code			
		);
		
		$insert = $this->db->insert('gcms_users_forgot_pass', $admin_forgot_pass_data);
		return $insert;
	
}

	public function is_valid_reset_code($reset_code){
		
			$this->db->where( 'retrival_code', $reset_code );
			$this->db->limit( 1 );
	       	$query = $this->db->get( 'gcms_users_forgot_pass' );
				
	        if( $query->num_rows() > 0 ) {
	            return $query->row();
	        } else {
	            return false;
	        }
		
		
	}
	
	
	public function delete_reset_code( $reset_code ) {
      
	  return $this->db->delete( 'gcms_users_forgot_pass', array( 'retrival_code' => $reset_code ) );
	   
    } //end delete

	public function change_password($new_password, $user_id){
		
		  $update = array(
            'password' => $new_password
        );

        $this->db->update( 'gcms_users', $update, array( 'id' => $user_id ) );
		
	}

}//end of model class