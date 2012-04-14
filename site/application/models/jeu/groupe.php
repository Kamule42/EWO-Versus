<?php

/**
 * Description d'un groupe
 *
 * @author Benjamin Herbomez <benjamin.herbomez@esial.com>
 */

class GroupePerso {
    protected $id;
    protected $nom;
    protected $utilisateur_id;
    
    function __construct($id, $nom, $utilisateur_id) {
        $this->id = $id;
        $this->nom = $nom;
        $this->utilisateur_id = $utilisateur_id;
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

    public function getUtilisateur_id() {
        return $this->utilisateur_id;
    }

    public function setUtilisateur_id($utilisateur_id) {
        $this->utilisateur_id = $utilisateur_id;
    }
}
?>
