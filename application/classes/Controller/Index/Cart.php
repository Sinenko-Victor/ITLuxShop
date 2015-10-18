<?php defined('SYSPATH') or die('No direct script access.');
/*
 * Корзина
 */
class Controller_Index_Cart extends Controller_Index {
   
    public function before(){
        parent::before();
        // Виджеты
        $menutov = Request::factory('indexblocks/Menutov')->execute(); //Меню товаров

        // Вывод в шаблон
        //$this->template->styles[] = 'lib/menu_files/style.css';
        //$this->template->scripts[] = 'lib/menu_files/script.js';
        $this->template->block_left = array($menutov);
    }
    
    public function action_index()
    {
        $products_s = $this->session->get('products');
        $brend_mas = $this->brend();
        //print_r($products_s);

        $products_cost = 0;
        $products_all = 0;
        if ($products_s != NULL)
        {
            $products = ORM::factory('good');
            foreach($products_s as $id => $count)
            {
                $products->or_where('go_id', '=', $id);
            }
            $products = $products->find_all();
            
            // Формирование корзины
            foreach ($products as $product)
            {
                $cart['products'][] = array(
                    'id' => $product->go_id,
                    'name' => $product->go_name,
                    'count' => $products_s[$product->go_id],
                    'cost' => $product->go_cost,
                );
                
                $products_cost += $product->go_cost * $products_s[$product->go_id];
                $products_all += $products_s[$product->go_id];
                
                if($product->br_id > 0)
                {
                    $brend_go[$product->go_id] = $brend_mas[$product->br_id];
                }
                else
                {
                    $brend_go[$product->go_id] = '';
                }
                
            }
            
            
            
            $this->session->set('products_cost', $products_cost);
            $this->session->set('products_all', $products_all);           
        }
        else
        {
            $products = NULL;
            $this->session->delete('products_all');
            $this->session->delete('products_cost');
            HTTP::redirect('/');
        }

        $products_cost=number_format($products_cost, 2, ',', ' '); //меняем точку на запятую
        $content = View::factory('index/cart/v_cart_index', array(
            'products' => $products,
            'products_s' => $products_s,
            'products_cost' => $products_cost,
            'products_all' => $products_all,
            'brend_go' => $brend_go,
        ));

        // Выводим в шаблон
        $this->template->title = 'Ваша корзина';
        $this->template->page_title = 'Ваша корзина';
        $this->template->block_center = array($content);

    }

    public function action_add()
    {
        // Получить существующие товары из куков
        $products_s = $this->session->get('products');
        $id = $this->request->param('id');

        if (isset($products_s[$id])) {
            $products_s[$id]++;
        }
        else {
            $products_s[$id] = 1;
        }

        $this->session->set('products', $products_s);
        HTTP::redirect('cart');
    }
    
    public function action_del()
    {
        // Получить существующие товары из куков
        $products_s = $this->session->get('products');
        $id = $this->request->param('id');

        if (isset($products_s[$id])) {
            unset ($products_s[$id]);    
        }
        
        $products_cost = 0;
        $products_all = 0;
        if ($products_s != NULL)
        {
            $products = ORM::factory('good');
            foreach($products_s as $id => $count)
            {
                $products->or_where('go_id', '=', $id);
            }
            $products = $products->find_all();
            
            // Формирование корзины
            foreach ($products as $product)
            {
                $cart['products'][] = array(
                    'id' => $product->go_id,
                    'name' => $product->go_name,
                    'count' => $products_s[$product->go_id],
                    'cost' => $product->go_cost,
                );
                
                $products_cost += $product->go_cost * $products_s[$product->go_id];
                $products_all += $products_s[$product->go_id];
            }
            
            $this->session->set('products_cost', $products_cost);
            $this->session->set('products_all', $products_all);           
        }

        $this->session->set('products', $products_s);
        HTTP::redirect('cart');
    }


