<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Goods extends Controller_Admin {    
    
     public function before() {
        parent::before();

        // Вывод в шаблон
        //$this->template->styles[] = 'lib/ckeditor_4.4.5/sample.css';
        $this->template->scripts[] = 'lib/ckeditor_4.4.5/ckeditor.js'; //Текстовый редактор CKEditor
        $this->template->styles[] = 'lib/lightbox/css/lightbox.css'; //Галлегеф фото
        $this->template->scripts[] = 'lib/lightbox/js/jquery-1.11.0.min.js'; //Галлегеф фото
        $this->template->scripts[] = 'lib/lightbox/js/lightbox.js'; //Галлегеф фото
        $this->template->page_title = 'Товар';    
    }
     
     public function action_index() {

        $id = (int) $this->request->param('id');
        
        if (isset($_POST['submit'])) 
        {
            $goodsseve = ORM::factory('good', $id);
            $data = Arr::extract($_POST, array('ca_id', 'go_name', 'br_id', 'go_cost', 'go_text'));
            //Убираем пробелы в начале и конце строки
            $data['go_name']=trim($data['go_name']);
            $goodsseve->values($data);

            try 
            {
                $goodsseve->save();    
            }
            catch (ORM_Validation_Exception $e) 
            {
                $errors = $e->errors('validation');
            }
        }
        
        $tree=$this->ca_tree();
        
        $good = ORM::factory('good', $id);

        $poption = ORM::factory('catalog')->find_all();
        foreach($poption as $option)
        {
            $ca_id=$option->ca_id;
            $ca_name[$ca_id]=$option->ca_name;
            $ca_father_id[$ca_id]=$option->ca_father;                
        }
        $catalog_option=$this->ca_option('0', $ca_name, $ca_father_id, '', '', $good->ca_id);
        
        $brend_mas=$this->brend();
        $brends = ORM::factory('brend')->find_all();        
        $brend_mas['0']='Нет данных';
        
        if($good->go_ok > 0)
        {
            $linkok = "/arun/delete/ok/".$good->go_id;
            $titleok = "Товар показан на ветрине! Убрать?";
            $imgok = "/media_admin/img/ok-1-16.png";
        }
        else
        {
            $linkok = "/arun/add/ok/".$good->go_id;
            $titleok = "Отобразить товар на ветрине";
            $imgok = "/media_admin/img/plus-1-16.png";
        }
        
        $mainfoto = ''; //Основное фото
        $foto = ''; //Дополнительніе фотографии
        if($good->img_id != NULL)
        {
            $mainfoto = "
            <br /><a href='/media/foto/goods/".$id."/".$good->img_id.".jpg' data-lightbox='roadtrip' title='".$good->go_name."'>
            <img border='0' src='/media/foto/goods/".$id."/".$good->img_id."_.jpg' /></a> 
            <a href='/admin/goods/dmf/".$good->img_id."' title='Удалить фото'>
            <img border='0' src='/media_admin/img/delete-16.png' align='absmiddle'></a>
            &nbsp;&nbsp;&nbsp;&nbsp;
            Главное фото";
        }
        
        $imgs = $good->images->find_all();
        foreach($imgs as $img)
        {
            $img_id = $img->img_id;
            //$img_dir = $img->img_dir;
            if($img_id != $good->img_id)
            {
                $foto .= "
                <a href='/media/foto/goods/".$id."/".$img_id.".jpg' data-lightbox='roadtrip' title='$good->go_name'>
                <img border='0' src='/media/foto/goods/".$id."/".$img_id."_.jpg' /></a> 
                <a href='/admin/goods/df/$img_id' title='Удалить фото'>
                <img border='0' src='/media_admin/img/delete-16.png' align='absmiddle'></a>
                &nbsp;&nbsp;&nbsp;&nbsp;
                <a href='/admin/goods/amf/$img_id' title='Сделать фото главным'>
                <img src='/media_admin/img/plus-1-16.png' align='absmiddle' /></a>
                &nbsp;&nbsp;&nbsp;&nbsp;
                /media/foto/goods/".$id."/".$img_id.".jpg
                <br />";
            }      
        }
                
        $catalog_line = HTML::anchor('/admin/catalog', 'Каталог товара').$this->catalog_line($good->ca_id, ''); //Вложенность категорий
        
        $content = View::factory('admin/goods/v_goods_index', array(
            'id' => $id,
            'catalog_line' => $catalog_line,
            'catalog_tree' => $tree,
            'catalog_option' => $catalog_option,
            'good' => $good,
            'sel_brend' => $brend_mas,
            'sel_br' => $good->br_id,
            'linkok' => $linkok,
            'titleok' => $titleok,
            'imgok' => $imgok,
            'mainfoto' => $mainfoto,
            'foto' => $foto,
            'page_title' =>'Карточка товара',
        ))
        ->bind('errors', $errors);

        // Вывод в шаблон
        $this->template->page_title = 'Карточка товара';
        $this->template->block_center = array($content);
    }
    
    public function action_new() {
        $id = (int) $this->request->param('id');
        $catalog_line = HTML::anchor('/admin/catalog', 'Каталог товара').$this->catalog_line($id, ''); //Вложенность категорий
        if (isset($_POST['submit'])) 
        {
            $data = Arr::extract($_POST, array('ca_id', 'go_name', 'br_id', 'go_cost'));
            $data['go_name'] = trim($data['go_name']); //Убираем пробелы в начале и конце строки
            //if($data['go_name'] == ''){$data['go_name'] = 'Новый товар';}
            $goodnew = ORM::factory('good');
            $goodnew->values($data);
            try 
            {
                $goodnew->save(); //Сохраняем данные в базе полученые из формы
                $good_in = ORM::factory('good')->order_by('go_id', 'desc')->limit(1)->find(); // Получим объект
                $good_in_id = $good_in->go_id;
                HTTP::redirect('/admin/goods/index/'.$good_in_id); //Перенаправляем на другую страницу
            }
            catch (ORM_Validation_Exception $e) 
            {
                $errors = $e->errors('validation'); //Если данные не сохранились получаем причину отказа
            }
        }
        
        $tree=$this->ca_tree();
        

        $poption = ORM::factory('catalog')->find_all();
        foreach($poption as $option)
        {
            $ca_id=$option->ca_id;
            $ca_name[$ca_id]=$option->ca_name;
            $ca_father_id[$ca_id]=$option->ca_father;                
        }
        $catalog_option=$this->ca_option('0', $ca_name, $ca_father_id, '', '', $id);
        
        $brend_mas=$this->brend();
        $brends = ORM::factory('brend')->find_all();        
        $brend_mas['0']='Нет данных';
        
                
        $content = View::factory('admin/goods/v_goods_new', array(
            'id' => $id,
            'catalog_line' => $catalog_line,
            'catalog_tree' => $tree,
            'catalog_option' => $catalog_option,
            'sel_brend' => $brend_mas,
            'sel_br' => 0,
            'page_title' =>'Карточка товара',
        ))
        ->bind('errors', $errors);

        // Вывод в шаблон
        $this->template->page_title = 'Карточка товара';
        $this->template->block_center = array($content);
    }
    
    //Удалить товар
    public function action_delete() {
        $id = (int) $this->request->param('id');
        $ca_id = $this->gooddel($id);
        $ref = "/admin/catalog/tab/".$ca_id;
        HTTP::redirect($ref); //Перенаправляем на другую страницу
    }
    
    public function action_addfoto() {
        
        $id = (int) $this->request->param('id');
        //Загрузка фото
        $uploaddirs = $this->dir_gofoto.$id.'/';
        //Если папка не существует то создаем
        if (!is_dir($uploaddirs))
        {
            mkdir($uploaddirs, 0755);
        }
        
        if(isset($_FILES['userfile']['name']) and $_FILES['userfile']['name'] != '')
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
                $image = Image::factory($uploaddirs.$id.'_temp.jpg'); // Загружаем изображение
                
                //Добавляем в базу инфу о фото
                $dataimg = array('go_id' => $id);
                ORM::factory('image')->values($dataimg)->save();
                //Определяем  ID добавленного фото
                $newimg = ORM::factory('image')->where('go_id', '=', $id)->order_by('img_id', 'desc')->limit(1)->find();
                $newimgid = $newimg->img_id; // ID нового фото
                $image->resize(800, 800); // Меняем размеры
                $image->save($uploaddirs.$newimgid.'.jpg');
                $image->resize(200, 200); // Меняем размеры
                $image->save($uploaddirs.$newimgid.'_.jpg'); // Сохраняем превью
                
                //Удаляем файл
                unlink($uploaddirs.$id.'_temp.jpg');
                $good = ORM::factory('good', $id);
                if($good->img_id == NULL)
                {
                    $data['img_id'] = $newimgid;
                    $goodnewimg = ORM::factory('good', $id)->values($data)->save();
                }                
            }    
        }
        $ref=getenv("HTTP_REFERER");
        //echo$img_dir;
        HTTP::redirect($ref); //Перенаправляем на другую страницу    
    }
    
    //Удалить фото
    public function action_df() {
        $id = (int) $this->request->param('id');
        $this->gofotodel($id);
        $ref=getenv("HTTP_REFERER");
        HTTP::redirect($ref); //Перенаправляем на другую страницу
    }
    
    //Делаем выбраное фото главным для выбраного товара
    public function action_amf() {
        $id = (int) $this->request->param('id');
        $image = ORM::factory('image', $id);
        $data['img_id']=$id;
        $goodsseve = ORM::factory('good', $image->go_id)->values($data)->save();       
        $ref=getenv("HTTP_REFERER");
        HTTP::redirect($ref); //Перенаправляем на другую страницу
    }
    
    //Удаляем главное фото
    public function action_dmf() {
        $id = (int) $this->request->param('id');
        $image = ORM::factory('image', $id);

        //Проверяем есть ли у данного товара еще фото
        $img_count = ORM::factory('image')
            ->where('go_id', '=', $image->go_id)
            ->where('img_id', '!=', $image->img_id)
            ->count_all();
        
        
        echo"img_count ".$img_count."|";
        if($img_count > 0)
        {
            //Определяем ID старшего фото
            $imgnewmain = ORM::factory('image')
                ->where('go_id', '=', $image->go_id)
                ->where('img_id', '!=', $image->img_id)
                ->order_by('img_id')
                ->limit(1)
                ->find(); // Получим объект
            $imgnewid = $imgnewmain->img_id;
            echo"imgnewid ".$imgnewid."|";
            //Делаем другое фото главным
            $data['img_id']=$imgnewid;
            $goodnewimg = ORM::factory('good', $image->go_id)->values($data)->save();
            //Удаляем фото
            $this->gofotodel($id);    
        }
        else
        {
            //Удаляем единственное фото
            $this->gofotodel($id);
            $data['img_id'] = NULL;
            $goodsseve = ORM::factory('good', $image->go_id)->values($data)->save();  
        }
               
        $ref=getenv("HTTP_REFERER");
        HTTP::redirect($ref); //Перенаправляем на другую страницу
    }

}