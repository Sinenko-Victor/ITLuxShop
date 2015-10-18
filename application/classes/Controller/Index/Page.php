<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Index_Page extends Controller_Index {
    
    public function action_index() {
        
        $title_tov='Текущий товар';
        $id = (int) $this->request->param('id');
        if($id!="")
        { 
            $page = ORM::factory('page', $id);   
        }
        
        $tree=$this->ca_tree();
        $block_center = View::factory('index/page/v_page_index', array(
            'catalog_tree' =>$tree,
            'page' =>$page,
        ));       

        // Вывод в шаблон
        $this->template->page_title = $page->pg_title;
        $this->template->block_center = array($block_center);
    }     
}