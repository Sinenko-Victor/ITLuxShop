<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Indexblocks_Footer extends Controller_Base {

    public $template = 'indexblocks/b_footer';
    
    public function action_index()
    {
        $topmenu = ORM::factory('page')->where('pg_father', '=', 1)->find_all();
        $this->template->topmenu = $topmenu;
    }

}