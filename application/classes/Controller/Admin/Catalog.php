<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Catalog extends Controller_Admin {    
    
    public function before() {
        parent::before();

        // Вывод в шаблон
        $this->template->styles[] = 'lib/xtree/style.css';
        $this->template->scripts[] = 'lib/xtree/common.js';
        $this->template->page_title = 'Каталог товаров';    
    }
    
    
    public function action_index() {
        
        $tree=$this->ca_tree();
        $catalogs = ORM::factory('catalog')->where('ca_father', '=', 0)->order_by('ca_name')->find_all();
        $foto = array();
        foreach($catalogs as $catalog)
        {
            //проверяем существование фото
            $file_img=$_SERVER['DOCUMENT_ROOT']."/media/foto/catalog/".$catalog->ca_id.".jpg";
            if (file_exists($file_img)) 
            {
                $foto[$catalog->ca_id] = '<img src="/media/foto/catalog/'.$catalog->ca_id.'.jpg" width="140" height="110"/>';  
            } 
            else 
            {
                $foto[$catalog->ca_id] = '<img src="/media/img/nofoto.jpg" width="120" height="120"/>';  
            }                
        }

     
        
        $content = View::factory('admin/catalog/v_catalog_index', array(
            'catalog_tree' => $tree,
            'catalogs' => $catalogs,
            'foto' => $foto,
            'page_title' =>'Каталог товаров',
        ));

        // Вывод в шаблон
        $this->template->block_center = array($content);
    }
    
    public function action_tab() {
        
        $tree=$this->ca_tree();
        $id = (int) $this->request->param('id');
        $catalog_line = HTML::anchor('/admin/catalog', 'Каталог товара').$this->catalog_line($id, ''); //Вложенность категорий
        $list = $this->session->get('list'); //Получаем данные из сесии
        $this->session->delete('list'); //Удаляем переменную сесии
        $sel_br = $this->session->get('br'); //Получаем данные из сесии
        $this->session->delete('br'); //Удаляем переменную сесии
        if(isset($_POST['brends'])and $_POST['brends']!="")
        {
            $sel_br=$_POST['brends'];
        }
        
        if(@$sel_br==''){$sel_br='all';}
        if(@$list==''){$list='all';}
        if($id > 0)
        {
            //Проверяем есть ли в данном категории товар
            $count_goods = ORM::factory('good')->where('ca_id', '=', $id)->count_all();
            if($count_goods > 0)
            {
                $editlist = Request::factory('editlist/'.$id.'/'.$sel_br.'/'.$list)->execute();
            }
            else
            {
                $editlist = "<h1> В данной категории товаров нет!</h1>
                &nbsp;<a href='/admin/goods/new/$id' title='Создать товар'>[Создать]</a> ";
            }
            
        }
        else
        {
            $editlist = "<h1>Выбирите группу товаров</h1>";
        }        
        
        $content = View::factory('admin/catalog/v_catalog_tab', array(
            'catalog_tree' =>$tree,
            'editlist' => $editlist,
            'catalog_line' => $catalog_line,
            'page_title' =>'Каталог товаров',
        ));

        // Вывод в шаблон
        $this->template->block_center = array($content);
    }
    
    public function action_edit() {
        
        $page_title = "Редактор группы товара";
        $id = (int) $this->request->param('id');
        
        if (isset($_POST['submit'])) 
        {
            $catalogs = ORM::factory('catalog', $id);
            $data = Arr::extract($_POST, array('ca_father', 'ca_name',));
            //Убираем пробелы в начале и конце строки
            $data['ca_name']=trim($data['ca_name']);
            $catalogs->values($data);

            try 
            {
                $catalogs->save();    
            }
            catch (ORM_Validation_Exception $e) 
            {
                $errors = $e->errors('validation');
            }
        }
        
        //проверяем существование фото
        $file_img = $_SERVER['DOCUMENT_ROOT']."/media/foto/catalog/$id.jpg";
        if (file_exists($file_img)) 
        {
            $foto = "<img border='0' src='/media/foto/catalog/".$id.".jpg' />";
            $deletefoto = "<a href='/admin/catalog/deletefoto/$id' title='Удалить фото'>
            <img border='0' src='/media_admin/img/delete-16.png' align='absmiddle'></a>";  
        } 
        else 
        {
            $foto = "<img border='0' src='/media_admin/img/nofoto.jpg' align='absmiddle' />";
            $deletefoto = "";   
        }
        
        $catalogs = ORM::factory('catalog', $id);
        $catalog = $catalogs->as_array();
        
        $poption = ORM::factory('catalog')->find_all();
        foreach($poption as $option)
        {
            $ca_id=$option->ca_id;
            $ca_name[$ca_id]=$option->ca_name;
            $ca_father_id[$ca_id]=$option->ca_father;                
        }
        $catalog_option=$this->ca_option('0', $ca_name, $ca_father_id, '', '', $ca_father_id[$id]); 
        $tree=$this->ca_tree();
        $content = View::factory('admin/catalog/v_catalog_edit', array(
            'catalog_tree' =>$tree,
            'catalog' => $catalog,
            'id' => $id,
            'link' => '/admin/catalog/edit/',
            'page_title' => $page_title,
            'catalog_option' => $catalog_option,
            'foto' => $foto,
            'deletefoto' => $deletefoto,
        ))
        ->bind('errors', $errors);

        // Вывод в шаблон
        $this->template->block_center = array($content);
    }
    
    public function action_new() {
        
        $catalog['ca_name'] = '';
        if (isset($_POST['submit'])) 
        {            
            $data = Arr::extract($_POST, array('ca_father', 'ca_name'));
            $data['ca_name']=trim($data['ca_name']); //Убираем пробелы в начале и конце строки
            $catalogs = ORM::factory('catalog');
            $catalogs->values($data);
            try 
            {
                $catalogs->save(); //Сохраняем данные в базе полученые из формы
                $catalog_in = ORM::factory('catalog')->order_by('ca_id', 'desc')->limit(1)->find(); // Получим объект
                $catalog_in_id = $catalog_in->ca_id;
                HTTP::redirect('/admin/catalog/edit/'.$catalog_in_id); //Перенаправляем на другую страницу
            }
            catch (ORM_Validation_Exception $e) 
            {
                $errors = $e->errors('validation'); //Если данные не сохранились получаем причину отказа
                
                $catalog['ca_name']=$data['ca_name'];
            }
        }
        
        $page_title = "Добавление новой группы товаров";
        $tree=$this->ca_tree();
        $id = '';
        
        $poption_num = ORM::factory('catalog')->count_all();
        if($poption_num > 0)
        {
            $poption = ORM::factory('catalog')->find_all();
            foreach($poption as $option)
            {
                $ca_id=$option->ca_id;
                $ca_name[$ca_id]=$option->ca_name;
                $ca_father_id[$ca_id]=$option->ca_father;                
            }
            $catalog_option = $this->ca_option('0', $ca_name, $ca_father_id, '', '', 0);
        }
        else
        {
            $catalog_option = "";
        }
         
        
        $content = View::factory('admin/catalog/v_catalog_new', array(
            'catalog_tree' =>$tree,
            'catalog' => $catalog,
            'page_title' => $page_title,
            'catalog_option' => $catalog_option,
        ))
        ->bind('errors', $errors);

        // Вывод в шаблон
        $this->template->block_center = array($content);
    }
    
    public function action_delete() {
        
        $id = (int) $this->request->param('id');
        $this->cadel($id);
        HTTP::redirect('/admin/catalog/new'); //Перенаправляем на другую страницу
            
    }
    
    public function action_addfoto() {
        
        $id = (int) $this->request->param('id');
        //Загрузка фото
        $uploaddirs=$_SERVER['DOCUMENT_ROOT'].'/media/foto/catalog/';
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
                $image->resize(140, 110);
                // Сохраняем превью
                $image->save($uploaddirs.$id.'.jpg');
                //Удаляем файл
                unlink($uploaddirs.$id.'_temp.jpg');                
            }    
        }
        $ref=getenv("HTTP_REFERER");
        HTTP::redirect($ref); //Перенаправляем на другую страницу    
    }
    
    public function action_deletefoto() {
        $ref=getenv("HTTP_REFERER");
        $id = (int) $this->request->param('id');
        $file_img=$_SERVER['DOCUMENT_ROOT']."/media/foto/catalog/$id.jpg";
        if (file_exists($file_img)) 
        {
            unlink ($file_img);   
        }
        HTTP::redirect($ref); //Перенаправляем на другую страницу
            
    }



    //-------------------------------------- ФУНКЦИИ ------------------------------




}//End Controller_Admin_Catalog