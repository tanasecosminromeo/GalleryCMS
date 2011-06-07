<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Albums
 *
 * @author aaronbenson
 */
class Albums extends Gcmsusers_Controller
{
 /**
  * Redirect if not logged in. 
  * Load Albums_Model and form validation library.
  */
  public function __construct()
  {
    parent::__construct();
    log_message('debug', "*** URI: " . $this->uri->ruri_string());

    if (!$this->session->userdata('is_logged_in'))
    {
      redirect(base_url() . 'gcmsadmin/login');
    }

    $this->load->library('form_validation');
    $this->load->model('albums_model', 'albums');
  }
 /**
  * Display index view
  */
  public function index()
  {
    $albumsData['rows'] = $this->albums->getAlbums();
    //$this->template->write_view('user_panel', 'users/user_panel_view');
    $this->template->write_view('main_content', 'albums/albums_view', $albumsData);
    $this->template->write('title', ' - Albums Manager');
    $this->template->render();
  }
 /** 
  * Display album update view, update record
  */
  public function edit()
  {
    /** @todo URI is not working */
    $this->form_validation->set_rules('title', 'Title', 'trim|required|max_length[40]|xss_clean');
    /** @todo Add callback to ensure the url is unique */
    $this->form_validation->set_rules('url', 'URL', 'trim|required|min_length[4]|max_length[40]|alpha_dash|xss_clean');
    $this->form_validation->set_rules('description', 'Description', 'trim|max_length[255]|xss_clean');
    
    if ($this->form_validation->run($this) == false)
    {
      $this->template->write_view('main_content', 'albums/albums_add_view');
      $this->template->write('title', ' - Albums Manager');
      $this->template->render();
    }
    else
    {
      // Save
      $values = array(
          'id' => $this->uri->segment(4),
          'aurl_title' => $this->input->post('url'),
          'album' => $this->input->post('title'),
          'description' => $this->input->post('description'),
          'album_owner' => $this->session->userdata('user_id'),
          /** @todo Add ability to publish */
          'apublished' => 0,
          'order_id' => 0
      );
      $this->albums->updateAlbum($values);
      // Redirect to index
      $this->index();
    }
  }
 /**
  * Display add new album view
  */
  public function add()
  {
    $this->template->write_view('main_content', 'albums/albums_add_view');
    $this->template->write('title', ' - Albums Manager');
    $this->template->render();
  }
 /**
  * Create new album
  */
  public function create()
  {
    $this->form_validation->set_rules('title', 'Title', 'trim|required|max_length[40]|xss_clean');
    /** @todo Add callback to ensure the url is unique */
    $this->form_validation->set_rules('url', 'URL', 'trim|required|min_length[4]|max_length[40]|alpha_dash|xss_clean');
    $this->form_validation->set_rules('description', 'Description', 'trim|max_length[255]|xss_clean');

    if ($this->form_validation->run($this) == false)
    {
      $this->template->write_view('main_content', 'albums/albums_add_view');
      $this->template->write('title', ' - Albums Manager');
      $this->template->render();
    }
    else
    {
      // Save
      $values = array(
          'aurl_title' => $this->input->post('url'),
          'album' => $this->input->post('title'),
          'description' => $this->input->post('description'),
          'album_owner' => $this->session->userdata('user_id'),
          'apublished' => 0,
          'order_id' => 0
      );
      $this->albums->createAlbum($values);
      // Redirect to index
      $this->index();
    }
  }
  
  public function remove()
  {
    /** @todo Implement remove view and delete action */
    /** @todo URI is not working */
    $this->albums->deleteAlbumById($this->uri->segment(4));
  }

}

?>
