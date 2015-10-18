<div id="pages_list">
    <div id="pages_header">
        <h1>Покупатели</h1>
    </div>
    <div>
    
<br/>          
<table width="1100" border="1"  cellspacing="0" style="margin: 0px auto;">
    <thead>
        <tr height="30" bgcolor="#2f8be8">
            <th  width="275"><span class="link_5"><a href="/admin/users" title="Сортировка по имеи">Имя</a></span></th>
            <th width="150"><span class="link_5"><a href="/admin/users/index/1" title="Сортировка по логину">Логин</a></span></th>
            <th width="180"><span class="link_5"><a href="/admin/users/index/2" title="Сортировка по городу">Город</span></th>
            <th width="125"><span class="link_5"><a href="/admin/users/index/3" title="Сортировка по телефону">Телефон</a></span></th>
            <th width="190"><span class="link_5"><a href="/admin/users/index/4" title="Сортировка по E-mail">E-mail</a></span></th>
            <th width="150"><span class="link_5"><a href="/admin/users/index/6" title="Сортировка по входу">Последний вход</a></span></th>
            <th width="25" bgcolor="#ffffff"></th>
        </tr>
    </thead>
    <?foreach ($users as $user):
    if($user->status == 1)
    {$usstat='<img src="/media/img/ok-1-16.png" border="0"/>';}
    else
    {$usstat='';}
    ?>
    <tr bgcolor="#E0EFDF" onmouseover='this.style.backgroundColor="#C3E0C2"' onmouseout='this.style.backgroundColor="#E0EFDF"'>
        <td height="27" align="left">
            &nbsp;&nbsp;<span class="link_4"><?=Html::anchor('/admin/users/edit/'.$user->id, $user->first_name, array('title' => 'подробнее о покупателе'))?></span>
        </td>
        <td align="left">
            &nbsp;&nbsp;<span class="text_4"><?=$user->username?></span>
        </td>
        <td align="center">
            &nbsp;<span class="text_4"><?=$user->city?></span>
        </td>
        <td align="left">
            &nbsp;&nbsp;<span class="text_4"><?=$user->tel?></span> 
        </td>
        <td>
            &nbsp;&nbsp;<span class="text_4"><?=$user->email?> </span>&nbsp;<?=$usstat?> 
        </td>
        <td >
            &nbsp;&nbsp;<span class="text_4"><?=date('d.m.Y G:i',$user->last_login)?></span>
        </td>
        <td bgcolor="#ffffff" align="right">
            <a href="/admin/users/del/<?php echo$user->id; ?>" title="Удалить покупателя" >
            <img src="/media/img/delete-16.png" border="0"/></a>
        </td>
    </tr>
    <?endforeach?>
</table>
   
    </div>
    <div id="pages_footer">
    </div>
</div>