<?php defined('SYSPATH') or die('No direct script access.');

class Model_User extends Model_Auth_User {    
    
    public function labels()
    {
        return array(
            'username' => 'Логин',
            'email' => 'E-mail',
            'first_name' => 'Имя и фамилия',
            'password' => 'Пароль',
            'tel' => 'Телефон',
            'city' => 'Город',
            'street' => 'Улица',
            'building' => 'Номер дом',
            'office' => 'Номер квартиры/офиса',
            'data' => 'Дополнительная информация',
        );
    }
    
    public function rules()
	{
		return array(
			'username' => array(
				array('not_empty'),
				array('min_length', array(':value', 4)),
				array('max_length', array(':value', 50)),
				array('regex', array(':value', '/^[-\pL\pN_.]++$/uD')),
				array(array($this, 'unique'), array('username', ':value')),
			),
            'first_name' => array(
				array('not_empty'),
				array('min_length', array(':value', 3)),
				array('max_length', array(':value', 50)),
			),
			'email' => array(
				array('not_empty'),
				array('min_length', array(':value', 4)),
				array('max_length', array(':value', 50)),
				array('email'),
				array(array($this, 'uniq_in'), array(':value', 'email')),
			),
            'tel' => array(
                array('not_empty'),
				array('max_length', array(':value', 16)),
				array('phone'),
			),
            'city' => array(
				array('max_length', array(':value', 50)),
                array('regex', array(':value', '/^[-\pL\pN_.]++$/uD')),
			),
            'street' => array(
				array('max_length', array(':value', 100)),
                array('regex', array(':value', '/^[-\pL\ \pN_.]++$/uD')),
			),
            'building' => array(
				array('max_length', array(':value', 5)),
                array('regex', array(':value', '/^[-\pL\pN_.]++$/uD')),
			),
            'office' => array(
				array('max_length', array(':value', 5)),
                array('regex', array(':value', '/^[-\pL\pN_.]++$/uD')),
			),
            'data' => array(
				array('max_length', array(':value', 200)),
                array('regex', array(':value', '/^[-\pL\ \,\!\?\pN_.]++$/uD')),
			),
			'password' => array(
				array('not_empty'),
                array('min_length', array(':value', 6)),
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