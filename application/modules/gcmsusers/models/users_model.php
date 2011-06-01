<?php

class Users_Model extends CI_Model
{
  const SUPER_ADMIN = 1;
  const ADMIN = 2;
  const USER = 3;
  const ENABLED = 1;
  const ACTIVATED = 1;

  public function doUsersExist()
  {
    if (!$this->db->table_exists('gcms_users'))
      redirect('/install/install');
  }

  public function login($username, $password)
  {
    $query = $this->db->get_where('gcms_users', array('username' => $username, 'password' => $password));
    if ($query->num_rows() == 0)
      return false;
    else
    {
      $result = $query->result();
      $userid = $result[0]->id;
      return $userid;
    }
  }

  public function changepw()
  {
    $this->password = $_POST['password'];
    $insertNew = $this->db->update('gcms_users', $this, array('id' => $_POST['id']));
    if ($insertNew)
    {
      redirect('gcmsadmin/profile/success');
    } else
    {
      echo("Operation Failed");
    }
  }

  public function getUserByName($value)
  {
    $this->db->where('username', $value);
    $query = $this->db->get('gcms_users');
    return $query->result();
  }

  public function get_user($data)
  {
    $query = $this->db->get_where('gcms_users', array('email' => $data->username, 'password' => $data->password));
    return $query->row();
  }

  public function is_admin_exist($data)
  {
    $query = $this->db->get_where('gcms_users', array('email' => $data->username, 'password' => $data->password));
    if ($query->num_rows() > 0)
    {
      return true;
    } else
    {
      return false;
    }
  }

  public function is_admin($data)
  {
    $this->db->where('email', $data->username);
    $this->db->where('password', $data->password);
    $this->db->where('usertype', self::SUPER_ADMIN);
    $this->db->or_where('usertype', self::ADMIN);
    $query = $this->db->get('gcms_users');
    if ($query->num_rows() > 0)
    {
      return true;
    } else
    {
      return false;
    }
  }

  public function is_admin_activated($data)
  {
    $this->db->where('email', $data->username);
    $this->db->where('password', $data->password);
    $this->db->where('activation', self::ACTIVATED);
    $query = $this->db->get('gcms_users');
    if ($query->num_rows() > 0)
    {
      return true;
    } else
    {
      return false;
    }
  }

  public function is_admin_enabled($data)
  {
    $this->db->where('email', $data->username);
    $this->db->where('password', $data->password);
    $this->db->where('enabled', self::ENABLED);
    $query = $this->db->get('gcms_users');
    if ($query->num_rows() > 0)
    {
      return true;
    } else
    {
      return false;
    }
  }

  public function return_user_group($data)
  {
    $query = $this->db->get_where('gcms_users', array('email' => $data->username, 'password' => $data->password));
    return $query->row()->usertype;
  }

  public function update_last_visit($user)
  {
    $this->db->where('id', $user->id);
    $this->db->update('gcms_users', array('last_visit' => $this->_getTimeStamp()));
  }

  private function _getTimeStamp()
  {
    $datestring = "%Y:%m:%d %h:%i:%a";
    $time = time();
    return mdate($datestring, $time);
  }

}