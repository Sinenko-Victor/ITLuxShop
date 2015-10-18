<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Index_Go extends Controller_Index {
    
    public function action_index() {        
        
        $title_tov='Текущий товар';
        //$this->template->styles[] = 'lib/lightgallery-1.4-rc1/skins/default/style.css'; //Галлегеф фото
        //$this->template->scripts[] = 'lib/lightgallery-1.4-rc1/lightgallery.min.js'; //Галлегеф фото
        //$this->template->scripts[] = 'lib/lightgallery-1.4-rc1/lang/ru_utf8.js'; //Галлегеф фото
        
        $list = $this->session->get('list'); //Получаем данные из сесии
        $this->session->delete('list'); //Удаляем переменную сесии
        
        $id = (int) $this->request->param('id');
        $titlen = $this->request->param('titlen');
        if($id < 1){HTTP::redirect('/');} // Если не выбрана категория перенаправляем на другую страницу
        if($id>0)
        { 
            $good = ORM::factory('good', $id);  
            $folder_goods = $good->go_id; //ID товара
            $ca_id = $good->ca_id;
            $name = htmlspecialchars(Text::limit_chars($good->go_name, 70, NULL, TRUE), ENT_QUOTES);
            $text = $good->go_text;
            $cost = number_format($good->go_cost, 2, ',', ' '); //меняем точку на запятую
            
            $ca_line=HTML::anchor('/', 'Каталог товара').$this->ca_line($good->ca_id, '');
            
            //проверяем существование фото
            $foto[$good->go_id] = "<img border='0' src='/media/img/nofoto.jpg' align='absmiddle' width='150' height='150' />";
            if($good->img_id != Null)
            {
                $foto[$good->go_id] = "<a href='/media/foto/goods/".$good->go_id."/".$good->img_id.".jpg' data-lightbox='roadtrip' title='".$good->go_name."'>
                <img border='0' src='/media/foto/goods/".$good->go_id."/".$good->img_id."_.jpg' /></a>";
            }
            
            $fotos = "<div id='fotopl_list'>";
            
            $imgs = $good->images->find_all();
            foreach($imgs as $img)
            {
                $img_id = $img->img_id;
                if($img_id != $good->img_id)
                {
                    $fotos .= "
                    <div id='fotopl'>
                        <span class='link_3'>
                        <a href='/media/foto/goods/".$id."/".$img_id.".jpg' data-lightbox='roadtrip' title='".$good->go_name."'>
                        <div id='fotopl_img'>
                            <img border='0' src='/media/foto/goods/".$id."/".$img_id."_.jpg' />   
                        </div>
                        </a></span>
                    </div>";
                }      
            }
            $fotos .= "<div id='floatend'>
                </div> 
            </div>";
            
            
            
            if($good->go_cost > 0)
            {
                $cost = number_format($good->go_cost, 0, ',', ' '); //меняем точку на запятую
                $cost = "<div class='go_price'>Цена: <span>".$cost."</span>&nbsp;грн.</div>";
            }
            else
            {
                $cost = "<div class='go_price'>Цена: <span>Договорная</span></div>";
            }
            
            $brend = '';
            if($good->br_id > 0)
            {
                $brend_mas = $this->brend();
                $brend = "Производитель: <span>".$brend_mas[$good->br_id]."<span/>";
            } 
        }
        else       
        {
            HTTP::redirect('/');
        }

        if(@$br==''){$br='all';}
        if(@$list==''){$list='all';}
        // Виджеты
        //$calist = Request::factory('calist/'.$ca_id.'/'.$br.'/'.$list)->execute();
        
        $tree=$this->ca_tree($ca_id); //Дерево категорий 

            
        $block_center = View::factory('index/go/v_go_index', array(
            'good' => $good,
            'catalog_tree' => $tree,
            'name' => $name,
            'text' => $text,
            'cost' => $cost,
            //'calist' => $calist,
            'foto' => $foto,
            'fotos' => $fotos,
            'brend' => $brend,
            'ca_line' => $ca_line,
            'folder_goods' => $folder_goods,
            )); 
        
        // Вывод в шаблон
        $this->template->styles[] = 'lib/lightbox/css/lightbox.css'; //Галлегеф фото
        $this->template->scripts[] = 'lib/lightbox/js/jquery-1.11.0.min.js'; //Галлегеф фото
        $this->template->scripts[] = 'lib/lightbox/js/lightbox.js'; //Галлегеф фото
        $this->template->page_title = $name.' купить';
        $this->template->site_description = $this->template->site_description.', '.$name.', '.$text.', цена, купить';
        $this->template->block_center = array($block_center);
    }   
     

} //End Controller_Index_Go