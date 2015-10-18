<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Indexblocks_Rekomend extends Controller_Base {

    public $template = 'indexblocks/b_rekomend';
    
    public function action_index()
    {
        $param = $this->request->param('param');
        $goods_rek = '';
        $rekomed = '';
        $goods_rek = ORM::factory('good')->where($param, '=', 1)->find_all(); // Данные о товаре
        
        foreach($goods_rek as $rek) //Создаем масивы
        {            
            $rekomed['name'][$rek->go_id] = $rek->go_name;
            $rekomed['cost'][$rek->go_id] = number_format($rek->go_cost, 2, ',', ' '); //меняем точку на запятую
            
            //Получаем сколько нужно добавить нулей
            $num_didg = 7 - mb_strlen($rek->go_id);
            $folder_goods = $rek->go_id;
            for ($or=1; $or<=$num_didg; $or++){$folder_goods="0".$folder_goods;}
            $rekomed['img'][$rek->go_id]=$folder_goods;
            
        }
        
        // Вывод в шаблон
        $this->template->goods_rek = $goods_rek;
        $this->template->rekomed = $rekomed;
        
    }

}