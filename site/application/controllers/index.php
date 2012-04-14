<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * @author Benjamin Herbomez <benjamin.herbomez@esial.com>
 */
class Index extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper(array('form','assets'));
        $this->load->model('appliModel');
        $this->load->model('forms/LogModel', 'logModel');
    }

    public function index($methode = '') {
        if($methode == 'ajax'){
            die($this->index_intern());
        }
        $data = $this->appliModel->get_info();
        $views = $this->processLog($data, array());
        $views['body'] = $this->index_intern();
        $data['views'] = (object)$views;
        $data['log'] = $this->session->isLogged();
        $data['utilisateur_id'] = $this->session->userdata('utilisateur.id');
        $this->load->view('main_view',$data);
    }
    
    private function index_intern(){
        return $this->load->view('index_view',array(
            'content' => $this->load->view('index/presentation_view',array(),true),
            'pres_select' => true
        ), true);
    }
    
    public function news($methode = ''){
        if($methode == 'ajax'){
            die($this->news_intern());
        }
        $data = $this->appliModel->get_info();
        $views = $this->processLog($data, array());
        
        $views['body'] = $this->news_intern();
        
        $data['views'] = (object)$views;
        $data['log'] = $this->session->isLogged();
        $data['utilisateur_id'] = $this->session->userdata('utilisateur.id');
        $this->load->view('main_view',$data);
    }
   
    private function news_intern(){
        $this->load->model('newsmodel');
        return $this->load->view('index_view',array(
            'content' => $this->load->view('index/news_view',
                    array('news' => $this->newsmodel->getNews()),
                true),
            'news_select' => true
        ), true);
    }

    
    protected function processLog($data, $views){
        //Si connecté
        if($this->session->isLogged()){
            $toolBox = $this->load->view('toolBox/connected_view',$data, true);
        }
        else{
            $toolBox = $this->load->view('toolBox/non_connected_view',$this->logModel->get_info(), true);
        }
        $views['toolBox'] = $toolBox;
        return $views;
    }
}

?>
