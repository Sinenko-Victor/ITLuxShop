<?php defined('SYSPATH') or die('No direct script access.');

class Model_Seting extends ORM {
    
    protected $_table_name = 'setings';
    protected $_primary_key = 'set_id';
    
    public function rules()
	{
		return array(
            'set_name' => array(
				array('not_empty'),
				array('min_length', array(':value', 1)),
				array('max_length', array(':value', 50)),
			),
            'set_data' => array(
				array('max_length', array(':value', 200)),
			),
		);
	}

} 