<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Page_not_found extends Gcmsfeeds_Controller {
	
	
	function __construct() {
		
		parent::__construct();
		log_message('debug', "*** URI: " . $this -> uri -> ruri_string());
		
		}

	function index() {
		$this->load->view('common/error404_view');

	}

	
	
	
}//end of class