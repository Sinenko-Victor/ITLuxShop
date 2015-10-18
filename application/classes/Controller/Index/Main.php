<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Index_Main extends Controller_Index {   
    
    public function action_index() {
        
        $tree = $this->ca_tree();
        $page = ORM::factory('page', 2);  
        $tel = $page->pg_text;
        
        // Виджеты
        $catalogvid = Request::factory('indexblocks/Catalogvid/0/')->execute();
        
        $main = View::factory('index/main/v_main_index', array(
            'catalog_tree' => $tree,
            'catalogvid' => $catalogvid,
        ));
        
        // Вывод в шаблон
        $this->template->page_title = 'Катоалог товаров';
        $this->template->block_center = array($main);                        
    }
    
    public function action_index_удалить() {
        
        $tree=$this->ca_tree();
        $page = ORM::factory('page', 2);  
        $tel=$page->pg_text;
        
        $catalogs = ORM::factory('catalog')->where('ca_father', '=', 0)->order_by('ca_name')->find_all();
        $foto = array();
        foreach($catalogs as $catalog)
        {
            //проверяем существование фото
            $file_img=$_SERVER['DOCUMENT_ROOT']."/media/foto/catalog/".$catalog->ca_id.".jpg";
            if (file_exists($file_img)) 
            {
                $foto[$catalog->ca_id] = '<img src="/media/foto/catalog/'.$catalog->ca_id.'.jpg" width="150" height="110" />';  
            } 
            else 
            {
                $foto[$catalog->ca_id] = '<img src="/media/img/nofoto.jpg" width="120" height="120" />';  
            }                
        }
        
        $main = View::factory('index/main/v_main_index', array(
            'catalog_tree' => $tree,
            'catalogs' => $catalogs,
            'foto' => $foto,
        ));
        
        // Вывод в шаблон
        $this->template->page_title = 'Катоалог товаров';
        $this->template->block_center = array($main);                        
    }  
     

} 