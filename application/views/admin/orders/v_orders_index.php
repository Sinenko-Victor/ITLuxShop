<div id="pages_list">
    <div id="pages_header">
        <h1>Заказы</h1>
    </div>
    <div>
<br/>
<?=Form::open('/admin/orders/index/'.$id)?>          
<table width="950" border="0"  cellspacing="0" style="margin: 0px auto;">
    <thead>
        <tr height="30" bgcolor="#cccccc">
            <th  width="50"><span class="text_2">№</span></th>
            <th width="130"><span class="text_2">Создан</span></th>
            <th width="100"><span class="text_2">Сатус</span></th>
            <th width="150"><span class="text_2">Сумма</span></th>
            <th width="200"><span class="text_2">Покупатель</span></th>
            <th width="200"><span class="text_2">Доставка</span></th>
            <th width="60" bgcolor="#ffffff"></th>
            <th width="60" bgcolor="#ffffff"></th>
        </tr>
    </thead>
    <?foreach ($orders as $order):?>
    <?php
    $cost=number_format($order->or_cost, 2, ',', ' '); //меняем точку на запятую
    $send=$sends[$order->se_id];
    $stat=$status[$order->st_id];
    if($order->st_id != 5)
    {
        $del_img=Html::image('/media_admin/img/delete.gif',array('title' => 'Удалить заказ')); //формируем изображение
        $del_order=Html::anchor('/admin/orders/del/'.$order->or_id, $del_img); //Формируем ссылку    
    }
    else
    {
        $del_order='';
    }
    
    $bgcolor='E0EFDF';
    if($order->st_id==3){$bgcolor='6aa667';}
    if($order->st_id==4 || $order->st_id==5){$bgcolor='fab68c';}
    ?>
    <tr bgcolor="#<?=$bgcolor?>" onmouseover=this.style.backgroundColor="#cccccc" onmouseout=this.style.backgroundColor="#<?=$bgcolor?>">
        <td height="27" align="center"><span class="text_1"><?=$order->or_id?></span></td>
        <td align="left"><span class="text_4"><?=date('d.m.Y G:i',$order->or_create)?> </span></td>
        <td>
            <?php echo Form::select('or_status['.$order->or_id.']', $status, $order->st_id); ?> 
        </td>
        <td align="right"><span class="text_3"><?=$cost?></span><span class="text_1"> Грн. &nbsp;&nbsp;</span></td>
        <td align="left"><span class="text_3"><?=$order->or_name?></span></td>
        <td ><?=$sends[$order->se_id]?></td>
        <td bgcolor="#ffffff">
            <div id='buttona'><?=Html::anchor('/admin/order/index/'.$order->or_id, '&nbsp;открыть&nbsp;', array('title' => 'Поcмотреть заказ подробнее'))?></div>
        </td>
        <td bgcolor="#ffffff"> <?=$del_order?></td>
    </tr>
    <?endforeach?>
    <tr>
        <td></td><td></td><td align="centr"><br/><?=Form::submit('submit', ' Сохранить ')?> </td>
    </tr>
</table>
<?=Form::close()?>
   
    </div>
    <div id="pages_footer">
    </div>
</div>