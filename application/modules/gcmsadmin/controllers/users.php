<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Users extends Gcmsadmin_Controller {
	
	
	function __construct() {
		
		parent::__construct();
		log_message('debug', "*** URI: " . $this -> uri -> ruri_string());
		
	if (!$this->session->userdata('is_logged_in'))
    	{
      	redirect(base_url().'gcmsadmin/login');
    	}    
		//load necessary libs.
		$this->load->library('pagination');
		
	   // load model
    	$this->load->model('users_model', 'users');
		}

	function _index() {
		
	}

	function _get_users($limit = NULL, $offset = NULL) {
                return $this->users->getOffsetAll($limit, $offset);
		}
	
	 function list_users() {

        $per_page = 10;
       	$offset = $this->uri->segment(4);
	    
		$config['base_url'] = site_url('gcmsadmin/users/list_users');

		$config['total_rows'] = $this->users->countAll();
		$config['per_page'] = $per_page;
		$config['full_tag_open'] = '<div id="pagination">';
		$config['full_tag_close'] = '</div>';
		$config['uri_segment'] = '4';
		
		$this->pagination->initialize($config);

			
			
                if( $config['total_rows']>0 ){
                    $data['records'] = $this->_get_users($per_page, $offset);
                    $data['page_links'] = $this->pagination->create_links();

                    }
				$data['total'] = $config['total_rows'];
				$data['limit'] = $per_page;
				
        $this->template->write_view('user_panel', 'users/user_panel_view');	
		$this->template->write_view('main_content', 'users/users_view', $data);
		$this->template->write('title', ' - Users Manager');
		$this->template->render();
	}
	
	
}//end of class