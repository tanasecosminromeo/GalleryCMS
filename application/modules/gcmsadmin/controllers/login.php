<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');



class Login extends Gcmsadmin_Controller{


         function __construct()
    {
           
        log_message('debug', "*** URI: ".$this->uri->ruri_string());
		
             parent::__construct();
			  //get template name
            $this->template->set_master_template('../../public_html/gcmstpls/default/gcms_login_tpl.html');
            $this->template->write('page_title', 'Administration Login');
			
			$this->load->library('form_validation');
			//autoloaded
			//$this->load->library('session');
			
			
			// load model
			$this->load->model('users_model', 'users');
	}
	
	
	function index() {
		
		$this->template->write_view('main_content', 'users/login_view');
		$this->template->write('title', ' - Login');
		$this->template->render();

	}
	
	public	function go()
	{		
        $entry_data->username = trim($this->input->post('username'));
		$entry_data->password = sha1(trim($this->input->post('password')));

		// field name, error message, validation rules
		$this->form_validation->set_rules('username', 'Email Address', 'trim|required|valid_email');
		$this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[4]|max_length[32]');
	
		 // set new delimiter
	    $this->form_validation->set_error_delimiters('<div class="error-box">', '</div>');
		
		if($this->form_validation->run($this) == FALSE)
		{
				$this->index();
		}
		
		else
		{			
			$validation = $this->_validate_cred( $entry_data );
			
			if(!$validation->err_status) // if the user's credentials validated...
			{
				  $sess = array(
								'username' => $validation->username,
                                'user_group' => $validation->usertype,
                                'user_id' =>$validation->id,
								'is_logged_in' => true
								);
								
					$this->session->set_userdata($sess);
					

                    //$this->users->log_login();
                    //$this->users->last_login();
					
				redirect(base_url().'gcmsadmin');
			}
			else // incorrect username or password
			{
				
                $this->template->write('title', ' - Login!');
				$this->template->write_view('main_content', 'users/login_view', $validation);
				$this->template->render();
				
			}		
		}	
	}
	
	
	function _validate_cred( $cred ){
		
		$valid = $this->users->is_valid_user($cred);
			
		if(!$valid){
			
			$data->err_message ='Email Address  or password Error!';
			$data->err_status = true; 
			
		}else{
			
						
		if( $valid->usertype > 2 ){
			//user is not an admin he is a simple user	
			redirect(base_url().'gcmsusers');
			
			}elseif(!$valid->activation){
			$data->err_message ='Admin Not Active Yet! Contact -- '.base_url().' Administrator to Activate it -- Sorry for the inconvinience ';
			$data->err_status = true; 
			
			}elseif(!$valid->enabled){
			
			$data->err_message ='You didn\'t Verify your account Yet, open the email that we sent you and click the link to activate your account! ';
			$data->err_status = true; 	
			}else {
				
			$data = $valid;	
			$data->err_status = false; 		
			}
			
			
			
		}
				
		return $data;
	}
	

	function leave() {
		$sess = array(
					'username' => '',
                    'user_group' => '',
                    'user_id' => '',
					'is_logged_in' => false
					);
		$this->session->set_userdata($sess);
		$this->session->sess_destroy();
		redirect(base_url().'gcmsadmin/login');
	}
	
}//end of class