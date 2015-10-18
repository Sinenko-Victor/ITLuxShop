<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Import extends Controller_Admin {    
    
     public function action_index() {
        
        $errors = array();
        $num_file = array();
        $filedata = array();
        $uploaddirs = $_SERVER['DOCUMENT_ROOT'].'/media_admin/import/'; //Папка для хранения Файлов
        if(isset($_FILES['userfile']['name']))
        {            
            //Передаем в валидатор массив данных $_POST
            $valid = Validation::factory($_FILES)
                ->rule('userfile', 'Upload::valid')
                ->rule('userfile', 'Upload::size', array(':value', '5M'))
                ->rule('userfile', 'Upload::type', array(':value', array('xlsx')))
                ;
        
            if ($valid->check())
            {
                $uploaded = Upload::save($_FILES['userfile'], $_FILES['userfile']['name'], $uploaddirs, 0777); //Сохраняем файл на сервере
            }
            else
            {               
                $errors = $valid->errors('upload');  // Вывод ошибки                      
            }    
        }
        
        //Получаем данные о загруженных файлах на сервер
        $n=-2;
        if (is_dir($uploaddirs)) 
        {
            if ($dh = opendir($uploaddirs)) 
            {
                while (($file = readdir($dh)) !== false) 
                {
                    $n=$n+1;
                    if($file!="." && $file!="..")
                    {
                        $size=$size_=filesize($uploaddirs.$file);
                        if($size < 1024)
                        {$bayt_t=" Байт";}else{$size=number_format(($size/1024), 0); $bayt_t=" kБайт";}
                        if($size_ > 1024*1024)
                        {$size=number_format(($size_/(1024*1024)), 0); $bayt_t=" МБайт";}
                        $num_file[$n]=$n;
                        //Убераем разшерение в файле
                        $file_names=explode(".",$file);
                        $filedata[$n]['name']=$file_names[0];
                        $filedata[$n]['size']=$size." ".$bayt_t;
                    }
				}
                closedir($dh);
            }
        }				       
        
        //Передаем данные в представление
        $content = View::factory('admin/import/v_import_index', array(
            'page_title' =>'Импорт/Експорт',
            'errors' =>$errors,
            'num_file' =>$num_file,
            'filedats' =>$filedata,
        ));

        // Вывод в шаблон
        $this->template->page_title = 'Импорт/Експорт';
        $this->template->block_center = array($content);
    }
    
    public function action_del() {
        //Удаляем файл
        $uploaddirs = $_SERVER['DOCUMENT_ROOT'].'/media_admin/import/'; //Папка для хранения Файлов
        $del = $this->request->param('id');
        $del = $del.'.xlsx';
        //echo"del $del";
        if(@$del != "" && is_writable($uploaddirs.$del))
        {
            unlink ($uploaddirs.$del);
            HTTP::redirect('/admin/import'); //Перенаправляем на другую страницу
        }
    }
    
    public function action_run() {
        $errors = "";
        $uploaddirs = $_SERVER['DOCUMENT_ROOT'].'/media_admin/import/'; //Папка для хранения Файлов
        $run = $this->request->param('id');
        $file_run = $uploaddirs.$run.'.xlsx';
        if(@$run != "" && is_writable($file_run))
        {
            
            $query = DB::delete('catalog')->execute(); //Очистить таблицу
            $query = DB::delete('goods')->execute(); //Очистить таблицу
            $query = DB::delete('brends')->execute(); //Очистить таблицу
            require_once ('./lib/PHPExcel_1.7.9/Classes/PHPExcel/IOFactory.php');
            $objPHPExcel = PHPExcel_IOFactory::load($file_run);
            foreach ($objPHPExcel->getWorksheetIterator() as $worksheet)
            {
                $worksheetTitle     = $worksheet->getTitle(); //Имя таблици
                $highestRow         = $worksheet->getHighestRow(); // Количество строк
                $highestColumn      = $worksheet->getHighestColumn(); // например, 'F'
                $highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn); //Количество столбцов
                
                echo"<br/>-----------------<br/>
                Имя таблици $worksheetTitle <br/>Количество строк $highestRow <br/>например $highestColumn <br/>Количество столбцов $highestColumnIndex <br/><br/>";
                $nrColumns = ord($highestColumn) - 64;
                for ($row = 2; $row <= $highestRow; ++ $row)
                {
                    //Разбор по ячейкам
                    for ($col = 0; $col < $highestColumnIndex; ++ $col) 
                    {
                        $cell = $worksheet->getCellByColumnAndRow($col, $row);
                        $val = $cell->getValue();
                        //$val=htmlspecialchars(iconv("utf-8", "cp1251", $val)); //Содержимое ячейки 
                        $tabl[$col]=$val;
                    }
                    $tab_0=@$tabl[0]; 
                    $tab_1=@$tabl[1]; 
                    $tab_2=@$tabl[2]; 
                    $tab_3=@$tabl[3]; 
                    $tab_4=@$tabl[4]; 
                    $tab_5=@$tabl[5]; 
                    $tab_6=@$tabl[6]; 
                    $tab_7=@$tabl[7]; 
                    $tab_8=@$tabl[8];
                    //$numb=$row-1;
                    echo"$tab_0 | $tab_1 | $tab_2 | $tab_3 | $tab_4 | $tab_5 | $tab_6 <br>";
                    
                    //Добавляем данные в таблизу каталока
                    if($worksheetTitle == 'catalog' and $tab_1 != "" and $tab_2 != ""){
                        ORM::factory('catalog')
                            ->set('ca_id', $tab_1)
                            ->set('ca_name', $tab_2)
                            ->set('ca_father', $tab_0)
                            ->save();
                    }
                    
                    //Добавляем данные в таблизу товаров
                    if($worksheetTitle == 'tovar' and $tab_1 != "" and $tab_2 != ""){
                        ORM::factory('good')
                            ->set('go_id', $tab_1)
                            ->set('ca_id', $tab_0)
                            ->set('go_name', $tab_2)
                            ->set('go_cost', $tab_3)
                            ->set('go_text', $tab_4)
                            ->set('br_id', $tab_5)
                            //->set('go_rek', $rek)
                            //->set('go_best', $best)
                            ->save();
                    }
                    
                    //Добавляем данные в таблизу брендов
                    if($worksheetTitle == 'brend' and $tab_0!="" and $tab_1!=""){
                        ORM::factory('brend')
                            ->set('br_id', $tab_0)
                            ->set('br_name', $tab_1)
                            ->save();
                    }
                    

                }
            }           
        }
        
        
        
        //------------------------- Создаем файл sitemap.xml
        if($errors=="")
        {
            //Создаем файл sitemap.xml
            $filename = 'sitemap.xml';
            //Проверяем существование файла
            if (file_exists($filename))
            {   
                rename($filename, "sitemap_old.xml"); //перейменовываем файл
            } 
        
//Создаем текст для sitemap.xml 
$host=$_SERVER['HTTP_HOST'];
$mytext='<?xml version="1.0" encoding="UTF-8"?>
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
$ca='';
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

$mytext=$mytext.$ca.$go.'
</urlset>';

            $fp = fopen($filename, 'wt'); // Текстовый режим
            $test = fwrite($fp, $mytext); // Запись в файл
            fclose($fp); //Закрытие файла

            HTTP::redirect('/admin/catalog'); //Перенаправляем на другую страницу
        }
        else
        {
            $errors="<h2>Загрузка товаров в базу данных произошла с ошибкой!</h2> <br />".$errors;
            //Передаем данные в представление
            $content = View::factory('admin/import/v_import_error', array(
                'page_title' =>'Импорт/Експорт',
                'errors' =>$errors,
            ));

            // Вывод в шаблон
            $this->template->page_title = 'Импорт/Експорт';
            $this->template->block_center = array($content);
        }  
        
        //------------------------- / Создаем файл sitemap.xml
        
        HTTP::redirect('/admin/catalog'); //Перенаправляем на другую страницу
    }
}