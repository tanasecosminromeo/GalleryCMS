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

	function index() {
		
		//$data = $this->_list_users();
		
		
		        $data['limit'] = 1;
        $data['total'] = $this->users->countAll();
		
 			 if ($data['total'] > $data['limit'] ){
                $offset = $this->uri->segment(3);
                }else{
                $offset = '';
                }
                
		$config['base_url'] = base_url().'gcmsadmin/users';

		$config['total_rows'] = $data['total'];
		$config['per_page'] = $data['limit'];
		$config['full_tag_open'] = '<div id="pagination">';
		$config['full_tag_close'] = '</div>';

		$this->pagination->initialize($config);


                if( $data['total']== 0 ){
                    $data['err_message'] = 'No Records!';
                    }else{
                    $data['records'] = $this->_get_users($data['limit'], $offset);
                    $data['page_links'] = $this->pagination->create_links();

                    }
		
		
		$this->template->write_view('user_panel', 'users/user_panel_view');	
		$this->template->write_view('main_content', 'users/users_view', $data);
		$this->template->write('title', ' - Users Manager');
		$this->template->render();

	}

	function _get_users($limit = NULL, $offset = NULL) {
                return $this->users->getOffsetAll($limit, $offset);
		}
	
	 function _list_users() {

        $data['limit'] = 1;
        $data['total'] = $this->users->countAll();
		
 			 if ($data['total'] > $data['limit'] ){
                $offset = $this->uri->segment(3);
                }else{
                $offset = '';
                }
                
		$config['base_url'] = base_url().'gcmsadmin/users';

		$config['total_rows'] = $data['total'];
		$config['per_page'] = $data['limit'];
		$config['full_tag_open'] = '<div id="pagination">';
		$config['full_tag_close'] = '</div>';

		$this->pagination->initialize($config);


                if( $data['total']== 0 ){
                    $data['err_message'] = 'No Records!';
                    }else{
                    $data['records'] = $this->_get_users($data['limit'], $offset);
                    $data['page_links'] = $this->pagination->create_links();

                    }

             return $data;
	}
	
	
}//end of class