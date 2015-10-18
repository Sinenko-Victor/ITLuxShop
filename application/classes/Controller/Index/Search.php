<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Index_Search extends Controller_Index {
    
    public function action_index() {
        
        $vid_tovara = $this->session->get('vid_tovara'); //Получаем данные из сесии
        $tree=$this->ca_tree(); //Дерево категорий
        $brend_mas=$this->brend(); //Получаем из базы виды достваки с создаем масив
        $search = Arr::get($_POST, 'searchfield', '');
        if(!empty($search))
        {
            
            $count=ORM::factory('good')
                ->or_where('go_id','like', '%'.$search.'%')
                ->or_where('go_name','like', '%'.$search.'%')
                ->where('go_ok', '=', 1)
                ->count_all();            
            
            if($count==0)
            {
                HTTP::redirect('/');
            }
            elseif($count==1)
            {
                $goods = ORM::factory('good')
                    ->or_where('go_id','like', '%'.$search.'%')
                    ->or_where('go_name','like', '%'.$search.'%')
                    ->where('go_ok', '=', 1)
                    ->find_all();
                foreach($goods as $good)
                {
                    HTTP::redirect('/go/'.$good->go_id);
                }              
            }
            else
            {
                $goods = ORM::factory('good')
                    ->or_where('go_id','like', '%'.$search.'%')
                    ->or_where('go_name','like', '%'.$search.'%')
                    ->where('go_ok', '=', 1)
                    ->order_by('go_name')
                    ->find_all();
            }
               
        }
        else
        {
            HTTP::redirect('/');
        }

        $search_mess='<span class="text_10">Результат поиска [</span><span class="text_3">'.$search.'</span><span class="text_2">]
        </span> <span class="text_6">найдено:</span><span class="text_3"> '.$count.' </span><span class="text_6">товаров</span>';
        //Ищем фото выбранных товаров
        foreach($goods as $good)
        {
            //Обрезаем строку и преобразуем специальные символы в HTML сущности
            $title[$good->go_id]=str_replace(',','',$good->go_name);
            $title[$good->go_id]=str_replace('.','',$title[$good->go_id]);
            $title[$good->go_id]=str_replace('/','-',$title[$good->go_id]);
            $title[$good->go_id]=str_replace('\\','-',$title[$good->go_id]);
            $title[$good->go_id]=str_replace('%','_процентов',$title[$good->go_id]);
            $title[$good->go_id]=htmlspecialchars(Text::limit_chars($title[$good->go_id], 200, NULL, TRUE), ENT_QUOTES);
            $title[$good->go_id]=str_replace(' ','_',$title[$good->go_id]);
            $name[$good->go_id]=htmlspecialchars(Text::limit_chars($good->go_name, 115, NULL, TRUE), ENT_QUOTES);
            
            if($good->go_cost > 0)
            {
                $cost[$good->go_id] = number_format($good->go_cost, 0, ',', ' '); //меняем точку на запятую
                $cost[$good->go_id] = "<span class='end'>".$cost[$good->go_id]."</span><span class='grn'>грн.</span>";
                $cart[$good->go_id] = "<a data-id='".$good->go_id."' title='Добавить в корзину'><img src='/media/img/cart-32.png' border='0'/></a>";
            }
            else
            {
                $cost[$good->go_id] = "<span class='end'>Договорная</span>";
                $cart[$good->go_id] = "";
            }
            
            if($good->br_id != '' and $good->br_id != 0){$brend[$good->go_id]=$brend_mas[$good->br_id];}else{$brend[$good->go_id]='';}
            
            $foto[$good->go_id] = "<img border='0' src='/media/img/nofoto.jpg' align='absmiddle' width='150' height='150' />";
            if($good->img_id != Null)
            {
                $image = ORM::factory('image', $good->img_id);
                $id_mainfoto = $image->img_id;
                $foto[$good->go_id] = "<a href='/go/".$good->go_id."' data-lightbox='roadtrip' title='".$good->go_name."'>
                <img border='0' src='/media/foto/goods/".$good->go_id."/".$image->img_dir."_.jpg' /></a>";
            }  
            
         
        }
        
        if($vid_tovara == 2)
        {
            $vid_form = 'indexblocks/b_goods_spisok';
        }
        else
        {
            $vid_form = 'indexblocks/b_goods_plitka';
        }
        
        $good_show = View::factory($vid_form, array(
            'goods' => $goods,
            'foto' => $foto,
            'name' => $name,
            'title' => $title,
            'brend_go' => $brend,
            'cost' => $cost,
            'cart' => $cart,
        ));
        
        
        $main = View::factory('index/search/v_index_search', array(
            'catalog_tree' => $tree,
            'good_show' => $good_show,
            'search_mess' => $search_mess,
        ));
        
        // Вывод в шаблон
        $this->template->styles[] = 'media/css/plit_tov.css';
        $this->template->page_title = 'Поиск товара';
        $this->template->block_center = array($main);    
        
        
        
        
        
        
        
        
        
    }     
     

} //End Contriler_Index_Main