<?php (defined('BASEPATH')) OR exit('No direct script access allowed');






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


class Gcmsadmin_Controller extends MX_Controller{
      
       function __construct()
    {
        parent::__construct();

        log_message('debug', 'Users Controller Controller Initialized');
		 
		$this->load_gcmsadmin_template();
		$this->load_gcmsadmin_assets();
		$this->load_gcmsadmin_defaults();

		
	}
	
	
		
		
	   protected function  load_gcmsadmin_template() {

     	log_message('debug', 'Default gcms admin default template Loaded ');
		
     	
	  	$gadmin['template'] = "../../public_html/gcmstpls/default/gcms_admin_tpl.html";
		$gadmin['regions'] = array(
						'title',
						'meta_tags',
						'top_nav',
                        'error_mgs',
            			'main_content',
            			'right_side',
            			'footer',
            			'copyright'
                     );

        // add and switch to installer template
		$this->template->add_template('gadmin', $gadmin, TRUE);


                }
	
	 protected function load_gcmsadmin_assets()
            {
           // Load js general to all child controllers.
			$this->template->add_js('gcmstpls/default/scripts/jquery-1.6.min.js');
			$this->template->add_js('gcmstpls/default/scripts/jquery.easing.1.3.js');
		
			// Load css general to child controllers.
			$this->template->add_css('gcmstpls/default/styles/gcmsadmin.css');
			
        }

	 protected function load_gcmsadmin_defaults()
            {
			$copyright = '<strong>Copyright &copy; '.date('Y').' GalleryCMS, All rights reserved.</strong>';
					
        	$this->template->write( 'title','GalleryCMS - Administration' );
			$this->template->write( 'copyright',$copyright );
			$this->template->write_view('top_nav', 'common/top_nav_view');
		
		
        }
	
	

}//end of GCMSadmin controller



// Gallery CMS Users BootLoader Class
	
class Gcmsusers_Controller extends MX_Controller{
      
    function __construct()
    {
        parent::__construct();

        log_message('debug', 'Gcmsusers Controller Controller Initialized');

		
	}
	
	

}//end of GCMSusers controller


	

// class used only for the installer
class Installer_Controller extends MX_Controller{
      
    function __construct()
    {
        parent::__construct();

        log_message('debug', 'Installer Controller Controller Initialized');
		 
		$this->load_template();
		$this->load_assets();
		$this->load_defaults();

		
	}
	
	
		
		
	   protected function  load_template() {

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
			$this->template->add_js('gcmstpls/default/scripts/jquery-1.6.min.js');
			$this->template->add_js('gcmstpls/default/scripts/jquery.easing.1.3.js');
		
			// Load css general to child controllers.
			$this->template->add_css('gcmstpls/default/styles/styles.css');
			
        }

	 protected function load_defaults()
            {
			$data['copyright_year'] = date('Y');		
        	$this->template->write( 'title','GalleryCMS - A free CMS for photo galleries' );
			$this->template->write_view('header', 'install/header_view');
			$this->template->write_view('footer', 'install/footer_view', $data);
		
		
        }
	
	


}//end of installer controller
