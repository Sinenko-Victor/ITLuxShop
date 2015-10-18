<?php defined('SYSPATH') or die('No direct script access.');

class Model_Ordergood extends ORM {
    
    protected $_table_name = 'ordergoods';
    
    protected $_belongs_to = array(
      'orders'    => array(
               'model'       => 'order',
               'foreign_key' => 'or_id',
           )
    );
    
    public function labels()
    {
        return array(
            'or_id' => 'Идентификатор заказа',
            'go_x' => 'Количество товаров',
            'go_name' => 'Название товара',
            'go_cost' => 'Цена',
        );
    }
    
    public function rules()
	{
		return array(
            'or_id' => array(
				array('not_empty'),
				array('digit'),
			),
			'go_x' => array(
				array('not_empty'),
				array('digit'),
			),
            'go_name' => array(
				array('not_empty'),
			),
            'go_cost' => array(
				array('not_empty'),
			),
		);
	}

}