<?php

class Users_Model extends CI_Model
{

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

}