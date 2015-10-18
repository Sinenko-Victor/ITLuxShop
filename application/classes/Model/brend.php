<?php defined('SYSPATH') or die('No direct script access.');

class Model_Brend extends ORM {
    
    protected $_table_name = 'brends';
    protected $_primary_key = 'br_id';
    
    protected $_has_many = array(
        'good' => array(
            'model' =>  'good',
            'foreign_key' => 'br_id',
        )
    );
    
    public function labels()
    {
        return array(
            'br_name' => 'Название бренда',
        );
    }
    
    public function rules()
	{
		return array(
            'br_name' => array(
				array('not_empty'),
				array('min_length', array(':value', 3)),
				array('max_length', array(':value', 50)),
                array(array($this, 'uniq_in'), array(':value', 'br_name')),
			),
		);
    }
    
    //Проверяем на уникальность в таблице вводимое заначение
    public function uniq_in($value, $field)
    {
        $page = ORM::factory($this->_object_name)
                ->where($field, '=', $value)
                ->and_where($this->_primary_key, '!=', $this->pk())
                ->find();
        
        if ($page->pk())
        {
            return false;
        }
        
        
        return true;
    }

} 
