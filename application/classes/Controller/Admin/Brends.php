<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Brends extends Controller_Admin {    
    
     public function action_index() {
                
        $brends=$this->brend();
        $content = View::factory('admin/brends/v_brends_index', array(
            'page_title' => 'Бренды',
            'brends' => $brends,
        ));

        // Вывод в шаблон
        $this->template->page_title = 'Бренды';
        $this->template->block_center = array($content);
    }
    
    public function action_new() {
                
        if (isset($_POST['submit'])) 
        {            
            $data = Arr::extract($_POST, array('br_name'));
            $data['br_name']=trim($data['br_name']); //Убираем пробелы в начале и конце строки
            $brendnew = ORM::factory('brend');
            $brendnew->values($data);
            try 
            {
                $brendnew->save(); //Сохраняем данные в базе полученые из формы
                $brend_in = ORM::factory('brend')->order_by('br_id', 'desc')->limit(1)->find(); // Получим объект
                $brend_in_id = $brend_in->br_id;
                HTTP::redirect('/admin/brends/edit/'.$brend_in_id); //Перенаправляем на другую страницу
            }
            catch (ORM_Validation_Exception $e) 
            {
                $errors = $e->errors('validation'); //Если данные не сохранились получаем причину отказа
                
                $catalog['br_name']=$data['br_name'];
            }
        }
        $brends=$this->brend();
        $content = View::factory('admin/brends/v_brends_new', array(
            'page_title' => 'Создать новый бренд',
            'brends' => $brends,
        ))
        ->bind('errors', $errors);

        // Вывод в шаблон
        $this->template->page_title = 'Создать новый бренд';
        $this->template->block_center = array($content);
    }
    
    public function action_edit() {
                
        $id = (int) $this->request->param('id');
        
        if (isset($_POST['submit'])) 
        {
            $brendedit = ORM::factory('brend', $id);
            $data = Arr::extract($_POST, array('br_name'));
            //Убираем пробелы в начале и конце строки
            $data['br_name']=trim($data['br_name']);
            $brendedit->values($data);

            try 
            {
                $brendedit->save();    
            }
            catch (ORM_Validation_Exception $e) 
            {
                $errors = $e->errors('validation');
            }
        }
        
        //проверяем существование фото
        $file_img=$_SERVER['DOCUMENT_ROOT']."/media/foto/brends/$id.jpg";
        if (file_exists($file_img)) 
        {
            $foto = "<img border='0' src='/media/foto/brends/".$id.".jpg' />";
            $deletefoto = "<a href='/admin/brends/deletefoto/$id' title='Удалить фото'>
            <img border='0' src='/media_admin/img/delete-16.png' align='absmiddle'></a>";  
        } 
        else 
        {
            $foto = "<img border='0' src='/media_admin/img/nofoto.jpg' align='absmiddle' />";
            $deletefoto = "";   
        }
        
        $brends=$this->brend();
        $br = ORM::factory('brend', $id);
        $content = View::factory('admin/brends/v_brends_edit', array(
            'page_title' => 'Бренд - '.$br->br_name,
            'brends' => $brends,
            'foto' => $foto,
            'deletefoto' => $deletefoto,
            'br' => $br,
        ));

        // Вывод в шаблон
        $this->template->page_title = 'Редактрировать бренд';
        $this->template->block_center = array($content);
    }
    
    public function action_delete() {
        
        $id = (int) $this->request->param('id');
        $goods=ORM::factory('good')
            ->where('br_id', '=', $id)
            ->find_all();
            
        foreach($goods as $good)
        {
            echo"".$good->go_id." - ".$good->br_id."<br />";
            $good->set('br_id', 0)->save(); // Заменяем в таблице товаров где мыл этот бренд на пустое значение
        }
        
        $file_img=$_SERVER['DOCUMENT_ROOT']."/media/foto/brends/$id.jpg";
        if (file_exists($file_img)) 
        {
            unlink ($file_img);
        } 
        ORM::factory('brend', $id)->delete(); 
        HTTP::redirect('/admin/brends/'); //Перенаправляем на другую страницу
    }
    
    public function action_addfoto() {
        
        $id = (int) $this->request->param('id');
        //Загрузка фото
        $uploaddirs=$_SERVER['DOCUMENT_ROOT'].'/media/foto/brends/';
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
                $image->resize(200, 200);
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
        $uploaddirs=$_SERVER['DOCUMENT_ROOT'].'/media/foto/brends/';       
        $brends=$this->brend();
        $id = (int) $this->request->param('id');
        unlink($uploaddirs.$id.'.jpg');
        HTTP::redirect('/admin/brends/edit/'.$id); //Перенаправляем на другую страницу
    }

}