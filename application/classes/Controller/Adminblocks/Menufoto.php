<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Adminblocks_Menufoto extends Controller_Base {

    public $template = 'adminblocks/b_menufoto';
    
    public function action_index()
    {
        $param = $this->request->param('param');
        // Вывод в шаблон
        $this->template->foto_index = '';
        $this->template->foto_in = '';
        $this->template->foto_noconect = '';
        
        if($param=='index')
        {
            $this->template->foto_index = 'id="current"';
        }
        if($param=='in')
        {
            $this->template->foto_in = 'id="current"';
        }
        elseif($param=='noconect')
        {
            $this->template->foto_noconect = 'id="current"';
        }
    }

}