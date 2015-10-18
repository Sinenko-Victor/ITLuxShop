<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Searchgo extends Controller {  
    
    public function action_index(){
        
        $search = $this->request->param('search');
        //echo"Поиск (".$search.")<br />";
        
        $goods = ORM::factory('good')
            ->or_where('go_id','like', '%'.$search.'%')
            ->or_where('go_name','like', '%'.$search.'%')
            ->where('go_ok', '=', 1)
            ->order_by('go_name')
            ->limit(50)
            ->find_all();
        
        echo'<div id="searchgo">';
        foreach($goods as $good)
        {
            echo'<span class="link_3"><a href="/go/'.$good->go_id.'">['.$good->go_id.'] '.$good->go_name.'</a></span><br />';
        }
        echo"</div>";
    }

}