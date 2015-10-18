<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Index extends Controller_Base {

    public $template = 'index/v_index';        // Базовый шаблон

    public function  before() {
        parent::before();
        
        //Проверяем авторизован ли пользователь
        $user='';
        if(Auth::instance()->logged_in()) {
            $user=$this->user->username;
        }      
        
        //$page_verts = ORM::factory('page')->where('pg_father', '=', 2)->order_by('pg_id')->find_all();       
        
        // Виджеты
        $header = Request::factory('indexblocks/Header')->execute();
        $footer = Request::factory('indexblocks/Footer')->execute();      
        
        // Вывод в шаблон
        $this->template->styles[] = 'media/css/main.css'; 
        $this->template->scripts[] = 'media/js/jquery-1.8.2.min.js'; 
        $this->template->scripts[] = 'media/js/cart.js';
        $this->template->scripts[] = 'media/js/login.js';
        $this->template->scripts[] = 'lib/lightbox/js/lightbox.js';
        $this->template->scripts[] = 'media/js/search.js'; 
        $this->template->styles[] = 'lib/lightbox/css/lightbox.css';
        $this->template->styles[] = 'lib/xtree/style.css';
        $this->template->scripts[] = 'lib/xtree/common.js';
        $this->template->block_header = array($header);
        $this->template->block_footer = array($footer);
        $this->template->user = $user;        
    }
    
    
    //----------------------- FUNCTION --------------------------

    public function ca_tree ($categoria_id=""){
        //Создаем дерево каталога страниц
        define('IN_APPLICATION', true);
        $dir_xtree='./lib/xtree';
        require($dir_xtree.'/app.config.php');
        require($dir_xtree.'/common.php');
        require($dir_xtree.'/xtree.page.php');
        $tree = new xtree("<a href='/' style='font : 16px Verdana, sans-serif;'>Каталог товаров</a>", 'example');
        $tree->SetImagePath('http://'.$_SERVER['HTTP_HOST'].'/lib/xtree/images_index');
        // ImageList
        $tree->AddNodeImage('root', 'home.gif');
        $tree->AddNodeImage('pege', 'html_content.gif');
            
        $pages_num = ORM::factory('catalog')->order_by('ca_name')->count_all();
        if($pages_num > 0)
        {
            $pages = ORM::factory('catalog')->order_by('ca_name')->find_all();
            foreach($pages as $page) //Создаем масивы
            {            
                $id[$pg_id]=$pg_id=$page->ca_id; //Масив ID названия категории
                $name[$pg_id]=$page->ca_name; //Масив названия категории 
                $father[$pg_id]=$page->ca_father; //Масив ID родителя категории
            }
        
            foreach($id as $pg_id) //Перебераем масив ID названия категории
            {
                $pg_father=$father[$pg_id];
                $pg_name=$name[$pg_id];
                        
                if($pg_father==0) //Отбераем корневые категоирии
                {              
                    if(@$mas!=''){$mas=$mas.",".$pg_id;}else{$mas=$pg_id;} //Сздает строку mas с ID категорий
                    //Получаем масив дочерних категорий
                    $mas=$this->tree_mas ($id, $father, $pg_id, $mas);              
                }    
            }
        
            $mas_array = explode( ',', $mas ); //Создаеи из строки mas Масив mas_array в нужном порядке
            foreach($mas_array as $pg_id)
            {
                $pg_id=$id[$pg_id];
                $pg_name=$name[$pg_id];
                $pg_father=$father[$pg_id]; 
                if($pg_father==0){$pg_father="";}else{$pg_father="_pege_".$pg_father;}
                if($pg_id==$categoria_id)
                {$link="<span class=cadirlinka>";}
                else
                {$link="<span class=cadirlink>";}
                $tree->AddNode($pg_father, '_pege_'.$pg_id, $link.'<a href="/ca/'.$pg_id.'/'.$pg_name.'">'.$pg_name.'<a/></span>', 'pege', cookievalue('tree_example_pege_'.$pg_id, 'open'));
            }        
            
        }       
        return $tree;
    }
    
    //Функция добавляет в строку mas ID дочерних категорий
    public function tree_mas ($id, $father, $key, $mas){
        
        foreach($id as $pg_id)
        {
            $pg_father=$father[$pg_id];
            if($pg_father==$key)
            {
                $mas= $mas.",".$pg_id;
                $mas=$this->tree_mas ($id, $father, $pg_id, $mas);
            }   
        }
        return $mas;        
     }
     
     //Строка родительских категорий
    public function ca_line($id_ca, $line){ 
        
        //Создаем дерево каталога товаров            
        $pages = ORM::factory('catalog')
            ->order_by('ca_id')
            ->find_all();
         
        foreach($pages as $page) //Создаем масивы
        {            
            $id[$ca_id]=$ca_id=$page->ca_id; //Масив ID названия категории
            $name[$ca_id]=$page->ca_name; //Масив названия категории 
            $father[$ca_id]=$page->ca_father; //Масив ID родителя категории
        }
        
        if($id_ca!="")
        {
            foreach($id as $ca_id) //Перебераем масив ID названия категории
            {
                if($id_ca==$ca_id)
                {
                    if($father[$ca_id]>0)
                    {
                        $ca_line=$this->ca_line($father[$ca_id], $line);
                        $line=$line.$ca_line;
                    }
                    $line=$line.' :: '.HTML::anchor('/ca/'.$ca_id, $name[$ca_id]);
                }
            }
        }        
        return $line;
    }


}