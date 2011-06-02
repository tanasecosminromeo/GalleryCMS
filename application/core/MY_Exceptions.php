<?php  
class MY_Exceptions extends CI_Exceptions{
    
       public function __construct()
    {
        parent::__construct();
    }


    function show_404($page=''){
        header('HTTP/1.1 404 Not Found');

        $this->config =& get_config();
        $base_url = $this->config['base_url'];

        redirect('/error404');
        exit;
    }
}


?>
