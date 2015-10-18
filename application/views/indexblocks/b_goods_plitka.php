<div class="catalog_tiles">
<div class="catalog_tiles_in">
<div id="cart">

<?php
foreach ($goods as $good):
?>

<div class="catalog_tile_item">
<div class="catalog_tile_item_in2">
<div class="cti">
<div class="plit_in">
 
    <div class="cti_kod_box"> Код: <span class="cti_kod"> <?php echo$good->go_id; ?></span></div>
    <div class="cti_image">
        <a href="/go/<?php echo$good->go_id; ?>/<?php echo$title[$good->go_id]; ?>"><?php echo$foto[$good->go_id]; ?>
    </div>
    <div class="cti_head"> 
        <?php echo$name[$good->go_id]; ?></a>
    </div>
    <div class="cti_info">
        <span class="cti_brend"><?php echo$brend_go[$good->go_id]; ?></span>
    </div>
    <div class="cti_end">
        <div class="cti_end_l">
            <div class="cti_price">
                Цена: <?php echo$cost[$good->go_id]; ?>
            </div>
        </div>
        <input type="text" id="num<?php echo$good->go_id; ?>" size="1"  value="1" /> шт.
        
        <?php echo$cart[$good->go_id]; ?>
    </div>
</div>
</div>
</div>
</div>

<?php endforeach?>     
        
</div>
</div>
</div>