<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Description of LogModel
 *
 * @author Benjamin Herbomez <benjamin.herbomez@esial.com>
 */
class LogModel extends CI_Model{
    public function get_info() {
        return array(
            'nom' => array('nom' => 'nom', 'value' => 'Nom'),
            'mdp' => array('nom' => 'mdp', 'value' => 'Mot de passe')
        );
    }
}

?>
