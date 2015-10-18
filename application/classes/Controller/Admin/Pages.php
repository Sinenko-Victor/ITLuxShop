<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Pages extends Controller_Admin { 
    
    public function before() {
        parent::before();

        // Вывод в шаблон
        $this->template->styles[] = 'lib/xtree/style.css';
        $this->template->scripts[] = 'lib/xtree/common.js';
        //$this->template->styles[] = 'lib/ckeditor-4.3.1/sample.css';
        //$this->template->scripts[] = 'lib/ckeditor-4.3.1/ckeditor.js';
        $this->template->scripts[] = 'lib/ckeditor_4.4.5/ckeditor.js'; //Текстовый редактор CKEditor
        $this->template->styles[] = 'lib/lightbox/css/lightbox.css'; //Галлегеф фото
        $this->template->scripts[] = 'lib/lightbox/js/jquery-1.11.0.min.js'; //Галлегеф фото
        $this->template->scripts[] = 'lib/lightbox/js/lightbox.js'; //Галлегеф фото
        
        $this->template->page_title = 'Страници';    
    }
    
    public function action_index() {

        //Проверяем нужна ли обработка формы
        if (isset($_POST['submit'])) 
        {
            $data = Arr::extract($_POST, array('pg_alias', 'pg_father', 'pg_name', 'pg_title', 'pg_text'));
            
            //Убираем пробелы в начале и конце строки
            $data['pg_name']=trim($data['pg_name']);
            //Если поле алисас пустое то оно равено названию
            if($data['pg_alias']==''){$data['pg_alias']=$data['pg_name'];}
            //Заменить пробелы на подчеркивание
            $data['pg_alias']=str_replace(" ","_", $data['pg_alias']);
            //Если поле титле пустое то оно равено названию
            if($data['pg_title']==''){$data['pg_title']=$data['pg_name'];}
            
            $pages = ORM::factory('page');
            $pages->values($data);

            try 
            {
                $pages->save(); //Сохраняем данные в базе полученые из формы
                $pege_in = ORM::factory('page')->where('pg_alias', '=', $data['pg_alias'])->find(); // Получим объект
                $page_in_id = $pege_in->pg_id;
                
                //Создаем папку для фото
                $dirfoto = $_SERVER['DOCUMENT_ROOT'].'/media/foto/pages/'.$page_in_id;
                if (!is_dir($dirfoto))
                {
                    mkdir($dirfoto, 0755);
                }
                
                HTTP::redirect('admin/pages/edit/'.$page_in_id); //Перенаправляем на другую страницу
            }
            catch (ORM_Validation_Exception $e) 
            {
                $errors = $e->errors('validation'); //Если данные не сохранились получаем причину отказа
                
                $page['pg_alias']=$data['pg_alias'];
                $page['pg_name']=$data['pg_name'];
                $page['pg_title']=$data['pg_title'];
                $page['pg_text']=$data['pg_text'];
            }
        }
        else
        {
            $page['pg_alias']='';
            $page['pg_name']='';
            $page['pg_title']='';
            $page['pg_text']='';
        }        
        
        $tree=$this->pg_tree();
        $poption = ORM::factory('page')->find_all();
        foreach($poption as $option)
        {
            $pg_id=$option->pg_id;
            $pg_name[$pg_id]=$option->pg_name;
            $pg_father_id[$pg_id]=$option->pg_father;              
        }
        $pages_option=$this->pg_option('0', $pg_name, $pg_father_id, '', '', '0');
        $content = View::factory('admin/pages/v_pages_index', array(
            'page_title' =>'Создаем новую страницу',
            'page_tree' =>$tree,
            'page' => $page,
            'id' => '',
            'link' => '/admin/pages',
            'pg_name' => $pg_name,
            'pages_option' => $pages_option,
        ))
        ->bind('errors', $errors);
        
        // Вывод в шаблон   
        $this->template->block_center = array($content);
    } 
    
    public function action_edit() {       
        $id = (int) $this->request->param('id');
        if (isset($_POST['submit'])) 
        {
            $pages = ORM::factory('page', $id);
            $data = Arr::extract($_POST, array('pg_alias', 'pg_father', 'pg_name', 'pg_title', 'pg_text'));
            //Убираем пробелы в начале и конце строки
            $data['pg_name']=trim($data['pg_name']);
            //Если поле алисас пустое то оно равено названию
            if($data['pg_alias']==''){$data['pg_alias']=$data['pg_name'];}
            //Заменить пробелы на подчеркивание
            $data['pg_alias']=str_replace(" ","_", $data['pg_alias']);
            //Если поле титле пустое то оно равено названию
            if($data['pg_title']==''){$data['pg_title']=$data['pg_name'];}
            $data['pg_d']=$pages->pg_d;
            $pages->values($data);

            try 
            {
                $pages->save();    
                //$this->request->redirect('/admin/pages');
            }
            catch (ORM_Validation_Exception $e) 
            {
                $errors = $e->errors('validation');
            }
        }        
        
        $tree=$this->pg_tree();
        $pages = ORM::factory('page', $id);
        $page = $pages->as_array();
    
        $poption = ORM::factory('page')->find_all();
        foreach($poption as $option)
        {
            $pg_id=$option->pg_id;
            $pg_name[$pg_id]=$option->pg_name;
            $pg_father_id[$pg_id]=$option->pg_father;                
        }
    
        $pages_option=$this->pg_option('0', $pg_name, $pg_father_id, '', '', $pg_father_id[$id]);    
    
        $foto = '';
        $imgs = $pages->pageimgs->find_all();
        foreach($imgs as $img)
        {
            $img_id=$img->pi_id;
            $img_dir=$img->img_dir;
            $foto .= "
            <a href='/media/foto/pages/".$id."/".$img_dir.".jpg' data-lightbox='roadtrip' title='$pages->pg_name'>
            <img border='0' src='/media/foto/pages/".$id."/".$img_dir."_.jpg' /></a> 
            <a href='/admin/pages/deletefoto/$img_id' title='Удалить фото'>
            <img border='0' src='/media_admin/img/delete-16.png' align='absmiddle'></a>
            &nbsp;&nbsp;&nbsp;&nbsp;
            /media/foto/pages/".$id."/".$img_dir.".jpg<br />";
               
        }
        
        $content = View::factory('admin/pages/v_pages_edit', array(
            'page_title' =>'Редактор страниц',
            'page_tree' =>$tree,
            'page' => $page,
            'id' => $id,
            'link' => '/admin/pages/edit/',
            'pg_name' => $pg_name,
            'foto' => $foto,
            'pages_option' => $pages_option,
        ))
        ->bind('errors', $errors);
        
        // Вывод в шаблон   
        $this->template->block_center = array($content);
    }
    
    public function action_delete() {
        //Нужно сделать удаление подчененных страниц
        $id = (int) $this->request->param('id');
        
        //Удаляем фото
        $dirfoto = $_SERVER['DOCUMENT_ROOT'].'/media/foto/pages/'.$id;
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
        
        //Удаляем з базы данных
        $imgs = ORM::factory('pageimg')->where('pg_id', '=', $id)->find_all();
        foreach($imgs as $img)
        {
            ORM::factory('pageimg', $img->pi_id)->delete();         
        } 
        
        //echo"Удаляем категорию $id<br>";
        ORM::factory('page', $id)->delete(); 
        
        //Удаляем подчененые категории
        $this->del_cat($id);
        HTTP::redirect('admin/pages'); //Перенаправляем на другую страницу
    }
    
    public function action_addfoto() {
        
        $id = (int) $this->request->param('id');
        //Загрузка фото
        $uploaddirs=$_SERVER['DOCUMENT_ROOT'].'/media/foto/pages/'.$id.'/';
        if(isset($_FILES['userfile']['name']))
        {            
            //Передаем в валидатор массив данных $_POST
            $valid = Validation::factory($_FILES)
                ->rule('userfile', 'Upload::valid')
                ->rule('userfile', 'Upload::size', array(':value', '5M'))
                ->rule('userfile', 'Upload::type', array(':value', array('jpg')))
                ;
        
            if ($valid->check())
            {
                $uploaded = Upload::save($_FILES['userfile'], $id.'_temp.jpg', $uploaddirs, 0777); //Сохраняем файл на сервере
                
                // Загружаем изображение
                $image = Image::factory($uploaddirs.$id.'_temp.jpg');
                // Меняем размеры
                $image->resize(800, 800);
                // Сохраняем превью
                $t = time();
                $image->save($uploaddirs.$t.'.jpg');
                
                $image->resize(200, 200);
                $image->save($uploaddirs.$t.'_.jpg');
                //Добавляем в базу инфу о фото
                $img_dir = $t;
                $dataimg = array('img_dir' => $img_dir, 'pg_id' => $id);
                ORM::factory('pageimg')->values($dataimg)->save();
                //Удаляем файл
                unlink($uploaddirs.$id.'_temp.jpg');                
            }    
        }
        $ref=getenv("HTTP_REFERER");
        //echo$img_dir;
        HTTP::redirect($ref); //Перенаправляем на другую страницу    
    }
    
    public function action_deletefoto() {
        $id = (int) $this->request->param('id');
        $pageimg = ORM::factory('pageimg', $id);;
        $fuuldir = $_SERVER['DOCUMENT_ROOT'].'/media/foto/pages/'.$pageimg->pg_id.'/'.$pageimg->img_dir;
        $fuuldirimg =  $fuuldir.'.jpg';
        $fuuldirimg_ = $fuuldir.'_.jpg';
        unlink($fuuldirimg);
        unlink($fuuldirimg_);
        
        ORM::factory('pageimg', $id)->delete();
        $ref=getenv("HTTP_REFERER");
        HTTP::redirect($ref); //Перенаправляем на другую страницу
    }
    
    //-------------------------------------- ФУНКЦИИ ------------------------------
    
    //Построение раскрывающегося списка с данными из масивов с отступами 
    public function pg_option ($pg_id, $pg_name, $pg_father_id, $tab, $potion_line, $father_select){
        
        //pg_id Корневой ID   
        //pg_name Масив названий каталога
        //pg_father_id Масив ID родителя
        //tab Отступ в начале строки
        //potion_line Строка предыдущих категорий 
        //father_select Выбраная категория
        
        $key=array_keys($pg_father_id, $pg_id);
        if($pg_id!='0'){$tab=$tab."&nbsp;&nbsp;&nbsp;";}
        foreach($key as $key_id)
        {
            $key_doch=array_keys($pg_father_id, $key_id);
            $key_num=count($key_doch);
            if($key_id==$father_select){$select=' selected="selected"';}else{$select='';}
            $potion_line=$potion_line.'<option value="'.$key_id.'"'.$select.'>'.$tab.$pg_name[$key_id].'</option>
            ';
            if($key_num>0)
            {
                $op_dir=$this->pg_option ($key_id, $pg_name, $pg_father_id, $tab, '', $father_select);
                $potion_line=$potion_line.$op_dir;   
            }
        }
        return $potion_line;
    }
    
    
    public function pg_tree (){
        //Создаем дерево каталога страниц
        define('IN_APPLICATION', true);
        $dir_xtree='./lib/xtree';
        require($dir_xtree.'/app.config.php');
        require($dir_xtree.'/common.php');
        require($dir_xtree.'/xtree.page.php');
        $tree = new xtree("<a href='/admin/pages' style='font : 13px Verdana, sans-serif;'>[Создать новую страницу]</a>", 'example');
        $tree->SetImagePath('http://'.$_SERVER['HTTP_HOST'].'/lib/xtree/images');
        // ImageList
        $tree->AddNodeImage('root', 'home.gif');
        $tree->AddNodeImage('pege', 'html_content.gif');
            
        $pages = ORM::factory('page')
            ->order_by('pg_id')
            ->find_all();
         
        foreach($pages as $page) //Создаем масивы
        {            
            $id[$pg_id]=$pg_id=$page->pg_id; //Масив ID названия категории
            $name[$pg_id]=$page->pg_name; //Масив названия категории 
            $father[$pg_id]=$page->pg_father; //Масив ID родителя категории
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
            $tree->AddNode($pg_father, '_pege_'.$pg_id, '<a href="/admin/pages/edit/'.$pg_id.'">'.$pg_name.'<a/>', 'pege', cookievalue('tree_example_pege_'.$pg_id, 'open'));
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
     
     //Функция удаления категорий
     public function del_cat ($id_faz){
        //Создаем масивы с ID категориями и их родителями
        $pages = ORM::factory('page')->find_all();
         
        foreach($pages as $page) //Создаем масивы
        {            
            $id[$pg_id]=$pg_id=$page->pg_id; //Масив ID названия категории
            $fath=$father[$pg_id]=$page->pg_father; //Масив ID родителя категории
        }
        
        foreach($id as $pg_id) //Перебераем масив ID названия категории
        {
            $pg_father=$father[$pg_id];           
            if($id_faz==$pg_father)
            {
                //Удаляем фото
                $dirfoto = $_SERVER['DOCUMENT_ROOT'].'/media/foto/pages/'.$pg_id;
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
                
                $imgs = ORM::factory('pageimg')->where('pg_id', '=', $pg_id)->find_all();
                foreach($imgs as $img)
                {
                    ORM::factory('pageimg', $img->pi_id)->delete();         
                }                 
                
                //echo"Удаляем категорию $pg_id <br>";
                ORM::factory('page', $pg_id)->delete();
                $this->del_cat($pg_id);
            }              
        }        
        return true;        
     }
     
} //End Controller_Admin_Pages