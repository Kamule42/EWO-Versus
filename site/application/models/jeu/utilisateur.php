<?php

/**
 * Description of Utilisateur
 *
 * @author Benjamin Herbomez <benjamin.herbomez@esial.com>
 */
class Utilisateur {

    protected $id;
    protected $nom;
    protected $mdp;
    protected $mail;
    protected $armee_id;
    protected $actif;

    public function __construct($id, $nom = '', $mdp = '', $mail = '', $armee_id = '', $actif = '') {
        if(!is_numeric($id))
            $this->construct_from_obj ($id);
        else{
            $this->id = $id;
            $this->nom = $nom;
            $this->mdp = $mdp;
            $this->mail = $mail;
            $this->armee_id = $armee_id;
            $this->actif = $actif;
        }
    }
    
    private function construct_from_obj($obj) {
        $this->id = $obj->id;
        $this->nom = $obj->nom;
        $this->mdp = $obj->mdp;
        $this->mail = $obj->mail;
        $this->armee_id = $obj->armee_id;
        $this->actif = $obj->actif;
    }

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getNom() {
        return $this->nom;
    }

    public function setNom($nom) {
        $this->nom = $nom;
    }

    public function getMdp() {
        return $this->mdp;
    }

    public function setMdp($mdp) {
        $this->mdp = $mdp;
    }

    public function getMail() {
        return $this->mail;
    }

    public function setMail($mail) {
        $this->mail = $mail;
    }

    public function getArmee_id() {
        return $this->armee_id;
    }

    public function setArmee_id($armee_id) {
        $this->armee_id = $armee_id;
    }

    public function getActif() {
        return $this->actif;
    }

    public function setActif($actif) {
        $this->actif = $actif;
    }

}

?>
