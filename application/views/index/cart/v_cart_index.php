<?if (count($products) > 0):?>

<div id='formmain'>
<h1>Корзина</h1>
<br/>
<?=Form::open('/cart/count')?>
    <table class="tabgreen">
        <tr>
            <td width="10"></td>
            <th width="70">Код</th>
            <th width="500">Найменование</th>
            <th width="0">Кол.</th>
            <th width="100" align="right">Цена&nbsp;</th>
            <th width="100">Всего</th>
            <td bgcolor="#ffffff"></td>
        </tr>
    
        <?$n=0; foreach ($products as $product):?>
        <?php
        $cost = number_format($product->go_cost, 2, ',', ' '); //меняем точку на запятую
        $cost_line = number_format($product->go_cost * $products_s[$product->go_id], 2, ',', ' '); //меняем точку на запятую
        $n += 1;
        ?>
        <tr bgcolor='#E0EFDF' onmouseover=this.style.backgroundColor='#C3E0C2' onmouseout=this.style.backgroundColor='#E0EFDF'>
            <td bgcolor='#ffffff'><?=$n?>.</td>
            <td align="center">
                <?=$product->go_id?>
            </td>
            <td align='left'>
                <a href='/go/<?=$product->go_id?>/' target='_blank' title='Подробнее о товаре'><?=$product->go_name?></a><br />
                <span class='namebrend'><?php echo$brend_go[$product->go_id]; ?></span>
            </td>
            <td align="left">
                <?=Form::input('go_count['.$product->go_id.']', $products_s[$product->go_id], array('size' => 3, 'placeholder' => 'Введите количество'))?>
            </td>
            <td align="right"><?=$cost?>&nbsp;</td>
            <td align="right"><?=$cost_line?> грн.&nbsp;</td>
            <td align="center" bgcolor="#FFFFFF">
                <a href="/cart/del/<?php echo$product->go_id; ?>" title="Удалить товар" >
                <img src="/media/img/delete-16.png" border="0"/></a>
            </td>
        </tr>
        <?endforeach?>
                
        <tr>
            <td height='20' align="right" colspan="3">Всего: </td>
            <td align="left"><?php echo$products_all; ?></td>
            <td align="right" >Итого:</td>
            <td align="right" ><?=$products_cost?> грн.&nbsp;</td>
        </tr>      
    </table>
     
    <br /><br />
    <?=Form::submit('submit', ' Пересчитать ', array('class' => 'submit'))?>
    <?=Form::close()?>
    <br />
    <?=Form::open('cart/order')?>
    <?=Form::submit('post', 'Оформить заказ', array('class' => 'form_in_submit'))?>
    <?=Form::close()?>
</div>







<br/>
</div>
    

<?else:?>
    <div class="empty">Нет товаров в корзине</div>
<?endif?>