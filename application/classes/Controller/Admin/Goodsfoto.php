<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Goodsfoto extends Controller_Admin {    
    
     public function before() {
        parent::before();

        // Вывод в шаблон
        $this->template->styles[] = 'lib/xtree/style.css';
        $this->template->scripts[] = 'lib/xtree/common.js';
        $this->template->page_title = 'Фото товаров';    
    }
     
     public function action_index() {
        // Виджеты
        $action = $this->request->action(); //Получаем текуший єкшен
        $menuset = Request::factory('adminblocks/Menufoto/'.$action)->execute();
        
        $goods = ORM::factory('good')->where('img_id', '>', 0)->order_by('go_name')->find_all();
        
        foreach($goods as $good)
        {
            $mainfoto[$good->go_id] = $this->okfoto($good->go_id,$good->img_id);
            //Определяем есть ли дополнительные фото
            $additfoto[$good->go_id] = '';
            $additionals_count = ORM::factory('image')->where('go_id', '=', $good->go_id)->count_all();
            if($additionals_count > 1)
            {                
                $additionals = ORM::factory('image')->where('go_id', '=', $good->go_id)->find_all();
                
                foreach($additionals as $additional)
                {                    
                    if($additional->img_id != $good->img_id)
                    {
                        $additfoto[$good->go_id] .= $this->okfoto($good->go_id,$additional->img_id)." ";
                    }  
                }
            }
            $foto_in[$good->go_id] = $this->foto_in($good->go_id); 
        }
        
        
        $content = View::factory('admin/goodsfoto/v_goodsfoto_index', array(
            'page_title' => 'Фото товаров :: в каталоге',
            'menuset' => $menuset,
            'goods' => $goods,
            'mainfoto' => $mainfoto,
            'additfoto' => $additfoto,
            'foto_in' => $foto_in,
        ));

        // Вывод в шаблон
        $this->template->page_title = 'Фото товаров';
        $this->template->block_center = array($content);
    }
    
    public function action_in() {
        // Виджеты
        $action = $this->request->action(); //Получаем текуший єкшен
        $menuset = Request::factory('adminblocks/Menufoto/'.$action)->execute();
        
        $dirfoto_1c = $this->dir_gofoto_1c;
        if (is_dir($dirfoto_1c)) 
        {
            $dir_1c = opendir($dirfoto_1c);
            while($foto_1c = readdir($dir_1c ))
            {
                if($foto_1c != "." && $foto_1c != "..") 
                {
                    if(ORM::factory('good')->where('go_id', '=', $foto_1c)->count_all() > 0)
                    {
                        $inbase[$foto_1c] = '<a href="/admin/goodsfoto/movefoto/'.$foto_1c.'">
                        <img border="0" src="/media_admin/img/plus-1-16.png" align="absmiddle" />
                        Добавить</a>';
                    }
                    else
                    {
                        $inbase[$foto_1c] = '<a href="/admin/goodsfoto/deletefoto/'.$foto_1c.'" title ="Удалить папку с фото">
                        <img border="0" src="/media_admin/img/delete-16.png" align="absmiddle" />
                        Удалить
                        </a>';
                    }
                    
                    //Проверяем наличие фото
                    if (is_dir($dirfoto_1c.$foto_1c)) 
                    {
                        $goods[$foto_1c] = $foto_1c;
                        
                        $dir_1c_go = opendir($dirfoto_1c.$foto_1c);
                        $mainfoto[$foto_1c] = '';
                        $otherfoto[$foto_1c] = '';
                        while($file_go = readdir($dir_1c_go))
                        {
                            if($file_go != "." && $file_go != "..") 
                            {
                                
                                if( $file_go == $foto_1c.'_1.jpg')
                                {
                                    $mainfoto[$foto_1c] = $file_go;
                                }
                                else
                                {
                                    
                                    $otherfoto[$foto_1c] .= $file_go.", ";
                                }
                            }
                        }
                    }
                    else
                    {
                        unlink ($dirfoto_1c.$foto_1c); //Если это не папка а файл то удаляем
                    }
                }
            }
        } 
        
        $content = View::factory('admin/goodsfoto/v_goodsfoto_in', array(
            'page_title' => 'Фото товаров :: в папке 1С',
            'menuset' => $menuset,
            'goods' => $goods,
            'inbase' => $inbase,
            'mainfoto' => $mainfoto,
            'otherfoto' => $otherfoto,

        ));

        // Вывод в шаблон
        $this->template->page_title = 'Фото товаров';
        $this->template->block_center = array($content);
    }
    
    
    public function action_noconect() {
        // Виджеты
        $action = $this->request->action(); //Получаем текуший єкшен
        $menuset = Request::factory('adminblocks/Menufoto/'.$action)->execute();
        
        // Виджеты
        $action = $this->request->action(); //Получаем текуший єкшен
        $menuset = Request::factory('adminblocks/Menufoto/'.$action)->execute();
        
        $goods = array();
        $inbase = array();
        $mainfoto = array();
        $otherfoto = array();
        
        $dirfoto_1c = $this->dir_gofoto_1c;
        if (is_dir($dirfoto_1c)) 
        {
            $dir_1c = opendir($dirfoto_1c);
            while($foto_1c = readdir($dir_1c ))
            {
                if($foto_1c != "." && $foto_1c != "..") 
                {
                    if(ORM::factory('good')->where('go_id', '=', $foto_1c)->count_all() == 0)
                    {
                        $inbase[$foto_1c] = '<a href="/admin/goodsfoto/deletefoto/'.$foto_1c.'" title ="Удалить папку с фото">
                        <img border="0" src="/media_admin/img/delete-16.png" align="absmiddle" />
                        удалить
                        </a>';

                        //Проверяем наличие фото
                        if (is_dir($dirfoto_1c.$foto_1c)) 
                        {
                            $goods[$foto_1c] = $foto_1c;
                            $dir_1c_go = opendir($dirfoto_1c.$foto_1c);
                            $mainfoto[$foto_1c] = '';
                            $otherfoto[$foto_1c] = '';
                            while($file_go = readdir($dir_1c_go))
                            {
                                if($file_go != "." && $file_go != "..") 
                                {
                                    if( $file_go == $foto_1c.'_1.jpg')
                                    {
                                        $mainfoto[$foto_1c] = $file_go;
                                    }
                                    else
                                    {           
                                        $otherfoto[$foto_1c] .= $file_go.", ";
                                    }
                                }
                            }
                        }
                        else
                        {
                            unlink ($dirfoto_1c.$foto_1c); //Если это не папка а файл то удаляем
                        }
                    }
                }
            }
        } 
        
        $content = View::factory('admin/goodsfoto/v_goodsfoto_noconect', array(
            'page_title' => 'Фото товаров :: не привязаны к товарам',
            'menuset' => $menuset,
            'goods' => $goods,
            'inbase' => $inbase,
            'mainfoto' => $mainfoto,
            'otherfoto' => $otherfoto,

        ));

        // Вывод в шаблон
        $this->template->page_title = 'Фото товаров не привязаны к товарам';
        $this->template->block_center = array($content);
    }
    
    //Добавить фото из папки goods_1c в папку goods
    public function action_movefoto() {
        
        $id = (int) $this->request->param('id');
        $run = $this->move_1c_foto($id);
        $ref = getenv("HTTP_REFERER");
        HTTP::redirect($ref); //Перенаправляем на другую страницу
    }
    
    //Добавить все фото из папки goods_1c в папку goods
    public function action_movefotos() {
        
        $dirfoto_1c = $this->dir_gofoto_1c;
        if (is_dir($dirfoto_1c)) 
        {
            $dir_1c = opendir($dirfoto_1c);
            while($foto_1c = readdir($dir_1c ))
            {
                if($foto_1c != "." && $foto_1c != "..") 
                {
                    if(ORM::factory('good')->where('go_id', '=', $foto_1c)->count_all() > 0)
                    {
                        //Проверяем наличие фото
                        if (is_dir($dirfoto_1c.$foto_1c)) 
                        {
                            $run = $this->move_1c_foto($foto_1c);
                        }
                        else
                        {
                            unlink ($dirfoto_1c.$foto_1c); //Если это не папка а файл то удаляем
                        }
                    }
                }
            }
        } 

        $ref = getenv("HTTP_REFERER");
        HTTP::redirect($ref); //Перенаправляем на другую страницу
    }
    
    //Удалить папку с фото из папки goods_1c
    public function action_deletefoto() {
        
        $id = $this->request->param('id');
        $run = $this->delete_1c_foto($id);
        $ref = getenv("HTTP_REFERER");
        HTTP::redirect($ref); //Перенаправляем на другую страницу
    }
    
    //Удалить все папки с фото из папки goods_1c которых нет в таблице товаров
    public function action_deletefotos() {
        
        $dirfoto_1c = $this->dir_gofoto_1c;
        if (is_dir($dirfoto_1c)) 
        {
            $dir_1c = opendir($dirfoto_1c);
            while($foto_1c = readdir($dir_1c ))
            {
                if($foto_1c != "." && $foto_1c != "..") 
                {
                    if(ORM::factory('good')->where('go_id', '=', $foto_1c)->count_all() == 0)
                    {
                        $run = $this->delete_1c_foto($foto_1c);
                    }
                }
            }
        } 
        
        $ref = getenv("HTTP_REFERER");
        HTTP::redirect($ref); //Перенаправляем на другую страницу
    }
    
    //----------------------- FUNCTION --------------------------
    
    //Добавить фото из папки goods_1c в папку goods
    public function move_1c_foto($id) {
        
        $dirfoto_1c = $this->dir_gofoto_1c.$id;
        $uploaddirs = $this->dir_gofoto.$id.'/';
        
        //Если папка не существует то создаем
        if (!is_dir($uploaddirs))
        {
            mkdir($uploaddirs, 0755);
        }
        
        //Удаляем данные из базы главное фото
        ORM::factory('good', $id)->values(array('img_id' => NULL))->save();
        
        //Удаляем данные из базы дополнительные фото
        $imgs = ORM::factory('image')->where('go_id', '=', $id)->find_all();
        foreach($imgs as $img)
        {
            ORM::factory('image', $img->img_id)->delete();         
        }
        
        //Удаляем все файлы что есть в данной папке
        $op_dir = opendir($uploaddirs);
        while($file=readdir($op_dir ))
        {
            if($file != "." && $file != "..") 
            {
                unlink ($uploaddirs.'/'.$file);
            }
        }
        
        if (is_dir($dirfoto_1c)) 
        {
            $dir_1c = opendir($dirfoto_1c);
            $main_foto = "";
            $endfoto = "";
            while($foto_1c = readdir($dir_1c ))
            {
                if($foto_1c != "." && $foto_1c != "..") 
                {                    
                    //Добавляем в базу инфу о фото
                    ORM::factory('image')->values(array('go_id' => $id))->save();
                    //Определяем  ID добавленного фото
                    $newimg = ORM::factory('image')->where('go_id', '=', $id)->order_by('img_id', 'desc')->limit(1)->find();
                    $newimgid = $newimg->img_id; // ID нового фото
                    $endfoto = $newimgid;
                    
                    //Добавить данные в базу главное фото
                    if($foto_1c == $id.'_1.jpg')
                    {
                        $main_foto = $newimgid;  
                    }

                    $image = Image::factory($dirfoto_1c."/".$foto_1c); // Загружаем изображение
                    $image->resize(800, 800); // Меняем размеры
                    $image->save($uploaddirs.$newimgid.'.jpg');
                    $image->resize(200, 200); // Меняем размеры
                    $image->save($uploaddirs.$newimgid.'_.jpg'); // Сохраняем превью
                }
            }
            if($main_foto  != "")
            {
                $goodsseve = ORM::factory('good', $id)->values(array('img_id' => $main_foto))->save();
            }
            elseif($main_foto  == "" and $endfoto != "")
            {
                $goodsseve = ORM::factory('good', $id)->values(array('img_id' => $endfoto))->save();
            }
            else
            {
                $goodsseve = ORM::factory('good', $id)->values(array('img_id' => NULL))->save();
            }
            
        }
    }
    
    //Добавить фото из папки goods_1c в папку goods
    public function delete_1c_foto($id) {
        
        $dirfoto_1c = $this->dir_gofoto_1c.$id;
        if (is_dir($dirfoto_1c)) 
        {
            $op_dir = opendir($dirfoto_1c);
            while($file = readdir($op_dir ))
            {
                if($file != "." && $file != "..") 
                {
                    unlink ($dirfoto_1c.'/'.$file);
                }
            }
            rmdir ($dirfoto_1c);
        }
    }

}

?>