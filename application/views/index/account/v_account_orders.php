<div id="pages_dir">
    <?php echo$menuaccaunt; ?>   
</div>
    <div id="pages_edit">
        <div id='formmain'>   
        
<h1>Заказы</h1>
<br/>

<table width="720">
    <thead>
        <tr height="30" >
            <th  width="50">№</th>
            <th width="130">Создан</th>
            <th width="100">Сатус</th>
            <th width="200">Доставка</th>
            <th width="150">Сумма</th>
            <td width="60"></td>
            <td width="30"></td>
        </tr>
    </thead>
    <?foreach ($orders as $order):?>
    <?php
    $cost=number_format($order->or_cost, 2, ',', ' '); //меняем точку на запятую
    $send=$sends[$order->se_id];
    $stat=$status[$order->st_id];
    if($order->st_id==0)
    {
        $cancel='<a href="/account/cancel/'.$order->or_id.'" title="Отменить заказ" ><img src="/media/img/delete-16.png" border="0"/></a>';
    }
    else
    {
        $cancel='';
    }
    $bgcolor='E0EFDF';
    if($order->st_id==3){$bgcolor='FFCC99';}
    if($order->st_id==4 || $order->st_id==5){$bgcolor='fab68c';}
    ?>
    <tr bgcolor="#<?=$bgcolor?>" onmouseover=this.style.backgroundColor="#99CC99" onmouseout=this.style.backgroundColor="#<?=$bgcolor?>">
        <td height="27" align="center"><?=$order->or_id?></td>
        <td align="left"><?=date('d.m.Y G:i',$order->or_create)?> </td>
        <td ><?=$stat?></td>
        <td ><?=$sends[$order->se_id]?></td>
        <td align="right"><span class="text_3"><?=$cost?></span><span class="text_1"> Грн. &nbsp;&nbsp;</span></td>
        <td bgcolor="#ffffff">
            <div id='buttona'><?=Html::anchor('/account/order/'.$order->or_id, '&nbsp;открыть&nbsp;', array('title' => 'Поcмотреть заказ подробнее'))?></div>
        </td>
        <td bgcolor="#ffffff"><?=$cancel?></td>
    </tr>
    <?endforeach?>
</table>
              
    
        </div>
    </div>
<div id="pages_footer">
</div>