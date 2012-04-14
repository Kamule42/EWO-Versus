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
    
    public function creer(){
        if($this->checkNomIntern('nom')){
            $this->groupe_model->ajouter(
                    $this->session->userdata('utilisateur.id'),
                    $this->input->post('nom')
                );
        }
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
    
    public function checkNom(){
        die($this->checkNomIntern('val'));
    }
    
    private function checkNomIntern($v){
         $this->load->library('form_validation');
        
        //Valide the form
        $this->form_validation->set_rules(
                $v, 'nom', 
                'trim|required|min_length[5]|max_length[100]encode_php_tags|xss_clean|callback_groupe_name_check'
        );
        
        if ($this->form_validation->run() == true) {
            return 'true';
        }
        return form_error($v);
    }
    
    function groupe_name_check($str){
        $resultat = $this->db->select('id')
                ->from('groupe')
                ->where(array(
                    'utilisateur_id' => $this->session->userdata('utilisateur.id'),
                    'nom' => $str
                    ))
                ->limit(1)
                ->get()
                ->result();
        if(count($resultat) != 1)
            return true;
        $this->form_validation->set_message('groupe_name_check', 'Vous avez déjà un groupe du nom de "'.$str.'"');
        return false;
    }
}

?>
