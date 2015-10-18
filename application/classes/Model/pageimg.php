<?php defined('SYSPATH') or die('No direct script access.');

class Model_Pageimg extends ORM {
    
    protected $_table_name = 'pageimgs';
    protected $_primary_key = 'pi_id';
    
    protected $_belongs_to = array(
      'pages'    => array(
               'model'       => 'page',
               'foreign_key' => 'pg_id',
           )
    );
    
    public function labels()
    {
        return array(
            'pi_id' => 'Идентификатор фото',
            'img_dir' => 'Путь к фото',
            'pg_id' => 'Идентификатор страници',
        );
    }

}