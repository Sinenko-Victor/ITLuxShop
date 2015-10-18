<?php defined('SYSPATH') or die('No direct script access.');

class Model_Image extends ORM {
    
    protected $_table_name = 'images';
    protected $_primary_key = 'img_id';
    
    protected $_belongs_to = array(
      'good'    => array(
               'model'       => 'good',
               'foreign_key' => 'go_id',
           )
    );
    
    public function labels()
    {
        return array(
            'img_id' => 'Идентификатор фото',
            'img_dir' => 'Путь к фото',
            'go_id' => 'Идентификатор товара',
        );
    }

}