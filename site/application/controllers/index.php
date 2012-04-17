<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * @author Benjamin Herbomez <benjamin.herbomez@esial.com>
 */
class Index extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->log_lvl = MY_Controller::LOG_LVL_OSEF;
        $this->load->helper(array('form','assets'));
    }

    public function index() {
        $this->display($this->index_intern());
    }
    
    protected function index_intern(){
        return $this->load->view('index_view',array(
            'content' => $this->load->view('index/presentation_view',array(),true),
            'pres_select' => true
        ), true);
    }
    
    public function news(){
        $this->display($this->news_intern());
    }
   
    protected function news_intern(){
        $this->load->model('newsmodel');
        return $this->load->view('index_view',array(
            'content' => $this->load->view('index/news_view',
                    array('news' => $this->newsmodel->getNews()),
                true),
            'news_select' => true
        ), true);
    }
}

?>
