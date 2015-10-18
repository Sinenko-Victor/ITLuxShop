<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Main extends Controller_Admin {    
    
     public function action_index() {

        //Получаем количество строк в таблице категорий и товаров
        $catalog_num = ORM::factory('catalog')->count_all();
        $goods_num = ORM::factory('good')->count_all();
        $gofoto_num = ORM::factory('good')->where('img_id', '>', 0)->count_all();
        $brends_num = ORM::factory('brend')->count_all();
        $users_num = ORM::factory('user')->count_all() - 1;
        $order_num = ORM::factory('order')->where('st_id', '=', 0)->count_all();
                
        $content = View::factory('admin/main/v_main_index', array(
            'page_title' =>'Статистика',
            'catalog_num' =>$catalog_num,
            'goods_num' =>$goods_num,
            'gofoto_num' =>$gofoto_num,
            'brends_num' =>$brends_num,
            'users_num' =>$users_num,
            'order_num' =>$order_num,
        ));

        // Вывод в шаблон
        $this->template->page_title = 'Главная';
        $this->template->block_center = array($content);
    }

}