    public function action_order()
    {
        
        $num_goods=count($this->session->get('products')); //Кол. товаров в корзине
        if($num_goods<1){
            HTTP::redirect('/');
        } 
        
        $errors=array();   
        
        if (!isset($_POST['submit'])) 
        {
            //echo"Отправить не нажато<br />";
            if (!Auth::instance()->logged_in())
            {
                //echo"НЕ залогинился<br />";
                $data_order = array(
                    'or_name' => '', //Имя заказщика
                    'or_email' => '', //Почта заказщика
                    'or_tel' => '', //Телефон заказщика
                    'se_id' => '', //Вид доставки
                    'or_city' => '', //Горд
                    'or_street' => '', //Улица
                    'or_building' => '', //Дом
                    'or_office' => '', //Номер кавртиры
                    'or_data' => '', //Дополнительная информация
                    'or_cost' => '', //Стоимость заказа
                );
            }
            else
            {
                //echo"ЗАЛОГИНИЛСЯ!<br />";
                $data_order = array(               
                    'or_name' => $this->user->first_name, //Имя заказщика
                    'or_email' => $this->user->email, //Почта заказщика
                    'or_tel' => $this->user->tel, //Телефон заказщика
                    'se_id' => '', //Вид доставки
                    'or_city' => $this->user->city, //Горд
                    'or_street' => $this->user->street, //Улица
                    'or_building' => $this->user->building, //Дом
                    'or_office' => $this->user->office, //Номер кавртиры
                    'or_data' => $this->user->data, //Дополнительная информация
                );
            }
        }
        else
        {
            //echo"Отправить НАЖАТО!<br />";
            $add_order = 1; //Если знаачение "1" не измениться то заказ создаем
            $data_or = Arr::extract($_POST, array('name', 'tel', 'send', 'email', 'city', 'street', 'building', 'office', 'data'));
            $data_or['tel'] = str_replace(" ","",$data_or['tel']);
            $data_or['tel'] = str_replace("-","",$data_or['tel']);
            $data_or['tel'] = preg_replace ("/[^0-9\-\ \s]/","",$data_or['tel']);
            if (!Auth::instance()->logged_in())
            {
                //echo"НЕ залогинился<br />";
                
                //Добавляем покупателя в базу
                $data['username'] = str_replace(' ', '', $data_or['name']); //убераем пробелы
                $data['username'] = substr($data['username'], 0, 8); //обрезаем строку
                $data['username'] = $data['username'].date("dis"); //добавляем дату
                $data['first_name'] = $data_or['name'];
                $data['password'] = md5(time().'as');
                $data['password_confirm'] = $data['password'];
                $data['repass'] = $data['password'];
                $data['tel'] = $data_or['tel'];
                $data['email'] = $data_or['email'];
                $data['city'] = $data_or['city'];
                $data['street'] = $data_or['street'];
                $data['building'] = $data_or['building'];
                $data['office'] = $data_or['office'];
                $data['data'] = $data_or['data'];
                $data['last_login'] = time();
                $users = ORM::factory('user');

                try {
                    $users->create_user($data, array(
                        'username',
                        'first_name',
                        'password',
                        'repass', 
                        'tel',
                        'email',
                        'city',
                        'street',
                        'building',
                        'office',
                        'data',
                        'last_login',
                    ));
                    
                    $role = ORM::factory('role')->where('name', '=', 'login')->find();
                    $users->add('roles', $role);
                    
                    $status = Auth::instance()->login($data['username'], $data['password'], (bool) 1);
                    $new_user = Auth::instance()->get_user();
                    $user_id = $new_user->id;
                                      
                    $hash = md5(time().$this->request->post('email')); // записываем в сессию хэш, который будем проверять
                    $session = Session::instance();
                    $session->set('forgotpass', $hash);
                    $session->set('forgotmail', $this->request->post('email')); // и почту записываем
                    //------------  Отправляем письмо о запросе подтверждения email, логин и пароль
                    $subject = 'Регистрация на сайте'; //Тема сообщения
                    $message = $this->mail_head. $data_or['name'].', 
                    Для подтверждения регистрации пройдите по ссылке 
                    - <a href="http://'.$_SERVER['HTTP_HOST'].'/auth/register?change='.$hash.'">ПОДТВЕРДИТЬ РЕГИСТРАЦИЮ</a><p/>
                    Ваш<br />
                    Логин: '.$data['username'].'<br />
                    Пароль: '.$data['password'].'<br />
                    <br />
                    Логин и пароль можете изменить в личном кабинете сайта.
                    <br />';
                    $email = Email::send($data_or['email'], $this->mail_from, $subject, $message, $html = true);
                    //------------ /Отправляем письмо о запросе подтверждения email, логин и пароль
                    
                }
                catch (ORM_Validation_Exception $e) {
                    $errors = $e->errors('auth');
                    //print_r($data);
                    //print_r($errors);
                    $data_order = array(
                        'or_name' => $data_or['name'], //Имя заказщика
                        'or_email' => $data_or['email'], //Почта заказщика
                        'or_tel' => $data_or['tel'], //Телефон заказщика
                        'se_id' => $data_or['send'], //Вид доставки
                        'or_city' => $data_or['city'], //Горд
                        'or_street' => $data_or['street'], //Улица
                        'or_building' => $data_or['building'], //Дом
                        'or_office' => $data_or['office'], //Номер кавртиры
                        'or_data' => $data_or['data'], //Дополнительная информация
                    );
                    $add_order=0;
                }
            }
            else
            {
                //echo"ЗАЛОГИНИЛСЯ!<br />";
                $user_id = $this->user->id;
            }
            
            //Создаем заказ
            if($add_order == 1)
            {
            $data_order = array(
            'bu_id' => $user_id,  //Идентификатор покупателя
            'st_id' => 0, //Статус заказа
            'or_create' => time(), //Время создания заказа
            'or_name' => $data_or['name'], //Имя заказщика
            'or_email' => $data_or['email'], //Почта заказщика
            'or_tel' => $data_or['tel'], //Телефон заказщика
            'se_id' => $data_or['send'], //Вид доставки
            'or_city' => $data_or['city'], //Горд
            'or_street' => $data_or['street'], //Улица
            'or_building' => $data_or['building'], //Дом
            'or_office' => $data_or['office'], //Номер кавртиры
            'or_data' => $data_or['data'], //Дополнительная информация
            'or_cost' => $this->session->get('products_cost'), //Стоимость заказа
            );

            //print_r($data_order);
            
            
            $orders = ORM::factory('order');
            $orders->values($data_order);
            
            try 
            {
                $orders->save(); //Сохраняем данные в базе
                $order_id_end = ORM::factory('order')->order_by('or_id', 'DESC')->limit(1)->find(); // Получим объект
                $og_id = $order_id_end->or_id; //Получаем ID заказа
                
                $goods_table = "
                <table border='0' cellspacing='0'>
                <tr height='30' bgcolor='#cccccc'>
                    <td>&nbsp;&nbsp;№<td/>
                    <td align='center'>Код<td/>
                    <td align='center'>Товар<td/>
                    <td align='center'>Кол.<td/>
                    <td align='center'>Цена<td/>
                    <td align='center'>Сумма<td/>
                <tr/>";
                
                //Добавляем товары в заказ
                $products_s = $this->session->get('products');
                if ($products_s != NULL)
                {
                    $products = ORM::factory('good');
                    foreach($products_s as $id => $count)
                    {
                        $products->or_where('go_id', '=', $id);
                    }
                    $products = $products->find_all();
            
                    // Формирование корзины
                    $goods_num = 0; $goods_num_all = 0;
                    foreach ($products as $product)
                    {
                        $data_go = array(
                            'or_id' => $og_id,
                            'go_id' => $product->go_id,
                            'go_x' => $products_s[$product->go_id],
                            'go_name' => $product->go_name,
                            'go_cost' => $product->go_cost,
                        );
                        $goods_num = $goods_num + 1; 
                        $goods_num_all = $goods_num_all + $goods_num;
                        $cost = number_format($products_s[$product->go_id], 2, ',', ' ');
                        $summa = number_format($products_s[$product->go_id]*$product->go_cost, 2, ',', ' ');
                        $goods_table = $goods_table."
                        <tr bgcolor='#E0EFDF' height='25'>
                            <td> &nbsp;&nbsp;".$goods_num."<td/>
                            <td>".$product->go_id."<td/>
                            <td>".$product->go_name."<td/>
                            <td align='center'>".$products_s[$product->go_id]."<td/>
                            <td align='right'>".$cost." грн.<td/>
                            <td align='right'>".$summa." грн.<td/>
                        <tr/>";
                        
                        //Сохраняем данные о товаре в заказе
                        $ordergo = ORM::factory('ordergood')->values($data_go)->save();
                    }
                }
                $goods_cost_all = number_format($this->session->get('products_cost'), 2, ',', ' ');
                $goods_table = $goods_table."
                <tr>
                    <td><td/>
                    <td><td/>
                    <td align='right'>Всего:<td/>
                    <td align='center' bgcolor='#E0EFDF'>$goods_num_all<td/>
                    <td align='right'>Итого:<td/>
                    <td align='center' bgcolor='#E0EFDF'>".$goods_cost_all." грн.<td/>
                <tr/>
                <table>
                Спасибо за покупку!<br /><br /><br />";
                
                //----------  Отправзяем сообшкеме о полученом заказе через SMS   --------
                //$text_sms="Заказ от: ".$data_or['name']." Сумма: ".$this->session->get('products_cost')."грн. Тел.".$data_or['tel'];
                //$body=file_get_contents("http://sms.ru/sms/send?api_id=14cacf3f-340f-2e94-3d72-341637361059&to=380972274822&text=".urlencode($text_sms));
                //$body=file_get_contents("http://sms.ru/sms/send?api_id=8e0781e1-022b-2ae4-8906-b962a56b4d4a&to=380980241535&text=".urlencode($text_sms));
                //---------- /Отправзяем сообшкеме о полученом заказе через SMS   --------
                
                //---------  Отправляем покупателю письмо с данными о заказе и предлааем сменить пароль ------
                //$subject = 'Заказ №'.$og_id.' ( на сумму:  '.$this->session->get('products_cost').'грн)'; //Тема сообщения
                //$message = $this->mail_head. $data_or['name'].', 
                //Ваш заказ  № '.$og_id.' принят!'.$goods_table.'<p>Для просмота статуса выполнения заказа войдите в свой кабинет 
                //- <a href="http://'.$_SERVER['HTTP_HOST'].'/login">ВХОД</a><p/>';
                //$email = Email::send($data_or['email'], $this->mail_from, $subject, $message, $html = true);
                //--------- /Отправляем покупателю письмо с данными о заказе и предлааем сменить пароль ------
                
                //Освобождаем переменные з сесии
                $this->session->delete('products_all');
                $this->session->delete('products_cost');
                $this->session->delete('products');
                
                //Передаем в сесию номер заказа
                $this->session->set('number_order', $og_id);
                HTTP::redirect('/cart/orderget');
                      
            }
            catch (ORM_Validation_Exception $e) 
            {
                $errors = $e->errors('validation'); //Если данные не сохранились получаем причину отказа
            }
            }
            
        }
        
        
        
        $sends=$this->orsend(); //Получаем из базы виды достваки с создаем масивв
        $content = View::factory('index/cart/v_cart_order')
            ->bind('data_order', $data_order)
            ->bind('errors', $errors)
            ->bind('sends', $sends);

        // Выводим в шаблон
        $this->template->title = 'Оформление заказа';
        $this->template->page_title = 'Оформление заказа';
        $this->template->block_center = array($content);
    }
    
