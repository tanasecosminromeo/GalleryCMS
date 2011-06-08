<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Install extends Installer_Controller {
	
	
	function __construct() {
		
		parent::__construct();
		log_message('debug', "*** URI: " . $this -> uri -> ruri_string());

		//try to select the active database its either gonna be ok, 
		//or triger a codeigniter error to check the database setting
		// receive that name if it exist for future use.
		$this->dbname = $this->db->database;
		
		
		$this->load->library('form_validation');
		
	
		}

	function index() {
		$sys_data = $this->_system_checkup();
			
			$install_data = array(
                   'system_checkup'  => $sys_data['checkup_status'],
                   'system_checkup_time'     => now()
               );

		$this->session->set_userdata($install_data);
		
		$this->template->write_view('main_content', 'install/install_step1_view', $sys_data);
		$this->template->write('title', ' - Installer - Step 1: System Checkup');
		$this->template->render();

	}


	function step2() {
		
		$system_checkup = $this->session->userdata('system_checkup'); 
		
		if($system_checkup){
		
		$this->template->write_view('main_content', 'install/install_step2_view');
		$this->template->write('title', ' - Installer - Step 2: License Agreement');
		$this-> template->render();
		
		}else{
		$this->index();	
		}
		}//end of func step2


		function license_agree() {
		
		$system_checkup = $this->session->userdata('system_checkup'); 
		
		if($system_checkup){
				
		$this->form_validation->set_rules('agreeCheck', 'License Agreement.', 'callback__license_check');
		$this->form_validation->set_error_delimiters('<label class="error-box">', '</label>');
		 
		if($this->form_validation->run($this) == FALSE) {

			$this->step2();
		} else {
			
			$install_data = array(
               'agree_license'  => TRUE,
               'agree_license_time'     => now()
           );
			$this->session->set_userdata($install_data);	

			$this->step3();
		}
		
		}else{
		$this->index();	
		}
		
	}

	 function _license_check($str) {
	 	if ( !isset($str ) ) 
		  {
		    $this->form_validation->set_message('_license_check', 'You need to Agree to the License Agreement to proceed.');
		    return FALSE;
		  }
		
 		}


	function step3(){
			
			$system_checkup = $this->session->userdata('system_checkup'); 
			$agree_license = $this->session->userdata('agree_license');
		
		if($system_checkup && $agree_license){
			
			$this->template->write_view('main_content', 'install/install_step3_view');
			$this->template->write('title', ' - Installer - Step 3: Gallery Informations');
			$this-> template->render();
			}else{
				$this->index();
			}
	}


	function installgcms(){
		
		$system_checkup = $this->session->userdata('system_checkup'); 
		$agree_license = $this->session->userdata('agree_license');
		
		if($system_checkup && $agree_license){
		//site info	
		$this->form_validation-> set_rules('gname', 'Gallery Name', 'trim|required|min_length[2]|max_length[254]');
		$this->form_validation-> set_rules('gtitle', 'Gallery Title', 'trim|required|min_length[2]|max_length[254]');
		//admin info
		$this->form_validation-> set_rules('ganame', 'Administrator Name', 'trim|required|min_length[2]|max_length[254]');
		$this->form_validation-> set_rules('gausername', 'Administrator Username', 'trim|required|min_length[7]|max_length[36]');
		$this->form_validation-> set_rules('gapass', 'Admin Password', 'trim|required|min_length[8]|max_length[36]|matches[gapassconf]|sha1');
		$this->form_validation->set_rules('gapassconf', 'Admin Password Confirmation', 'trim|required');
		$this->form_validation->set_rules('gaemail', 'Admin Email Address', 'trim|required|valid_email');
		//other settings
		$this->form_validation-> set_rules('max_albums', 'Maximum Albums per user', 'numeric|trim|required|greater_than[0]|less_than[100]');
		$this->form_validation-> set_rules('max_imgs', 'Maximum Photos per Album', 'numeric|trim|required|greater_than[0]|less_than[999]');
		
		$this->form_validation-> set_rules('thumb_width', 'Thumbnails Width', 'numeric|trim|required|greater_than[10]|less_than[200]');
		$this->form_validation-> set_rules('thumb_height', 'Thumbnails Height', 'numeric|trim|required|greater_than[10]|less_than[200]');
		
		$this->form_validation-> set_rules('uploads_folder', 'Albums Uploads Folder', 'alpha_dash|trim|required|min_length[2]|max_length[12]');
		
		$this->form_validation->set_error_delimiters('<label class="error-box">', '</label>');
		 
		if($this->form_validation->run($this) == FALSE) {

			$this->step3();
		} else {
			
			$data->gname = $this->input->post('gname');
			$data->gtitle = $this->input->post('gtitle');
			$data->gurl = $this->input->post('gurl');
			$data->ganame = $this->input->post('ganame');
			$data->gausername = $this->input->post('gausername');
			$data->gapass = $this->input->post('gapass');
			$data->gaemail = $this->input->post('gaemail');
			$data->max_albums = $this->input->post('max_albums');
			$data->max_imgs = $this->input->post('max_imgs');
			$data->crop_imgs = $this->input->post('crop_imgs');
			$data->thumb_width = $this->input->post('thumb_width');
			$data->thumb_height = $this->input->post('thumb_height');
			$data->uploads_folder = $this->input->post('uploads_folder');
				
			$installed = $this->_process_install( $data );
			
			if($installed){
				
				$this->_done();
			}else{
				$this->_failed();
			}
			
			
		}//end of form_validation run
			
			
		}else{
		//if either system check failed or user didnt agree to license take back to system checkup.	
		$this->index();	
			
		}
		
		
	}// end of installcms

	function _process_install($data){
		
		
		// install database tables and insert settings and 1st user
		$status = $this->_create_gcms_tables();
		$status = $this->_insert_gcms_predata($data);
		$status = $this->_create_uploads_folder($data->uploads_folder);
		
		return $status;
	}

	function _done()
	{
			$this->template->write_view('main_content', 'install/install_final_view');
			$this->template->write('title', ' - Installer - Installation finished');
			$this-> template->render();	
			
			// places here to let last page of install show befoore we delete install files
			// commented for the moment.
			
			$this->_delete_install_files();
		
	}


	function _failed()
	{
			$this->template->write_view('main_content', 'install/install_failed_view');
			$this->template->write('title', ' - Installer - Installation didnt finish properly');
			$this-> template->render();	
		
	}




	
	function _create_gcms_tables(){
		
			$this->load->dbforge();
			
			$data['tables_status'] = true;
			
			if ($this->db->table_exists('gcms_users_groups')){
				$this->dbforge->rename_table('gcms_users_groups', 'bak_'.date('m-d-Y_h-m-s').'-gcms_users_groups');
			}
			$db_users_groups_fields = array('id' => array('type' => 'INT', 'auto_increment' => TRUE), 'users_group' => array('type' => 'VARCHAR', 'constraint' => '25'), 'group_id' => array('type' => 'TINYINT', 'constraint' => '2'), 'group_description' => array('type' => 'VARCHAR', 'constraint' => '255'), 'user_group_display' => array('type' => 'VARCHAR', 'constraint' => '255'), 'user_group_parms' => array('type' => 'VARCHAR', 'constraint' => '255') );
			$this->dbforge->add_field($db_users_groups_fields);
			$this->dbforge->add_key('id', TRUE);
			if( !$this->dbforge->create_table('gcms_users_groups', TRUE)) $data['tables_status'] = false;	
		
			
			if ($this->db->table_exists('gcms_users')){
			$this->dbforge->rename_table('gcms_users', 'bak_'.date('m-d-Y_h-m-s').'-gcms_users');
			}
			$db_users_fields = array('id' => array('type' => 'INT', 'auto_increment' => TRUE), 'name' => array('type' => 'VARCHAR', 'constraint' => '255'), 'username' => array('type' => 'VARCHAR', 'constraint' => '150'), 'password' => array('type' => 'VARCHAR', 'constraint' => '100'), 'email' => array('type' => 'VARCHAR', 'constraint' => '100'), 'usertype' => array('type' => 'TINYINT', 'constraint' => '2'), 'enabled' => array('type' => 'TINYINT', 'constraint' => '4'), 'register_date' => array('type' => 'DATETIME'), 'last_visit' => array('type' => 'DATETIME'), 'activation' => array('type' => 'TINYINT', 'constraint' => '2'), 'activation_code' => array('type' => 'VARCHAR', 'constraint' => '25'));
			$this->dbforge->add_field($db_users_fields);
			$this->dbforge->add_key('id', TRUE);
			if( !$this->dbforge->create_table('gcms_users', TRUE)) $data['tables_status'] = false;	
		

			if ($this->db->table_exists('gcms_users_forgot_pass')){
			$this->dbforge->rename_table('gcms_users_forgot_pass', 'bak_'.date('m-d-Y_h-m-s').'-gcms_users_forgot_pass');	
			}	
			$db_users_forgot_pass_fields = array('id' => array('type' => 'INT', 'auto_increment' => TRUE), 'user_id' => array('type' => 'VARCHAR', 'constraint' => '150'), 'email' => array('type' => 'VARCHAR', 'constraint' => '100'), 'reqdate' => array('type' => 'TIMESTAMP'), 'ip' => array('type' => 'VARCHAR', 'constraint' => '15'), 'retrival_code' => array('type' => 'VARCHAR', 'constraint' => '32'));
			$this->dbforge->add_field($db_users_forgot_pass_fields);
			$this->dbforge->add_key('id', TRUE);
			if( !$this->dbforge->create_table('gcms_users_forgot_pass', TRUE)) $data['tables_status'] = false;	
		
			
			if ($this->db->table_exists('gcms_settings')){
			$this->dbforge->rename_table('gcms_settings', 'bak_'.date('m-d-Y_h-m-s').'-gcms_settings');	
			}	
			$settings_fields = array('id' => array('type' => 'INT', 'auto_increment' => TRUE, ), 'option_name' => array('type' => 'VARCHAR', 'constraint' => '255'), 'option_value' => array('type' => 'VARCHAR', 'constraint' => '255'));
			$this->dbforge->add_field($settings_fields);
			$this->dbforge->add_key('id', TRUE);
			if( !$this->dbforge->create_table('gcms_settings', TRUE)) $data['tables_status'] = false;	
			
			
			if ($this->db->table_exists('gcms_albums')){
			$this->dbforge->rename_table('gcms_albums', 'bak_'.date('m-d-Y_h-m-s').'-gcms_albums');	
			}
			$gallery_albums_fields = array('id' => array('type' => 'INT', 'auto_increment' => TRUE, ), 'aurl_title' => array('type' => 'VARCHAR', 'constraint' => '255'), 'album' => array('type' => 'VARCHAR', 'constraint' => '255'), 'description' => array('type' => 'TEXT'), 'album_owner' => array('type' => 'INT', 'constraint' => '255'), 'apublished' => array('type' => 'TINYINT', 'constraint' => '2'), 'order_id' => array('type' => 'INT') );
			$this->dbforge->add_field($gallery_albums_fields);
			$this->dbforge->add_key('id', TRUE);
			if( !$this->dbforge->create_table('gcms_albums', TRUE)) $data['tables_status'] = false;	
			

			if ($this->db->table_exists('gcms_assets')){
			$this->dbforge->rename_table('gcms_assets', 'bak_'.date('m-d-Y_h-m-s').'-gcms_assets');	
			}		
			$gallery_assets_fields = array('id' => array('type' => 'INT', 'auto_increment' => TRUE, ), 'album_id' => array('type' => 'INT'), 'iurl_title' => array('type' => 'VARCHAR', 'constraint' => '255'), 'img_filename' => array('type' => 'VARCHAR', 'constraint' => '255'), 'thumb_filename' => array('type' => 'VARCHAR', 'constraint' => '255'), 'caption' => array('type' => 'TEXT'), 'img_tags' => array('type' => 'VARCHAR', 'constraint' => '255', ), 'img_owner' => array('type' => 'INT'), 'uploaded' => array('type' => 'DATETIME'), 'rated' => array('type' => 'TINYINT', 'constraint' => '2'), 'ipublished' => array('type' => 'TINYINT', 'constraint' => '2'), 'watermark' => array('type' => 'VARCHAR', 'constraint' => '255'), 'parms' => array('type' => 'VARCHAR', 'constraint' => '255'), 'order_num' => array('type' => 'INT'), 'viewed' => array('type' => 'INT'), 'emailed' => array('type' => 'INT') );
			$this->dbforge->add_field($gallery_assets_fields);
			$this->dbforge->add_key('id', TRUE);
			if( !$this->dbforge->create_table('gcms_assets', TRUE)) $data['tables_status'] = false;	
			
			

		return $data;
	}





	function _insert_gcms_predata($data){
		$this->load->model( 'installer_model', 'installer' );
		
		$datestring = "%Y:%m:%d %h:%i:%a";
        $time = time();
        $rightnow = mdate($datestring, $time);
		
		$status = true;
		
		$groups_data = array(
					'users_group' => 'super',
					'group_id'=> 0,
					'user_group_display' => 'Super Administrator',
					'group_description' => 'Admin of Admins'					
			); 
			
		if(!$this->installer->insert_data('gcms_users_groups', $groups_data)) $status = false;
		
		
		$groups_data2 = array(
					'users_group' => 'admins',
					'group_id'=> 1,
					'user_group_display' => 'Administrators',
					'group_description' => 'Admins'					
			); 
			
		if(!$this->installer->insert_data('gcms_users_groups', $groups_data2)) $status = false;
		
		
		$groups_data3 = array(
					'users_group' => 'users',
					'group_id'=> 2,
					'user_group_display' => 'Users',
					'group_description' => 'Simple User'					
			); 
			
		if(!$this->installer->insert_data('gcms_users_groups', $groups_data3)) $status = false;
		
		
		$admin_data = array(
					'name' => $data->ganame,
					'username' => $data->gausername,
					'password' => $data->gapass,
					'email' => $data->gaemail,			
					'usertype' => 0,
					'enabled' => true,
					'register_date' => $rightnow,
					'last_visit' => $rightnow,
					'activation' => true,						
			); 
			
		if(!$this->installer->insert_data('gcms_users', $admin_data)) $status = false;
		
		
		
		$settings_data1 = array(
					'option_name' => 'site_name',
					'option_value' => $data->gname					
			); 
			
		if(!$this->installer->insert_data('gcms_settings', $settings_data1)) $status = false;
		
		$settings_data2 = array(
					'option_name' => 'site_title',
					'option_value' => $data->gtitle					
			); 
			
		if(!$this->installer->insert_data('gcms_settings', $settings_data2)) $status = false;
		
		$settings_data3 = array(
					'option_name' => 'site_url',
					'option_value' => $data->gurl					
			); 
			
		if(!$this->installer->insert_data('gcms_settings', $settings_data3)) $status = false;
		
		$settings_data4 = array(
					'option_name' => 'max_albums',
					'option_value' => $data->max_albums					
			); 
			
		if(!$this->installer->insert_data('gcms_settings', $settings_data4)) $status = false;
		
		$settings_data5 = array(
					'option_name' => 'crop_imgs',
					'option_value' => $data->crop_imgs					
			); 
			
		if(!$this->installer->insert_data('gcms_settings', $settings_data5)) $status = false;
		
		$settings_data6 = array(
					'option_name' => 'max_imgs',
					'option_value' => $data->max_imgs					
			); 
			
		if(!$this->installer->insert_data('gcms_settings', $settings_data6)) $status = false;
		
		
		$settings_data7 = array(
					'option_name' => 'install_date',
					'option_value' => $rightnow					
			); 
			
		if(!$this->installer->insert_data('gcms_settings', $settings_data7)) $status = false;
		
		
			$settings_data8 = array(
					'option_name' => 'gcms_ver',
					'option_value' => '2.0'					
			); 
			
		if(!$this->installer->insert_data('gcms_settings', $settings_data8)) $status = false;
		
			$settings_data9 = array(
					'option_name' => 'gcms_admin_tpl',
					'option_value' => 'default'					
			); 
			
		if(!$this->installer->insert_data('gcms_settings', $settings_data9)) $status = false;
		
			$settings_data10 = array(
					'option_name' => 'gcms_users_tpl',
					'option_value' => 'default'					
			); 
			
		if(!$this->installer->insert_data('gcms_settings', $settings_data10)) $status = false;
		
		
			$settings_data11 = array(
					'option_name' => 'uploads_folder',
					'option_value' => './~'.$data->uploads_folder					
			); 
			
		if(!$this->installer->insert_data('gcms_settings', $settings_data11)) $status = false;
		
		
		
	return $status;
		
		
	}


	
	function _system_checkup() {
		
		$data['checkup_status'] = true;
		
		if(phpversion() <= "4.1.2") {
			$data['checkup_status'] = false;
			$data['phpver'] = "<span class='no'>" . phpversion() . " {You SHOULD upgrade this!}</span>";
		} else {
			$data['phpver'] =  "<span class='ok'>" . phpversion() . "</span>";
		}

		$data['php_api_ver'] = @php_sapi_name();

		if(ini_get("safe_mode")) {
			$data['checkup_status'] = false;
			$data['php_safe_mode_status'] = "<span class='no'>ON</span>";
		} else {
			$data['php_safe_mode_status'] = "<span class='ok'>OFF</span>";
		}

	
	if(ini_get('register_globals')) {
			$data['php_register_global_status'] = "<span class='warn'>ON</span>";
		} else {
			$data['php_register_global_status'] = "<span class='ok'>OFF</span>";
		}
		
		
		
		$data['php_set_time_limit'] = ini_get("max_execution_time");
		
		$data['php_disabled_functions'] = ini_get("disable_functions");
		
		$data['php_open_basedir'] = ini_get("open_basedir");
		
		if(@extension_loaded('session')){
		$data['php_sessions_support'] = "<span class='ok'></span>";
		}else{
		$data['checkup_status'] = false;	
		$data['php_sessions_support'] = "<span class='no'></span>";
		}
		
		if(ini_get('session.auto_start')){
		$data['php_session_auto_start'] = "<span class='ok'></span>";
		}else{
		$data['php_session_auto_start'] = "<span class='warn'></span>";	
		}
		
		if(ini_get('session.use_trans_sid')){
		$data['php_session_use_trans_sid'] = "<span class='ok'></span>";
		}else{
		$data['php_session_use_trans_sid'] = "<span class='warn'></span>";	
		}
		
		$data['php_session_save_path'] = ini_get("session.save_path");
		
		
		if(@get_magic_quotes_runtime() > 0){
		$data['php_magic_quotes'] = "<span class='ok'></span>";
		}else{
		$data['php_magic_quotes'] = "<span class='warn'></span>";	
		}
			
		if(@ini_get("output_buffering") > 0){
		$data['php_gzip'] = "<span class='ok'></span>";
		}else{
		$data['php_gzip'] = "<span class='warn'></span>";	
		}
		
		if(@extension_loaded('gd')) {
			$data['php_gd'] = "<span class='ok'></span>";
			$gd_status = true;
			}else{
			$gd_status = false;
			$data['php_gd'] = "<span class='no'> Used to create and manipulate image files in a variety of different image formats, including GIF, PNG, JPEG, WBMP, and XPM</span>";
			}
		
		exec("convert -version", $out, $rcode);
		if( $rcode == 0){
				$im_ver = $out[0];
				$imagic_status = true;
				$data['php_image_magic'] = "<span class='ok'>".$im_ver."</span>";
		}else{
				$imagic_status = false;
				$data['php_image_magic'] = "<span class='no'></span>";
		}
		
			//stop the install only if both gd And image magic are not available.
		if(!$gd_status && !$imagic_status ) $data['checkup_status'] = false;	
				
		if(@extension_loaded('zlib')) {
			$data['php_zlib'] = "<span class='ok'></span>";
			}else{
			$data['php_zlib'] = "<span class='warn'></span>";
			}


		if(@extension_loaded('openssl')) {
			$data['php_openssl'] = "<span class='ok'></span>";
			}else{
			$data['php_openssl'] = "<span class='warn'></span>";
			}
			
			
		if(@extension_loaded('curl')) {
			$data['php_curl'] = "<span class='ok'></span>";
			}else{
			$data['php_curl'] = "<span class='no'></span>";
			}
				
		
		if(@ini_get('file_uploads')) {
			$data['php_file_uploads'] = "<span class='ok'></span>";
			}else{
			$data['checkup_status'] = false;	
			$data['php_file_uploads'] = "<span class='no'></span>";
			}
			
		
		$data['php_upload_max_filesize'] = @ini_get('upload_max_filesize');
		
		$data['php_post_max_size'] = @ini_get('post_max_size');	

		$data['php_upload_tmp_dir'] = ini_get("upload_tmp_dir");
		
		if(function_exists('xml_parser_create')) {
			$data['php_xml_support'] = "<span class='ok'></span>";
			}else{
			$data['checkup_status'] = false;
			$data['php_xml_support'] = "<span class='no'></span>";
			}	
			
		if(@extension_loaded('ftp')) {
			$data['php_ftp_support'] = "<span class='ok'></span>";
			}else{
			$data['php_ftp_support'] = "<span class='warn'></span>";
			}		
			
			
		if(@extension_loaded('pfpro')) {
			$data['php_pfpro_support'] = "<span class='ok'></span>";
			}else{
			$data['php_pfpro_support'] = "<span class='warn'></span>";
			}			
		
		$data['php_sendmail_from'] = ini_get("sendmail_from");
		
		$data['php_sendmail_path'] = ini_get("sendmail_path");
		
		$data['php_smtp_settings'] = ini_get("SMTP");	
			
		$data['php_include_path'] = ini_get("include_path");
		
			
		
			//check folders status
			// './uploads'=>'777 read/write/execute (INCLUDE SUBDIRECTORIES TOO)',
			
			foreach(
			array(	APPPATH.'cache'=>'777 read/write/execute',
					APPPATH.'logs'=>'777 read/write (INCLUDE SUBDIRECTORIES TOO)') as $folder => $chmod)
					 {
				if(@is_writable($folder)){
				$status = '<span class="ok"> writable folder</span>';
				}else{
				$data['checkup_status'] = false;
				$status = '<span class="no"> unwritable folder : change permissions to  ' . $chmod . '</span>';
				}	 	
				$data['folders_status'][$folder]  = $status;
			}
		
		
	
		
		
		return $data;

	}// end of class system checkup
	

	function _delete_install_files(){
		
		
		// delete install controller
		$install_controller_filename = dirname(__FILE__).'/install.php';
		$deleted = unlink($install_controller_filename);
		
		// delete views folder
		$install_views_dir = APPPATH.'modules/home/views/install';
		$deleted = delete_directory($install_views_dir);
		
		// delete models folder
		$install_models_filename = APPPATH.'modules/home/models/installer_model.php';
		$deleted = unlink($install_models_filename);
		
		return $deleted;
	}
	
	
	function _create_uploads_folder($dir){
		
		$uploads_dir = './~'.$dir;
		//return true if dire exist or made.
		 
		$created = create_directory($uploads_dir);
		
		if($created){
			
			$data = '<html><head>
					<title>403 Forbidden</title>
					</head>
					<body>

					<p>Directory access is forbidden.</p>

					</body>
					</html>';

	
	if(!file_exists($uploads_dir.'/index.html')){
		
	if ( !write_file($uploads_dir.'/index.html', $data)) $created = false;
			
		}
	
	}
		
		return $created;
	}
	
	

}//end of controller class