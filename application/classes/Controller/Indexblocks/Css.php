<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Css extends Controller_Base {

    public $template = 'index/css';        // Базовый шаблон

    public function  before() {
        parent::before();      
        
        // Вывод в шаблон
        $this->template->styles[] = 'media/css/index.css';
        $this->template->styles[] = 'lib/lightbox/css/lightbox.css';
        $this->template->styles[] = 'lib/xtree/style.css';         
    }
}