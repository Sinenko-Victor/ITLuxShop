<?php defined('SYSPATH') or die('No direct script access.');

class Model_Page extends ORM {
    
    protected $_table_name = 'pages';
    protected $_primary_key = 'pg_id';
    
    protected $_has_many = array(
        'pageimgs' => array(
            'model' =>  'pageimg',
            'foreign_key' => 'pg_id',
        )
    );
    
    public function rules()
    {
        return array(
            'pg_name' => array(
                array('not_empty'),
                array('min_length', array(':value', 3)),
                array('max_length', array(':value', 30)),
                //array(array($this, 'uniq_alias'), array(':value', ':field')),
            ),
            'pg_alias' => array(
                array('not_empty'),
                array('min_length', array(':value', 3)),
                array('max_length', array(':value', 50)),
                array(array($this, 'uniq_alias'), array(':value', ':field')),                
            ),
            'pg_title' => array(
                array('not_empty'),
                array('min_length', array(':value', 3)),
                array('max_length', array(':value', 50))                
            ),
            'pg_text' => array(
                array('max_length', array(':value', 50000))
            )
        );
    }
    
    public function labels()
    {
         return array(
            'pg_alias' => 'Алиас',
            'pg_name' => 'Название',
            'pg_title' => 'Титле',
            'pg_text' => 'Содержание'
        );
    }
    
    public function filters()
    {
        return array(
            //Удаляет пробелы (или другие символы) из начала и конца строки
            TRUE => array(
                array('trim'),
            ),
            //Удаляет HTML и PHP тэги из строки
            'title' => array(
                array('strip_tags'),
            ),
        );
    }
    
    //Проверяем на уникальность в таблице вводимое заначение
    public function uniq_alias($value, $field)
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