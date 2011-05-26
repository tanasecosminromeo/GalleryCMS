<?php
class Install extends Public_Controller {
		
	function __construct()
	{
	log_message('debug', "*** URI: ".$this->uri->ruri_string());
	parent::__construct();
	
	}	
	
	
	function index() {
		$this->load->view('install/install_view');
	}
	
	function gentables() {
		
		$this->load->library('form_validation');
		$this->form_validation->set_rules('username', 'Username', 'trim|required|min_length[5]');
		$this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[5]|matches[passconf]|md5');
		$this->form_validation->set_rules('passconf', 'Password Confirmation', 'trim|required');
		
		if ($this->form_validation->run() == FALSE) {
			
			$this->index();
			
		} else {		
			$us = $this->input->post('username');
			$pw = $this->input->post('password');
			
			$this->load->dbforge();
			
			$db_users_fields = array(
		                        'id' => array(
		                                                 'type' => 'INT',
		                                                 'auto_increment' => TRUE,
		                                          ),
		                        'username' => array(
		                                                 'type' => 'VARCHAR',
		                                                 'constraint' => '255',
		                                          ),
		                        'password' => array(
		                                                 'type' =>'VARCHAR',
		                                                 'constraint' => '255',
		                                          ),
		                );
			$this->dbforge->add_field($db_users_fields);
			$this->dbforge->add_key('id', TRUE);
			$this->dbforge->create_table('gcms_users', TRUE);
		
		
			$gallery_categories_fields = array(
		                        'id' => array(
		                                                 'type' => 'INT',
		                                                 'auto_increment' => TRUE,
		                                          ),
		                        'title' => array(
		                                                 'type' => 'VARCHAR',
		                                                 'constraint' => '255',
		                                          ),
		                        'description' => array(
		                                                 'type' =>'TEXT',
		                                          ),
		                        'order_id' => array(
		                                                 'type' => 'INT',
		                                          ),
		                );
			$this->dbforge->add_field($gallery_categories_fields);
			$this->dbforge->add_key('id', TRUE);
			$this->dbforge->create_table('gcms_categories', TRUE);
		
		
			$gallery_assets_fields = array(
		                        'img_id' => array(
		                                                 'type' => 'INT',
		                                                 'auto_increment' => TRUE,
		                                          ),
		                        'cat_id' => array(
		                                                 'type' => 'INT',
		                                          ),
		                        'order_num' => array(
														'type' =>'INT',
		                                          ),
		                        'filename' => array(
		                                                'type' => 'VARCHAR',
														'constraint' => '255',
		                                          ),
								'thumbnail' => array(
					                                    'type' => 'VARCHAR',
														'constraint' => '255',
					                                          ),
								'caption' => array(
					                                    'type' => 'TEXT',
					                                          ),
		                );
		
			$this->dbforge->add_field($gallery_assets_fields);
			$this->dbforge->add_key('img_id', TRUE);
			$this->dbforge->create_table('gcms_assets', TRUE);
		
		
			$settings_fields = array(
		                        'id' => array(
		                                                 'type' => 'INT',
		                                                 'auto_increment' => TRUE,
		                                          ),
		                        'thumb_width' => array(
		                                                 'type' => 'INT',
		                                          ),
		                        'thumb_height' => array(
														'type' =>'INT',
		                                          ),
		                        'crop' => array(
		                        						'type' => 'ENUM',
		                        						'constraint' => "'Y','N'",
		                        						'default' => "Y",
		                        					),
		                );
			$this->dbforge->add_field($settings_fields);
			$this->dbforge->add_key('id', TRUE);
			$this->dbforge->create_table('gcms_settings', TRUE);
		
			$sett->thumb_width = 100;
			$sett->thumb_height = 75;
			$sett->crop = "Y";
			
			$createSampleSettings = $this->db->insert('settings', $sett);
		
			$this->username = $us;
			$this->password = $pw;
			$insertNew = $this->db->insert('gcms_users', $this);
			if ($insertNew) {
				$this->_created($us,$pw);
			} else {
				echo("Operation Failed!");
			}
		}	
	}
	function _created($us, $pw) {
		$this->load->model('users_model', 'users');
		$results = $this->users->login($us,$pw);
		if ($results == false) redirect(base_url().'gcmsadmin/login');
		else {
			$this->session->set_userdata(array('userid'=>$results));
			redirect('/');
		}
	}
}