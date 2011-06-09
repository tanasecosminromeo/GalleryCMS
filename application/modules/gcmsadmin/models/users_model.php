<?php

class users_model extends CI_Model
{

	public function countAll()
	    {
	            return $this->db->count_all('gcms_users');
	    }
	
	public function countByUserType($type)
    {
            $this->db->where( 'usertype', $type );	
            return $this->db->count_all_results('gcms_users');
    }
	
	
     public function getOffsetAll($limit, $offset) {
         $offset = intval( $offset );
         $limit = intval( $limit );

        //get all records from users table
        $this->db->order_by("id", "asc");
        $this->db->limit($limit, $offset);

       $this->db->select('gcms_users.*', FALSE);
       $this->db->select('gcms_users_groups.group_id, gcms_users_groups.user_group_display', FALSE);
       $this->db->select('gcms_albums.aurl_title, gcms_albums.aurl_title');

       $this->db->join('gcms_users_groups', 'gcms_users_groups.group_id = gcms_users.usertype', 'left');
       $this->db->join('gcms_albums', 'gcms_albums.album_owner = gcms_users.id', 'left');

        $query = $this->db->get('gcms_users');

        if( $query->num_rows() > 0 ) {
            return $query->result();
        } else {
            return array();
        }
    } //end getAll by offset
    	
	
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