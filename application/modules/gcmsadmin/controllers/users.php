<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Users extends Gcmsadmin_Controller {
	
	
	function __construct() {
		
		parent::__construct();
		log_message('debug', "*** URI: " . $this -> uri -> ruri_string());
		
	if (!$this->session->userdata('is_admin_logged_in'))
    {
      redirect(base_url() . 'gcmsadmin/login');
    }   
		//load necessary libs.
		$this->load->library('pagination');
		$this->load->library('form_validation');
		
	   // load model
    	$this->load->model('users_model', 'users');
		
		//widgets
		$stats = $this->_user_stats();
		$this->template->write_view('sidebar', 'widgets/user_stat_view', $stats);	
		$this->template->write_view('user_panel', 'users/user_panel_view');	
		}

	function index() {
		
		//main content
		$data = $this->list_users();
		$this->template->write_view('main_content', 'users/users_view', $data);
		$this->template->write('title', ' - Users Manager');
		$this->template->render();
		
	}

	function _get_users($limit = NULL, $offset = NULL) {
                return $this->users->getOffsetAll($limit, $offset);
		}
	
	 function list_users() {

        $per_page = 10;
       	$offset = $this->uri->segment(4);
	    
		$config['base_url'] = site_url('gcmsadmin/users/index');

		$config['total_rows'] = $this->users->countAll();
		$config['per_page'] = $per_page;
		$config['full_tag_open'] = '<div id="pagination">';
		$config['full_tag_close'] = '</div>';
		$config['next_link'] = 'Next';
		$config['prev_link'] = 'Previous';
		$config['first_tag_close'] = '</div>';
		
		
		$config['uri_segment'] = '4';
		
		$this->pagination->initialize($config);

			
			
                if( $config['total_rows']>0 ){
                    $data['records'] = $this->_get_users($per_page, $offset);
                    $data['page_links'] = $this->pagination->create_links();

                    }
				$data['total'] = $config['total_rows'];
				$data['limit'] = $per_page;
				
       return $data;
	}
	
	
	function _user_stats(){
		
		$data['super_admins'] = $this->users->countByUserType(0);
		$data['admins'] = $this->users->countByUserType(1);
		$data['users'] = $this->users->countByUserType(2);
		
		return $data;
	}
	
	
	function add(){
		
		//main content
		$this->template->write_view('main_content', 'users/add_user_view');
		$this->template->write('title', ' - Add New User');
		$this->template->render();
		
	}//end of add user func
	
	function process_new_user(){
		
	

    // field name, error message, validation rules
   	$this->form_validation-> set_rules('fname', 'User Full Name', 'trim|required|min_length[2]|max_length[254]');
	$this->form_validation-> set_rules('uname', 'User Username', 'trim|required|min_length[7]|max_length[36]|unique[gcms_users.username]');
	$this->form_validation-> set_rules('upass', 'User Password', 'trim|required|min_length[8]|max_length[36]|matches[upassconf]|sha1');
	$this->form_validation->set_rules('upassconf', 'User Password Confirmation', 'trim|required');
	$this->form_validation->set_rules('uemail', 'User Email Address', 'trim|required|valid_email|unique[gcms_users.email]');
	
    // set new delimiter
    $this->form_validation->set_error_delimiters('<div class="error-box">', '</div>');

    if ($this->form_validation->run($this) == FALSE)
    {
      $this->add();
    }
    else
    {
     
	$entry_data->fname = trim($this->input->post('fname'));
	$entry_data->uname = trim($this->input->post('uname'));
	$entry_data->uemail = trim($this->input->post('uemail'));
	$entry_data->upass = sha1(trim($this->input->post('upass')));
	$entry_data->usertype = trim($this->input->post('usertype'));
	//insert data and create user sub-folder /~username
	
	
	
	if(!$this->users->add($entry_data) || !$this->_create_user_fldr($entry_data->uname)) {
			$data->err_message 	= 'I couldn\'t add this user to the database, or create his home folder, check the your configuration!';
			
      }else{
      		$data->err_message 	= '<div class="success-box"> User Added Successfully </div>';
			
      }
		//main content
		$this->template->write_view('main_content', 'users/add_user_view', $data);
		$this->template->write('title', ' - Add New User');
		$this->template->render();
	
    }
		
		
		
	}//end of function process_new_user
	
	
	function _create_user_fldr($foldername){
		
		$this->upload_fldr = modules::run('gcmsadmin/common/_read_setting', 'uploads_folder');
		
		$usr_uploads_dir = $this->upload_fldr.'/~'.$foldername;
		 
		$created = create_directory($usr_uploads_dir);
		
				if($created){
			
			$data = '<html><head>
					<title>403 Forbidden</title>
					</head>
					<body>

					<p>Directory access is forbidden.</p>

					</body>
					</html>';

	
	if(!file_exists($usr_uploads_dir.'/index.html')){
		
	if ( !write_file($usr_uploads_dir.'/index.html', $data)) $created = false;
			
		}
	
	}
		
		return $created;
		
	}
	
	
	function update(){
		
		
		
		
		
		
		
	}//end of update user func
	
	function delete(){
		
		
		
		
		
		
		
	}//end of delete user func
	
	
}//end of class