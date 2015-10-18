<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Order extends Controller_Admin {    
    
     public function action_index() {
        
        $number_order = (int) $this->request->param('id');

        //Получаем данные о заказе
        if($number_order>0)
        { 
            $order = ORM::factory('order', $number_order); //Данные о заказщике
            $goods = $order->ordergoods->find_all(); // Данные о товаре
            $send = $order->send->se_name; //Вид доставки, масив 
            $status = $this->orstat(); //Статус заказа, масив
            $content = View::factory('admin/order/v_order_index')
                ->bind('order', $order)
                ->bind('goods', $goods)
                ->bind('status', $status)
                ->bind('send', $send);

            // Выводим в шаблон
            $this->template->title = 'Оформление заказа';
            $this->template->page_title = 'Оформление заказа';
            $this->template->block_center = array($content);
        }
        else
        {
            HTTP::redirect('/');
        }
    }

}