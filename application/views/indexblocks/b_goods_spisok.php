<div id="cart">
<div id="go_spisok">
<table width="730" class="tabgreen">
<tr>
    <th width="70" height="25">Код</th>
    <th width="530">Найменование</th>
    <th width="100" align="right">Цена&nbsp;</th>
    <th width="30"></th>
</tr>
<?php
foreach ($goods as $good):
?>

<tr bgcolor='#E0EFDF' onmouseover=this.style.backgroundColor='#C3E0C2' onmouseout=this.style.backgroundColor='#E0EFDF'>
    <td align="center">
        <?php echo$good->go_id; ?>
    </td>
    <td align="left">
        <a href="/go/<?php echo$good->go_id; ?>/<?php echo$title[$good->go_id]; ?>">
        <?php echo$name[$good->go_id]; ?>
        </a><br />
        <span class='namebrend'><?php echo$brend_go[$good->go_id]; ?></span>
    </td>
    <td align="right">
        <?php echo$cost[$good->go_id]; ?>
    </td>
    <td align="center">
        <?php echo$cart[$good->go_id]; ?>
    </td>
</tr>


<?php endforeach?>
</table>
</div>
</div>