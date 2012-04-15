<?php

/**
 * Description d'un groupe
 *
 * @author Benjamin Herbomez <benjamin.herbomez@esial.com>
 */

class Unite {
    protected $id;
    protected $nom;
    protected $unite;
    protected $pv;
    protected $mouv;
    protected $force;
    protected $des;
    protected $atk;
    protected $cout;
    function __construct($id, $nom, $unite, $pv, $mouv, $force, $des, $atk, $cout) {
        $this->id = $id;
        $this->nom = $nom;
        $this->unite = $unite;
        $this->pv = $pv;
        $this->mouv = $mouv;
        $this->force = $force;
        $this->des = $des;
        $this->atk = $atk;
        $this->cout = $cout;
    }

    public function getId() {
        return $this->id;
    }

    public function getNom() {
        return $this->nom;
    }

    public function getUnite() {
        return $this->unite;
    }

    public function getPv() {
        return $this->pv;
    }

    public function getMouv() {
        return $this->mouv;
    }

    public function getForce() {
        return $this->force;
    }

    public function getDes() {
        return $this->des;
    }

    public function getAtk() {
        return $this->atk;
    }

    public function getCout() {
        return $this->cout;
    }
} 
?>
