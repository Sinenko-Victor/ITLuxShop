<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Adminblocks_Editlist extends Controller_Base {
    
    public $template = 'adminblocks/b_editlist';
    
    public function action_index() {
        
        $ca = (int) $this->request->param('ca');
        $br = (int) $this->request->param('br');
        $list = (int) $this->request->param('list');
        if($br=='all'){$sel_br='';}else{$sel_br=$br;}
        if($list==''){$list=1;}
        
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
                $goods=ORM::factory('good')
                    ->where('br_id', '=', $sel_br)
                    ->where('ca_id', '=', $ca)
                    ->limit($num_go_list)
                    ->offset($offset)
                    ->order_by('go_name')
                    ->find_all();
                
                $count_goods=ORM::factory('good')
                    ->where('br_id', '=', $sel_br)
                    ->where('ca_id', '=', $ca)
                    ->count_all();
            }
            else
            {
                $goods=ORM::factory('good')
                    ->where('ca_id', '=', $ca)
                    ->limit($num_go_list)
                    ->offset($offset)
                    ->order_by('go_name')
                    ->find_all();
                
                $count_goods=ORM::factory('good')
                    ->where('ca_id', '=', $ca)
                    ->count_all();
            }
            
            $brends = ORM::factory('good')
                ->where('ca_id', '=', $ca)
                ->group_by('br_id')
                ->find_all();
                
            //$sel_brend['0']='нет данных';
            $sel_brend['']='Все!';
            foreach ($brends as $brend)
            {
                $br_id=$brend->br_id;
                if($br_id!=0)
                {
                    $sel_brend[$br_id]=$brend_mas[$br_id];
                }
            };
                            
            foreach($goods as $good)
            {
                //Обрезаем строку и преобразуем специальные символы в HTML сущности
                $name[$good->go_id] = htmlspecialchars(Text::limit_chars($good->go_name, 70, NULL, TRUE), ENT_QUOTES);
                $cost[$good->go_id] = number_format($good->go_cost, 0, ',', ' '); //меняем точку на запятую 
                if($good->go_ok > 0)
                {
                    $linkok[$good->go_id] = "/arun/delete/ok/".$good->go_id;
                    $titleok[$good->go_id] = "Товар показан на ветрине! Убрать?";
                    $imgok[$good->go_id] = "/media_admin/img/ok-1-16.png";
                }
                else
                {
                    $linkok[$good->go_id] = "/arun/add/ok/".$good->go_id;
                    $titleok[$good->go_id] = "Отобразить товар на ветрине";
                    $imgok[$good->go_id] = "/media_admin/img/plus-1-16.png";
                }
                
                if($good->br_id!=0 and $sel_br == "")
                {
                    $brend_go[$good->go_id] = $sel_brend[$good->br_id];
                }
                elseif($sel_br != "")
                {
                    $brend_go[$good->go_id] = $sel_brend[$sel_br];
                }
                else
                {
                    $brend_go[$good->go_id] = '-';    
                }       
            }
            
            $count_list=ceil($count_goods/100);
            $pagin=$this->pagination ($count_list, $list, 10, '/ca_run/'.$br.'/1/1', '/ca_run/'.$br.'/1/');
            
            $this->template->pagin=$pagin;
            $this->template->ca=$ca;
            $this->template->count_goods=$count_goods;
            $this->template->goods=$goods;
            $this->template->brend_go=$brend_go;
            $this->template->sel_brend=$sel_brend;
            $this->template->sel_br=$sel_br;
            $this->template->name=$name;
            $this->template->cost=$cost;
            
            $this->template->linkok=$linkok;
            $this->template->imgok=$imgok;
            $this->template->titleok=$titleok;
        
        }
        else
        {
            HTTP::redirect('/admin/catalog');
        }
                               
    }     

}