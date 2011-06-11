<?php

if (!defined('BASEPATH'))
  exit('No direct script access allowed');

class Login extends Gcmsadmin_Controller
{

  function __construct()
  {

    log_message('debug', "*** URI: " . $this->uri->ruri_string());

    parent::__construct();


    $filename = APPPATH . 'modules/home/controllers/install.php';
    if (file_exists($filename))
    {
     
      redirect(base_url() . 'install');
    }


    //get template name
    $this->template->set_master_template('../../public_html/gcmstpls/default/gcms_login_tpl.html');
    $this->template->write('page_title', 'Administration Login');

    $this->load->library('form_validation');

    // load model
    $this->load->model('users_model', 'users');
  }

  function index()
  {

    $this->template->write_view('main_content', 'users/login_view');
    $this->template->write('title', ' - Login');
    $this->template->render();
  }

  public function go()
  {
    $entry_data->username = trim($this->input->post('username'));
    $entry_data->password = sha1(trim($this->input->post('password')));

    // field name, error message, validation rules
    $this->form_validation->set_rules('username', 'Email Address', 'trim|required|valid_email|chkmx|doexist[gcms_users.email]');
    $this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[4]|max_length[32]');

    // set new delimiter
    $this->form_validation->set_error_delimiters('<div class="error-box">', '</div>');

    if ($this->form_validation->run($this) == FALSE)
    {
      $this->index();
    }
    else
    {
      $validation = $this->_validate_cred($entry_data);

      if (!$validation->err_status) // if the user's credentials validated...
      {
        $sess = array(
            'username' => $validation->username,
            'group_id' => $validation->usertype,
            'user_id' => $validation->id,
            'is_admin_logged_in' => true
        );

        $this->session->set_userdata($sess);


        //$this->users->log_login();
        //$this->users->last_login();

        redirect(base_url() . 'gcmsadmin');
      }
      else // incorrect username or password
      {

        $this->template->write('title', ' - Login!');
        $this->template->write_view('main_content', 'users/login_view', $validation);
        $this->template->render();
      }
    }
  }

  function _validate_cred($cred)
  {

    $valid = $this->users->is_valid_user($cred);

    if (!$valid)
    {

      $data->err_message = 'Email Address  or password Error!';
      $data->err_status = true;
    }
    else
    {
      if ($valid->usertype > 1)
      {
        //user is not an admin he is a simple user	
        redirect(base_url() . 'gcmsusers');
      }
      elseif (!$valid->activation)
      {
        $data->err_message = 'Admin Not Active Yet! Contact -- ' . base_url() . ' Administrator to Activate it -- Sorry for the inconvinience ';
        $data->err_status = true;
      }
      elseif (!$valid->enabled)
      {

        $data->err_message = 'You didn\'t Verify your account Yet, open the email that we sent you and click the link to activate your account! ';
        $data->err_status = true;
      }
      else
      {

        $data = $valid;
        $data->err_status = false;
      }
    }

    return $data;
  }

  function password_recovery()
  {

    $this->template->write('title', ' - Password Recovery!');
    $this->template->write('page_title', 'Password Recovery', TRUE);
    $this->template->write_view('main_content', 'users/password_recovery_view');
    $this->template->render();
  }

  function password_recovery_go()
  {
    // field name, error message, validation rules
    $this->form_validation->set_rules('email', 'email', 'trim|required|valid_email|chkmx|doexist[gcms_users.email]');
    // set new delimiter
    $this->form_validation->set_error_delimiters('<div class="error-box">', '</div>');

    if ($this->form_validation->run($this) == FALSE)
    {
      $this->password_recovery();
    }
    else
    {
      $email = trim($this->input->post('email'));
      $emailsent = $this->_recovery_code_email($email);

      if ($emailsent) // email sent
      {
        $data['err_message'] = 'We Sent you an email!';
      }
      else // email wasnt sent
      {
        $data['err_message'] = 'Unknown error happened while sending you the reset code contact the administrator for help!';
      }

      $this->template->write('title', ' - Password Recovery!');
      $this->template->write('page_title', 'Password Recovery', TRUE);
      $this->template->write_view('main_content', 'users/password_recovery_view', $data);
      $this->template->render();
    }
  }

//end of password_recovery_go




  function _recovery_code_email($email)
  {

    $data = $this->users->admin_email_exist($email);
    $data->reset_code = generate_random_code();

    $register_request = $this->users->register_reset_request($data);
    $send_email = $this->_send_recovery_email($data);


    return true;
  }

  function _send_recovery_email($data)
  {
    $this->load->library('email');

    //get contact name - email
    $toname = $data->name;
    $toemail = $data->email;
    $domain = $_SERVER['HTTP_HOST'];

    $this->email->set_newline("\r\n");
    $this->email->from('no-reply@' . $domain, $domain . ' support');
    $this->email->to($toemail);
    $subject = 'Password Reset Request';
    $this->email->subject($subject);

    $email_message = $this->load->view("users/emails/password_recovery_email_view.php", $data, true);

    $this->email->message($email_message);

    if ($this->email->send())
    {
      return true;
    }
    else
    {
      //show_error($this->email->print_debugger());

      return false;
    }
  }

  function reset_password($reset_code = NULL)
  {
    if (empty($reset_code))
    {
      $reset_code = trim($this->input->post('reset_code'));
    }

    $is_valid_code = $this->users->is_valid_reset_code($reset_code);

    if ($is_valid_code)
    {
      $request_date_plus = mysql_to_unix($is_valid_code->reqdate) + 86400;
      $now = time();
      $request_life = $now - $request_date_plus;

      if ($request_life <= 0)
      {
        $this->template->write('title', ' - Password Recovery!');
        $this->template->write('page_title', 'Password Change', TRUE);
        $this->template->write_view('main_content', 'users/password_change_view', $is_valid_code);
        $this->template->render();
      }
      else
      {

        $this->users->delete_reset_code($reset_code);
        echo "Reset Code Expired Request  new one Please!";
        die();
      }
    }
    else
    {

      echo "Invalid Reset Code!";
      die();
    }
  }

//end of function

  function password_change_go()
  {

    // field name, error message, validation rules
    $this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[4]|max_length[32]');
    $this->form_validation->set_rules('password2', 'Password Confirmation', 'trim|required|min_length[4]|max_length[32]|matches[password]');

    // set new delimiter
    $this->form_validation->set_error_delimiters('<div class="error-box">', '</div>');

    if ($this->form_validation->run($this) == FALSE)
    {
      $this->reset_password($this->input->post('reset_code'));
    }
    else
    {
      $new_password = sha1(trim($this->input->post('password')));
      $this->users->change_password($new_password, $this->input->post('user_id'));

      $this->users->delete_reset_code($this->input->post('reset_code'));

      redirect(base_url() . 'gcmsadmin/login');
    }
  }

  function leave()
  {
    $sess = array(
        'username' => '',
        'group_id' => '',
        'user_id' => '',
        'is_logged_in' => false
    );
    $this->session->set_userdata($sess);
    $this->session->sess_destroy();
    redirect(base_url() . 'gcmsadmin/login');
  }

}

//end of class