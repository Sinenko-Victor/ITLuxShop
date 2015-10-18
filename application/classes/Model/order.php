<?php defined('SYSPATH') or die('No direct script access.');

class Model_Order extends ORM {
    
    protected $_table_name = 'orders';
    protected $_primary_key = 'or_id';
    
    protected $_has_many = array(
        'ordergoods' => array(
            'model' =>  'ordergood',
            'foreign_key' => 'or_id',
        )
    );
    
    protected $_belongs_to = array(
      'send'    => array(
               'model'       => 'send',
               'foreign_key' => 'se_id',
           )
    );
    
    public function labels()
    {
        return array(
            'or_name' => 'Имя и фамилия',
            'or_email' => 'E-mail',
            'or_tel' => 'Телефон',
            'or_city' => 'Город',
            'or_street' => 'Улица',
            'or_building' => 'Номер дом',
            'or_office' => 'Номер квартиры/офиса',
            'or_data' => 'Дополнительная информация',
        );
    }
    
    public function rules()
	{
		return array(
            'or_name' => array(
				array('not_empty'),
				array('min_length', array(':value', 3)),
				array('max_length', array(':value', 50)),
			),
			'or_email' => array(
                array('min_length', array(':value', 4)),
				array('max_length', array(':value', 50)),
				array('email'),
			),
            'or_tel' => array(
				array('not_empty'),
                array('max_length', array(':value', 16)),
				array('phone'),
                
			),
            'or_city' => array(
				array('max_length', array(':value', 50)),
                array('regex', array(':value', '/^[-\pL\pN_.]++$/uD')),
			),
            'or_street' => array(
				array('max_length', array(':value', 50)),
                array('regex', array(':value', '/^[-\pL\ \pN_.]++$/uD')),
			),
            'or_building' => array(
				array('max_length', array(':value', 5)),
                array('regex', array(':value', '/^[-\pL\pN_.]++$/uD')),
			),
            'or_office' => array(
				array('max_length', array(':value', 5)),
                array('regex', array(':value', '/^[-\pL\pN_.]++$/uD')),
			),
            'or_data' => array(
				array('max_length', array(':value', 200)),
                array('regex', array(':value', '/^[-\pL\ \,\!\?\pN_.]++$/uD')),
			),
		);
	}
    
}