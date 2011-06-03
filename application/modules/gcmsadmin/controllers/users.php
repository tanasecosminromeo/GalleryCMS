<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Users extends Gcmsadmin_Controller {
	
	
	function __construct() {
		
		parent::__construct();
		log_message('debug', "*** URI: " . $this -> uri -> ruri_string());
		
	if (!$this->session->userdata('is_logged_in'))
    	{
      	redirect(base_url().'gcmsadmin/login');
    	}    
	
	
		}

	function index() {
		
		$this->template->write_view('user_panel', 'users/user_panel_view');	
		$this->template->write_view('main_content', 'users/users_view.php');
		$this->template->write('title', ' - Users Manager');
		$this->template->render();

	}

	
	
	
}//end of class