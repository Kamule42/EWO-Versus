<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

require_once('utilisateur.php');

/**
 * 	@author Benjamin Herbomez <benjamin.herbomez@esial.com>
 */
class Utilisateur_model extends CI_Model {

    protected $table        = 'utilisateur';
    protected $token_table = 'inscr_token';

    public function ajouter_utilisateur($nom, $mdp, $mail, $armee, $tokken) {
        if($this->db->set('nom', $nom)
                        ->set('mdp', $this->hash_mdp($nom, $mdp))
                        ->set('mail', $mail)
                        ->set('armee_id', $armee)
                        ->insert($this->table)){
            $id = $this->db->insert_id();
            $this->db->set('utilisateur_id', $id)
                        ->set('token', $tokken)
                        ->insert($this->token_table);
            return $id;
        }
        return false;
    }
    
    public function activer_utilisateur($id){
        $this->db->delete($this->token_table,array('utilisateur_id' => $id));
        
        $this->db->where('id', $id)
                ->update('utilisateur', array('actif' => 'actif'));
    }
    
    public function getUtilisateur($nom){
        $resultat = $this->db->select('id, nom, mdp, mail, armee_id, actif')
                ->from($this->table)
                ->where(array('nom' => $nom))
                ->limit(1)
                ->get()
                ->result();
        if(count($resultat) != 1)
            return false;
        return new Utilisateur($resultat[0]);
    }
    
    public function hash_mdp($nom,$mdp){
        $this->load->library('encrypt');
        return $this->encrypt->sha1($this->encrypt->sha1($nom).'^-*='.$this->encrypt->sha1($mdp));
    }

}

?>
