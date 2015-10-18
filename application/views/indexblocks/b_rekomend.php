<div class="catalog_tiles">
<div class="catalog_tiles_in">
<div id="cart">

<?php
foreach($goods_rek as $rek) //Создаем масивы
{
?>


<div class="catalog_tile_item">
<div class="catalog_tile_item_in2">
<div class="cti">
<div class="cti_in">
 
    <div class="cti_image">
        <center>
            <a href="/go/<?php echo$rek->go_id; ?>">
                <img border="0" title="<?php echo$rekomed['name'][$rek->go_id]; ?>" src="/goodimg/<?php echo$rekomed['img'][$rek->go_id];; ?>/1/200/200" />            </a>
        </center>
    </div>
        <div class="cti_head"><a href="/go/<?php echo$rek->go_id; ?>"><?php echo$rekomed['name'][$rek->go_id]; ?></a></div>
    <div class="cti_info">
        Код товара: <span class="cti_kod"><?php echo$rek->go_id; ?></span>
    </div>
    <div class="cti_ost">
        
    </div>
    <div class="cti_end">
        <div class="cti_end_l">
            <div class="cti_price">
                <span class="end"><?php echo$rekomed['cost'][$rek->go_id]; ?></span>
                <span class="grn">грн.</span>
            </div>
        </div>
        <a data-id="<?php echo$rek->go_id; ?>" title="Добавить в корзину"><img src="/media/img/cart_big.gif" border="0"/></a>
    </div>
</div>
</div>
</div>
</div>


<?php
}

?>
        
        
</div>
</div>
</div>       