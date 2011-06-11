<?php

(defined('BASEPATH')) OR exit('No direct script access allowed');

// module bootloaded example
// class Public_Controller extends MX_Controller{
//       
// function __construct()
// {
// parent::__construct();
// 
// log_message('debug', 'Public Controller Controller Initialized');
// 
// if( $this->agent->is_mobile() ){
// redirect('/mobile');
// }
// }
// 	
// 	    
// 
// }//end of public controller
// Gallery CMS Admin BootLoader Class


class Gcmsadmin_Controller extends MX_Controller
{

  function __construct()
  {
    parent::__construct();

    log_message('debug', 'Gcmsadmin Controller Controller Initialized');

    $this->load_gcmsadmin_template();
    $this->load_gcmsadmin_assets();
    $this->load_gcmsadmin_defaults();
  }
  
  
		public function _remap($method, $params = array())
		{
		   if (method_exists($this, $method))
		       {
		        return call_user_func_array(array($this, $method), $params);
		    }
		    
		    $this->_show_404();
		}
		
		function _show_404($page=''){
			
        header('HTTP/1.1 404 Not Found');

        redirect(base_url().'gcmsadmin/page_not_found');
        exit;
    }




  protected function load_gcmsadmin_template()
  {

    log_message('debug', 'Default gcms admin default template Loaded ');

	$this->atpl = modules::run('gcmsadmin/common/_read_setting', 'gcms_admin_tpl');
	 
    $gadmin['template'] = '../../public_html/gcmstpls/' . $this->atpl . '/gcms_admin_tpl.html';
    $gadmin['regions'] = array(
        'title',
        'meta_tags',
        'user_panel',
        'top_nav',
        'page_title',
        'error_mgs',
        'main_content',
        'sidebar',
        'footer',
        'copyright'
    );

    // add and switch to installer template
    $this->template->add_template('gadmin', $gadmin, TRUE);
  }

  protected function load_gcmsadmin_assets()
  {
    // Load js general to all child controllers.
  }


  protected function load_gcmsadmin_defaults()
  {
	$data = modules::run('gcmsadmin/common/_read_global_settings');
	
    $copyright = '<strong>Copyright &copy; ' . date('Y') . ' ' . $data['site_name'] . ', All rights reserved. Powered by <a href="http://www.gallerycms.com">GalleryCMS ' . $data['gcms_ver'] . '</a></strong>';

    $this->template->write('title', $data['site_name'] . ' - Administration');
    $this->template->write('copyright', $copyright);
    $this->template->write_view('top_nav', 'common/top_nav_view');
  }

}

//end of GCMSadmin controller
// Gallery CMS Users BootLoader Class

class Gcmsusers_Controller extends MX_Controller
{

  function __construct()
  {
    parent::__construct();

    log_message('debug', 'Users Controller Controller Initialized');

    $this->load_gcmsusers_template();
    $this->load_gcmsusers_assets();
    $this->load_gcmsusers_defaults();
  }


	public function _remap($method, $params = array())
		{
		   if (method_exists($this, $method))
		       {
		        return call_user_func_array(array($this, $method), $params);
		    }
		    
		    $this->_show_404();
		}
		
		function _show_404($page=''){
			
        header('HTTP/1.1 404 Not Found');

        redirect(base_url().'gcmsusers/page_not_found');
        exit;
    }

  protected function load_gcmsusers_template()
  {

    log_message('debug', 'Default gcms users default template Loaded ');

	
    $this->utpl = modules::run('gcmsadmin/common/_read_setting', 'gcms_users_tpl');
	
    $gusers['template'] = '../../public_html/gcmstpls/'.$this->utpl.'/gcms_users_tpl.html';
    $gusers['regions'] = array(
        'title',
        'meta_tags',
        'top_nav',
        'page_title',
        'error_mgs',
        'main_content',
        'right_side',
        'footer',
        'copyright'
    );

    // add and switch to installer template
    $this->template->add_template('gusers', $gusers, TRUE);
  }

  protected function load_gcmsusers_assets()
  {
    // Load js general to all child controllers.
    // Load css general to child controllers.
  }

  protected function load_gcmsusers_defaults()
  {
   	$data = modules::run('gcmsadmin/common/_read_global_settings');
	
    $copyright = '<strong>Copyright &copy; ' . date('Y') . ' ' . $data['site_name'] . ', All rights reserved. Powered by <a href="http://www.gallerycms.com">GalleryCMS ' . $data['gcms_ver'] . '</a></strong>';
	$this->template->write('title', $data['site_name'] . ' - Administration');
    $this->template->write('copyright', $copyright);
    $this->template->write_view('top_nav', 'common/top_nav_view');
  }

}

//end of GCMSusers controller





// Gallery CMS Feeds BootLoader Class

class Gcmsfeeds_Controller extends MX_Controller
{

  function __construct()
  {
    parent::__construct();

    log_message('debug', 'Feeds Controller Controller Initialized');


    $this->load_gcmsfeeds_assets();
    $this->load_gcmsfeeds_defaults();
  }


	public function _remap($method, $params = array())
		{
		   if (method_exists($this, $method))
		       {
		        return call_user_func_array(array($this, $method), $params);
		    }
		    
		    $this->_show_404();
		}
		
		function _show_404($page=''){
			
        header('HTTP/1.1 404 Not Found');

        redirect(base_url().'gfeed/page_not_found');
        exit;
    }


  protected function load_gcmsfeeds_assets()
  {
    // Load js general to all child controllers.
    // Load css general to child controllers.
  }

  protected function load_gcmsfeeds_defaults()
  {
   	$data = modules::run('gcmsadmin/common/_read_global_settings');
	
    $copyright = '<strong>Copyright &copy; ' . date('Y') . ' ' . $data['site_name'] . ', All rights reserved. Powered by <a href="http://www.gallerycms.com">GalleryCMS ' . $data['gcms_ver'] . '</a></strong>';
	
  }

}








// class used only for the installer
class Installer_Controller extends MX_Controller
{

  function __construct()
  {
    parent::__construct();

    log_message('debug', 'Installer Controller Controller Initialized');
	
	$this->load->library(array('template', 'session'));
	
    $this->load_template();
    $this->load_assets();
    $this->load_defaults();
  }

  protected function load_template()
  {

    log_message('debug', 'Default installer template Loaded ');


    $installer['template'] = "../../public_html/gcmstpls/default/installer.html";
    $installer['regions'] = array(
        'title',
        'header',
        'error_mgs',
        'main_content',
        'footer',
        'copyright'
    );

    // add and switch to installer template
    $this->template->add_template('installer', $installer, TRUE);
  }

  protected function load_assets()
  {
    // Load js general to all child controllers.
    // Load css general to child controllers.
  }

  protected function load_defaults()
  {
    $data['copyright_year'] = date('Y');
    $this->template->write('title', 'GalleryCMS - A free CMS for photo galleries');
    $this->template->write_view('header', 'install/header_view');
    $this->template->write_view('footer', 'install/footer_view', $data);
  }

}

//end of installer controller
