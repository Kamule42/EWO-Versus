<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * @author Benjamin Herbomez <benjamin.herbomez@esial.com>
 */
class Inscription extends CI_Controller{
public $form_validation = "";
    
    public function __construct() {
        parent::__construct();
        //On ne s'inscrie pas quand on est log
        if($this->session->isLogged())
            redirect();
        
        $this->load->helper(array('form','assets','json'));
        $this->load->model('appliModel');
        $this->load->model('forms/InscriptionModel', 'inscrModel');
        $this->load->model('forms/LogModel', 'logModel');
    }

    public function index($methode = '') {
        if($methode == 'ajax'){
            die($this->index_intern());
        }
        $data = $this->appliModel->get_info();
        
        $views = array();
        $views['toolBox'] = $this->load->view('toolBox/non_connected_view',$this->logModel->get_info(), true);
        $views['body'] = $this->index_intern();
        
        $data['views'] = (object)$views;
        $this->load->view('main_view',$data);
    }
    
    private function index_intern(){
        return $this->load->view('inscription/form_view',$this->inscrModel->get_champs(), true);
    }
    
    public function finalize(){
        $champs = $this->inscrModel->get_champs();
        if( $this->checkNomIntern($champs['nom']['nom']) && 
            $this->checkMdpIntern($champs['mdp']['nom']) && 
            $this->checkMdpConfIntern($champs['mdp_conf']['nom']) &&
            $this->checkMailIntern($champs['mail']['nom']) &&
            $this->checkArmeeIntern($champs['armee']['nom'])){
            
            //Generate inscription tokken
            $this->load->helper('string');
            $token = random_string('unique', 16);
            
            $this->load->model('jeu/utilisateur_model');
            
            $id = $this->utilisateur_model->ajouter_utilisateur(
                    $this->input->post($champs['nom']['nom']),
                    $this->input->post($champs['mdp']['nom']),
                    $this->input->post($champs['mail']['nom']),
                    $this->input->post($champs['armee']['nom']),
                    $token
            );
            
            $this->load->library('email');

            $config['mailtype'] = 'html';
            $config['smtp_host'] = 'smtp.free.fr';
            $config['smtp_user'] = 'benjamin.herbomez@free.fr';
            $config['smtp_pass'] = 'guizmo';
            $config['smtp_port'] = 25;
            $this->email->initialize($config);
            
            $this->email->from('versus.ewo-le-monde.com', 'Ewo Versus Team');
            $this->email->to($this->input->post($champs['mail']['nom'])); 

            $this->email->subject('Inscription à EWO Versus');
            $this->email->message('Bonjour '.$this->input->post($champs['nom']['nom']).'
                
Merci de suivre ce lien pour finir votre inscription : <a href="'.site_url('inscription/valid/'.$id.'/'.$token).'">valider mon inscription</a>');	

            $this->email->send();
            
            $data = $this->appliModel->get_info();
        
            $views = array();
            $views['toolBox'] = $this->load->view('toolBox/non_connected_view',
                    $this->logModel->get_info(), true);
            $views['body'] = $this->load->view('inscription/mail_send',array(), true);
            $data['views'] = (object)$views;
            $this->load->view('main_view',$data);
        }
        else
            $this->index();
    }
    
    public function valid($id,$token){
        $resultat = $this->db->select('token')
                ->from('inscr_token')
                ->limit(1)
                ->get()
                ->result();
        if(count($resultat) == 1 && $resultat[0]->token == $token){
            //MAJ de la base de donnée
            $this->load->model('jeu/utilisateur_model');
            $this->utilisateur_model->activer_utilisateur($id);
            
            $data = $this->appliModel->get_info();
        
            $views = array();
            $views['toolBox'] = $this->load->view('toolBox/non_connected_view',
                    $this->logModel->get_info(), true);
            $views['body'] = $this->load->view('inscription/fin',array(), true);
            $data['views'] = (object)$views;
            $this->load->view('main_view',$data);
        }
        else
            redirect();
    }
    
    public function checkNom(){
        die($this->checkNomIntern('val'));
    }
    
    private function checkNomIntern($v){
         $this->load->library('form_validation');
        
        //Valide the form
        $this->form_validation->set_rules(
                $v, 'nom', 'trim|required|min_length[5]|max_length[100]|is_unique[utilisateur.nom]|alpha_dash|encode_php_tags|xss_clean'
        );
        
        if ($this->form_validation->run() == true) {
            return 'true';
        }
        return form_error($v);
    }
    
    public function checkMdp(){
        die($this->checkMdpIntern('val'));
    }
    
    private function checkMdpIntern($v){
        $this->load->library('form_validation');
        
        //Valide the form
        $this->form_validation->set_rules(
                $v, 'mot de passe', 'required|min_length[5]|max_length[255]|encode_php_tags|xss_clean'
        );
        
        if ($this->form_validation->run() == true) {
            return 'true';
        }
        return form_error($v);
    }
    
    private function checkMdpConfIntern($v){
        $this->load->library('form_validation');
        
        //Valide the form
        $this->form_validation->set_rules(
                $v, 'mot de passe', 'required|matches['.$v.']'
        );
        
        if ($this->form_validation->run() == true) {
            return 'true';
        }
        return form_error($v);
    }
    
    public function checkMail(){
        die($this->checkMailIntern('val'));
    }
    
    private function checkMailIntern($v){
        $this->load->library('form_validation');
        //Valide the form
        $this->form_validation->set_rules(
                $v, 'email', 'required|valid_email|max_length[255]|is_unique[utilisateur.mail]|encode_php_tags|xss_clean'
        );
        
        if ($this->form_validation->run() == true){
            return 'true';
        }
        return form_error($v);
    }
    
    private function checkArmeeIntern($armee){
        $this->load->library('form_validation');
        //Valide the form
        $this->form_validation->set_rules($armee, 'armee', 'required|numeric');
        
        return $this->form_validation->run();
    }
}

?>
