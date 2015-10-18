<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Css extends Controller_Base {

    public $template = 'index/v_css';        // Базовый шаблон

    public function  before() {
        parent::before();
      
        
        // Вывод в шаблон
        $this->template->styles[] = 'media/css/main.css'; 

        
    }
    
    public function action_index() {
        
        $this->template->page_title = 'Стили';     
    }
    

}