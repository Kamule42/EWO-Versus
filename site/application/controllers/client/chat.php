<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

require('application/config/api_config.php');

/**
 * Description of Connexion
 *
 * @author Benjamin Herbomez <benjamin.herbomez@esial.com>
 */
class Chat extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('form_validation');
    }

    public function index() {
        die('{}');
    }

    public function check_token() {
        $key = ApiConfig::$api_key;

        $this->form_validation->set_rules('id', '', 'trim|required|is_natural');
        $this->form_validation->set_rules('key', '', 'trim|required');

        if ($this->form_validation->run() == FALSE ||
                $this->input->post('key') != $key
        )
            die('{"erreur" : "validation"}');

        $this->clear_token();

        $resultat = $this->db->select('
            ct.token as token,
            u.nom as nom'
                )
                ->from('chat_token ct')
                ->join('utilisateur u', 'u.id = ct.utilisateur_id')
                ->where(array('utilisateur_id' => $this->input->post('id')))
                ->limit(1)
                ->get()
                ->result();

        if (count($resultat) == 1) {
            $this->db->where(array('utilisateur_id' => $this->input->post('id')))
                    ->delete('chat_token');
            die('{"token" : "'.$resultat[0]->token.'","name"  : "'.$resultat[0]->nom.'"}');
        }
        die('{"erreur" : "'.$this->input->post('id').'"}');
    }

    public function gen_token() {
        if (!$this->session->isLogged())
            die('');
        $this->load->helper('string');
        $token = random_string('unique', 16);

        $this->clear_token();

        //Clear old token
        $this->db->where(array('utilisateur_id' => $this->session->userdata('utilisateur.id')))
                ->delete('chat_token');

        $this->db->set('utilisateur_id', $this->session->userdata('utilisateur.id'))
                        ->set('token', $token)
                        ->set('time', 'NOW()', FALSE)
                        ->insert('chat_token') or
                die('error');

        die($token);
    }

    private function clear_token() {
        $ttl = 3; //3 minutes
        $this->db->where('DATE_ADD(time,  INTERVAL ' . $ttl . ' MINUTE) < NOW()')
                ->delete('chat_token');
    }

}

?>