    //Сообщение о принятом заказе
    public function action_orderget()
    {
        $number_order = $this->session->get('number_order'); //Получаем ID заказа
        $this->session->delete('number_order'); //Удаяем из сесии ID заказа
        
        //Получаем данные о заказе
        if($number_order>0)
        { 
            $order = ORM::factory('order', $number_order); //Данные о заказщике
            $goods = $order->ordergoods->find_all(); // Данные о товаре
            $send = $order->send->se_name; //Вид доставки
        
            $content = View::factory('index/cart/v_cart_get')
                ->bind('order', $order)
                ->bind('goods', $goods)
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
    
    //Пересчет количества товара в корзине
    public function action_count()
    {
        if (isset($_POST['submit'])) 
        {
            $products_s = $this->session->get('products');            
            $data = Arr::extract($_POST, array('go_count'));
            $go_count=$data['go_count'];
            
            foreach($products_s as $id => $count)
            {
                $go_count[$id] = preg_replace ("/[^0-9\s]/","",$go_count[$id]); //Убераем све корме цифр
                if($go_count[$id]<0.00001)
                {
                    unset ($products_s[$id]); //Если количество товара меньше 0.00001 то его дуаляем из корзины
                }
                elseif($products_s[$id]!=$go_count[$id])
                {
                    $products_s[$id]=$go_count[$id];
                }
            }
            
            $products_cost = 0;
            $products_all = 0;
            if ($products_s != NULL)
            {
                $products = ORM::factory('good');
                foreach($products_s as $id => $count)
                {
                    $products->or_where('go_id', '=', $id);
                }
                $products = $products->find_all();
            
                // Формирование корзины
                foreach ($products as $product)
                {
                    $cart['products'][] = array(
                        'id' => $product->go_id,
                        'name' => $product->go_name,
                        'count' => $products_s[$product->go_id],
                        'cost' => $product->go_cost,
                    );
                
                    $products_cost += $product->go_cost * $products_s[$product->go_id];
                    $products_all += $products_s[$product->go_id];
                }
                $this->session->set('products_cost', $products_cost);
                $this->session->set('products_all', $products_all);           
            }
            $this->session->set('products', $products_s);              
        }
        HTTP::redirect('cart');
    }


}