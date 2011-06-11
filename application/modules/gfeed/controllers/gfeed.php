<?php

if (!defined('BASEPATH'))
  exit('No direct script access allowed');

class Gfeed extends Gcmsfeeds_Controller
{

  function __construct()
  {
    log_message('debug', __CLASS__ . ".index()");
    parent::__construct();

  $filename = APPPATH . 'modules/home/controllers/install.php';
    if (file_exists($filename))
    {
      redirect(base_url() . 'install');
    }
	
	$this->load->model('gfeed_model', 'gfeed');
  }

  public function _index()
  {
  
  }
  
  
  	function xml() {
  		
		
	}
	
	
	function json() {
	
	
	}

}

