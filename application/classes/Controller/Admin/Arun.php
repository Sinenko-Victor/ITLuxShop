<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Arun extends Controller_Admin {
    
    public function action_run() {
        
        echo"ARUN";
        $ref=getenv("HTTP_REFERER");
        $br = $this->request->param('br');
        $id = $this->request->param('id');
        $param = (int) $this->request->param('param');
        
        echo"| $br | $id | $param";
        
        //Добавляем товар в группу рекомендуемые
        if($br == 'add' AND $id == 'ok' AND $param >0)
        {
            ORM::factory('good', $param)->values(array('go_ok' => 1))->save();
        }
        
        //Удаляем товар в группу рекомендуемые
        if($br == 'delete' AND $id == 'ok' AND $param >0)
        {
            ORM::factory('good', $param)->values(array('go_ok' => 0))->save();
        }
        
        HTTP::redirect($ref);
    }
    
     

} //End Controller_Index_Ca