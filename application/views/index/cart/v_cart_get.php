<div id='formmain'>

<?php
$or_cost=number_format($order->or_cost, 2, ',', ' '); //меняем точку на запятую
?>
<h1><?php echo$order->or_name; ?>, Ваш заказ оформлен! </h1>

<span class="text_2">Номер заказа: № </span><span class="text_3"><?php echo$order->or_id; ?></span><br/>
<div id='tabl'>
<table width="800" >
    <tr>
        <th width="50"><div id='tablh'>Код</div></th>
        <th width="450"><div id='tablh'>Товар</div></th>
        <th width="50"><div id='tablh'>Кол.</div></th>
        <th width="100"><div id='tablh'>Цена, грн.</div></th>
        <th width="100"><div id='tablh'>Сумма</div></th>
        <td width="50"></td>
    </tr>
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
        <td align="center"><span class="text_3"><?=$cost?></span></td>
        <td align="center"><span class="text_3"><?=$cost_line?></span></td>
    </tr>
    <?endforeach?>
    <tr>
        <td></td>
        <td align="right" ><span class="text_2">Всего:</span></td>
        <td align="center" ><span class="text_2"><?php echo$products_all; ?></span></td>
        <td align="right" ><span class="text_2">Итого:</span></td>
        <td align="right"><span class="text_3"><?=$or_cost?></span></td>
        <td align="left"><span class="text_1"> Грн.</span></td>
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
    <?php
    }
    ?>
</table>
</div>
</div>

