<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Albums_model
 *
 * @author aaronbenson
 */
class Albums_Model extends CI_Model
{
  
  public function __construct()
  {
    parent::__construct();
  }

 /**
  * Create new album
  * @param array $values
  * @return bool 
  */
  public function createAlbum($values)
  {
    if ($this->db->insert('gcms_albums', $values))
    {
      return true;
    }
    else
    {
      return false;
    }
  }
  
 /**
  * Updates an album for the logged in user
  * @param array $values
  * @return bool 
  */
  public function updateAlbum($values)
  {
    $this->db->where('album_owner', $this->session->userdata('user_id'));
    $this->db->where('id', $this->uri->segment(4));
    if ($this->db->update('gcms_albums', $values))
    {
      return true;
    }
    else
    {
      return false;
    }
  }
 /**
  * Deletes album and recursively deletes all affected assets & asset records.
  * @param int $id
  * @return bool 
  */
  public function deleteAlbumById($id)
  {
    $this->db->where('album_owner', $this->session->userdata('user_id'));
    $this->db->where('id', $this->uri->segment(4));
    /** @todo This also needs to delete all asset records and images for this album upon deletion */
    if ($this->db->delete('gcms_albums'))
    {
      return true;
    }
    else
    {
      return false;
    }
  }

 /**
  * Get all albums for the logged in user
  * @return ActiveRecord 
  */
  public function getAlbums()
  {
    return $this->db->get_where('gcms_albums', array(
        'album_owner' => $this->session->userdata('user_id')
            )
    );
  }
 /**
  * Retrieve album by id
  * @param int $id
  * @return ActiveRecord 
  */
  public function getAlbumById($id)
  {
    return $this->db->get_where('gcms_albums', array(
        'album_owner' => $this->session->userdata('user_id'),
        'id' => $id
            )
    );
  }
 /**
  * Retrieve album by url
  * @param string $url
  * @return ActiveRecord 
  */
  public function getAlbumByUrl($url)
  {
    return $this->db->get_where('gcms_albums', array(
        'album_owner' => $this->session->userdata('user_id'),
        'aurl_title' => $url
            )
    );
  }

}

?>
