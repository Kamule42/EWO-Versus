<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * @author Benjamin Herbomez <benjamin.herbomez@esial.com>
 */
class AppliModel extends CI_Model {

    public function get_info() {
        return array(
            'title' => 'Versus'
        );
    }

}

?>
