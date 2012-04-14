<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Description of Connexion
 *
 * @author Benjamin Herbomez <benjamin.herbomez@esial.com>
 */
class Connexion extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->helper(array('form', 'assets', 'url'));
        $this->load->model('forms/LogModel', 'logModel');
    }

    public function index() {
        redirect();
    }

    public function connect() {

        $form_data = (object) $this->logModel->get_info();
        //Valide the form
        $this->form_validation->set_rules(
                $form_data->nom['nom'], '"'.$form_data->nom['value'].'"', 'trim|required|min_length[5]|max_length[52]|alpha_dash|encode_php_tags|xss_clean'
        );
        $this->form_validation->set_rules(
                $form_data->mdp['nom'], '"'.$form_data->mdp['value'].'"', 'required|min_length[5]|max_length[100]|alpha_dash|xss_clean'
        );

        //Test de la validité du formulaire, s'il y a un problème on affiche l'erreur
        if ($this->form_validation->run() == FALSE) {
            $this->display_error();
        } else {
            $this->load->model('jeu/utilisateur_model');
            if($u = $this->utilisateur_model->getUtilisateur($this->input->post('nom'))){
                if($u->getActif() != 'actif'){
                    $this->display_error('Cet utilisateur n\'est pas actif');
                } 
                else if($u->getMdp() != 
                        $this->utilisateur_model->hash_mdp($this->input->post('nom'),$this->input->post('mdp')))
                    $this->display_error('mauvais mot de passe : ');
                else{
                    $this->session->log();
                    $this->session->set_userdata('utilisateur.id',$u->getId());
                    redirect();
                }
            }
            else
                $this->display_error('cet utilisateur n\'existe pas');
        }
    }
    
    public function logout(){
        $this->session->unlog();
        $this->session->sess_destroy();
	redirect();
    }

    protected function display_error($error = '') {
        $this->load->model('appliModel');
        $data = $this->appliModel->get_info();
        
        $data_c = $this->logModel->get_info();
        $data_c['wrap'] = true;
        $data_c['error'] = $error;
        $toolBox = $this->load->view('toolBox/non_connected_view', $data_c, true);
        $data['views'] = (object) array(
            'toolBox' => '',
            'body' => $toolBox);

        $this->load->view('main_view', $data);
    }

}

?>
