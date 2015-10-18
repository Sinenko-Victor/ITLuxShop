<?php defined('SYSPATH') or die('No direct script access.');

class Model_Catalog extends ORM {
    
    protected $_table_name = 'catalog';
    protected $_primary_key = 'ca_id';
    
    protected $_has_many = array(
        'good' => array(
            'model' =>  'good',
            'foreign_key' => 'ca_id',
        )
    );
    
    public function labels()
    {
         return array(
            'ca_name' => 'Название группы',
        );
    }
    
    public function rules()
    {
        return array(
            'ca_name' => array(
                array('not_empty'),
                array('min_length', array(':value', 1)),
                array('max_length', array(':value', 30)),
            )
        );
    }

} 