<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Orders extends Controller_Admin {    
    
     public function action_index() {
        
        $status=$this->orstat(); //Статус заказа, масив
        $sends=$this->orsend(); //Вид доставки, масив
        
        //Проверяем нужна ли обработка формы
        if (isset($_POST['submit'])) 
        {
            $data_or = Arr::extract($_POST, array('or_status'));
            $stat=$data_or['or_status'];
             foreach ($stat as $key => $value)
             {
                ORM::factory('order', $key)->set('st_id', $value)->save();
             }
        }
        
        $id = $this->request->param('id');
        $id = preg_replace ("/[^0-9\ \s]/","",$id); //Удаляем все короме цифр
        $id = substr($id, 0, 1); //Обрезаем строку до одного символа
        if($id!="")
        {
            $orders = ORM::factory('order')->where('st_id', '=', $id)->order_by('or_id', 'DESC')->find_all(); 
        }
        else
        {
            $orders = ORM::factory('order')->order_by('or_id', 'DESC')->where('st_id', '!=', 5)->find_all();
        }
        
        $content = View::factory('admin/orders/v_orders_index')
            ->bind('id', $id)
            ->bind('status', $status)
            ->bind('sends', $sends)
            ->bind('orders', $orders);

        // Вывод в шаблон;
        $this->template->page_title = 'Заказы';
        $this->template->block_center = array($content);
    }
    
    public function action_del() {
        
        $number_order = (int) $this->request->param('id');
        $number_order = preg_replace ("/[^0-9\ \s]/","",$number_order); //Удаляем все короме цифр
        //Получаем данные о заказе
        if($number_order!="")
        { 
            $order = ORM::factory('order', $number_order)
                ->values(array(
                    'st_id' => 5)
                )
                ->save();
        }
        HTTP::redirect('/admin/orders');
    }

}