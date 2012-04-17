<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/**
 * Class de controller customisée
 */
class MY_Controller extends CI_Controller {
    const LOG_LVL_OSEF      = 0;
    const LOG_LVL_NONE      = 1;
    const LOG_LVL_REQUIRE   = 2;

    protected $log_lvl = self::LOG_LVL_OSEF;
    
    function __construct(){
        parent::__construct();
        $this->load->model('appliModel');
    }

    protected function logError($methode){
        if($methode == 'ajax')
            die('logError');
        redirect();
    }
    
    /**
     * Fonction interne à codeigniter. Ici elle permet de gèrer les les appels ajax quand c'est utile.
     * @param type $method
     * @param type $params
     */
    public function _remap($method, $params = array()){
        $ajax = false;
        foreach($params as $k => $p)
            if($p=='ajax'){
                $ajax = true;
                unset($params[$k]);
                break;
            }
        //Si il faut $etre logué et que ce n'est pas le cas
        if($this->log_lvl == self::LOG_LVL_REQUIRE && !$this->session->isLogged() ||
               $this->log_lvl == self::LOG_LVL_NONE && $this->session->isLogged() ){
            if($ajax)
                die('errorLog');
            redirect();
        }
        
        if($ajax)
            echo call_user_func_array(array($this, $method.'_intern'), $params);
        else
            call_user_func_array(array($this, $method), $params);
    }
    
    
    /**
     * Affichage d'une page type avec au centre le contenu de la variable $content
     * @param type $content 
     */
    protected function display($content){
        $data = $this->appliModel->get_info();
        
        $views = array();
        $views['toolBox'] = $this->toolBoxLog();
        $views['body'] = $content;
        $data['views'] = (object)$views;
        $data['log'] = true;
        $data['utilisateur_id'] = $this->session->userdata('utilisateur.id');
        $this->load->view('main_view',$data);
    }
    
    /**
     * Gènére la boite en haut en fonction du log ou non
     * @return type 
     */
    protected function toolBoxLog(){
        //Si connecté
        if($this->session->isLogged())
            return  $this->load->view('toolBox/connected_view',array(), true);
        //Sinon
        $this->load->model('forms/LogModel', 'logModel');
        return $this->load->view('toolBox/non_connected_view',$this->logModel->get_info(), true);
    }
}

?>
