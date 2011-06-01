<?php

if (!defined('BASEPATH'))
  exit('No direct script access allowed');

class Gcmsusers extends Gcmsusers_Controller
{

  function __construct()
  {

    parent::__construct();
    $this->load->library('session');
    log_message('debug', "*** URI: " . $this->uri->ruri_string());
  }

  function index()
  {
    if (!$this->session->userdata('is_logged_in'))
    {
      redirect(base_url().'gcmsusers/login');
      return;
    }    

    $this->template->write_view('main_content', 'index/index_view');
    $this->template->write('title', ' - Home');
    $this->template->render();
  }

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */