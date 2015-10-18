<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Index_Vcart extends Controller_Base {
    
    public $template = 'index/cart/v_cart_vcart';        // Базовый шаблон
    
    public function before() {
        parent::before();       
    }
    
    public function action_index() {
        $id = (int) $this->request->param('id');
        $num = (int) $this->request->param('num');
        $products_s = $this->session->get('products');
        
        if(isset($id) && is_numeric($id))
        {            
            if($num < 1)
            {$num = 1;}
            $this->addToCart($id,$num);
            
            $this->template->products_all = $products_all = $this->session->get('products_all');
            $products_cost = $this->session->get('products_cost');
    
            //Проверяем есть ли товары в корзине
            if($products_cost>0)
            {
                $this->template->products_cost = number_format($products_cost, 2, ',', ' ')." грн."; //меняем точку на запятую
                $this->template->open_cart = '<div id="cart_top_logo"><a href="/cart" title="Открыть корзину">'.$products_all.'</a></div>';
                $this->template->del_tov = '<img src="/media/img/delete-16.png" />';
                $this->template->run_oder = '<div id="run_oder"><a href="/cart/order" title="Оформить заказ"></a></div>';
            }
            else
            {
                $this->template->products_all=0;
            }   
        }       
    }
    
    public function action_clear() {
        
        $this->session->delete('products_all');
        $this->session->delete('products_cost');
        $this->session->delete('products');
        $ref=getenv("HTTP_REFERER");
        HTTP::redirect($ref);
    }

//--------------------------  Функции  ---------------------------------


//Добавить товар в корзину
public function addToCart($id,$num){
    $products = $this->session->get('products'); 
    $products_all = $this->session->get('products_all');
    $products_cost = $this->session->get('products_cost');
    
    $good = ORM::factory('good', $id);
    $go_cost = $good->go_cost;
    if($go_cost){
     
    //Количество выбраного товара
    if (isset($products[$id])) {
        $products[$id] = $products[$id] + $num;
    }
    else {
        $products[$id] = $num;
    }  
    
    //Количество всех товара 
    if (isset($products_all)) {
        $products_all = $products_all + $num;
    }
    else {
        $products_all = $num;
    }
    $this->session->set('products_all', $products_all);
    
    //Получаем стоимость товара
    if (isset($products_cost)) {
        $products_cost=$products_cost+$go_cost*$num;
    }
    else {
        $products_cost = $go_cost*$num;
    }
    $this->session->set('products_cost', $products_cost);   
    }
    
    $this->session->set('products', $products);    
}
     

} //End Controller_Index_Vcart