<?php

if (!defined('BASEPATH'))
  exit('No direct script access allowed');

class Home extends CI_Controller
{

 	function __construct()
	{
		log_message('debug', __CLASS__.".index()");
        parent::__construct();
	
		$filename = dirname(__FILE__).'/install.php';
		if (file_exists($filename)) redirect(base_url().'install');
				
	}

  public function index()
  {
    $this->load->view('home_view');
  }

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */