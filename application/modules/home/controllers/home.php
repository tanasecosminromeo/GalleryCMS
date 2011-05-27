<?php

if (!defined('BASEPATH'))
  exit('No direct script access allowed');

class Home extends Public_Controller
{

  function __construct()
  {
    log_message('debug', __CLASS__ . ".index()");
    /*
    parent::__construct();

    if ($this->db->table_exists('gcms_users'))
      redirect(base_url() . '/install');
    */


    $this->load->dbutil();

    if (!$this->dbutil->database_exists('gallerycms'))
    {
      echo '<strong><red>Oops! sorry, i can\'t locate your database.</red></strong> <br>';
      echo '1. create the \'gallerycms\' database. <br>';
      echo '2. setup your database configuration in (application\config) folder and try again. thank you.';
      die();
    }
  }

  public function index()
  {
    $this->load->view('welcome_message');
  }

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */