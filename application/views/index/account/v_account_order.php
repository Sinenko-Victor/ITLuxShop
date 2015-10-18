<div id="pages_dir">
    <?php echo$menuaccaunt; ?>   
</div>
    <div id="pages_edit">
        <div id='formmain'>
    
        
<h1>Заказ № <?php echo$order->or_id; ?></h1>
<br/>
<?php
$or_cost=number_format($order->or_cost, 2, ',', ' '); //меняем точку на запятую
$stat=$status[$order->st_id]; //Статус заказа
?>
<table width="700" border="0" class="tbl"  cellspacing="0">
    <thead>
        <tr height="30" bgcolor="#cccccc">
            <th width="70"><span class="text_2">Код</span></th>
            <th width="380"><span class="text_2">Товар</span></th>
            <th width="50"><span class="text_2">Кол.</span></th>
            <th width="100"><span class="text_2">Цена</span></th>
            <th width="100"><span class="text_2">Сумма</span></th>
        </tr>
    </thead>
    <?php $products_all=0; ?>
    <?foreach ($goods as $good):?>
    <?php
    $cost=number_format($good->go_cost, 2, ',', ' '); //меняем точку на запятую
    $cost_line=number_format($good->go_x*$good->go_cost, 2, ',', ' '); //меняем точку на запятую
    $products_all=$products_all+$good->go_x;
    ?>
    <tr bgcolor="#E0EFDF" onmouseover=this.style.backgroundColor="#C3E0C2" onmouseout=this.style.backgroundColor="#E0EFDF">
        <td height="27" align="center"><?=$good->go_id?></td>
        <td ><span class="link_3"><?=Html::anchor('go/'.$good->go_id, $good->go_name)?></span></td>
        <td align="center"><span class="text_2"><?=$good->go_x?></span></td>
        <td align="right"><span class="text_3"><?=$cost?></span><span class="text_1"> Грн.</span>&nbsp;</td>
        <td align="right"><span class="text_3"><?=$cost_line?></span><span class="text_1"> Грн.</span>&nbsp;</td>
    </tr>
    <?endforeach?>
    <tr>
        <td height="20"></td>
        <td align="right" ><span class="text_2">Всего:</span></td>
        <td align="center" bgcolor="#cccccc"><span class="text_2"><?php echo$products_all; ?></span></td>
        <td align="right" ><span class="text_2">Итого:</span></td>
        <td align="right" bgcolor="#cccccc"><span class="text_3"><?=$or_cost?></span><span class="text_1"> Грн.</span>&nbsp;</td>
    </tr>
    <tr >
        <td height="30"></td>
    </tr>
    <tr >
        <td colspan="2" align="right">
            <span class="text_2">Телефон:</span>
        </td>
        <td colspan="3" align="left" bgcolor="#E0EFDF">
            <span class="text_3"><?php echo$order->or_tel; ?></span>
        </td>
    </tr>
    <tr >
        <td colspan="2" align="right">
            <span class="text_2">Доставка:</span>
        </td>
        <td colspan="3" align="left" bgcolor="#E0EFDF">
            <span class="text_3"><?=$send?></span>
        </td>
    </tr>
    <?php
    if($order->or_city!="" || $order->or_street!="")
    {
    ?>
    <tr >
        <td colspan="2" align="right">
            <span class="text_2">Адресс:</span>
        </td>
        <td colspan="3" align="left" bgcolor="#E0EFDF">
            <?php
            if($order->or_city!="")
            {
                echo'<span class="text_1">Город: '.$order->or_city.'</span><br/>';
            }
            if($order->or_street!="")
            {
                echo'<span class="text_1">Улица: '.$order->or_street.'</span>';
            }
            if($order->or_building!="")
            {
                echo'<span class="text_1">'.$order->or_building.'</span>';
            }
            if($order->or_building!="")
            {
                echo'<span class="text_1"> / '.$order->or_office.'</span><br/>';
            }
            ?>            
        </td>
    </tr>  
    <?php
    }
    if($order->or_data!="")
    {
    ?>
    <tr >
        <td colspan="2" align="right">
            <span class="text_2">Дополнительная информация:</span>
        </td>
        <td colspan="3" align="left" bgcolor="#E0EFDF">
            <span class="text_1"><?php echo$order->or_data; ?></span><br/>
        </td>
    </tr>
    <tr >
        <td colspan="2" align="right">
            <span class="text_2">Статус:</span>
        </td>
        <td colspan="3" align="left" bgcolor="#cccccc">
            <span class="text_3"><?=$stat?></span>
        </td>
    </tr> 
    <?php
    }
    ?>
</table>

              
    
        </div>
    </div>
<div id="pages_footer">
</div>