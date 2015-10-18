<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Indexblocks_Header extends Controller_Base {

    public $template = 'indexblocks/b_header';
    
    public function action_index()
    {
        //Инициализация сесии
        $this->session = Session::instance();
        
        //Проверяем авторизован ли пользователь
        $user = '';
        if(Auth::instance()->logged_in()) {
            $user=$this->user->username;  
        }
        
        $setings_4 = ORM::factory('seting', 4);
        $tel = $setings_4->set_data;
        $setings_5 = ORM::factory('seting', 5);   
        $slogan = $setings_5->set_data;
        
        
        $products_all = $this->session->get('products_all');
        $products_cost = $this->session->get('products_cost');
        
        $pages = ORM::factory('page')->where('pg_father', '=', 1)->order_by('pg_id')->find_all();
         
        //Проверяем есть ли товары в корзине
        if($products_cost > 0)
        {
            $products_cost = number_format($products_cost, 2, ',', ' ')." грн."; //меняем точку на запятую
            $open_cart = '<div id="cart_top_logo"><a href="/cart" title="Открыть корзину">'.$products_all.'</a></div>';
            $run_oder = '<div id="run_oder"><a href="/cart/order" title="Оформить заказ"></a></div>';
            $del_tov = '<img src="/media/img/delete-16.png" />';
        }
        else
        {
            $products_cost = '';
            $products_all = 0;
            $open_cart = '';
            $del_tov = '';
            $run_oder = '';
            
        }
        $topmenu = ORM::factory('page')->where('pg_father', '=', 1)->find_all();
        
        // Вывод в шаблон
        $this->template->topmenu = $topmenu;
        $this->template->products_cost = $products_cost;
        $this->template->products_all = $products_all;
        $this->template->user = $user;
        $this->template->pages = $pages;
        $this->template->tel = $tel;
        $this->template->slogan = $slogan;
        $this->template->open_cart = $open_cart;
        $this->template->del_tov = $del_tov;
        $this->template->run_oder = $run_oder;             
    }

}