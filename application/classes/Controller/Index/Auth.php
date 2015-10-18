<?php defined('SYSPATH') or die('No direct script access.');
/*
 * Авторизация
 */
class Controller_Index_Auth extends Controller_Index {
    
    public function before(){
        parent::before();
        // Виджеты
        $menutov = Request::factory('indexblocks/Menutov')->execute(); //Меню товаров

        // Вывод в шаблон
        $this->template->styles[] = 'lib/menu_files/style.css';
        $this->template->scripts[] = 'lib/menu_files/script.js';
        $this->template->block_left = array($menutov);
    }
    
    public function action_index() {
        $this->action_login();
    }

    public function action_login() {
        //Проверяем авторизован ли пользователь
        if(Auth::instance()->logged_in()) {
            
            //Проверяеп авторизовался покупатель или администратор
            $inuser=$this->user->username;
            if($inuser=='admin')
            {
                HTTP::redirect('/admin');
            }
            else
            {
                HTTP::redirect('account');   
            }
        }

        if (isset($_POST['submit'])){
            $data = Arr::extract($_POST, array('username', 'password', 'remember'));
            $status = Auth::instance()->login($data['username'], $data['password'], (bool) $data['remember']);

            if ($status and $data['username']='admin'){
                HTTP::redirect('/admin'); //Авторизовался администратор
            }
            elseif ($status) {
                HTTP::redirect('account/profile'); //Авторизовался покупатель
            }
            else {
                $errors = array(Kohana::message('auth/user', 'no_user')); //Авторизация не прошла
            }
        }
        
        // Виджеты
        $content = View::factory('index/auth/v_auth_login')
                    ->bind('errors', $errors)
                    ->bind('data', $data);

        // Выводим в шаблон
        $this->template->title = 'Вход';
        $this->template->page_title = 'Вход';
        $this->template->block_center = array($content);
    }

    public function action_register() {
        
        //Подтверждение почтового ящика
        $restore = Arr::get($_GET, 'change');
        if ($restore) // если человек прошел по ссылке в письме
        {
            $session = Session::instance();
             $ses = $session->get('forgotpass');
            echo"restore $restore <br /> $ses";
           
            if ($session->get('forgotpass') === $restore) // проверяем его сессию - действительно ли именно он подтверждает?
            {
                $to = $session->get('forgotmail');                
                $users = ORM::factory('user');
                $data_check['status'] = 1;
                $users->where('email', '=', $to)
                    ->find()
                    ->update_user($data_check, array(
                        'status',
                    )); 

                $reuser = ORM::factory('user')->where('email', '=', $to)->find();
                $reneme = $reuser->username;
                $repass = $reuser->repass;
                $session->delete('forgotpass');
                $session->delete('forgotmail'); // очищаем сессию
                //echo"($reneme | $repass)";
                $data['username']=$reneme;
                $data['password']=$repass;
                $data['remember']=1;
                try {
                    $status = Auth::instance()->login($data['username'], $data['password'], (bool) $data['remember']);
                }
                catch (ORM_Validation_Exception $e) {
                $errors = $e->errors('auth');
                }
                HTTP::redirect('account/profile'); //Авторизовался покупатель
            }
            else
            {
                HTTP::redirect('login'); //Авторизовался покупатель
            }
        }        
        
        
        if (isset($_POST['submit'])){
            $data = Arr::extract($_POST, array('username', 'password', 'first_name', 'password_confirm', 'tel', 'email'));
            $data['tel'] = str_replace(" ","",$data['tel']);
            $data['tel'] = str_replace("-","",$data['tel']);
            $data['tel'] = preg_replace ("/[^0-9\-\ \s]/","",$data['tel']);
            $to = $data['email'];
            $data['repass'] = $data['password'];
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
                    'last_login',
                ));
                
                $role = ORM::factory('role')->where('name', '=', 'login')->find();
                $users->add('roles', $role);
                               
                $session = Session::instance();
                $hash = md5(time().$this->request->post('email')); // записываем в сессию хэш, который будем проверять
                $session->set('forgotpass', $hash);
                $session->set('forgotmail', $this->request->post('email')); // и почту записываем
                
