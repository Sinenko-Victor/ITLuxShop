<?php defined('SYSPATH') or die('No direct script access.');

class Model_Statu extends ORM {
    
    protected $_table_name = 'status';
    protected $_primary_key = 'st_id';
    
    protected $_has_many = array(
        'order' => array(
            'model' =>  'order',
            'foreign_key' => 'st_id',
        )
    );

}