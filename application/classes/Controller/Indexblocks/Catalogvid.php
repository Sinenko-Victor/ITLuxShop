<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Indexblocks_Catalogvid extends Controller_Base {

    public $template = 'indexblocks/b_catalogvid';
    
    public function action_index()
    {
        $id_ca = (int) $this->request->param('param');
        
        $catalogs = ORM::factory('catalog')->where('ca_father', '=', $id_ca)->order_by('ca_name')->find_all();
        $foto = array();
        $sab_catalogs = array();
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
            
            //Определяем подкатегории
            $sab_cat_link[$catalog->ca_id] = ''; $sab_catalogs[$catalog->ca_id] = '';
            $sub_count = ORM::factory('catalog')->where('ca_father', '=', $catalog->ca_id)->order_by('ca_name')->count_all();
            if($sub_count > 0)
            {
                $subcatalogs = ORM::factory('catalog')->where('ca_father', '=', $catalog->ca_id)->order_by('ca_name')->find_all();
                foreach($subcatalogs as $subcatalog)
                {
                    $sab_cat_link[$catalog->ca_id] .= HTML::anchor('/ca/'.$subcatalog->ca_id.'/1', $subcatalog->ca_name)."<br />";
                }
                $sab_catalogs[$catalog->ca_id] = '<div class="sub_catalog">'.$sab_cat_link[$catalog->ca_id].'</div>';
            }                      
        }
        
        $this->template->id_ca = $id_ca;
        $this->template->catalogs = $catalogs;
        $this->template->foto = $foto;
        $this->template->sab_catalogs = $sab_catalogs;
    }

}