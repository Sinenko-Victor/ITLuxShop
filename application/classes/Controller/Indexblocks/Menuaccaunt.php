<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Indexblocks_Menuaccaunt extends Controller_Base {

    
    
    public $template = 'indexblocks/b_menuaccaunt';
    
    public function action_index()
    {
        $param=$this->request->param('param');
        
        // Вывод в шаблон
        $this->template->sel_order = '';
        $this->template->sel_prof = '';
        $this->template->sel_pass = '';
        if($param=='' || $param=='profile')
        {
            $this->template->sel_prof = 'id="current"';
        }
        elseif($param=='orders' || $param=='order')
        {
            $this->template->sel_order = 'id="current"';
        }
        elseif($param=='pass')
        {
            $this->template->sel_pass = 'id="current"';
        }
    }

}