<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Adminblocks_Menuset extends Controller_Base {

    public $template = 'adminblocks/b_menuset';
    
    public function action_index()
    {
        $param = $this->request->param('param');
        // Вывод в шаблон
        $this->template->sel_main = '';
        $this->template->sel_mail = '';
        $this->template->sel_pass = '';
        $this->template->sel_sitemap = '';
        
        if($param=='index')
        {
            $this->template->sel_main = 'id="current"';
        }
        elseif($param=='mail')
        {
            $this->template->sel_mail = 'id="current"';
        }
        elseif($param=='pass')
        {
            $this->template->sel_pass = 'id="current"';
        }
        elseif($param=='sitemap')
        {
            $this->template->sel_sitemap = 'id="current"';
        }

    }

}