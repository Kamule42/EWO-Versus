<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Description of Connexion
 *
 * @author Benjamin Herbomez <benjamin.herbomez@esial.com>
 */
class Groupe extends CI_Controller {

    public function __construct() {
        parent::__construct();
        if(!$this->session->isLogged())
            redirect();
        //Libs
        $this->load->library('form_validation');
        //Helpers
        $this->load->helper(array('form', 'assets', 'url'));
        //Models
        $this->load->model('appliModel');
        $this->load->model('jeu/groupe_model','groupe_model');
    }

    public function index($methode = '') {
        $this->liste($methode);
    }
    
    /**
     *  Afficher seulement la liste
     * @param type $methode permet d'utiliser la navigation ajax si activé
     */
    public function liste($methode = ''){
        if($methode == 'ajax'){
            die($this->liste_intern());
        }
        $this->display($this->liste_intern());
    }
    
    protected function liste_intern(){
        return $this->load->view('jeu/groupe/liste_view',
                array(
                    'groupes' => $this->groupe_model->getGroupList($this->session->userdata('utilisateur.id'))),
                true);
    }

    /**
     * Afficher la liste et un formulaire de création
     * @param type $methode permet d'utiliser la navigation ajax si activé
     */
    public function creer($methode = ''){
        if($methode == 'ajax'){
            die($this->creer_intern());
        }
        $this->display($this->creer_intern());
    }
    
    protected function creer_intern(){
        return
                $this->load->view('jeu/groupe/creer_view',
                    array(),
                true).
                $this->liste_intern();
    }
    
    /**
     * Affichage d'une page type avec au centre le contenu de la variable $content
     * @param type $content 
     */
    protected function display($content){
        $data = $this->appliModel->get_info();
        
        $views = array();
        $views['toolBox'] = $this->load->view('toolBox/connected_view',array(), true);
        $views['body'] = $content;
        $data['views'] = (object)$views;
        $data['log'] = true;
        $data['utilisateur_id'] = $this->session->userdata('utilisateur.id');
        $this->load->view('main_view',$data);
    }
}

?>
