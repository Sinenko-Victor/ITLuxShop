<?php defined('SYSPATH') or die('No direct script access.');

class Model_Send extends ORM {
    
    protected $_table_name = 'sends';
    protected $_primary_key = 'se_id';
    
    protected $_has_many = array(
        'order' => array(
            'model' =>  'order',
            'foreign_key' => 'or_send',
        )
    );

}