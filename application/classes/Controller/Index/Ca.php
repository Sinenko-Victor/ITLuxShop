<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Index_Ca extends Controller_Index {
    
    public function action_index() {
        
        $list = $this->session->get('list'); //Получаем данные из сесии
        $this->session->delete('list'); //Удаляем переменную сесии
        $sel_br = $this->session->get('br'); //Получаем данные из сесии
        $this->session->delete('br'); //Удаляем переменную сесии
        
        //$gorek = Request::factory('indexblocks/Rekomend/go_rek')->execute(); //Рекомендуемые товары
        //$gobest = Request::factory('indexblocks/Rekomend/go_best')->execute(); // лучшие товары
        
        $id = (int) $this->request->param('id');
        $ca_line = HTML::anchor('/', 'Каталог товара').$this->ca_line($id, ''); //Вложенность категорий
        if($id < 1)// Если не выбрана категория перенаправляем на другую страницу
        {
            HTTP::redirect('/');
        }
        else
        {
            $catalog = ORM::factory('catalog', $id); //Получаем название категории
            $name_catalog=htmlspecialchars(Text::limit_chars($catalog->ca_name, 70, NULL, TRUE), ENT_QUOTES);
            
            $brend_mas=$this->brend(); //Получаем из базы виды достваки с создаем масив
            $tree=$this->ca_tree($id); //Дерево категорий
            
            // Виджеты
            $catalogvid = Request::factory('indexblocks/Catalogvid/'.$id)->execute();           
            
            //Проверяем есть ли в данном категории товар
            $count=ORM::factory('good')->where('ca_id', '=', $id)->count_all();            
            if($count>0)
            {   
                //В данной гуппе есть товары
                if(isset($_POST['brends'])and $_POST['brends']!="")
                {
                    $sel_br=$_POST['brends'];
                }
 
                if(@$sel_br==''){$sel_br='all';}
                if(@$list==''){$list='all';}
                
                $cagoods = Request::factory('goods/'.$id.'/'.$sel_br.'/'.$list)->execute();  
            }
            else
            {
                $cagoods = "";
            }

            $block_center = View::factory('index/catalog/v_catalog_index', array(
                'id' => $id,
                'catalog_tree' => $tree, 
                'catalogvid' => $catalogvid,
                'ca_line' => $ca_line,
                'cagoods' => $cagoods,
            )); 
        }       
        
        // Вывод в шаблон
        $this->template->styles[] = 'media/css/plit_tov.css';  
        $this->template->page_title = $name_catalog;
        $this->template->site_description = $this->template->site_description.', '.$name_catalog.', цена, купить';
        $this->template->block_center = array($block_center);
    }
    
    public function action_run() {
        
        $ref=getenv("HTTP_REFERER");
        $br = $this->request->param('br');
        $id = (int) $this->request->param('id');
        $param = $this->request->param('param');
        
        //id=1 листы, param - номер листа
        if($id == 1)
        {
            $this->session->set('list', $param);
            $this->session->set('br', $br);
        }
        
        //id=2 Вид (плитка/список), 1 - плитка, 2 - список
        if($id == 2)
        {
            $this->session->set('vid_tovara', $param);
            $this->session->set('br', $br);
        }
        HTTP::redirect($ref);      
    }
    
     

} //End Controller_Index_Ca