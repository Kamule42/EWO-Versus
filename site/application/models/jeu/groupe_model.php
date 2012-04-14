<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

require_once('groupe.php');

/**
 * 	@author Benjamin Herbomez <benjamin.herbomez@esial.com>
 */
class Groupe_Model extends CI_Model {
    protected $table        = 'groupe';
    
    public function getGroupList($utilisateur_id){
        $r = array();
        $resultat = $this->db->select('id, nom')
                ->from($this->table)
                ->where(array('utilisateur_id' => $utilisateur_id))
                ->get()
                ->result();
        foreach($resultat as $res)
            $r[] = new GroupePerso($res->id, $res->nom, $utilisateur_id);
        return $r;
    }
    
    public function ajouter($id, $nom){
        $this->db->set('utilisateur_id', $id)
                    ->set('nom', $nom)
                    ->insert($this->table);
    }
}
?>
