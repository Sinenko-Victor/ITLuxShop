<br />

<?=Form::open('/admin/catalog/tab/'.$ca)?>
<?php echo$pagin; ?>
<div id='gotable'>    

<table width="830" border="0" class="tbl"  cellspacing="0">                           
    <tr>
        <td colspan="2">
            &nbsp;<a href='/admin/goods/new/<?php echo$ca; ?>' title='Создать товар'>[Создать]</a>      
        </td>
        <td align="center">
            <?php echo Form::select('brends', $sel_brend, $sel_br, array('onchange' => 'this.form.submit()', 'style' => 'font-size: 14px;')); ?>               
        </td>
        <td align="center" colspan="3">
            кол. товаров <?php echo$count_goods; ?> шт.           
        </td>                                        
    </tr>
    <tr height="30">
            <th width="50">Код</th>
            <th width="505">Название</th>
            <th width="100">Бренд</th>
            <th width="125" align="right">Цена, грн.</th>
            <th width="25"></th>
            <th width="25"></th>
    </tr>
    <?php
    foreach ($goods as $good):    
    ?>
    <tr bgcolor="#E0EFDF" onmouseover=this.style.backgroundColor="#C3E0C2" onmouseout=this.style.backgroundColor="#E0EFDF" >
        <td>
            &nbsp;<span class="text_2"><?php echo$good->go_id; ?></span>      
        </td>
        <td>
            &nbsp;<a href='/admin/goods/index/<?php echo$good->go_id; ?>' title='Открыть карточку товара'><?php echo$name[$good->go_id]; ?></a>   
        </td>
        <td align="center">
            <span class="text_2"><?php echo$brend_go[$good->go_id]; ?></span>           
        </td>
        <td align="right">
            <span class="text_3"><?php echo$cost[$good->go_id]; ?>&nbsp;</span>           
        </td>
        <td>
            <a href="<?php echo$linkok[$good->go_id]; ?>" title="<?php echo$titleok[$good->go_id]; ?>">
            <img src="<?php echo$imgok[$good->go_id]; ?>" /></a>          
        </td>
        <td>
            <a href='/admin/goods/delete/<?php echo$good->go_id; ?>' title='Удалить товар' onClick="return window.confirm('При нажатии &quot;ОК&quot; товар будут удален! Удалить?');">
            <img border='0' src='/media_admin/img/delete-16.png' align='absmiddle'></a>          
        </td>                                        
    </tr>
    <?php endforeach?>
</table>
<?php echo$pagin; ?>
</div>