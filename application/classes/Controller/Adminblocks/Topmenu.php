<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Adminblocks_Topmenu extends Controller_Base {

    public $template = 'adminblocks/b_topmenu';
    
    public function action_index()
    {
        $orstat=$this->orstat(); //Получаем из базы статусы заказа
        $this->template->orstat = $orstat;
    }

}