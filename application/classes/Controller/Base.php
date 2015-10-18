<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Base extends Controller_Template {
    
    protected $user;
    protected $auth;
    protected $session;
    protected $mail_name;
    protected $mail_from;
    protected $mail_head;
    
    protected $dir_gofoto;
    protected $dir_gofoto_1c;
    
    public function before() {
        parent::before();
        
        //Получаем данные из таблици настроек
        $setings = ORM::factory('seting')->find_all();
        foreach($setings as $seting)
        {
            $set_id=$seting->set_id;
            $set_data[$set_id]=$seting->set_data;               
        }
        
        //Проверка авторизации пользователя
        $this->auth = Auth::instance();
        $this->user = $this->auth->get_user();
        
        //Инициализация сесии
        $this->session = Session::instance();
        
        //Папки для фото
        $this->dir_gofoto =  $_SERVER['DOCUMENT_ROOT'].'/media/foto/goods/'; //Папка фото товаров
        $this->dir_gofoto_1c =  $_SERVER['DOCUMENT_ROOT'].'/media/foto/goods_1c/'; //Папка для выгрузки фото с 1С 

        //Отправка почты
        $this->mail_name =  $set_data[7]; //Имя отправителя 
        $this->mail_from = array($set_data[6], $set_data[7]); //Email и имя отправителя
        $this->mail_head = "<h1> ".$set_data[1]."</h1><br /><br />"; //Заголовок письма
        
        // Вывод в шаблон
        $this->template->site_name = $set_data[1]; //Название магазина
        $this->template->site_description = $set_data[2]; //Описание магазина
        $this->template->page_title = $set_data[1]; //Название магазина
        $this->template->telefon = $set_data[4]; //Телефон
        $this->template->slogan = $set_data[5]; //Слоган

        // Подключаем стили и скрипты
        $this->template->styles = array();
        $this->template->scripts = array();

        // Подключаем блоки
        $this->template->block_header = null;
        $this->template->block_center = null;
        $this->template->block_footer = null;
        
    }
    
    //-------------------------- Функции -------------------------

    //виды достваки - создаем масив
    public function orsend(){
        $sends_data = ORM::factory('send')->find_all();
        foreach($sends_data as $data)
        {
            $sends[]=$data->se_name;
        }
        return $sends;
    }

    //статус заказа - создаем масив
    public function orstat(){
        $stat_data = ORM::factory('statu')->find_all();
        foreach($stat_data as $data)
        {
            $sends[]=$data->st_name;
        }
        return $sends;
    }
    
    //Бренды - создаем масив
    public function brend(){
        $brend_data = ORM::factory('brend')->find_all();
        $sends = array();
        foreach($brend_data as $data)
        {
            $sends[$data->br_id]=$data->br_name;
        }
        return @$sends;
    }
    
    //Функция навигации по страницам
    public function pagination ($count_pages, $active, $count_show_pages, $url, $url_page){
        
        //$count_pages = 6; //количество страниц
        //$active = 2; //текущая активная страница
        //$count_show_pages = 10; //количество отображаемых страниц
        //$url = "/ca/77/"; //адрес страницы, для которой и создаётся Pagination
        //$url_page = "/ca/77/"; // адрес страницы с параметром page без значения на конце
        $pagination='';
        if ($count_pages > 1) 
        { 
            if($active==10000)
            {
               $active=0.5; 
            }
            
            $left = $active - 1;
            $right = $count_pages - $active;
            if ($left < floor($count_show_pages / 2)) $start = 1;
            else $start = $active - floor($count_show_pages / 2);
            $end = $start + $count_show_pages - 1;
            if($end > $count_pages)
            {
                $start -= ($end - $count_pages);
                $end = $count_pages;
                if ($start < 1){$start = 1;}
            }
        
            
            if($active != 0) 
            {
                $pagination=$pagination.'
                <div class="pagination">
                <span>Страницы: </span>
                <a href="'.$url.'" class="page" title="Первая страница">Первая</a>';
                if($active == 2 OR $active==0.5 OR $active==1)
                {
                    $previous=$url;
                }
                else
                {
                    $previous=$url_page.ceil($active - 1);
                }
                $pagination=$pagination.'
                <a href="'.$previous.'" class="page" title="Предыдущая страница">&lt;</a>';
                for($i = $start; $i <= $end; $i++)
                {
                    if ($i == $active)
                    {
                        $pagination=$pagination.'
                        <span class="page active">'.$i.'</span>';
                    }
                    else
                    {
                        if($i == 1)
                        {
                            $pagination=$pagination.'
                            <a href="'.$url.'" class="page">'.$i.'</a>';
                        }
                        else
                        {
                            $pagination=$pagination.'
                            <a href="'.$url_page.$i.'" class="page">'.$i.'</a>';
                        }
                    }
                }
                if($active != $count_pages)
                {
                    $pagination=$pagination.'
                    <a href="'.$url_page.ceil($active + 1).'" class="page" title="Следующая страница">&gt;</a>
                    <a href="'.$url_page.$count_pages.'" class="page" title="Последняя страница">Последняя</a>';
                }
                if($active==0.5)
                {
                    $pagination=$pagination.'
                    <span class="page active">Все</span>';
                }
                else
                {
                    $pagination=$pagination.'
                    <a href="'.$url_page.'10000" class="page" title="Всё на одной странице">Все</a>';
                }
                
                $pagination=$pagination.'
                </div>';
            }
        }
        return $pagination;
    }
    
    
    //Отправка почты
    public function outmail($to, $subject, $message){    
        
        $message = '<html><body>'.$message.'</body></html>';
        $headers  = "Content-type: text/html; charset=windows-utf-8 \r\n";
        $headers .= "From: ".$this->mail_name." <info@".$_SERVER['HTTP_HOST'].">\r\n";
        mail($to, $subject, $message, $headers);
        //$email = Email::send($to, $this->mail_from, $subject, $message, $html = true);

        return true;
    }


}