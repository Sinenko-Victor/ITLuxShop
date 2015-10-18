<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Setings extends Controller_Admin {    
    
     public function before() {
        parent::before();

        // Вывод в шаблон
        $this->template->styles[] = 'lib/xtree/style.css';
        $this->template->scripts[] = 'lib/xtree/common.js';
        $this->template->page_title = 'Настройки';    
    }
     
     public function action_index() {

        $errors=array();
        $profok='';
        if (isset($_POST['submit'])) 
        {
            $profok=' Изминения сохранены!'; //Сообщение об изминении даных
            $data = Arr::extract($_POST, array('name', 'description', 'keywords', 'tel', 'rab'));
            try{
                $save_name = ORM::factory('seting', 1)->values(array('set_data' => $data['name']))->save();
            }
            catch (ORM_Validation_Exception $e) 
            {
                $errors = $e->errors('validation'); $profok='';
            }
            
            try{
                ORM::factory('seting', 2)->values(array('set_data' => $data['description']))->save();
            }
            catch (ORM_Validation_Exception $e) 
            {
                $errors = $e->errors('validation'); $profok='';
            }
            
            try{
                ORM::factory('seting', 3)->values(array('set_data' => $data['keywords']))->save();
            }
            catch (ORM_Validation_Exception $e) 
            {
                $errors = $e->errors('validation'); $profok='';
            }
            try{
                ORM::factory('seting', 4)->values(array('set_data' => $data['tel']))->save();
            }
            catch (ORM_Validation_Exception $e) 
            {
                $errors = $e->errors('validation'); $profok='';
            }
            try{
                ORM::factory('seting', 5)->values(array('set_data' => $data['rab']))->save();
            }
            catch (ORM_Validation_Exception $e) 
            {
                $errors = $e->errors('validation'); $profok='';
            }
        }
        
        $setings = ORM::factory('seting')->find_all();
        foreach($setings as $seting)
        {
            $set_id=$seting->set_id;
            $set_name[$set_id]=$seting->set_name;
            $set_data[$set_id]=$seting->set_data;               
        }
        
        // Виджеты
        $action = $this->request->action(); //Получаем текуший єкшен
        $menuset = Request::factory('adminblocks/Menuset/'.$action)->execute();
        
        $content = View::factory('admin/setings/v_setings_index', array(
            'page_title' => 'Настройки :: Основные',
            'menuset' => $menuset,
            'set_name' => $set_name,
            'set_data' => $set_data,
            'errors' => $errors,
            'profok' => $profok,
        ));

        // Вывод в шаблон
        $this->template->page_title = 'Настройки';
        $this->template->block_center = array($content);
    }
    
    public function action_mail() {

        $errors=array();
        $profok='';
        if (isset($_POST['submit'])) 
        {
            $profok=' Изминения сохранены!'; //Сообщение об изминении даных
            $data = Arr::extract($_POST, array('email', 'nameout', 'pass', 'smtp', 'port'));
            try{
                $save_name = ORM::factory('seting', 6)->values(array('set_data' => $data['email']))->save();
            }
            catch (ORM_Validation_Exception $e) 
            {
                $errors = $e->errors('validation'); $profok='';
            }
            
            try{
                ORM::factory('seting', 7)->values(array('set_data' => $data['nameout']))->save();
            }
            catch (ORM_Validation_Exception $e) 
            {
                $errors = $e->errors('validation'); $profok='';
            }
            
            try{
                ORM::factory('seting', 8)->values(array('set_data' => $data['pass']))->save();
            }
            catch (ORM_Validation_Exception $e) 
            {
                $errors = $e->errors('validation'); $profok='';
            }
            try{
                ORM::factory('seting', 9)->values(array('set_data' => $data['smtp']))->save();
            }
            catch (ORM_Validation_Exception $e) 
            {
                $errors = $e->errors('validation'); $profok='';
            }
            try{
                ORM::factory('seting', 10)->values(array('set_data' => $data['port']))->save();
            }
            catch (ORM_Validation_Exception $e) 
            {
                $errors = $e->errors('validation'); $profok='';
            }
        }
        
        $setings = ORM::factory('seting')->find_all();
        foreach($setings as $seting)
        {
            $set_id=$seting->set_id;
            $set_name[$set_id]=$seting->set_name;
            $set_data[$set_id]=$seting->set_data;               
        }
        
        // Виджеты
        $action = $this->request->action(); //Получаем текуший єкшен
        $menuset = Request::factory('adminblocks/Menuset/'.$action)->execute();
        
        $content = View::factory('admin/setings/v_setings_mail', array(
            'page_title' => 'Настройки :: почта',
            'menuset' => $menuset,
            'set_name' => $set_name,
            'set_data' => $set_data,
            'errors' => $errors,
            'profok' => $profok,
        ));

        // Вывод в шаблон
        $this->template->page_title = 'Настройки';
        $this->template->block_center = array($content);
    }
    
    public function action_pass() {

        // Виджеты
        $action = $this->request->action(); //Получаем текуший єкшен
        $menuset = Request::factory('adminblocks/Menuset/'.$action)->execute();
        
        $passok='';
        $errors=array();
        if (isset($_POST['submit']))
        {
            $users = ORM::factory('user');
            $data = Arr::extract($_POST, array('password', 'password_confirm'));
            $data['repass'] = $data['password'];
            try {
                $users->where('username', '=', 'admin')
                    ->find()
                    ->update_user($data, array(
                        'password',
                        'repass',
                    ));
                //HTTP::redirect('account/pass');
                $passok='Новый пароль сохранен!';
            }
            catch (ORM_Validation_Exception $e) {
                $errors = $e->errors('auth');
            }
        } 
        
        $content = View::factory('admin/setings/v_setings_pass', array(
            'page_title' => 'Настройки :: Изменить пароль входа в панель управления',
            'menuset' => $menuset,
            'passok' => $passok,
            'errors' => $errors,
        ));

        // Вывод в шаблон
        $this->template->page_title = 'Настройки';
        $this->template->block_center = array($content);
    }
    
    public function action_sitemap() {

        // Виджеты
        $action = $this->request->action(); //Получаем текуший єкшен
        $id = (int) $this->request->param('id');
        $menuset = Request::factory('adminblocks/Menuset/'.$action)->execute();
        $host = $_SERVER['HTTP_HOST'];
        
        $filerobot = 'robots.txt';
        $filesitemap = 'sitemap.xml';
        
        if (file_exists($filerobot)) {
            
            if($id == 1)
            {
                rename($filerobot, "robots_old.xml"); //перейменовываем файл

//Создаем текст для sitemap.xml 
$robottext = 'User-agent: *

Allow: /
Sitemap: http://'.$host.'/sitemap.xml

Disallow: /application/
Disallow: /system/
Disallow: /modules/
Disallow: /media/
Disallow: /media_admin/
Disallow: /lib/
Disallow: /admin/';
                
            $fp = fopen($filerobot, 'wt'); // Текстовый режим
            $test = fwrite($fp, $robottext); // Запись в файл
            fclose($fp); //Закрытие файла     
            }
            
        }

        if (file_exists($filesitemap)) {
            
            if($id == 1)
            {
                rename($filesitemap, "sitemap_old.xml"); //перейменовываем файл
                

//Создаем текст для sitemap.xml 
$sitemaptext = '<?xml version="1.0" encoding="UTF-8"?>
<urlset
      xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"
      xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
      xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9
            http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">
<!-- created with Free Online Sitemap Generator www.xml-sitemaps.com -->

<url>
  <loc>http://'.$host.'/</loc>
</url>
';

$catalogs = ORM::factory('catalog')->find_all();
$ca = '';
foreach ($catalogs as $catalog)
{
$ca=$ca.'
<url>
<loc>http://'.$host.'/ca/'.$catalog->ca_id.'</loc>
</url>
';  
}

$goods = ORM::factory('good')->find_all();
$go='';
$host=$_SERVER['HTTP_HOST'];
foreach ($goods as $good)
{
$go=$go.'
<url>
<loc>http://'.$host.'/go/'.$good->go_id.'</loc>
</url>
';  
}

$pages = ORM::factory('page')->find_all();
$pg = '';
foreach ($pages as $page)
{
$pg = $pg.'
<url>
<loc>http://'.$host.'/page/'.$page->pg_id.'/'.$page->pg_alias.'</loc>
</url>
';  
}

$sitemaptext = $sitemaptext.$ca.$go.$pg.'
</urlset>';

            $fp = fopen($filesitemap, 'wt'); // Текстовый режим
            $test = fwrite($fp, $sitemaptext); // Запись в файл
            fclose($fp); //Закрытие файла 
            }
                      
            
            $update = "
            <br /><a href='/sitemap.xml' target='_blank'><span>sitemap.xml</span></a>
            обновлялся: " . date ("Y-m-d  H:i", filemtime($filesitemap))."
            <br /><br /><a href='/robots.txt' target='_blank'><span>robots.txt</span></a>
            обновлялся: " . date ("Y-m-d  H:i", filemtime($filerobot))."";
        }
        else 
        {
            $sitemap = "Не существует";
        }
        
        $content = View::factory('admin/setings/v_setings_sitemap', array(
            'page_title' => 'Настройки :: Карта сайта',
            'menuset' => $menuset,
            'update' => $update,
        ));

        // Вывод в шаблон
        $this->template->page_title = 'Настройки';
        $this->template->block_center = array($content);
    }


}

?>