<?php

if (!defined('BASEPATH'))
  exit('No direct script access allowed');

class Common extends MX_Controller
{

  protected $data = array();

  function __construct()
  {
    parent::__construct();
  }

  function _index()
  {
    
  }

  function _read_global_settings()
  {

    $this->load->model('settings_model', 'settings');

    $data = $this->settings->_read_global_settings();

    if (!$data)
    {

      echo "<strong>General Error Cant Read your Site Settings</strong>, contact your Administrator Please. ";
      die();
    }


    foreach ($data as $row)
    {
      $settings_data[$row->option_name] = $row->option_value;
    }

    return $settings_data;
  }

}

//end of class