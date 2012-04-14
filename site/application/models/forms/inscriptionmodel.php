<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/**
 * @author Benjamin Herbomez <benjamin.herbomez@esial.com>
 */
class InscriptionModel  extends CI_Model{
    public function get_champs() {
               
        $r = array(
            'nom'       => array('nom' => 'nom',            'value' => 'Nom'),
            'mdp'       => array('nom' => 'mdp',            'value' => 'Mot de passe'),
            'mdp_conf'  => array('nom' => 'mdp_confirm',    'value' => 'Confirmez'),
            'mail'      => array('nom' => 'mail',           'value' => 'Email'),
            'camps'     => array('nom' => 'camps',          'value' => 'Votre camps'),
            'ordre'     => array('nom' => 'ordres',         'value' => 'Choisissez un ordre'),
            'armee'     => array('nom' => 'armee',          'value' => 'Choisissez une armée')
        );
        
        $resultat = $this->db->select('id, nom')
                     ->from('camps')
                     ->get()
                     ->result();
        
        foreach($resultat as $k => $v){
            $r['camps_list'][$v->id] = $v->nom;
        }
        
        $resultat = $this->db->select(
                'o.id       as id,
                 o.nom      as nom,
                 o.camps_id as camps,
                 a.id       as a_id,
                 a.nom      as a_nom,
                 a.descr    as a_descr')
                     ->from('ordre o')
                     ->join('armee a','a.ordre_id = o.id')
                     ->order_by('camps_id','ASC')
                     ->get()
                     ->result();
        foreach($resultat as $k => $v){
            $r['ordres'][$v->camps][$v->id]['nom'] = $v->nom;
            $r['ordres'][$v->camps][$v->id]['armee'][$v->a_id]['nom'] = $v->a_nom;
            $r['ordres'][$v->camps][$v->id]['armee'][$v->a_id]['descr'] = $v->a_descr;
        }
        return $r;
    }
}

?>
