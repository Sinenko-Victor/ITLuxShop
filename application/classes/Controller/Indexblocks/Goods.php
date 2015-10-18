<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Indexblocks_Goods extends Controller_Base {
    
    public $template = 'indexblocks/b_goods';
    
    public function action_index() {
        
        $ca = (int) $this->request->param('ca');
        $br = (int) $this->request->param('br');
        $list = (int) $this->request->param('list');
        if($br=='all'){$sel_br='';}else{$sel_br=$br;}
        if($list==''){$list=1;}
        
        $vid_tovara = $this->session->get('vid_tovara'); //Получаем данные из сесии
        
        //Проверяем есть ли в данном категории товар
        $count_goods=ORM::factory('good')->where('ca_id', '=', $ca)->count_all();
        
        $num_go_list=100;//Количество товаров на листе  
        $count_list=ceil($count_goods/$num_go_list); //Количество листов        
        $offset=$num_go_list*$list-$num_go_list; //Номер первого товара на текущем листе
        if($list > 9999)
        {$num_go_list=1000000; $offset=0;}//Количество товаров на листе
        
        if($count_goods>0)
        {
            $brend_mas=$this->brend(); 
            if($sel_br>0)
            {
                $goods = ORM::factory('good')
                    ->where('br_id', '=', $sel_br)
                    ->where('ca_id', '=', $ca)
                    ->where('go_ok', '=', 1)
                    ->limit($num_go_list)
                    ->offset($offset)
                    ->order_by('go_name')
                    ->find_all();
                
                $count_goods = ORM::factory('good')
                    ->where('br_id', '=', $sel_br)
                    ->where('ca_id', '=', $ca)
                    ->where('go_ok', '=', 1)
                    ->count_all();
            }
            else
            {
                $goods = ORM::factory('good')
                    ->where('ca_id', '=', $ca)
                    ->where('go_ok', '=', 1)
                    ->limit($num_go_list)
                    ->offset($offset)
                    ->order_by('go_name')
                    ->find_all();
                
                $count_goods = ORM::factory('good')
                    ->where('ca_id', '=', $ca)
                    ->where('go_ok', '=', 1)
                    ->count_all();
            }
            
            $brends = ORM::factory('good')
                ->where('ca_id', '=', $ca)
                ->group_by('br_id')
                ->find_all();
                
            //$sel_brend['0']='Все!';
            foreach ($brends as $brend)
            {
                $br_id = $brend->br_id;
                if($br_id != 0)
                {
                    $sel_brend[$br_id] = $brend_mas[$br_id];
                }
                else
                {
                    $sel_brend[''] = 'Все!';
                }
            };
                            
            $foto = array();
            $name = array();
            $cost = array();
            $cart = array();
            $brend_go = array();
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
                
                //Обрезаем строку и преобразуем специальные символы в HTML сущности
                $name[$good->go_id] = htmlspecialchars(Text::limit_chars($good->go_name, 70, NULL, TRUE), ENT_QUOTES);
                if($good->go_cost > 0)
                {
                    $cost[$good->go_id] = "<span class='end'>".number_format($good->go_cost, 0, ',', ' ')."</span><span class='grn'>грн.</span>";
                    $cart[$good->go_id] = "<a data-id='".$good->go_id."' title='Добавить в корзину'><img src='/media/img/cart-32.png' /></a>";
                }
                else
                {
                    $cost[$good->go_id] = "<span class='end'>Договорная</span>";
                    $cart[$good->go_id] = "";
                }
                
                if($good->br_id!=0 and $sel_br == "")
                {
                    $brend_go[$good->go_id] = $sel_brend[$good->br_id];
                }
                else
                {
                    $brend_go[$good->go_id] = "";
                }
                
                $foto[$good->go_id] = "<img border='0' src='/media/img/nofoto.jpg' align='absmiddle' width='150' height='150' />";
                if($good->img_id != Null)
                {;
                    $foto[$good->go_id] = "<img border='0' src='/media/foto/goods/".$good->go_id."/".$good->img_id."_.jpg' />";
                }        
            }
            
            $count_list=ceil($count_goods/100);
            $pagin=$this->pagination ($count_list, $list, 10, '/ca_run/'.$br.'/1/1', '/ca_run/'.$br.'/1/');
            
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
                'brend_go' => $brend_go,
                'cost' => $cost,
                'cart' => $cart,
            )); 
            
            
            $this->template->styles[] = 'media/css/plit_tov.css';
            $this->template->good_show = $good_show;
            $this->template->ca = $ca;
            $this->template->sel_brend = $sel_brend;
            $this->template->sel_br = $sel_br;
            $this->template->count_goods = $count_goods;
            $this->template->pagin = $pagin;        
        }
                               
    }     

}