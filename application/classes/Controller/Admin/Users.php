<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Users extends Controller_Admin {    
    
     public function action_index() {
        
        $id = (int) $this->request->param('id');
        $desc='';
        if ($id=='1'){ //Логин
        $sort='username';}
        elseif ($id=='2'){ //Город
        $sort='city';}
        elseif ($id=='3'){ //Телефон
        $sort='tel';}
        elseif ($id=='4'){ //E-Mail
        $sort='email';}
        elseif ($id=='5'){ //Процент
        $sort='percentage'; 
        $desc='desc';}
        elseif ($id=='6'){ //Последний вход
        $sort='last_login';
        $desc='desc';}
        else{
        $sort='first_name';} //Имя покупателя
        
        $users = ORM::factory('user')
            ->where('username', '!=', 'admin')
            ->order_by($sort, $desc)
            ->find_all();
        
        $content = View::factory('admin/users/v_users_index', array(
            'page_title' => 'Покупатели',
            'users' => $users,
        ));

        // Вывод в шаблон
        $this->template->page_title = 'Покупатели';
        $this->template->block_center = array($content);
    }
    
    public function action_edit() {
        
        $id = (int) $this->request->param('id');        
        
        $user_count = ORM::factory('user')->where('id', '=', $id)->count_all(); //Проверяем есть ли в базе покупатель с таким ID
        if($user_count==0){HTTP::redirect('/admin/users');}
        $errors=''; $save_user='';
        if (isset($_POST['submit'])) 
        {
            $user_save = ORM::factory('user');
            try 
            {
                $user_save->where('id', '=', $id)
                    ->find()
                    ->update_user($_POST, array(//
                        'first_name',
                        'username',
                        'city',
                        'tel',
                        'email',
                        'street',
                        'building',
                        'office',
                        'data',
                        ));
                $save_user='Сохранено!'; 
            }
            catch (ORM_Validation_Exception $e) 
            {
                $errors = $e->errors('auth');
            }
        }        
        
        $user = ORM::factory('user', $id);
        if($user->status==0){$status_email="Нет";}else{$status_email="Да";}
        $content = View::factory('admin/users/v_user_index', array(
            'page_title' => 'Покупатель',
            'save_user' => $save_user,
            'errors' => $errors,
            'user' => $user,
            'status_email' => $status_email,
        ));

        // Вывод в шаблон
        $this->template->page_title = 'Покупатель';
        $this->template->block_center = array($content);
    }
    
    public function action_del() {
        
        $id = (int) $this->request->param('id');        
        $user_count = ORM::factory('user')->where('id', '=', $id)->count_all(); //Проверяем есть ли в базе покупатель с таким ID
        if($user_count==0){HTTP::redirect('/admin/users');}
        $user = ORM::factory('user', $id);
        $user->delete();
        HTTP::redirect('/admin/users');   
    }

}