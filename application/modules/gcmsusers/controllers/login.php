<?php

if (!defined('BASEPATH'))
  exit('No direct script access allowed');

class Login extends Gcmsadmin_Controller
{

  function __construct()
  {

    log_message('debug', "*** URI: " . $this->uri->ruri_string());

    parent::__construct();
    //get template name
    $this->template->set_master_template('../../public_html/gcmstpls/default/gcms_login_tpl.html');
    $this->template->write('page_title', 'Login');

    $this->load->library('form_validation');
    $this->load->library('session');

    // load model
    $this->load->model('users_model', 'users');
  }

  function index()
  {

    $this->template->write_view('main_content', 'login/login_view');
    $this->template->write('title', ' - Login');
    $this->template->render();
  }

  function go()
  {
    $entry_data->username = $this->input->post('username');
    $entry_data->password = sha1($this->input->post('password'));

    // field name, error message, validation rules
    $this->form_validation->set_rules('username', 'Email Address', 'trim|required|valid_email');
    $this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[4]|max_length[32]|xss_clean');

    if ($this->form_validation->run($this) == FALSE)
    {
      $this->index();
    } else
    {
      $validation = $this->_validate_cred($entry_data);

      if ($validation) // if the user's credentials validated...
      {
        $user = $this->users->get_user($entry_data);

        $sess = array(
            'username' => $user->username,
            'user_group' => $user->usertype,
            'user_id' => $user->id,
            'is_logged_in' => true
        );

        $this->session->set_userdata($sess);
        log_message('debug', "*** LOGIN: " . $user->username);

        $this->users->update_last_visit($user);
        //$this->users->log_login();
        //$this->users->last_login();

        redirect(base_url() . 'gcmsusers');
      } else // incorrect username or password
      {
        $data->error_string = 'Wrong Credentials!';

        $this->template->write('title', ' - Login!');
        $this->template->write_view('main_content', 'login/login_view', $data);
        $this->template->render();
      }
    }
  }

  function _validate_cred($data)
  {
    $is_admin_exist = $this->users->is_admin_exist($data);
    $is_admin = $this->users->is_admin($data);
    $is_admin_activated = $this->users->is_admin_activated($data);
    $is_admin_enabled = $this->users->is_admin_enabled($data);

    if ($is_admin_exist && $is_admin && $is_admin_activated && $is_admin_enabled)
    {
      return true;
    } else
    {
      return false;
    }
  }

  function leave()
  {
    $this->session->set_userdata(array('userid' => ''));
    $this->session->sess_destroy();
    redirect('login');
  }

}

//end of class