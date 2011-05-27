<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends Public_Controller {

	function __construct()
	{
		log_message('debug', __CLASS__.".index()");
        parent::__construct();
		
		if ($this->db->table_exists('gcms_users')) redirect(base_url().'/install');
				
	}
	
	
	public function index()
	{
		$this->load->view('welcome_message');
	}
	
	
	
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */