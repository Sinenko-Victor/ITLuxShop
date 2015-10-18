<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin extends Controller_Base {
    
    public $template = 'admin/v_base';        // Базовый шаблон

    public function  before() {
        parent::before();
        
        //Проверка на авторизацию админа
        if(!$this->auth->logged_in('admin'))
        {
            HTTP::redirect('/login');   
        }

        // Виджеты
        $topmenu = Request::factory('adminblocks/Topmenu')->execute();
        $header = Request::factory('adminblocks/Header')->execute();
        $footer = Request::factory('adminblocks/Footer')->execute();      
        
        // Вывод в шаблон
        $this->template->styles[] = 'media_admin/css/admin.css';
        $this->template->block_topmenu = array($topmenu);
        $this->template->block_header = array($header);
        $this->template->block_footer = array($footer);

    }
    
    //----------------------- FUNCTION --------------------------

    public function ca_tree (){
        //Создаем дерево каталога страниц
        define('IN_APPLICATION', true);
        $dir_xtree='./lib/xtree';
        require($dir_xtree.'/app.config.php');
        require($dir_xtree.'/common.php');
        require($dir_xtree.'/xtree.page.php');
        $tree = new xtree("<a href='/admin/catalog/new' style='font : 13px Verdana, sans-serif;' title='Создать новую группу товаров'>[Создать]</a>", 'example');
        $tree->SetImagePath('http://'.$_SERVER['HTTP_HOST'].'/lib/xtree/images');
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
                $tree->AddNode($pg_father, '_pege_'.$pg_id, '<a href="/admin/catalog/tab/'.$pg_id.'" title="Просмотр товаров в этой группе">'.$pg_name.'<a/> 
                <a href="/admin/catalog/edit/'.$pg_id.'" title="Редактировать группу товаров">
                <img border="0" src="/media_admin/img/edit-12.png" /><a/>', 'pege', cookievalue('tree_example_pege_'.$pg_id, 'open'));
            }      
        }  
        return $tree;
    }
    
    //Построение раскрывающегося списка с данными из масивов с отступами 
    public function ca_option ($ca_id, $ca_name, $ca_father_id, $tab, $potion_line, $father_select){
        
        //ca_id Корневой ID   
        //ca_name Масив названий каталога
        //ca_father_id Масив ID родителя
        //tab Отступ в начале строки
        //potion_line Строка предыдущих категорий 
        //father_select Выбраная категория
        
        $key=array_keys($ca_father_id, $ca_id);
        if($ca_id!='0'){$tab=$tab."&nbsp;&nbsp;&nbsp;";}
        foreach($key as $key_id)
        {
            $key_doch=array_keys($ca_father_id, $key_id);
            $key_num=count($key_doch);
            if($key_id==$father_select){$select=' selected="selected"';}else{$select='';}
            $potion_line=$potion_line.'<option value="'.$key_id.'"'.$select.'>'.$tab.$ca_name[$key_id].'</option>
            ';
            if($key_num>0)
            {
                $op_dir=$this->ca_option ($key_id, $ca_name, $ca_father_id, $tab, '', $father_select);
                $potion_line=$potion_line.$op_dir;   
            }
        }
        return $potion_line;
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
    public function catalog_line($id_ca, $line){ 
        
        //Создаем дерево каталога товаров            
        $pages = ORM::factory('catalog')
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
                        $ca_line=$this->catalog_line($father[$ca_id], $line);
                        $line=$line.$ca_line;
                    }
                    $line=$line.' :: '.HTML::anchor('/admin/catalog/tab/'.$ca_id, $name[$ca_id]);
                }
            }
        }        
        return $line;
    }
    
    //Удаляем фото товара
    public function gofotodel($img_id){ 
        
        $image = ORM::factory('image', $img_id);
        $fuuldir = $_SERVER['DOCUMENT_ROOT'].'/media/foto/goods/'.$image->go_id.'/'.$image->img_id;
        unlink($fuuldir.'.jpg');
        unlink($fuuldir.'_.jpg');
        ORM::factory('image', $img_id)->delete();
        return true;
    }
    
    //Удаляем товар товара
    public function gooddel($go_id){
        $good = ORM::factory('good', $go_id);
        $dirfoto = $_SERVER['DOCUMENT_ROOT'].'/media/foto/goods/'.$go_id;
        if (is_dir($dirfoto)) 
        {
            $op_dir=opendir($dirfoto);
            while($file=readdir($op_dir ))
            {
                if($file != "." && $file != "..") 
                {
                    unlink ($dirfoto.'/'.$file);
                }
            }
            rmdir ($dirfoto);
        } 
        $imgs = ORM::factory('image')->where('go_id', '=', $go_id)->find_all();
        foreach($imgs as $img)
        {
            ORM::factory('image', $img->img_id)->delete();         
        }
        ORM::factory('good', $go_id)->delete();
        return $good->ca_id;
    }
    
    //Удаляем группу товаров
    public function cadel($ca_id){
        
        //Ищем подчененные групп
        $fathers = ORM::factory('catalog')->where('ca_father', '=', $ca_id)->find_all(); // Получим объект
        foreach($fathers as $father)
        {
            $this->cadel($father->ca_id);         
        }
        
        //Удаляем товар в данной группе
        $goods = ORM::factory('good')->where('ca_id', '=', $ca_id)->find_all();
        foreach($goods as $good)
        {
            $this->gooddel($good->go_id);        
        }
        
        //Удаляем фото группы
        $file_img = $_SERVER['DOCUMENT_ROOT']."/media/foto/catalog/$ca_id.jpg";
        if (file_exists($file_img)) 
        {
            //unlink ($file_img);
        } 
        
        //Удаляем удаляем данные данной группы в таблице группы
        ORM::factory('catalog', $ca_id)->delete();
        
        return true;
    }
    
    //Проверка существования фото в папке
    public function okfoto($go,$img){
        $dir_foto_ok = "no"; $dir_foto_ok_ = "no";
        $dir_foto = $this->dir_gofoto.$go.'/'.$img.".jpg";
        $dir_foto_ = $this->dir_gofoto.$go.'/'.$img."_.jpg";
        if (file_exists($dir_foto))
        {
            $dir_foto_ok = "+";
        }
        if (file_exists($dir_foto_))
        {
            $dir_foto_ok_ = "+";
        }
        $okfoto = $img.$dir_foto_ok.$dir_foto_ok_;
        return $okfoto;
    }
    
    //Проверка существования главное фото в папке foto_1c
    public function foto_in($go){
        $dir_foto_ok = "no"; $dir_foto_ok_ = "no";
        $dir_foto = $this->dir_gofoto_1c.$go.'/'.$go."_1.jpg";
        if (file_exists($dir_foto))
        {
            $dir_foto_ok = '<a href="/admin/goodsfoto/movefoto/'.$go.'" title="Добавить в базу">
            <img border="0" src="/media_admin/img/plus-1-16.png" align="absmiddle" />Добавить</a>';
        }
        else
        {
            $dir_foto_ok = "-";
        }
        $okfoto = $dir_foto_ok;
        return $okfoto;
    }
    


}