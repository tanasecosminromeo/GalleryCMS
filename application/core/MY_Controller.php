<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

class Gcmsadmin_Controller extends MX_Controller{
      
    function __construct()
    {
        parent::__construct();

        log_message('debug', 'Gcmsadmin Controller Controller Initialized');

		
	}
	
	

}//end of public controller



	
class Public_Controller extends MX_Controller{
      
    function __construct()
    {
        parent::__construct();

        log_message('debug', 'Public Controller Controller Initialized');

		if( $this->agent->is_mobile() ){
	      redirect('/mobile');
	      }
	}
	
	    

}//end of public controller




	
class Admin_Controller extends MX_Controller{
      
    function __construct()
    {
        parent::__construct();

        log_message('debug', 'Admin Controller Controller Initialized');

		
	}
	
	


}//end of admin controller





	
class Mobile_Controller extends MX_Controller{
      
    function __construct()
    {
        parent::__construct();

        log_message('debug', 'Mobile Controller Controller Initialized');

		
	}
	
	


}//end of mobile controller


class Users_Controller extends MX_Controller{
      
    function __construct()
    {
        parent::__construct();

        log_message('debug', 'Users Controller Controller Initialized');

		
	}
	
	


}//end of users controller



class Installer_Controller extends MX_Controller{
      
    function __construct()
    {
        parent::__construct();

        log_message('debug', 'Users Controller Controller Initialized');
		 
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
			$this->template->add_css('gcmstpls/default/styles/installer.css');
			
        }

	 protected function load_defaults()
            {
			$data['copyright_year'] = date('Y');		
        	$this->template->write( 'title','GalleryCMS - A free CMS for photo galleries' );
			$this->template->write_view('header', 'install/header_view');
			$this->template->write_view('footer', 'install/footer_view', $data);
		
		
        }
	
	


}//end of installer controller
