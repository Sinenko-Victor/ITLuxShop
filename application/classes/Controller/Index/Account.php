<?php defined('SYSPATH') or die('No direct script access.');
/*
 * Личный кабинет
 */
class Controller_Index_Account extends Controller_Index {

    public function before(){
        parent::before();
        if (!Auth::instance()->logged_in()) {
            HTTP::redirect('/login');
        }
        
        //Проверяеп авторизовался покупатель или администратор
        $inuser=$this->user->username;
        if($inuser=='admin')
        {
            HTTP::redirect('/admin');
        }
        
        
        
    }

    public function action_index() {
        
        HTTP::redirect('account/profile');
    }
    
    public function action_profile() {
        
        $profok=''; //Сообщение об изминении даных
        
        // Виджеты
        $action = $this->request->action(); //Получаем текуший єкшен
        $menuaccaunt = Request::factory('indexblocks/Menuaccaunt/'.$action)->execute();
        
        if (isset($_POST['submit'])) 
        {
            $users = ORM::factory('user');
            $_POST['tel'] = preg_replace ("/[^0-9\-\ \s]/","",$_POST['tel']);  //Убераем буквы и цифры с телефонного номера       
            try 
            {
                $users->where('id', '=', $this->user->id)
                    ->find()
                    ->update_user($_POST, array(
                        'username',
                        'first_name',
                        'email',
                        'tel',
                        'city',
                        'street',
                        'building',
                        'office',
                        'data',
                        ));
                
                $profok='Изминения сохранены!'; //Сообщение об изминении даных
                
            }
            catch (ORM_Validation_Exception $e) 
            {
                $errors = $e->errors('auth');
            }
            //Получаем обновленные данные з базы
            $updata_user = ORM::factory('user')
                ->where('id', '=', $this->user->id)
                ->find();
            $user_data=$updata_user;
        }
        else
        {
            $user_data=$this->user;
        }
        
        $content = View::factory('index/account/v_account_profile')
            ->bind('menuaccaunt', $menuaccaunt)
            ->bind('user', $user_data)
            ->bind('profok', $profok)
            ->bind('errors', $errors);

        // Выводим в шаблон
        $this->template->title = 'Профиль';
        $this->template->page_title = 'Профиль';
        $this->template->block_center = array($content);
    }

    public function action_orders() {
        
        // Виджеты
        $action = $this->request->action(); //Получаем текуший єкшен
        $menuaccaunt = Request::factory('indexblocks/Menuaccaunt/'.$action)->execute();
          
        $status=$this->orstat(); //Статус заказа, масив
        $sends=$this->orsend(); //Вид доставки, масив
        $orders = ORM::factory('order')->where('bu_id', '=', $this->user->id)->where('st_id', '!=', 5)->order_by('or_id', 'DESC')->find_all(); //Получаем заказы текущего покупателя
        $content = View::factory('index/account/v_account_orders')
            ->bind('menuaccaunt', $menuaccaunt)
            ->bind('status', $status)
            ->bind('sends', $sends)
            ->bind('orders', $orders);
        
        // Выводим в шаблон
        $this->template->title = 'Заказы';
        $this->template->page_title = 'Заказы';
        $this->template->block_center = array($content);
    }
    
    public function action_order() {
          
        // Виджеты
        $action = $this->request->action(); //Получаем текуший єкшен
        $menuaccaunt = Request::factory('indexblocks/Menuaccaunt/'.$action)->execute();
        
        $number_order = (int) $this->request->param('id');

        //Получаем данные о заказе
        if($number_order>0)
        { 
            $order = ORM::factory('order', $number_order); //Данные о заказщике
            $goods = $order->ordergoods->find_all(); // Данные о товаре
            $send = $order->send->se_name; //Вид доставки, масив 
            $status = $this->orstat(); //Статус заказа, масив
            $content = View::factory('index/account/v_account_order')
                ->bind('menuaccaunt', $menuaccaunt)
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
    
    public function action_cancel() {
          
        $number_order = (int) $this->request->param('id');

        //Получаем данные о заказе
        if($number_order>0)
        { 
            $order = ORM::factory('order', $number_order)
                ->values(array(
                    'st_id' => 3)
                )
                ->save();
        }
        HTTP::redirect('/account/orders');
    }
    
    public function action_pass() {
        $passok='';
        // Виджеты
        $action = $this->request->action(); //Получаем текуший єкшен
        $menuaccaunt = Request::factory('indexblocks/Menuaccaunt/'.$action)->execute();
        
        if (isset($_POST['submit'])) {
                    $users = ORM::factory('user');
                    $data = Arr::extract($_POST, array('password', 'password_confirm'));
                    $data['repass'] = $data['password'];
                    try {
                        $users->where('id', '=', $this->user->id)
                                ->find()
                                ->update_user($data, array(
                                    'password',
                                    'repass'
                                ));
                        //HTTP::redirect('account/pass');
                        $passok='Новый пароль сохранен!';
                    }
                    catch (ORM_Validation_Exception $e) {
                        $errors = $e->errors('auth');
                    }
                }


        $content = View::factory('index/account/v_account_pass')
            ->bind('menuaccaunt', $menuaccaunt)
            ->bind('user', $this->user)
            ->bind('passok', $passok)
            ->bind('errors', $errors);

        // Выводим в шаблон
        $this->template->title = 'Профиль';
        $this->template->page_title = 'Профиль';
        $this->template->block_center = array($content);
    }
}