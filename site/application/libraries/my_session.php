<?php

/**
 * @author Benjamin Herbomez <benjamin.herbomez@esial.com>
 */
class MY_Session extends CI_Session{
    function __construct() {
        parent::__construct();
    }

    public function isLogged(){
        return $this->userdata('logged') == true;
    }
    
    public function log(){
        $this->set_userdata('logged', true);
    }
    
    public function unlog(){
        $this->set_userdata('logged', false);
    }
}

?>
