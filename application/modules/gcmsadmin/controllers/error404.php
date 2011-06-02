<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Error404 extends Gcmsadmin_Controller {
	
	
	function __construct() {
		
		parent::__construct();
		log_message('debug', "*** URI: " . $this -> uri -> ruri_string());
		
		  //get template name
            $this->template->set_master_template('../../public_html/gcmstpls/default/gcms_error_tpl.html');
         
		}

	function index() {
		
		$this->template->write_view('main_content', 'common/error404_view');
		$this->template->write('title', ' - 404 Page Not Found!');
		$this->template->render();

	}

	
	
	
}//end of class