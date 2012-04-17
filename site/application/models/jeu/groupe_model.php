<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

require_once('groupe.php');
require_once('unite.php');

/**
 * 	@author Benjamin Herbomez <benjamin.herbomez@esial.com>
 */
class Groupe_Model extends CI_Model {
    protected $table        = 'groupe';
    protected $table_grp    = 'groupe_unite';
    protected $table_u      = 'unite';
    protected $table_ua     = 'unite_arme'; 
    
    /**
     * Donne la liste des groupes d'un utilisateur
     * @param type $utilisateur_id
     * @return  
     */
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
    
    /**
     * Donne la liste des unités d'un groupe donné
     * @param type $groupe_id le groupe en question
     * @param type $utilisateur_id l'utilisateur, pour sécuriser l'accès aux données
     * @return  
     */
    public function getGroupeUnite($groupe_id, $utilisateur_id){
        $r = array();
        $resultat = $this->db->select(
                'gu.id  as id,
                gu.nom  as nom,
                u.nom   as unite,
                u.pv    as pv,
                u.mouv  as mouv,
                u.force as forcev,
                u.des   as des,
                u.atk   as atk,
                u.cout  as cout
                ')
                ->from($this->table.' g')
                ->join($this->table_grp.' gu','g.id = gu.groupe_id')
                ->join($this->table_u.' u','u.id = gu.unite_id')
                ->where(array(
                    'g.utilisateur_id' => $utilisateur_id,
                    'g.id' => $groupe_id
                    ))
                ->get()
                ->result();
        foreach($resultat as $res)
            $r[] = new Unite ($res->id, $res->nom, $res->unite, $res->pv,
                    $res->mouv, $res->forcev, $res->des, $res->atk, $res->cout);
        return $r;
    }
    
    public function getUniteUtilisables($armee_id){
        $r = array();
        $resultat = $this->db->select(
                '
                u.id    as id,
                u.nom   as nom,
                u.pv    as pv,
                u.mouv  as mouv,
                u.force as forcev,
                u.des   as des,
                u.atk   as atk,
                u.cout  as cout
                ')
                ->from($this->table_u.' u')
                ->join($this->table_ua.' ua','u.id = ua.unite_id AND ua.arme_id = '.$armee_id)
                ->order_by('u.nom ASC, u.cout DESC')
                ->get()
                ->result();
        foreach($resultat as $res)
            $r[] = new Unite ($res->id, '', $res->nom, $res->pv,
                    $res->mouv, $res->forcev, $res->des, $res->atk, $res->cout);
        return $r;
    }
}
?>
