<?php defined('SYSPATH') or die('No direct script access.');

class Model_Good extends ORM {
    
    protected $_table_name = 'goods';
    protected $_primary_key = 'go_id';
    
    protected $_belongs_to = array(
      'catalog'    => array(
               'model'       => 'catalog',
               'foreign_key' => 'ca_id',
           )
    );
    
    protected $_has_many = array(
        'images' => array(
            'model' =>  'image',
            'foreign_key' => 'go_id',
        )
    );
    
    public function labels()
    {
         return array(
            'go_name' => 'Название товара',
            'ca_id' => 'Название группы',
            'go_cost' => 'Цена',
        );
    }
    
    public function rules()
    {
        return array(
            'go_name' => array(
                array('not_empty'),
                array('min_length', array(':value', 1)),
                array('max_length', array(':value', 200)),
            )
        );
    }

} 