                $subject = 'Регистрпация'; //Тема сообщения
                $message = $this->mail_head.$data['first_name'].'!<br />
                Для подтверждения  регистрации пройдите по ссылке - <a href="http://'.$_SERVER['HTTP_HOST'].'/auth/register?change='.$hash.'">ПОДТВЕРДИТЬ</a>'; // отправляем ссылку с хэшем для сброса пароля
                $this->outmail($to, $subject, $message); //Отправляем письмо
                $this->action_login(); 
                HTTP::redirect('account/profile');
            }
            catch (ORM_Validation_Exception $e) {
                $errors = $e->errors('auth');
            }
        }

        $content = View::factory('index/auth/v_auth_register')
                            ->bind('errors', $errors)
                            ->bind('data', $data);

        // Выводим в шаблон
        $this->template->title = 'Регистрация';
        $this->template->page_title = 'Регистрация';
        $this->template->block_center = array($content);
    }
    
    public function action_logout() {
        if(Auth::instance()->logout()) {
            HTTP::redirect('/');
        }
    }
    
    public function action_repass() {
        
        $data = array();
        if (HTTP_Request::POST == $this->request->method())
        {
            $data['message'] = Kohana::message('account', 'passwordSended'); // в любом случае выводим сообщение о том, что пароль отправлен. Пусть думают что все почтовые аккаунты имеют своих владельцев
            $user = ORM::factory('User', array('email' => $this->request->post('email'))); // а теперь действительно ищем - есть ли пользователь со введенным адресом
            if ($user->loaded()) // если есть
            { 
                $session = Session::instance();
                $hash = md5(time().$this->request->post('email')); // записываем в сессию хэш, который будем проверять
                $session->set('forgotpass', $hash);
                $session->set('forgotmail', $this->request->post('email')); // и почту записываем
                $to = $this->request->post('email');
                $subject = 'Востановление пароля'; //Тема сообщения
                $message = $this->mail_head. $user->first_name.'!<br />Для востановления пароля пройдите по ссылке - <a href="http://'.$_SERVER['HTTP_HOST'].'/auth/repass?change='.$hash.'">ВОСТАНОВИТЬ</a>'; // отправляем ссылку с хэшем для сброса пароля
                //echo"to: ".$to."<br />subject: ".$subject."<br />from: ".$this->mail_from."<br />message: ".$message;
                $this->outmail($to, $subject, $message); //Отправляем письмо
                //$email = Email::send($to, $this->mail_from, $subject, $message, $html = true);
                HTTP::redirect('auth/repassok');
                                    
            }    
            
        }
        //Востановление пароля
        $restore = Arr::get($_GET, 'change');
        if ($restore) // если человек прошел по ссылке в письме
        {
            $session = Session::instance();
            if ($session->get('forgotpass') === $restore) // проверяем его сессию - действительно ли именно он запросил сброс?
            {
                $newpass = substr(md5(time().$session->get('forgotmail')),0,8); // генерируем новый пароль
                $to = $session->get('forgotmail');
                $indata = time();
                // ставим новый пароль пользователю
                DB::update('users')
                    ->set(array('password' => Auth::instance()
                    ->hash_password($newpass)))
                    ->set(array('status' => 1))
                    ->set(array('last_login' => $indata))
                    ->where('email', '=', $session->get('forgotmail'))
                    ->execute(); 
                
                $reuser = ORM::factory('user')->where('email', '=', $to)->find();
                $reneme = $reuser->username;
                
                

                $session->delete('forgotpass');
                $session->delete('forgotmail'); // очищаем сессию
                $subject = Kohana::message('account', 'email.themes.newPassword');
                $from = Kohana::message('account', 'email.from');
                
                echo"($reneme | $newpass)";
                
                $data['username']=$reneme;
                $data['password']=$newpass;
                $data['remember']=1;
                try {
                    $status = Auth::instance()->login($data['username'], $data['password'], (bool) $data['remember']);
                }
                catch (ORM_Validation_Exception $e) {
                $errors = $e->errors('auth');
                }
                HTTP::redirect('account/pass'); //Авторизовался покупатель
            }
        }        
        
        $data['email'] = array_key_exists('email', $this->request->post()) ? htmlspecialchars($this->request->post('email')) : '';


        $content = View::factory('index/auth/v_auth_repass')
            ->bind('data', $data);

        // Выводим в шаблон
        $this->template->title = 'Востановление пароля';
        $this->template->page_title = 'Востановление пароля';
        $this->template->block_center = array($content);
    }
    
    public function action_repassok() {
        $content = View::factory('index/auth/v_auth_repassok');
        // Выводим в шаблон
        $this->template->title = 'Востановление пароля';
        $this->template->page_title = 'Востановление пароля';
        $this->template->block_center = array($content);
        
    }

} // End Controller_Index_Auth