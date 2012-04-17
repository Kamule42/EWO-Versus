<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Description of Connexion
 *
 * @author Benjamin Herbomez <benjamin.herbomez@esial.com>
 */
class Groupe extends MY_Controller {

    public function __construct() {
        parent::__construct();
        
        $this->log_lvl = MY_Controller::LOG_LVL_REQUIRE;
        
        //Libs
        $this->load->library('form_validation');
        //Helpers
        $this->load->helper(array('form', 'assets', 'url'));
        //Models
        $this->load->model('appliModel');
        $this->load->model('jeu/groupe_model','groupe_model');
    }

    public function index() {
        $this->liste();
    }
    
    /**
     *  Afficher seulement la liste
     * @param type $methode permet d'utiliser la navigation ajax si activé
     */
    public function liste(){
        $this->display($this->liste_intern());
    }
    
    protected function liste_intern(){
        return $this->load->view('jeu/groupe/liste_view',
                array(
                    'groupes' => $this->groupe_model->getGroupList($this->session->userdata('utilisateur.id'))),
                true);
    }
    
    public function view_groupe($id){
        $this->display($this->view_groupe_intern($id));
    }
    
    protected function view_groupe_intern($id){
        return $this->liste_intern().
                $this->load->view('jeu/groupe/groupe_view',
                array(
                    'unites' => $this->groupe_model->getGroupeUnite(
                            $id,$this->session->userdata('utilisateur.id')),
                    'dispo'  => $this->groupe_model->getUniteUtilisables($this->session->userdata('utilisateur.armee_id'))
                ),
                true);
    }
    
    public function creer(){
        if(!$this->session->isLogged())
            $this->logError($methode);
        
        if($this->checkNomIntern('nom')){
            $this->groupe_model->ajouter(
                    $this->session->userdata('utilisateur.id'),
                    $this->input->post('nom')
                );
        }
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
